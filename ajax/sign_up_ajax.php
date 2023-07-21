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



require_once("../loader.php");
require_once("../helpers/querys.php");
require_once("../helpers/phpmailer/class.phpmailer.php");
require_once("../helpers/phpmailer/class.smtp.php");

$user = new User;
$core = new Core;
$db = new Conexion;

$errors = array();

if (empty($_POST['username']))

    $errors['username'] = 'Enter a valid username';

if ($value = $user->cdp_usernameExists($_POST['username']))

    if ($value == 1)

        $errors['username'] = 'Username is too short (less than 4 characters long).';

if ($value == 2)

    $errors['username'] = 'Invalid characters found in the username.';

if ($value == 3)
    $errors['username'] = 'Sorry, this username is already taken';



if (empty($_POST['fname']))

    $errors['fname'] = 'Please enter the name';
if (empty($_POST['lname']))

    $errors['lname'] = 'Please enter the last name';

if (empty($_POST['pass']))

    $errors['password'] = 'Enter a valid password.';

if (strlen($_POST['pass']) < 6)

    $errors['password'] = 'Password is too short (less than 6 characters)';

if ($_POST['pass'] != $_POST['pass2'])

    $errors['password'] = 'Your password does not match the confirmed password!.';

if (empty($_POST['email']))

    $errors['email'] = 'Enter a valid email address';

if ($user->cdp_emailExists($_POST['email']))

    $errors['email'] = 'The email address you entered is already in use.';

if (!$user->cdp_isValidEmail($_POST['email']))

    $errors['email'] = 'The email address you entered is invalid.';

if (empty($_POST['address']))

    $errors['address'] = 'Please enter the address';

if (empty($_POST['terms']))

    $errors['terms'] = 'Please accept the terms and conditions';

