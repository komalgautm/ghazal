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



require_once('helpers/querys.php');
require_once 'helpers/vendor/autoload.php';

use Twilio\Rest\Client;

require_once("helpers/phpmailer/class.phpmailer.php");
require_once("helpers/phpmailer/class.smtp.php");

$userData = $user->cdp_getUserData();

if (isset($_GET['id'])) {
    $data = cdp_getCustomerPackagePrint($_GET['id']);
}

if (!isset($_GET['id']) or $data['rowCount'] != 1) {
    cdp_redirect_to("customer_packages_list.php");
}

$row = $data['data'];



$office = $core->cdp_getOffices();
$statusrow = $core->cdp_getStatus();


$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->sender_id . "'");
$sender_data = $db->cdp_registro();

$driverrow = $user->cdp_userAllDriver();


if (isset($_POST['person_receives'])) {
    $db = new Conexion;


    $id = $_GET['id'];

    $errors = array();

    if (empty($_POST['deliver_date']))

        $errors['deliver_date'] = 'Please Enter Date';

    if (empty($_POST['person_receives']))

        $errors['person_receives'] = 'Please Enter Person who receives';

    if (intval($_POST['driver_id']) <= 0)

        $errors['driver_id'] = 'Please select employee';

    $status_courier = 8;
    //signature update  
    if (isset($_POST['sig-dataUrl'])) {

        $img = $_POST['sig-dataUrl']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        file_put_contents('doc_signs/package' . $id . '.png', base64_decode($img));
    }





    if (!empty($_FILES['miarchivo']['name'])) {

        $target_dir = "files/";
        $image_name = time() . "_" . basename($_FILES["miarchivo"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $imageFileZise = $_FILES["miarchivo"]["size"];

        if (($imageFileType != "jpg" && $imageFileType != "png")) {

            $errors['miarchivo'] = "<p>Illegal file type. Only jpg and png file types are allowed..</p>";
        } else if (empty(getimagesize($_FILES['miarchivo']['tmp_name']))) { //1048576 byte=1MB

            $errors['miarchivo'] = "<p>Illegal file type. Only jpg and png file types are allowed.";
        } else {

            move_uploaded_file($_FILES["miarchivo"]["tmp_name"], $target_file);
            $photo_delivered = 'files/' . $image_name;
        }
    }


    if (empty($errors)) {


        $db->cdp_query('UPDATE cdb_customers_packages SET    
                         
                status_courier =:status_courier,
                person_receives=:person_receives,
                photo_delivered=:photo_delivered
                where  order_id=:id      
            ');


        $db->bind(':status_courier', $status_courier);
        $db->bind(':person_receives', $_POST['person_receives']);
        $db->bind(':id', $id);
        $db->bind(':photo_delivered', $photo_delivered);


        $db->cdp_execute();


        $order_track = $row->order_prefix . $row->order_no;
        $date = date('Y-m-d', strtotime(trim($_POST["deliver_date"])));
        $time = date("H:i:s");
        $date = $date . ' ' . $time;


        $db->cdp_query("
                INSERT INTO cdb_courier_track 
                (
                    order_track,
                    t_date,
                    status_courier,
                    user_id
                    )
                VALUES
                    (
                    :order_track,
                    :t_date,
                    :status_courier,                   
                    :user_id
                    )
            ");



        $db->bind(':order_track',  $order_track);
        $db->bind(':user_id',  $_SESSION['userid']);
        $db->bind(':t_date',  trim($date));
        $db->bind(':status_courier', $status_courier);

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
        $db->bind(':order_id',  $_GET['id']);
        $db->bind(':notification_description', 'The package has been delivered, please check it');
        $db->bind(':shipping_type', '4');
        $db->bind(':notification_date',  date("Y-m-d H:i:s"));

        $db->cdp_execute();


        $notification_id = $db->dbh->lastInsertId();

        //NOTIFICATION TO DRIVER

        cdp_insertNotificationsUsers($notification_id, $row->driver_id);


        //NOTIFICATION TO ADMIN AND EMPLOYEES

        $users_employees = cdp_getUsersAdminEmployees();

        foreach ($users_employees as $key) {

            cdp_insertNotificationsUsers($notification_id, $key->id);
        }


        //NOTIFICATION TO CUSTOMER

        cdp_insertNotificationsUsers($notification_id, $row->sender_id);


        $sql = "SELECT * FROM cdb_settings";

        $db->cdp_query($sql);

        $db->cdp_execute();

        $settings = $db->cdp_registro();

        $site_email = $settings->site_email;
        $check_mail = $settings->mailer;
        $names_info = $settings->smtp_names;
        $mlogo      = $settings->logo;
        $msite_url  = $settings->site_url;
        $msnames    = $settings->site_name;

        //SMTP

        $smtphoste = $settings->smtp_host;
        $smtpuser = $settings->smtp_user;
        $smtppass = $settings->smtp_password;
        $smtpport = $settings->smtp_port;
        $smtpsecure = $settings->smtp_secure;


        $fullshipment = $row->order_prefix . $row->order_no;
        $date_ship   = date("Y-m-d H:i:s a");

        $app_url = $settings->site_url . 'track.php?order_track=' . $fullshipment;
        $subject = "package has been delivered, tracking number $fullshipment";
        $status_courier_deliver = 'Delivered';



        $email_template = cdp_getEmailTemplates(23);

        $body = str_replace(
            array(
                '[NAME]',
                '[TRACKING]',
                '[DELIVERY_TIME]',
                '[COURIER]',
                '[URL]',
                '[URL_LINK]',
                '[SITE_NAME]',
                '[URL_SHIP]'
            ),
            array(
                $sender_data->fname . ' ' . $sender_data->lname,
                $fullshipment,
                $date_ship,
                $status_courier_deliver,
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

        if (isset($_POST['notify_whatsapp']) && $_POST['notify_whatsapp'] == 1) {


            if ($core->twilio_sid != null && $core->twilio_token != null && $core->twilio_number != null) {

                $phone_sender = $sender_data->phone;

                $sid    = $core->twilio_sid;
                $token  = $core->twilio_token;

                $twilio = new Client($sid, $token);

                $message = $twilio->messages
                    ->create(
                        "whatsapp:" . $phone_sender, // to 
                        array(
                            "from" => "whatsapp:" . $core->twilio_number,
                            "body" => "Package has been delivered, *Tracking #$fullshipment* Follow up on your package by entering the following link and you will have detailed information on the status of your packages $app_url"
                        )
                    );
            }
        }


        header("location:customer_packages_view.php?id=$id");
    }
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
    <title>Deliver package | <?php echo $core->site_name ?></title>
    <!-- This Page CSS -->
    <!-- Custom CSS -->
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


        <!-- End Left Sidebar - style you can find in sidebar.scss  -->

        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">


            <div class="container-fluid">


                <div class="row justify-content-center">
                    <!-- Column -->
                    <div class="col-lg-12 col-xlg-12 col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <!-- <div id="loader" style="display:none"></div> -->
                                <div id="resultados_ajax">
                                    <?php if (!empty($errors)) { ?>
                                        <div class="alert alert-danger" id="success-alert">
                                            <p><span class="icon-minus-sign"></span><i class="close icon-remove-circle"></i>
                                                <span>Error! </span> There was an error processing the request
                                            <ul class="error">
                                                <?php
                                                foreach ($errors as $error) { ?>
                                                    <li>
                                                        <i class="icon-double-angle-right"></i>
                                                        <?php
                                                        echo $error;

                                                        ?>

                                                    </li>
                                                <?php
                                                }
                                                ?>


                                            </ul>
                                            </p>
                                        </div>
                                    <?php
                                    } ?>

                                </div>
                                <form name="myForm" class="xform" enctype="multipart/form-data" id="deliver_form" method="POST">
                                    <header>
                                        <h4 class="modal-title"> <b class="text-danger">Package tracking </b> <b>| #<?php echo $row->order_prefix . $row->order_no; ?></b>
                                        </h4><!--  <?php echo $lang['status-ship3'] ?> <?php echo $receiver_data->country; ?> | <?php echo $receiver_data->city; ?> -->
                                        <hr>
                                    </header>


                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['deliver-ship4'] ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" name="deliver_date" id="deliver_date" value="<?php echo date('Y-m-d'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title16'] ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputname" class="control-label col-form-label">Employee</label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="driver_id" name="driver_id" required>
                                                    <option value="">--Select Employee -</option>
                                                    <?php foreach ($driverrow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>" <?php if ($row->id == $_SESSION['userid']) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row->fname . ' ' . $row->lname; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>





                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <label for="message-text" class="control-label"><?php echo $lang['deliver-ship6'] ?></label>
                                            <input type="text" name="person_receives" id="person_receives" class="form-control" placeholder="Name who receives the package" required="">
                                        </div>



                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label class="subtitle"><?php echo $lang['left1064'] ?> </label>
                                                <input type="file" class="form-control form-control-sm" name="miarchivo" id="miarchivo">
                                            </div>
                                        </div>




                                    </div>

                                    <br>

                                    <div class="row">

                                        <div class="col-sm-12 col-md-5 ml-4">
                                            <label for="inputcontact" class="control-label col-form-label"><i align='left'><img src='assets/images/alert/sign_icon.png' width='32' /></i>&nbsp;&nbsp;&nbsp;Draw your signature with your mouse</label>

                                            <div class="row">

                                                <!-- Trigger the modal with a button -->
                                                <button type="button" class="btn btn-info ml-4" data-toggle="modal" data-target=".bs-example-modal-lg"> Open signature </button>



                                                <!-- sample modal content -->
                                                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myLargeModalLabel">Draw your signature with your mouse</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>
                                                                    <canvas id="sig-canvas" width="400" height="160">
                                                                        Get a better browser.
                                                                    </canvas>
                                                                </p>

                                                                <br><br><br><br><br><br><br><br>
                                                                <span class="btn btn-danger" id="sig-clearBtn">Clear Signature</span>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect text-left" data-dismiss="modal">Save signature</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->


                                            </div>


                                            <div class="row" style="display:none">
                                                <div class="col-md-8">
                                                    <textarea id="sig-dataUrl" name="sig-dataUrl" class="form-control" rows="5">Data URL for your signature will go here!</textarea>
                                                </div>
                                            </div>


                                        </div>
                                        <?php
                                        if ($core->active_whatsapp == 1) {
                                        ?>
                                            <div class="col-sm-12 col-md-5 offset-1 mt-4">
                                                <label class="custom-control custom-checkbox" style="font-size: 18px; padding-left: 0px">
                                                    <input type="checkbox" class="custom-control-input" name="notify_whatsapp" id="notify_whatsapp" value="1">
                                                    <b>Notify sender by WhatsApp <i class="fa fa-whatsapp" style="font-size: 22px; color:#07bc4c;"></i></b>
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>


                                    </br>
                                    </br>
                                    </br>
                                    <footer>
                                        <div class="pull-right">

                                            <a href="index.php" class="btn btn-outline-secondary btn-confirmation"><span><i class="ti-share-alt"></i></span> <?php echo $lang['status-ship11'] ?></a>

                                            <button class="btn btn-success" type="submit" id="sig-submitBtn"><?php echo $lang['deliver-ship10'] ?></button>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- Column -->
                </div>





            </div>


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

    </script>
    <script src="assets/custom_dependencies/jquery-3.6.0.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/custom_dependencies/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.js"></script>
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
    <script src="assets/js/global.js"></script>
    <script src="assets/moment.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap-datetimepicker.min.js"></script>

    <script src="dataJs/customer_packages_deliver.js"></script>
</body>

</html>