<?php
// *************************************************************************
// *                                                                       *
// * DEPRIXA PRO -  Integrated Web Shipping System                         *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: support@jaom.info                                              *
// * Website: http://www.jaom.info                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************



$userData = $user->cdp_getUserData();
require_once("helpers/querys.php");

require_once("helpers/phpmailer/class.phpmailer.php");
require_once("helpers/phpmailer/class.smtp.php");




$db = new Conexion;

//Prefix tracking   
$sql = "SELECT * FROM cdb_settings";

$db->cdp_query($sql);

$db->cdp_execute();

$settings = $db->cdp_registro();

$order_prefix = $settings->prefix;
$check_mail = $settings->mailer;
$names_info = $settings->smtp_names;
$mlogo = $settings->logo;
$msite_url = $settings->site_url;
$msnames = $settings->site_name;

//SMTP

$smtphoste = $settings->smtp_host;
$smtpuser = $settings->smtp_user;
$smtppass = $settings->smtp_password;
$smtpport = $settings->smtp_port;
$smtpsecure = $settings->smtp_secure;

$tax = $settings->tax;
$insurance = $settings->insurance;
$value_weight = $settings->value_weight;
$meter = $settings->meter;
$c_tariffs = $settings->c_tariffs;
$site_email = $settings->site_email;