if (empty($errors)) {

    $datos = array(
        'username' => cdp_sanitize($_POST['username']),
        'email' => cdp_sanitize($_POST['email']),
        'lname' => cdp_sanitize($_POST['lname']),
        'fname' => cdp_sanitize($_POST['fname']),
        'locker' => cdp_sanitize($_POST['locker']),
        'country' => cdp_sanitize($_POST['country']),
        'city' => cdp_sanitize($_POST['city']),
        'postal' => cdp_sanitize($_POST['postal']),
        'address' => cdp_sanitize($_POST['address']),
        'userlevel' => 1,
    );

    if ($_POST['pass'] != "") {

        $datos['password'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    }

    if (isset($_POST['terms'])) {
        $datos['terms'] = $_POST['terms'];
    } else {
        $datos['terms'] = "";
    }



    $datos['created'] = date("Y-m-d H:i:s");




    $db->cdp_query('INSERT INTO cdb_users
        (
            username,
            password,
            locker,
            userlevel,
            email,
            fname,
            lname,
            created,
            terms
            
        )

        VALUES (
            :username,
            :password,
            :locker,
            :userlevel,
            :email,
            :fname,
            :lname,
            :created,
            :terms
        )');


    $db->bind(':username', $datos['username']);
    $db->bind(':password', $datos['password']);
    $db->bind(':userlevel', $datos['userlevel']);
    $db->bind(':email', $datos['email']);
    $db->bind(':fname', $datos['fname']);
    $db->bind(':lname', $datos['lname']);
    $db->bind(':created', $datos['created']);
    $db->bind(':locker', $datos['locker']);
    $db->bind(':terms', $datos['terms']);



    $insert = $db->cdp_execute();

    $user_created_id = $db->dbh->lastInsertId();


    $db->cdp_query("
                  INSERT INTO cdb_users_multiple_addresses 
                  (
                  address,
                  country,
                  city,
                  zip_code,
                  user_id                                
                  )
                  VALUES 
                  (
                  :address,
                  :country,
                  :city, 
                  :zip_code,
                  :user_id                            
                  )
                ");


    $db->bind(':user_id',  $user_created_id);
    $db->bind(':address',  cdp_sanitize($_POST["address"]));
    $db->bind(':country',  cdp_sanitize($_POST["country"]));
    $db->bind(':city',  cdp_sanitize($_POST["city"]));
    $db->bind(':zip_code',  cdp_sanitize($_POST["postal"]));

    $db->cdp_execute();


    if ($insert) {

        $db->cdp_query("
                INSERT INTO cdb_notifications 
                (
                    user_id,
                    notification_description,
                    shipping_type,
                    notification_date

                )
                VALUES
                    (
                    :user_id,                    
                    :notification_description,
                    :shipping_type,
                    :notification_date                    
                    )
              ");



        $db->bind(':user_id',  $user_created_id);
        $db->bind(':notification_description', 'a new user has been registered');
        $db->bind(':shipping_type', '0');
        $db->bind(':notification_date',  date("Y-m-d H:i:s"));

        $db->cdp_execute();

        $notification_id = $db->dbh->lastInsertId();


        //NOTIFICATION TO ADMIN AND EMPLOYEES

        $users_employees = cdp_getUsersAdminEmployees();

        foreach ($users_employees as $key) {

            cdp_insertNotificationsUsers($notification_id, $key->id);
        }

        $messages[] = "You have successfully registered. Please check your email for further information";
    } else {

        $errors['critical_error'] = "An error occurred during the registration process. Contact the administrator ...";
    }






    $email_template = cdp_getEmailTemplates(7);

    $body = str_replace(
        array(
            '[NAME]',
            '[USERNAME]',
            '[PASSWORD]',
            '[LOCKER]',
            '[VIRTUAL_LOCKER]',
            '[CCOUNTRY]',
            '[CCITY]',
            '[CPOSTAL]',
            '[CPHONE]',
            '[EMAIL]',
            '[URL]',
            '[URL_LINK]',
            '[SITE_NAME]'
        ),
        array(
            $_POST['fname'] . ' ' . $_POST['lname'],
            $_POST['username'],
            $_POST['pass'],
            $_POST['locker'],
            $core->locker_address,
            $core->c_country,
            $core->c_city,
            $core->c_postal,
            $core->c_phone,
            $_POST['email'],
            $core->site_url,
            $core->logo,
            $core->site_name
        ),
        $email_template->body
    );

    $newbody = cdp_cleanOut($body);


    //SENDMAIL PHP

    if ($core->mailer == 'PHP') {

        /*SIGUE RECOLECTANDO DATOS PARA FUNCION MAIL*/
        $message = $newbody;
        $websiteName = $core->site_name;
        $emailAddress = $core->site_email;
        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $header .= "From: " . $websiteName . " <" . $emailAddress . ">\r\n";
        $header .= "Bcc: " . $core->email_address . "\r\n";
        $subject = $email_template->subject;
        mail($_POST['email'], $subject, $message, $header);
        /*FINALIZA RECOLECTANDO DATOS PARA FUNCION MAIL*/


        // var_dump($user_created_id);



    } elseif ($core->mailer == 'SMTP') {


        //PHPMAILER PHP


        $destinatario = "" . $_POST['email'] . "";


        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Port = $core->smtp_port;
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";

        // Datos de la cuenta de correo utilizada para enviar vía SMTP
        $mail->Host = $core->smtp_host;       // Dominio alternativo brindado en el email de alta
        $mail->Username = $core->smtp_user;    // Mi cuenta de correo
        $mail->Password = $core->smtp_password;    //Mi contraseña


        $mail->From = $core->site_email; // Email desde donde envío el correo.
        $mail->FromName = $core->smtp_names;
        $mail->AddAddress($destinatario); // Esta es la dirección a donde enviamos los datos del formulario
        $mail->addReplyTo($destinatario);

        //CC Copia al admin
        $mail->addCC($core->email_address);

        $mail->Subject = $email_template->subject; // Este es el titulo del email.
        $mail->Body = "<html> 
              
              <body> 
              
              <p>{$newbody}</p>
              
              </body> 
              
              </html>
              
              <br />"; // Texto del email en formato HTML
        // FIN - VALORES A MODIFICAR //

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );




        $estadoEnvio = $mail->Send();
    }
}


if (!empty($errors)) {
    // var_dump($errors);
?>
    <div class="alert alert-danger" id="success-alert">
        <p><span class="icon-minus-sign"></span><i class="close icon-remove-circle"></i>
            <span>Error! </span> There was an error processing the request <br>
            <?php
            foreach ($errors as $error) { ?>
                < <?php
                    echo $error . "<br>";

                    ?> <?php

                    }
                        ?> </p>
    </div>



<?php
}

if (isset($messages)) {

?>

    <div class="alert alert-success" id="success-alert">
        <p><span class="icon-minus-sign"></span><i class="close icon-remove-circle"></i>
            <span>Success!</span>
            <?php
            foreach ($messages as $message) {
                echo $message;
            }
            ?>
        </p>
    </div>
<?php
}
?>