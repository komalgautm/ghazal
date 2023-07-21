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



if (!$user->cdp_is_Admin())
    cdp_redirect_to("login.php");



require_once("helpers/querys.php");
require_once 'helpers/vendor/autoload.php';

use Twilio\Rest\Client;

require_once("helpers/phpmailer/class.phpmailer.php");
require_once("helpers/phpmailer/class.smtp.php");

$userData = $user->cdp_getUserData();

$db = new Conexion;

//Prefix tracking   
$sql = "SELECT * FROM cdb_settings";

$db->cdp_query($sql);

$db->cdp_execute();

$settings = $db->cdp_registro();

$order_prefix = $settings->prefix_consolidate;
$check_mail = $settings->mailer;
$names_info = $settings->smtp_names;

//SMTP

$smtphoste = $settings->smtp_host;
$smtpuser = $settings->smtp_user;
$smtppass = $settings->smtp_password;
$smtpport = $settings->smtp_port;
$smtpsecure = $settings->smtp_secure;

$value_weight = $settings->value_weight;
$meter = $settings->meter;
$site_email = $settings->site_email;


if (isset($_POST["create_invoice"])) {

    $next_order = $core->cdp_consolidate_track();
    $date = date('Y-m-d', strtotime(trim($_POST["order_date"])));
    $time = date("H:i:s");

    $date = $date . ' ' . $time;

    if (isset($_POST["prefix_check"]) == 1) {

        $code_prefix = cdp_sanitize($_POST["code_prefix2"]);
    } else {

        $code_prefix = cdp_sanitize($_POST["code_prefix"]);
    }

    $status_invoice = 2;




    $db->cdp_query("
                INSERT INTO cdb_consolidate 
                (
                    user_id,
                    c_prefix,
                    c_no,
                    c_date,                    
                    sender_id,
                    sender_address_id,
                    receiver_id,                
                    receiver_address_id,
                    tax_value,
                    tax_insurance_value,
                    tax_custom_tariffis_value,
                    value_weight,
                    volumetric_percentage,
                    total_weight,                    
                    sub_total,
                    tax_discount,
                    total_tax_insurance,
                    total_tax_custom_tariffis,
                    total_tax,
                    total_tax_discount,
                    total_reexp,                    
                    total_order,                    
                    order_datetime,
                    agency,
                    origin_off,
                    order_package,
                    order_courier,
                    order_service_options,
                    order_deli_time,                   
                    order_pay_mode,
                    status_courier,
                    driver_id,
                    seals_package,
                    status_invoice
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

                    :tax_value,
                    :tax_insurance_value,
                    :tax_custom_tariffis_value,
                    :value_weight,
                    :volumetric_percentage,
                    :total_weight,                    
                    :sub_total,
                    :tax_discount,
                    :total_tax_insurance,
                    :total_tax_custom_tariffis,
                    :total_tax,
                    :total_tax_discount,
                    :total_reexp,
                    :total_order,                    
                    :order_datetime,
                    :agency,
                    :origin_off,
                    :order_package,
                    :order_courier,
                    :order_service_options,
                    :order_deli_time,                   
                    :order_pay_mode,
                    :status_courier,
                    :driver_id,
                    :seals_package,
                    :status_invoice
                    )
            ");


    $db->bind(':status_invoice',  $status_invoice);

    $db->bind(':user_id',  $_SESSION['userid']);
    $db->bind(':order_prefix',  $code_prefix);
    $db->bind(':order_no',  $_POST["order_no"]);
    $db->bind(':order_datetime',  trim($date));

    $db->bind(':sender_id',  cdp_sanitize($_POST["sender_id"]));
    $db->bind(':receiver_id',  cdp_sanitize($_POST["recipient_id"]));
    $db->bind(':sender_address_id',  cdp_sanitize($_POST["sender_address_id"]));
    $db->bind(':receiver_address_id',  cdp_sanitize($_POST["recipient_address_id"]));

    $db->bind(':tax_value', floatval($_POST["tax_value"]));
    $db->bind(':tax_insurance_value', floatval($_POST["insurance_value"]));
    $db->bind(':tax_custom_tariffis_value', floatval($_POST["tariffs_value"]));
    $db->bind(':value_weight',  floatval($_POST["price_lb"]));
    $db->bind(':volumetric_percentage',  $meter);
    $db->bind(':sub_total',  floatval($_POST["subtotal_input"]));
    $db->bind(':tax_discount',  floatval($_POST["discount_value"]));
    $db->bind(':total_reexp',  floatval($_POST["reexpedicion_value"]));

    $db->bind(':total_tax_discount',  floatval($_POST["discount_input"]));
    $db->bind(':total_tax_insurance',  floatval($_POST["insurance_input"]));
    $db->bind(':total_tax_custom_tariffis',  floatval($_POST["total_impuesto_aduanero_input"]));
    $db->bind(':total_tax',  floatval($_POST["impuesto_input"]));
    $db->bind(':total_order',  floatval($_POST["total_envio_input"]));
    $db->bind(':total_weight',  floatval($_POST["total_weight_input"]));

    $db->bind(':order_date',  date("Y-m-d H:i:s"));
    $db->bind(':agency',  cdp_sanitize($_POST["agency"]));
    $db->bind(':origin_off',  cdp_sanitize($_POST["origin_off"]));
    $db->bind(':order_package',  cdp_sanitize($_POST["order_package"]));
    $db->bind(':order_courier',  cdp_sanitize($_POST["order_courier"]));
    $db->bind(':order_service_options',  cdp_sanitize($_POST["order_service_options"]));
    $db->bind(':order_deli_time',  cdp_sanitize($_POST["order_deli_time"]));
    $db->bind(':order_pay_mode',  cdp_sanitize($_POST["order_pay_mode"]));
    $db->bind(':status_courier',  cdp_sanitize($_POST["status_courier"]));
    $db->bind(':driver_id',  cdp_sanitize($_POST["driver_id"]));
    $db->bind(':seals_package',  cdp_sanitize($_POST["seals"]));

    $db->cdp_execute();


    $order_id = $db->dbh->lastInsertId();

    for ($count = 0; $count < $_POST["total_item"]; $count++) {

        $db->cdp_query("
                  INSERT INTO cdb_consolidate_detail 
                  (
                  consolidate_id,
                  order_id,
                  order_prefix,
                  order_no,
                  weight,
                  weight_vol,  
                  length,
                  width,
                  height              
                                  
                  )
                  VALUES 
                  (
                  :consolidate_id,
                  :order_id,
                  :order_prefix,
                  :order_no, 
                  :weight,
                  :weight_vol,
                  :length,
                  :width,
                  :height                               
                  )
                ");


        $db->bind(':consolidate_id',  $order_id);
        $db->bind(':order_prefix',  cdp_sanitize($_POST["prefix"][$count]));
        $db->bind(':order_no',  cdp_sanitize($_POST["order_no_item"][$count]));
        $db->bind(':weight',  cdp_sanitize($_POST["weight"][$count]));
        $db->bind(':length',  cdp_sanitize($_POST["length"][$count]));
        $db->bind(':width',  cdp_sanitize($_POST["width"][$count]));
        $db->bind(':height',  cdp_sanitize($_POST["height"][$count]));
        $db->bind(':weight_vol',  cdp_sanitize($_POST["weight_vol"][$count]));
        $db->bind(':order_id',  cdp_sanitize($_POST["order_id"][$count]));

        $db->cdp_execute();

        $is_consolidate = 1;

        $db->cdp_query("
                UPDATE  cdb_add_order SET                
                    
                    is_consolidate=:is_consolidate

                    WHERE order_id=:order_id                 
                
                ");

        $db->bind(':order_id',  cdp_sanitize($_POST["order_id"][$count]));
        $db->bind(':is_consolidate',  $is_consolidate);

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
    $db->cdp_query("SELECT * FROM cdb_users where id= '" . $_POST["sender_id"] . "'");
    $sender_data = $db->cdp_registro();


    $$fullshipment = $code_prefix . $_POST["order_no"];
    $date_ship   = date("Y-m-d H:i:s a");
    $app_url = $settings->site_url . 'track.php?order_track=' . $fullshipment;


    $subject = "a new consolidate has been created, tracking number $fullshipment";



    $email_template = cdp_getEmailTemplates(1);

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



    //NOTIFY WHATSAPP API

    if (isset($_POST['notify_whatsapp_sender']) && $_POST['notify_whatsapp_sender'] == 1) {


        if ($core->twilio_sid != null && $core->twilio_token != null && $core->twilio_number != null) {

            $db->cdp_query("SELECT * FROM cdb_users where id= '" . $_POST["sender_id"] . "'");
            $sender_data = $db->cdp_registro();

            $phone_sender = $sender_data->phone;

            $sid    = $core->twilio_sid;
            $token  = $core->twilio_token;

            try {

                $twilio = new Client($sid, $token);

                $message = $twilio->messages
                    ->create(
                        "whatsapp:" . $phone_sender, // to 
                        array(
                            "from" => "whatsapp:" . $core->twilio_number,
                            "body" => "a new consolidated has been registered, *Tracking #$fullshipment* "
                        )
                    );
            } catch (Exception $e) {
            }
        }
    }


    if (isset($_POST['notify_whatsapp_receiver']) && $_POST['notify_whatsapp_receiver'] == 1) {


        if ($core->twilio_sid != null && $core->twilio_token != null && $core->twilio_number != null) {

            $db->cdp_query("SELECT * FROM cdb_users where id= '" . $_POST["receiver_id"] . "'");
            $receiver_data = $db->cdp_registro();

            $phone_receiver = $receiver_data->phone;


            $sid    = $core->twilio_sid;
            $token  = $core->twilio_token;

            try {

                $twilio = new Client($sid, $token);

                $message = $twilio->messages
                    ->create(
                        "whatsapp:" . $phone_receiver, // to 
                        array(
                            "from" => "whatsapp:" . $core->twilio_number,
                            "body" => "a new consolidated has been registered, *Tracking #$fullshipment* "
                        )
                    );
            } catch (Exception $e) {
            }
        }
    }

    $order_track = $code_prefix . $_POST["order_no"];

    $db->cdp_query("
                INSERT INTO cdb_courier_track 
                (
                    order_track, 
                    comments,                                  
                    t_date,
                    status_courier,
                    office_id,
                    user_id
                    )
                VALUES
                    (
                    :order_track, 
                    :comments,                                     
                    :t_date,
                    :status_courier,
                    :office,                   
                    :user_id
                    )
            ");



    $db->bind(':order_track',  $order_track);
    $db->bind(':t_date',  date("Y-m-d H:i:s"));
    $db->bind(':status_courier', $_POST['status_courier']);
    $db->bind(':comments', 'Consolidated created');
    $db->bind(':office', $_POST['origin_off']);
    $db->bind(':user_id',  $_SESSION['userid']);

    $db->cdp_execute();

    //INSERT HISTORY USER
    $date = date("Y-m-d H:i:s");
    $db->cdp_query("
                INSERT INTO cdb_order_user_history 
                (
                    user_id,
                    order_id,
                    action,
                    date_history,
                    is_consolidate                  
                    )
                VALUES
                    (
                    :user_id,
                    :order_id,
                    :action,
                    :date_history,
                    :is_consolidate
                    )
            ");



    $db->bind(':order_id',  $order_id);
    $db->bind(':is_consolidate', '1');
    $db->bind(':user_id',  $_SESSION['userid']);
    $db->bind(':action', 'create consolidated');
    $db->bind(':date_history',  trim($date));
    $db->cdp_execute();

    // SAVE NOTIFICATION
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
    $db->bind(':notification_description', 'There is a new shipment consolidated, please check it');
    $db->bind(':shipping_type', '2');
    $db->bind(':notification_date',  date("Y-m-d H:i:s"));

    $db->cdp_execute();


    $notification_id = $db->dbh->lastInsertId();

    //NOTIFICATION TO DRIVER

    cdp_insertNotificationsUsers($notification_id, $_POST["driver_id"]);


    //NOTIFICATION TO ADMIN AND EMPLOYEES

    $users_employees = cdp_getUsersAdminEmployees();

    foreach ($users_employees as $key) {

        cdp_insertNotificationsUsers($notification_id, $key->id);
    }

    //NOTIFICATION TO CUSTOMER

    cdp_insertNotificationsUsers($notification_id, $_POST['sender_id']);


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



    $db->bind(':order_track',  $order_track);

    $db->bind(':sender_address',  $sender_address);
    $db->bind(':sender_country',  $sender_country);
    $db->bind(':sender_city',  $sender_city);
    $db->bind(':sender_zip_code',  $sender_zip_code);

    $db->bind(':recipient_address',  $recipient_address);
    $db->bind(':recipient_country',  $recipient_country);
    $db->bind(':recipient_city',  $recipient_city);
    $db->bind(':recipient_zip_code',  $recipient_zip_code);

    $db->cdp_execute();




    header("location:consolidate_view.php?id=$order_id");
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
    <title><?php echo $lang['langs_01'] ?> | <?php echo $core->site_name ?></title>
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
        <?php $track = $core->cdp_consolidate_track(); ?>
        <?php $categories = $core->cdp_getCategories(); ?>
        <?php $code_countries = $core->cdp_getCodeCountries(); ?>
        <?php $trackDigitsx = $core->cdp_trackDigits(); ?>

        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h4 class="page-title"><i class="ti-package" aria-hidden="true"></i> <?php echo $lang['langs_01']; ?></h4>
                    </div>
                </div>
            </div>

            <form method="post" id="invoice_form" name="invoice_form" enctype="multipart/form-data">

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">

                                        <div class="form-group col-md-4">
                                            <label for="inputcom" class="control-label col-form-label">Shipment Prefix</label>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="prefix_check" id="prefix_check" value="1">
                                                            <label class="form-check-label" for="prefix_check">Country prefix</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="text" class="form-control" name="code_prefix" id="code_prefix_input" value="<?php echo $order_prefix; ?>" readonly>

                                                <select class="custom-select input-sm hide" id="code_prefix_select" name="code_prefix2">
                                                    <option value="">--Select country code--</option>
                                                    <?php foreach ($code_countries as $row) : ?>
                                                        <option value="<?php echo $row->iso_3166_3; ?>"><?php echo $row->iso_3166_3 . ' - ' . $row->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </div>


                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="inputcom" class="control-label col-form-label"><?php echo $lang['add-title24'] ?></label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" name="order_no" id="order_no" value="<?php echo $track; ?>" onchange="cdp_validateTrackNumber(this.value, '<?php echo $trackDigitsx; ?>');">
                                            </div>

                                            <input type="hidden" name="order_no_main" id="order_no_main" value="<?php echo $track; ?>">

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="field-2" class="control-label col-form-label"><?php echo $lang['langs_021'] ?></label>
                                                <input name="seals" id="seals" class="form-control" placeholder="00-00000">
                                            </div>
                                        </div>



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




                                        <?php if ($user->access_level = 'Admin') { ?>

                                            <div class="form-group col-md-6">
                                                <label for="inputname" class="control-label col-form-label"><?php echo $lang['add-title14'] ?></label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select col-12" id="origin_off" name="origin_off">
                                                        <option value="0">--<?php echo $lang['left343'] ?>--</option>

                                                        <?php foreach ($office as $row) : ?>
                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name_off; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } else if ($user->access_level = 'Employee') { ?>

                                            <div class="form-group col-md-6">
                                                <label for="inputname" class="control-label col-form-label"><?php echo $lang['add-title14'] ?></label>
                                                <div class="input-group mb-3">
                                                    <input class="form-control" name="origin_off" value="<?php echo $user->name_off; ?>" readonly>
                                                </div>
                                            </div>

                                        <?php } ?>

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
                                    <h4 class="card-title"><i class="mdi mdi-information-outline" style="color:#36bea6"></i><?php echo $lang['langs_010']; ?></h4>
                                    <hr>

                                    <div class="resultados_ajax_add_user_modal_sender"></div>
                                    <br>
                                    <?php
                                    if ($core->active_whatsapp == 1) {
                                    ?>
                                        <label class="custom-control custom-checkbox" style="font-size: 18px; padding-left: 0px">
                                            <input type="checkbox" class="custom-control-input" name="notify_whatsapp_sender" id="notify_whatsapp_sender" value="1">
                                            <b>Notify by WhatsApp <i class="fa fa-whatsapp" style="font-size: 22px; color:#07bc4c;"></i></b>
                                            <span class="custom-control-indicator"></span>
                                        </label>
                                    <?php } ?>

                                    <div class="row">

                                        <div class="col-md-12 ">

                                            <label class="control-label col-form-label"><?php echo $lang['sender_search_title'] ?></label>


                                            <div class="input-group">

                                                <select class="select2 form-control custom-select" style="width: 97%;" id="sender_id" name="sender_id">
                                                </select>


                                                <div class="input-group-append input-sm">
                                                    <button type="button" class="btn btn-default" data-type_user="user_customer" data-toggle="modal" data-target="#myModalAddUser"><i class="fa fa-plus"></i></button>
                                                </div>

                                            </div>
                                        </div>





                                        <div class="col-md-12 ">

                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['sender_search_address_title'] ?></label>

                                            <div class="input-group">
                                                <select style="width: 97%;" class="select2 form-control" id="sender_address_id" name="sender_address_id" disabled="">
                                                </select>

                                                <div class="input-group-append input-sm">
                                                    <button disabled id="add_address_sender" data-type_user="user_customer" data-toggle="modal" data-target="#myModalAddRecipientAddresses" type="button" class="btn btn-default"><i class="fa fa-plus"></i></button>
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

                                    <br>
                                    <?php
                                    if ($core->active_whatsapp == 1) {
                                    ?>
                                        <label class="custom-control custom-checkbox" style="font-size: 18px; padding-left: 0px">
                                            <input type="checkbox" class="custom-control-input" name="notify_whatsapp_receiver" id="notify_whatsapp_receiver" value="1">
                                            <b>Notify by WhatsApp <i class="fa fa-whatsapp" style="font-size: 22px; color:#07bc4c;"></i></b>
                                            <span class="custom-control-indicator"></span>
                                        </label>
                                    <?php } ?>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['recipient_search_title'] ?></label>

                                            <div class="input-group">

                                                <select style="width: 97%;" class="select2 form-control custom-select" id="recipient_id" name="recipient_id" disabled>
                                                </select>

                                                <div class="input-group-append input-sm">
                                                    <button disabled id="add_recipient" type="button" data-type_user="user_recipient" data-toggle="modal" data-target="#myModalAddUser" class="btn btn-default"><i class="fa fa-plus"></i></button>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">

                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['recipient_search_address_title'] ?></label>


                                            <div class="input-group">

                                                <select style="width: 97%;" class="select2 form-control" id="recipient_address_id" name="recipient_address_id" disabled="">
                                                </select>

                                                <div class="input-group-append input-sm">
                                                    <button disabled id="add_address_recipient" type="button" data-type_user="user_recipient" data-toggle="modal" data-target="#myModalAddRecipientAddresses" class="btn btn-default"><i class="fa fa-plus"></i></button>
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

                                        <div class="form-group col-md-4">
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




                                        <div class="form-group col-md-4">
                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['add-title18'] ?></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="order_courier" name="order_courier">
                                                    <option value="0">--<?php echo $lang['left204'] ?>--</option>
                                                    <?php foreach ($courierrow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name_com; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>




                                        <div class="form-group col-md-4">
                                            <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title22'] ?></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="order_service_options" name="order_service_options">
                                                    <option value="0">--<?php echo $lang['left205'] ?>--</option>
                                                    <?php foreach ($moderow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->ship_mode; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['add-title15'] ?></i></label>
                                            <div class="input-group">
                                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i style="color:#ff0000" class="fa fa-calendar"></i></div>
                                                </div>
                                                <input type='text' class="form-control" name="order_date" id="order_date" placeholder="--<?php echo $lang['left206'] ?>--" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title16'] ?>" readonly value="<?php echo date('Y-m-d'); ?>" />
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title20'] ?></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="order_deli_time" name="order_deli_time">
                                                    <option value="0">--<?php echo $lang['left207'] ?>--</option>
                                                    <?php foreach ($delitimerow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->delitime; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!--/span-->


                                        <div class="form-group col-md-4">
                                            <label for="inputname" class="control-label col-form-label"><?php echo $lang['left208'] ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="color:#ff0000"><i class="fas fa-car"></i></span>
                                                </div>
                                                <select class="custom-select col-12" id="driver_id" name="driver_id">
                                                    <option value="0">--<?php echo $lang['left209'] ?>--</option>
                                                    <?php foreach ($driverrow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->fname . ' ' . $row->lname; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- <HR> -->
                                    <div class="row">

                                        <div class="form-group col-md-4">
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

                                        <!--/span-->


                                        <!--/span-->

                                        <div class="form-group col-md-4">
                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['langs_039'] ?> <i style="color:#ff0000" class="fas fa-shipping-fast"></i></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="status_courier" name="status_courier">
                                                    <option value="0">--<?php echo $lang['left210'] ?>--</option>
                                                    <?php foreach ($statusrow as $row) : ?>
                                                        <?php if ($row->mod_style == 'Delivered') { ?>
                                                        <?php } elseif ($row->mod_style == 'Pending') { ?>
                                                        <?php } elseif ($row->mod_style == 'Rejected') { ?>
                                                        <?php } elseif ($row->mod_style == 'Pick up') { ?>
                                                        <?php } elseif ($row->mod_style == 'Picked up') { ?>
                                                        <?php } elseif ($row->mod_style == 'No Picked up') { ?>
                                                        <?php } elseif ($row->mod_style == 'Consolidate') { ?>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->mod_style; ?></option>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->

                                    <!--/row-->
                                    <div class="row">

                                        <div class="col-md-4">

                                            <div>
                                                <label class="control-label" id="selectItem"> Attach files</label>
                                            </div>

                                            <input class="custom-file-input" id="filesMultiple" name="filesMultiple[]" multiple="multiple" type="file" style="display: none;" onchange="cdp_validateZiseFiles();" />


                                            <button type="button" id="openMultiFile" class="btn btn-default  pull-left "> <i class='fa fa-paperclip' id="openMultiFile" style="font-size:18px; cursor:pointer;"></i> Upload files </button>

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


                                    <div id="resultados_ajax"></div>

                                    <div class="table-responsive">
                                        <table id="invoice-item-table" class="table">
                                            <div align="right">
                                                <button type="button" data-toggle="modal" data-target="#myModalConsolidate" class="btn btn-success mb-2"><span class="fa fa-search"></span> Search Shipments</button>
                                            </div>
                                            <thead class="bg-inverse text-white">
                                                <tr>

                                                    <th colspan="3"><b><?php echo $lang['ltracking'] ?></b></th>
                                                    <th colspan="2" class="text-center"><b>Weights</b></th>
                                                    <th colspan="2" class="text-right"><b>Weight Vol.</b></th>


                                                    <th class="text-center"></th>
                                                </tr>
                                            </thead>


                                            <tbody id="projects-tbl">

                                            </tbody>
                                            <tfoot>
                                                <tr class="card-hover">
                                                    <td colspan="2"></td>
                                                    <td colspan="2" class="text-right"><b><?php echo $lang['left240'] ?></b></td>
                                                    <td colspan="2"></td>
                                                    <td class="text-center" id="subtotal">0.00</td>
                                                    <td></td>
                                                </tr>

                                                <tr class="card-hover">
                                                    <td class="text-left"><b>Price Lb:</b></td>
                                                    <td class="text-left">
                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" onblur="cdp_cal_final_total();" class="form-control form-control-sm" value="<?php echo $core->value_weight; ?>" name="price_lb" id="price_lb" style="width: 160px;">
                                                    </td>

                                                    <td colspan="2" class="text-right"> <b>Discount % </b></td>
                                                    <td colspan="2" class="text-right">
                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" onblur="cdp_cal_final_total();" value="0" name="discount_value" id="discount_value" class="form-control form-control-sm">
                                                    </td>
                                                    <td class="text-center" id="discount">0.00</td>
                                                    <td></td>
                                                </tr>

                                                <tr class="card-hover">
                                                    <td colspan="2"><b><?php echo $lang['left232'] ?>:</b> <span id="total_libras">0.00</span></td>

                                                    <td colspan="2" class="text-right"> <b>Shipping insurance % </b></td>
                                                    <td colspan="2" class="text-right">
                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" onblur="cdp_cal_final_total();" class="form-control form-control-sm" value="<?php echo $core->insurance; ?>" name="insurance_value" id="insurance_value">
                                                    </td>
                                                    <td class="text-center" id="insurance">0.00</td>
                                                    <td></td>
                                                </tr>

                                                <tr class="card-hover">
                                                    <td colspan="2"><b><?php echo $lang['left234'] ?>:</b> <span id="total_volumetrico">0.00</span></td>

                                                    <td colspan="2" class="text-right"><b>Customs tariffs %</b></td>
                                                    <td colspan="2" class="text-right">
                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" onblur="cdp_cal_final_total();" class="form-control form-control-sm" value="<?php echo $core->c_tariffs; ?>" name="tariffs_value" id="tariffs_value">

                                                    </td>
                                                    <td class="text-center" id="total_impuesto_aduanero">0.00</td>
                                                    <td></td>

                                                </tr>

                                                <tr class="card-hover">
                                                    <td colspan="2"><b><?php echo $lang['left236'] ?></b>: <span id="total_peso">0.00</span></td>
                                                    <td></td>
                                                    <td class="text-right"><b>Tax % </b></td>
                                                    <td colspan="2">
                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" onblur="cdp_cal_final_total();" class="form-control form-control-sm" value="<?php echo $core->tax; ?>" name="tax_value" id="tax_value">
                                                    </td>
                                                    <td class="text-center" id="impuesto">0.00</td>
                                                    <td></td>
                                                </tr>

                                                <tr class="card-hover">
                                                    <td colspan="2"></td>
                                                    <td class="text-right" colspan="2"><b>Re expedition</b></td>
                                                    <td colspan="2">
                                                        <input type="text" onkeypress="return cdp_soloNumeros(event)" onblur="cdp_cal_final_total();" class="form-control form-control-sm" value="0" name="reexpedicion_value" id="reexpedicion_value">
                                                    </td>
                                                    <td class="text-center" id="reexpedicion_label"></td>
                                                    <td></td>
                                                </tr>

                                                <tr class="card-hover">
                                                    <td colspan="2"></td>
                                                    <td colspan="2" class="text-right"><b><?php echo $lang['add-title44'] ?> &nbsp; <?php echo $core->currency; ?></b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center" id="total_envio">0.00</td>
                                                    <td></td>

                                                </tr>
                                            </tfoot>
                                        </table>


                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-actions">
                                            <div class="card-body">
                                                <div class="text-right">

                                                    <input type="hidden" name="total_item" id="total_item" value="0" />
                                                    <input type="hidden" name="discount_input" id="discount_input" />
                                                    <input type="hidden" name="subtotal_input" id="subtotal_input" />
                                                    <input type="hidden" name="impuesto_input" id="impuesto_input" />
                                                    <input type="hidden" name="insurance_input" id="insurance_input" />
                                                    <input type="hidden" name="total_impuesto_aduanero_input" id="total_impuesto_aduanero_input" />
                                                    <input type="hidden" name="total_envio_input" id="total_envio_input" />
                                                    <input type="hidden" name="total_weight_input" id="total_weight_input" />

                                                    <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-success" value="Consolidate" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <input type="hidden" name="core_meter" id="core_meter" value="<?php echo $core->meter; ?>" />
                    <input type="hidden" name="core_min_cost_tax" id="core_min_cost_tax" value="<?php echo $core->min_cost_tax; ?>" />



            </form>


            <?php include('views/modals/modal_add_user_shipment.php'); ?>
            <?php include('views/modals/modal_add_addresses_user.php'); ?>


        </div>


    </div>
    <footer class="footer text-center">
        &copy <?php echo date('Y') . ' ' . $core->site_name; ?> - <?php echo $lang['foot'] ?>
    </footer>

    </div>

    <?php
    include('views/modals/modal_add_ship_consolidate.php');
    ?>
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

    <script src="dataJs/consolidate_add.js"></script>



</body>

</html>