if (isset($_POST["create_invoice"])) {


    $db->cdp_query("SELECT MAX(order_no) AS order_no FROM cdb_add_order");
    $db->cdp_execute();

    $invNum = $db->cdp_fetch_assoc();
    $max_id = $invNum['order_no'];
    $cod = $max_id;
    $next_order = $core->cdp_order_track();
    $date = date('Y-m-d', strtotime(cdp_sanitize($_POST["order_date"])));
    $time = date("H:i:s");

    $date = $date . ' ' . $time;

    $status = 11;

    $order_incomplete = 0;

    $days = 0;


    $days = intval($days);

    $sale_date   = date("Y-m-d H:i:s");

    $due_date = cdp_sumardias($sale_date, $days);



    $status_invoice = 2;


    $db->cdp_query("
                INSERT INTO cdb_add_order 
                (
                    user_id,
                    order_prefix,
                    order_no,
                    order_date,
                    sender_id,
                    sender_address_id,
                    receiver_id,                
                    receiver_address_id,   
                    volumetric_percentage,                 
                    order_datetime,                    
                    order_package,            
                    order_pay_mode,
                    status_courier,
                    due_date,      
                    status_invoice,
                    order_incomplete
                    )
                VALUES
                    (
                    :user_id,
                    :order_prefix,
                    :order_no,
                    :order_date,
                    :sender_id,
                    :sender_address_id,
                    :receiver_id,       
                    :receiver_address_id,          
                    :volumetric_percentage,
                    :order_datetime,                    
                    :order_package,                                  
                    :order_pay_mode,
                    :status_courier,
                    :due_date,
                    :status_invoice,
                    :order_incomplete
                    )
            ");



    $db->bind(':user_id',  $_SESSION['userid']);
    $db->bind(':order_prefix',  $order_prefix);
    $db->bind(':volumetric_percentage',  $meter);
    $db->bind(':order_no',  $next_order);
    $db->bind(':order_datetime',  cdp_sanitize($date));

    $db->bind(':sender_id',  cdp_sanitize($_POST["sender_id_temp"]));
    $db->bind(':receiver_id',  cdp_sanitize($_POST["recipient_id"]));
    $db->bind(':sender_address_id',  cdp_sanitize($_POST["sender_address_id"]));
    $db->bind(':receiver_address_id',  cdp_sanitize($_POST["recipient_address_id"]));


    $db->bind(':order_date',  date("Y-m-d H:i:s"));

    $db->bind(':order_package',  cdp_sanitize($_POST["order_package"]));

    $db->bind(':order_pay_mode',  cdp_sanitize($_POST["order_pay_mode"]));

    $db->bind(':status_courier',  cdp_sanitize($status));
    $db->bind(':order_incomplete',  $order_incomplete);

    $db->bind(':due_date',  $due_date);
    $db->bind(':status_invoice',  $status_invoice);
    $success = $db->cdp_execute();


    $order_id = $db->dbh->lastInsertId();

    for ($count = 0; $count < $_POST["total_item"]; $count++) {

        $db->cdp_query("
                  INSERT INTO cdb_add_order_item 
                  (
                  order_id,
                  order_item_description,
                  order_item_category,
                  order_item_quantity,
                  order_item_weight,
                  order_item_length,
                  order_item_width,
                  order_item_height,
                  order_item_declared_value

                                  
                  )
                  VALUES 
                  (
                  :order_id,
                  :order_item_description,
                  :order_item_category, 
                  :order_item_quantity,
                  :order_item_weight,
                  :order_item_length,
                  :order_item_width,
                  :order_item_height,
                  :order_item_declared_value               

                  )
                ");


        $db->bind(':order_id',  $order_id);
        $db->bind(':order_item_description',  cdp_sanitize($_POST["order_item_description"][$count]));
        $db->bind(':order_item_category',  cdp_sanitize($_POST["order_item_category"][$count]));
        $db->bind(':order_item_quantity',  cdp_sanitize($_POST["order_item_quantity"][$count]));
        $db->bind(':order_item_weight',  cdp_sanitize($_POST["order_item_weight"][$count]));
        $db->bind(':order_item_length',  cdp_sanitize($_POST["order_item_length"][$count]));
        $db->bind(':order_item_width',  cdp_sanitize($_POST["order_item_width"][$count]));
        $db->bind(':order_item_height',  cdp_sanitize($_POST["order_item_height"][$count]));
        $db->bind(':order_item_declared_value',  cdp_sanitize($_POST["order_item_declared_value"][$count]));

        $db->cdp_execute();
    }





    if (count($_FILES['filesMultiple']['name']) > 0 && $_FILES['filesMultiple']['tmp_name'][0] != '') {

        $target_dir = "order_files/";


        foreach ($_FILES["filesMultiple"]['tmp_name'] as $key => $tmp_name) {

            $image_name = time() . "_" . basename($_FILES["filesMultiple"]["name"][$key]);
            $target_file = $target_dir . $image_name;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $imageFileZise = $_FILES["filesMultiple"]["size"][$key];

            if ($imageFileZise > 0) {

                move_uploaded_file($_FILES["filesMultiple"]["tmp_name"][$key], $target_file);
                $imagen = basename($_FILES["filesMultiple"]["name"][$key]);
                $file = "image_path='img/usuarios/$image_name' ";
            }

            cdp_insertOrdersFiles($order_id, $target_file, $image_name, date("Y-m-d H:i:s"), '1');
        }
    }



    // Add a recipient
    $db->cdp_query("SELECT * FROM cdb_users where id= '" . $_POST["sender_id_temp"] . "'");
    $sender_data = $db->cdp_registro();


    $fullshipment = $order_prefix . $next_order;
    $date_ship   = date("Y-m-d H:i:s a");

    $app_url = $settings->site_url . '/track.php?order_track=' . $fullshipment;
    $subject = "a new shipment has been created, tracking number $fullshipment";



    $email_template = cdp_getEmailTemplates(16);

    $body = str_replace(
        array(
            '[NAME]',
            '[TRACKING]',
            '[DELIVERY_TIME]',
            '[URL]',
            '[URL_LINK]',
            '[SITE_NAME]',
            '[URL_SHIP]'
        ),
        array(
            $sender_data->fname . ' ' . $sender_data->lname,
            $fullshipment,
            $date_ship,
            $msite_url,
            $mlogo,
            $msnames,
            $app_url
        ),
        $email_template->body
    );


    $newbody = cdp_cleanOut($body);


    //SENDMAIL PHP

    if ($check_mail == 'PHP') {



        $message = $newbody;
        $to = $sender_data->email;
        $from = $site_email;

        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=UTF-8 \r\n";
        $header .= "From: " . $from . " \r\n";

        mail($to, $subject, $message, $header);
    } elseif ($check_mail == 'SMTP') {


        //PHPMAILER PHP

        $destinatario = $sender_data->email;


        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port = $smtpport;
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        // Datos de la cuenta de correo utilizada para enviar vía SMTP
        $mail->Host = $smtphoste;       // Dominio alternativo brindado en el email de alta
        $mail->Username = $smtpuser;    // Mi cuenta de correo
        $mail->Password = $smtppass;    //Mi contraseña


        $mail->From = $site_email; // Email desde donde envío el correo.
        $mail->FromName = $names_info;
        $mail->AddAddress($destinatario); // Esta es la dirección a donde enviamos los datos del formulario

        $mail->Subject = $subject; // Este es el titulo del email.
        $mail->Body = "
            <html> 
            
            <body> 
            
            <p>{$newbody}</p>
            
            </body> 
            
            </html>
            
            <br />"; // Texto del email en formato HTML

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $estadoEnvio = $mail->Send();
        if ($estadoEnvio) {
            echo "El correo fue enviado correctamente.";
        } else {
            echo "Ocurrió un error inesperado.";
        }
    }



    //INSERT HISTORY USER
    $date = date("Y-m-d H:i:s");
    $db->cdp_query("
                INSERT INTO cdb_order_user_history 
                (
                    user_id,
                    order_id,
                    action,
                    date_history                   
                    )
                VALUES
                    (
                    :user_id,
                    :order_id,
                    :action,
                    :date_history
                    )
            ");



    $db->bind(':order_id',  $order_id);
    $db->bind(':user_id',  $_SESSION['userid']);
    $db->bind(':action', 'create shipping pickup');
    $db->bind(':date_history',  cdp_sanitize($date));
    $db->cdp_execute();



    // SAVE NOTIFICATION
    $fullshipment = $order_prefix . $next_order;
    $db->cdp_query("
                INSERT INTO cdb_notifications 
                (
                    user_id,
                    order_id,
                    notification_description,
                    shipping_type,
                    notification_date

                )
                VALUES
                    (
                    :user_id,                    
                    :order_id,
                    :notification_description,
                    :shipping_type,
                    :notification_date                    
                    )
            ");



    $db->bind(':user_id',  $_SESSION['userid']);
    $db->bind(':order_id',  $order_id);
    $db->bind(':notification_description', 'There is a new shipment, check it out');
    $db->bind(':shipping_type', '1');
    $db->bind(':notification_date',  date("Y-m-d H:i:s"));

    $db->cdp_execute();


    $notification_id = $db->dbh->lastInsertId();

    //NOTIFICATION TO DRIVER

    $users_drivers = $user->cdp_userAllDriver();

    foreach ($users_drivers as $key) {

        cdp_insertNotificationsUsers($notification_id, $key->id);
    }

    //NOTIFICATION TO ADMIN AND EMPLOYEES

    $users_employees = cdp_getUsersAdminEmployees();

    foreach ($users_employees as $key) {

        cdp_insertNotificationsUsers($notification_id, $key->id);
    }
    //NOTIFICATION TO CUSTOMER

    cdp_insertNotificationsUsers($notification_id, $_POST['sender_id_temp']);


    $db->cdp_query("SELECT * FROM cdb_users_multiple_addresses where id_addresses= '" . $_POST["sender_address_id"] . "'");

    $sender_address_data = $db->cdp_registro();

    $sender_address = $sender_address_data->address;
    $sender_country = $sender_address_data->country;
    $sender_city = $sender_address_data->city;
    $sender_zip_code = $sender_address_data->zip_code;


    $db->cdp_query("SELECT * FROM cdb_users_multiple_addresses where id_addresses= '" . $_POST["recipient_address_id"] . "'");

    $recipient_address_data = $db->cdp_registro();


    $recipient_address = $recipient_address_data->address;
    $recipient_country = $recipient_address_data->country;
    $recipient_city = $recipient_address_data->city;
    $recipient_zip_code = $recipient_address_data->zip_code;


    // SAVE ADDRESS FOR Shipments

    $db->cdp_query("
                INSERT INTO cdb_address_shipments
                (
                    order_track,
                    sender_address,
                    sender_country,
                    sender_city,
                    sender_zip_code,

                    recipient_address,
                    recipient_country,
                    recipient_city,
                    recipient_zip_code

                )
                VALUES
                    (
                    :order_track,
                    :sender_address,
                    :sender_country,
                    :sender_city,
                    :sender_zip_code,
                    
                    :recipient_address,
                    :recipient_country,
                    :recipient_city,
                    :recipient_zip_code                
                    )
            ");



    $db->bind(':order_track',  $fullshipment);

    $db->bind(':sender_address',  $sender_address);
    $db->bind(':sender_country',  $sender_country);
    $db->bind(':sender_city',  $sender_city);
    $db->bind(':sender_zip_code',  $sender_zip_code);

    $db->bind(':recipient_address',  $recipient_address);
    $db->bind(':recipient_country',  $recipient_country);
    $db->bind(':recipient_city',  $recipient_city);
    $db->bind(':recipient_zip_code',  $recipient_zip_code);

    $db->cdp_execute();

    header("location:courier_view.php?id=$order_id");




?>

<?php

}

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <title><?php echo $lang['add-courier'] ?> | <?php echo $core->site_name ?></title>
    <!-- This Page CSS -->
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/input-css/intlTelInput.css">

    <link rel="stylesheet" type="text/css" href="assets/select2/dist/css/select2.min.css">

    <link href="assets/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/jquery-ui.css" type="text/css" />

    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui.js"></script>

    <link rel="stylesheet" href="assets/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="assets/custom_dependencies/bootstrap.min.css" rel="stylesheet">


    <script>

    </script>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->


    <?php include 'views/inc/preloader.php'; ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->

        <?php include 'views/inc/topbar.php'; ?>

        <!-- End Topbar header -->


        <!-- Left Sidebar - style you can find in sidebar.scss  -->

        <?php include 'views/inc/left_sidebar.php'; ?>

        <?php $office = $core->cdp_getOffices(); ?>
        <?php $agencyrow = $core->cdp_getBranchoffices(); ?>
        <?php $courierrow = $core->cdp_getCouriercom(); ?>
        <?php $statusrow = $core->cdp_getStatus(); ?>
        <?php $packrow = $core->cdp_getPack(); ?>
        <?php $payrow = $core->cdp_getPayment(); ?>

        <?php $itemrow = $core->cdp_getItem(); ?>
        <?php $moderow = $core->cdp_getShipmode(); ?>
        <?php $driverrow = $user->cdp_userAllDriver(); ?>
        <?php $delitimerow = $core->cdp_getDelitime(); ?>
        <?php $track = $core->cdp_order_track(); ?>
        <?php $categories = $core->cdp_getCategories(); ?>

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h4 class="page-title"><i class="ti-package" aria-hidden="true"></i> <?php echo $lang['left82'] ?></h4> <br>
                    </div>
                </div>
            </div>

            <form method="post" id="invoice_form" name="invoice_form" enctype="multipart/form-data">

                <div class="container-fluid">
                    <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>

                        <div class="alert alert-info" id="success-alert">
                            <p><span class="icon-info-sign"></span><i class="close icon-remove-circle"></i>
                                Your collection has been created successfully!
                            </p>
                        </div>
                    <?php
                    } else if (isset($_GET['success']) && $_GET['success'] == 0) { ?>

                        <div class="alert alert-danger" id="success-alert">
                            <p><span class="icon-minus-sign"></span><i class="close icon-remove-circle"></i>
                                <span>Error! </span> There was an error processing the request
                            </p>
                        </div>
                    <?php
                    }
                    ?>




                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="mdi mdi-information-outline" style="color:#36bea6"></i><?php echo $lang['langs_010']; ?></h4>
                                    <hr>

                                    <div class="resultados_ajax_add_user_modal_sender"></div>



                                    <div class="row">

                                        <div class="col-md-12 ">

                                            <label class="control-label col-form-label"><?php echo $lang['sender_search_title'] ?></label>


                                            <div class="input-group">
                                                <select class="select2 form-control custom-select" style="width: 100%;" id="sender_id" name="sender_id" disabled="">
                                                    <option value="<?php echo $userData->id; ?>" selected> <?php echo $userData->fname . ' ' . $userData->lname; ?></option>

                                                </select>

                                                <input type="hidden" name="sender_id_temp" id="sender_id_temp" value="<?php echo $userData->id; ?>">


                                            </div>
                                        </div>





                                        <div class="col-md-12 ">

                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['sender_search_address_title'] ?></label>

                                            <div class="input-group">
                                                <select class="select2 form-control" id="sender_address_id" style="width: 97%;" name="sender_address_id">
                                                </select>

                                                <div class="input-group-append input-sm">
                                                    <button id="add_address_sender" data-type_user="user_customer" data-toggle="modal" data-target="#myModalAddRecipientAddresses" type="button" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                                </div>

                                            </div>
                                        </div>

                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="mdi mdi-information-outline" style="color:#36bea6"></i><?php echo $lang['left334']; ?></h4>
                                    <hr>
                                    <div class="resultados_ajax_add_user_modal_recipient"></div>



                                    <div class="row">

                                        <div class="col-md-12">
                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['recipient_search_title'] ?></label>

                                            <div class="input-group">

                                                <select class="select2 form-control custom-select" id="recipient_id" style="width: 97%;" name="recipient_id">
                                                </select>

                                                <div class="input-group-append input-sm">
                                                    <button id="add_recipient" type="button" data-type_user="user_recipient" data-toggle="modal" data-target="#myModalAddUser" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">

                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['recipient_search_address_title'] ?></label>


                                            <div class="input-group">

                                                <select class="select2 form-control" id="recipient_address_id" style="width: 97%;" name="recipient_address_id" disabled="">
                                                </select>

                                                <div class="input-group-append input-sm">
                                                    <button disabled id="add_address_recipient" type="button" data-type_user="user_recipient" data-toggle="modal" data-target="#myModalAddRecipientAddresses" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                                </div>

                                            </div>
                                        </div>


                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row -->






                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="mdi mdi-book-multiple" style="color:#36bea6"></i> <?php echo $lang['add-title13'] ?></h4>
                                    <br>
                                    <div class="row">

                                        <?php if ($userData->userlevel == 9 || $userData->userlevel == 3) { ?>

                                            <div class="form-group col-md-6">
                                                <label for="inputlname" class="control-label col-form-label"><?php echo $lang['left201'] ?> </label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select col-12" id="agency" name="agency">
                                                        <option value="0">--<?php echo $lang['left202'] ?>--</option>
                                                        <?php foreach ($agencyrow as $row) : ?>
                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name_branch; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                        <?php } else { ?>
                                            <input type="hidden" name="agency" id="agency" value="000">
                                        <?php } ?>

                                        <div class="form-group col-md-6">
                                            <label for="inputlname" class="control-label col-form-label"><?php echo $lang['add-title17'] ?></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="order_package" name="order_package">
                                                    <option value="0">--<?php echo $lang['left203'] ?>--</option>
                                                    <?php foreach ($packrow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name_pack; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['add-title1555'] ?></i></label>
                                            <div class="input-group">
                                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i style="color:#ff0000" class="fa fa-calendar"></i></div>
                                                </div>
                                                <input type='text' class="form-control" name="order_date" id="order_date" placeholder="--<?php echo $lang['left206'] ?>--" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title1555'] ?>" readonly value="<?php echo date('Y-m-d'); ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title23'] ?> <i style="color:#ff0000" class="fas fa-donate"></i></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="order_pay_mode" name="order_pay_mode">
                                                    <option value="0">--<?php echo $lang['left243'] ?>--</option>
                                                    <?php foreach ($payrow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->met_payment; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>



                                    </div>


                                    <div class="row">

                                        <div class="col-md-4">

                                            <div>
                                                <label class="control-label" id="selectItem"> Attach files</label>
                                            </div>

                                            <input class="custom-file-input" id="filesMultiple" name="filesMultiple[]" multiple="multiple" type="file" style="display: none;" onchange="cdp_validateZiseFiles();" />


                                            <button type="button" id="openMultiFile" class="btn btn-info  pull-left "> <i class='fa fa-paperclip' id="openMultiFile" style="font-size:18px; cursor:pointer;"></i> Upload files </button>

                                            <div id="clean_files" class="hide">
                                                <button type="button" id="clean_file_button" class="btn btn-danger ml-3"> <i class='fa fa-trash' style="font-size:18px; cursor:pointer;"></i> Cancel attachments </button>

                                            </div>

                                        </div>


                                    </div>


                                    <div class="row">



                                        <div class="resultados_file col-md-4 pull-right mt-4">


                                        </div>


                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fas fas fa-boxes" style="color:#36bea6"></i> <?php echo $lang['left212'] ?></h4>



                                    <div id="resultados_ajax"></div>


                                    <div class="card-hover">
                                        <hr>

                                        <div class="row">

                                            <div class="col-md-4">

                                                <div class="form-group">


                                                    <label for="emailAddress1">Category</label>
                                                    <div class="input-group">
                                                        <select class="custom-select col-12 order_item_category1" id="order_item_category1" name="order_item_category[]" required>
                                                            <option value="0">--Select Category--</option>
                                                            <?php foreach ($categories as $row) : ?>
                                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name_item; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-5">

                                                <div class="form-group">

                                                    <label for="emailAddress1"><?php echo $lang['left213'] ?></label>
                                                    <div class="input-group">
                                                        <input type="text" name="order_item_description[]" id="order_item_description1" class="form-control input-sm order_item_description" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left225'] ?>" placeholder="<?php echo $lang['left224'] ?>" required>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-3">

                                                <div class="form-group">

                                                    <label for="emailAddress1"> Declared value</label>
                                                    <div class="input-group">

                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_declared_value[]" id="order_item_declared_value1" data-srno="1" class="form-control input-sm number_only order_item_declared_value" data-toggle="tooltip" data-placement="bottom" title="Declared value" value="0" />

                                                    </div>
                                                </div>
                                            </div>




                                        </div>

                                        <div class="row ">
                                            <div class="col-md-2">

                                                <div class="form-group">

                                                    <label for="emailAddress1"><?php echo $lang['left214'] ?></label>
                                                    <div class="input-group">
                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber('order_item_quantity', 1)"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                        <input min="1" type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_quantity[]" id="order_item_quantity1" data-srno="1" class="form-control input-sm order_item_quantity" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left227'] ?>" value="1" required />
                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber('order_item_quantity', 1)"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-2">

                                                <div class="form-group">

                                                    <label for="emailAddress1"><?php echo $lang['left215']; ?></label>
                                                    <div class="input-group">

                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber('order_item_weight', 1)"><i class="fa fa-minus"></i></button>
                                                        </div>

                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_weight[]" id="order_item_weight1" data-srno="1" class="form-control input-sm order_item_weight" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title31'] ?>" value="0" />

                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber('order_item_weight', 1)"><i class="fa fa-plus"></i></button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="emailAddress1"><?php echo $lang['left216'] ?></label>
                                                    <div class="input-group">
                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber('order_item_length', 1)"><i class="fa fa-minus"></i></button>
                                                        </div>

                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_length[]" id="order_item_length1" data-srno="1" class="form-control input-sm text_only order_item_length" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title37'] ?>" value="0" />
                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber('order_item_length', 1)"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-2">

                                                <div class="form-group">

                                                    <label for="emailAddress1"><?php echo $lang['left217'] ?></label>
                                                    <div class="input-group">
                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber('order_item_width', 1)"><i class="fa fa-minus"></i></button>
                                                        </div>

                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_width[]" id="order_item_width1" data-srno="1" class="form-control input-sm text_only order_item_width" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title38'] ?>" value="0" />
                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber('order_item_width', 1)"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">

                                                <div class="form-group">

                                                    <label for="emailAddress1"><?php echo $lang['left218'] ?></label>
                                                    <div class="input-group">

                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber('order_item_height', 1)"><i class="fa fa-minus"></i></button>
                                                        </div>

                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_height[]" id="order_item_height1" data-srno="1" class="form-control input-sm number_only order_item_height" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title39'] ?>" value="0" />
                                                        <div class="input-group-append input-sm">
                                                            <button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber('order_item_height', 1)"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                        <hr>
                                    </div>

                                    <div id="data_items"></div>

                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div align="">
                                                <button type="button" name="add_row" id="add_row" class="btn btn-success mb-2"><span class="fa fa-plus"></span> <?php echo $lang['left231'] ?></button>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-actions">
                                            <div class="card-body">
                                                <div class="text-right">

                                                    <input type="hidden" name="total_item" id="total_item" value="1" />


                                                    <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-success" value="Create Invoice" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

            </form>




            <?php include('views/modals/modal_add_user_shipment.php'); ?>
            <?php include('views/modals/modal_add_addresses_user.php'); ?>



        </div>


    </div>
    <footer class="footer text-center">
        &copy <?php echo date('Y') . ' ' . $core->site_name; ?> - <?php echo $lang['foot'] ?>
    </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->


    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->

    <script src="assets/custom_dependencies/jquery-3.6.0.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/custom_dependencies/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <!-- <script src="assets/js/app.init.js"></script> -->
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/js/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.min.js"></script>

    <script src="assets/moment.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/select2/dist/js/select2.min.js"></script>
    <script src="assets/js/input-js/intlTelInput.js"></script>

    <script src="dataJs/courier_add_client.js"></script>



</body>

</html>