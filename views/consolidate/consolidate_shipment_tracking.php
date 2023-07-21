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
    $data = cdp_getConsolidatePrint($_GET['id']);
}

if (!isset($_GET['id']) or $data['rowCount'] != 1) {
    cdp_redirect_to("consolidate_list.php");
}

$row = $data['data'];

$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->receiver_id . "'");
$receiver_data = $db->cdp_registro();

$office = $core->cdp_getOffices();
$statusrow = $core->cdp_getStatus();


$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->sender_id . "'");
$sender_data = $db->cdp_registro();


if (isset($_POST['address'])) {
    $db = new Conexion;


    $id = $_GET['id'];

    $errors = array();

    if (empty($_POST['t_date']))

        $errors['t_date'] = 'Please Enter Date';

    if (empty($_POST['address']))

        $errors['address'] = 'Please Enter address';

    if (intval($_POST['status_courier']) <= 0)

        $errors['status_courier'] = 'Please select status courier';

    if (intval($_POST['office']) <= 0)

        $errors['office'] = 'Please select office';

    if (empty($_POST['country']))

        $errors['country'] = 'Please select country';



    if (empty($errors)) {


        $db->cdp_query('UPDATE cdb_consolidate SET    
                         
                status_courier =:status_courier               
                where  consolidate_id=:id      
            ');


        $db->bind(':status_courier', $_POST['status_courier']);
        $db->bind(':id', $id);


        $db->cdp_execute();


        $order_track = $row->c_prefix . $row->c_no;
        $date = date('Y-m-d', strtotime(trim($_POST["t_date"])));
        $time = date("H:i:s");
        $date = $date . ' ' . $time;


        $db->cdp_query("
                INSERT INTO cdb_courier_track 
                (
                    order_track,
                    t_dest,
                    t_city,
                    comments,
                    t_date,
                    status_courier,
                    office_id,
                    user_id
                    )
                VALUES
                    (
                    :order_track,
                    :country,
                    :address,
                    :comments,
                    :t_date,
                    :status_courier,
                    :office,                   
                    :user_id
                    )
            ");



        $db->bind(':order_track',  $order_track);
        $db->bind(':country', cdp_sanitize($_POST['country']));
        $db->bind(':address', cdp_sanitize($_POST['address']));
        $db->bind(':comments', cdp_sanitize($_POST['comments']));
        $db->bind(':t_date',  trim($date));
        $db->bind(':status_courier', cdp_sanitize($_POST['status_courier']));
        $db->bind(':office', cdp_sanitize($_POST['office']));
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



        $db->bind(':order_id',  $id);
        $db->bind(':is_consolidate', '1');
        $db->bind(':user_id',  $_SESSION['userid']);
        $db->bind(':action', 'added status tracking to onsolidated');
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
        $db->bind(':order_id',  $_GET['id']);
        $db->bind(':notification_description', 'The consolidated status has been updated, check it');
        $db->bind(':shipping_type', '2');
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



        $fullshipment = $row->c_prefix . $row->c_no;
        $date_ship   = date("Y-m-d H:i:s a");

        $app_url = $settings->site_url . 'track.php?order_track=' . $fullshipment;
        $subject = "Updated consolidate tracking, tracking number $fullshipment";
        $status_courier_deliver = "" . $_POST['status_courier'] . "";



        $email_template = cdp_getEmailTemplates(19);

        $body = str_replace(
            array(
                '[NAME]',
                '[TRACKING]',
                '[DELIVERY_TIME]',
                '[COURIER]',
                '[NEW_ADDRESS]',
                '[COMMENT]',
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
                $_POST['country'] . ' | ' . $_POST['address'],
                $_POST['comments'],
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

                $phone_sender = $sender_data->phone;


                $sid    = $core->twilio_sid;
                $token  = $core->twilio_token;

                $twilio = new Client($sid, $token);

                $message = $twilio->messages
                    ->create(
                        "whatsapp:" . $phone_sender, // to 
                        array(
                            "from" => "whatsapp:" . $core->twilio_number,
                            "body" => "a consolidated has been Updated, *Tracking #$fullshipment* "
                        )
                    );
            }
        }


        if (isset($_POST['notify_whatsapp_receiver']) && $_POST['notify_whatsapp_receiver'] == 1) {


            if ($core->twilio_sid != null && $core->twilio_token != null && $core->twilio_number != null) {

                $phone_receiver = $receiver_data->phone;


                $sid    = $core->twilio_sid;
                $token  = $core->twilio_token;

                $twilio = new Client($sid, $token);

                $message = $twilio->messages
                    ->create(
                        "whatsapp:" . $phone_receiver, // to 
                        array(
                            "from" => "whatsapp:" . $core->twilio_number,
                            "body" => "Consolidated has been updated, *Tracking #$fullshipment* "
                        )
                    );
            }
        }



        header("location:consolidate_view.php?id=$id");
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
    <title><?php echo $lang['status-ship1011'] ?> | <?php echo $core->site_name ?></title>
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
                                <form class="xform" id="form" name="form" method="post">
                                    <header>
                                        <h4 class="modal-title"> <b class="text-danger"><?php echo $lang['status-ship1011'] ?> </b> <b>| #<?php echo $row->c_prefix . $row->c_no; ?></b>
                                        </h4><!--  <?php echo $lang['status-ship3'] ?> <?php echo $receiver_data->country; ?> | <?php echo $receiver_data->city; ?> -->
                                        <hr>
                                    </header>


                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['status-ship4'] ?> </label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" name="country" id="country" placeholder="--Select country--" required="required">
                                                    <!-- <datalist id="browsers"> -->
                                                    <option value="">--Select country--</option>
                                                    <option value="United States">United States</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American Samoa">American Samoa</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Anguilla">Anguilla</option>
                                                    <option value="Antarctica">Antarctica</option>
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Aruba">Aruba</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bermuda">Bermuda</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Bouvet Island">Bouvet Island</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Cape Verde">Cape Verde</option>
                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                    <option value="Central African Republic">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Christmas Island">Christmas Island</option>
                                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo">Congo</option>
                                                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                                    <option value="Cook Islands">Cook Islands</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="French Guiana">French Guiana</option>
                                                    <option value="French Polynesia">French Polynesia</option>
                                                    <option value="French Southern Territories">French Southern Territories</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Gibraltar">Gibraltar</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Greenland">Greenland</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                    <option value="Guam">Guam</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guinea-bissau">Guinea-bissau</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                                    <option value="Korea, Republic of">Korea, Republic of</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon">Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Macao">Macao</option>
                                                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Martinique">Martinique</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mayotte">Mayotte</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montserrat">Montserrat</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Namibia">Namibia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                    <option value="New Caledonia">New Caledonia</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Niue">Niue</option>
                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau">Palau</option>
                                                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Pitcairn">Pitcairn</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Reunion">Reunion</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russian Federation">Russian Federation</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Saint Helena">Saint Helena</option>
                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                    <option value="Saint Lucia">Saint Lucia</option>
                                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Slovakia">Slovakia</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sri Lanka">Sri Lanka</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                                    <option value="Swaziland">Swaziland</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Timor-leste">Timor-leste</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tokelau">Tokelau</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                    <option value="Tuvalu">Tuvalu</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                    <option value="Uruguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Venezuela">Venezuela</option>
                                                    <option value="Viet Nam">Viet Nam</option>
                                                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                                                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                    <option value="Western Sahara">Western Sahara</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                    <!-- </datalist> -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6">
                                            <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['status-ship5'] ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="ti-direction"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">

                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="inputcontact" class="control-label col-form-label">Oficina</label>
                                                <select class="custom-select" name="office" id="office" list="browsee" autocomplete="off" placeholder="--Select Office--">
                                                    <option value="0">--Select Office--</option>
                                                    <!-- <datalist id="browsee"> -->
                                                    <?php foreach ($office as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name_off; ?></option>
                                                    <?php endforeach; ?>
                                                    <!-- </datalist> -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6">
                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['status-ship9'] ?></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select" name="status_courier" placeholder="--Select Status--" required="required">
                                                    <!-- <datalist id="browserst"> -->
                                                    <option value="0">--Select Status--</option>
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
                                                    <!-- </datalist> -->
                                                </select>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['status-ship6'] ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" name="t_date" id="t_date" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title16'] ?>" readonly value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>


                                        <div class="col-sm-12 col-md-6">
                                            <label for="message-text" class="control-label"><?php echo $lang['status-ship8'] ?></label>
                                            <textarea rows="3" class="form-control" placeholder="Status change details...." id="message-text" name="comments"></textarea>
                                        </div>
                                        <?php
                                        if ($core->active_whatsapp == 1) {
                                        ?>
                                            <div class="col-sm-12 col-md-6">
                                                <br>
                                                <label class="custom-control custom-checkbox" style="font-size: 18px; padding-left: 0px">
                                                    <input type="checkbox" class="custom-control-input" name="notify_whatsapp_sender" id="notify_whatsapp_sender" value="1">
                                                    <b>Notify sender by WhatsApp &nbsp; <i class="fa fa-whatsapp" style="font-size: 22px; color:#07bc4c;"></i></b>
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                                <br>
                                                <label class="custom-control custom-checkbox" style="font-size: 18px; padding-left: 0px">
                                                    <input type="checkbox" class="custom-control-input" name="notify_whatsapp_receiver" id="notify_whatsapp_receiver" value="1">
                                                    <b>Notify receiver by WhatsApp <i class="fa fa-whatsapp" style="font-size: 22px; color:#07bc4c;"></i></b>
                                                    <span class="custom-control-indicator"></span>
                                                </label>
                                            </div>
                                        <?php } ?>


                                    </div>

                                    </br>
                                    </br>
                                    <footer>
                                        <div class="pull-right">

                                            <a href="consolidate_list.php" class="btn btn-outline-secondary btn-confirmation"><span><i class="ti-share-alt"></i></span> <?php echo $lang['status-ship11'] ?></a>
                                            <button class="btn btn-success" name="dosubmit" type="submit"><?php echo $lang['status-ship10'] ?></button>
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

    <script src="assets/moment.min.js" type="text/javascript"></script>
    <script src="assets/bootstrap-datetimepicker.min.js"></script>


    <script src="assets/bootstrap-datetimepicker.min.js"></script>

    <script src="dataJs/consolidate_tracking.js"></script>

</body>

</html>