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



require_once("../../loader.php");
require_once("../../helpers/querys.php");
$user = new User;

$errors = array();


if (empty($_POST['fname']))

    $errors['fname'] = 'Please enter the name';
if (empty($_POST['lname']))

    $errors['lname'] = 'Please enter the last name';

if (empty($_POST['email']))

    $errors['email'] = 'Enter a valid email address';

if ($user->cdp_emailExists($_POST['email'], $_POST['id']))

    $errors[] = 'The email address you entered is already in use.';

if (!$user->cdp_isValidEmail($_POST['email']))

    $errors[] = 'The email address you entered is invalid.';


if (empty($_POST['phone']))

    $errors['phone'] = 'Please enter the phone';

if (empty($_POST['address']))

    $errors['address'] = 'Please enter the address';


if (!empty($_FILES['avatar']['name'])) {

    $target_dir = "../../assets/uploads/";
    $image_name = time() . "_" . basename($_FILES["avatar"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $imageFileZise = $_FILES["avatar"]["size"];

    if (($imageFileType != "jpg" && $imageFileType != "png")) {

        $errors['avatar'] = "<p>Illegal file type. Only jpg and png file types are allowed..</p>";
    } else if (empty(getimagesize($_FILES['avatar']['tmp_name']))) { //1048576 byte=1MB

        $errors['avatar'] = "<p>Illegal file type. Only jpg and png file types are allowed.";
    }
}

if (empty($errors)) {

    $datos = array(
        'email' => cdp_sanitize($_POST['email']),
        'lname' => cdp_sanitize($_POST['lname']),
        'fname' => cdp_sanitize($_POST['fname']),
        'newsletter' => intval($_POST['newsletter']),
        'notes' => cdp_sanitize($_POST['notes']),
        'phone' => cdp_sanitize($_POST['phone']),
        'gender' => cdp_sanitize($_POST['gender']),
        'active' => cdp_sanitize($_POST['active']),
        'id' => cdp_sanitize($_POST['id'])
    );



    $userDataEdit = cdp_getUserEdit($_POST['id']);



    if ($_POST['password'] != "") {

        $datos['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {

        $datos['password'] = $userDataEdit['data']->password;
    }




    if (!empty($_FILES['avatar']['name'])) {

        move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
        $imagen = basename($_FILES["avatar"]["name"]);
        $datos['avatar'] = 'uploads/' . $image_name;
    } else {

        $datos['avatar'] = $userDataEdit['data']->avatar;
    }


    $db->cdp_query('UPDATE cdb_users SET
          
                  password =:password,
                  email =:email,
                  fname =:fname,
                  lname =:lname,
                  notes =:notes,
                  phone =:phone,
                  gender =:gender,
                  newsletter =:newsletter,
                  active =:active,
                  avatar =:avatar

                  where id = :id
                  
              ');


    $db->bind(':password', $datos['password']);
    $db->bind(':email', $datos['email']);
    $db->bind(':fname', $datos['fname']);
    $db->bind(':lname', $datos['lname']);
    $db->bind(':notes', $datos['notes']);
    $db->bind(':phone', $datos['phone']);
    $db->bind(':gender', $datos['gender']);
    $db->bind(':newsletter', $datos['newsletter']);
    $db->bind(':active', $datos['active']);
    $db->bind(':avatar', $datos['avatar']);
    $db->bind(':id', $datos['id']);


    $db->cdp_execute();


    $db->cdp_query("DELETE FROM cdb_users_multiple_addresses WHERE user_id='" . $_POST['id'] . "'");
    $db->cdp_execute();


    for ($count = 0; $count < $_POST["total_address"]; $count++) {

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


        $db->bind(':user_id',  $_POST['id']);
        $db->bind(':address',  cdp_sanitize($_POST["address"][$count]));
        $db->bind(':country',  cdp_sanitize($_POST["country"][$count]));
        $db->bind(':city',  cdp_sanitize($_POST["city"][$count]));
        $db->bind(':zip_code',  cdp_sanitize($_POST["postal"][$count]));

        $insert = $db->cdp_execute();
    }


    if ($insert) {

        $messages[] = "Customer updated successfully!";
    } else {

        $errors['critical_error'] = "the update was not completed";
    }
}


if (!empty($errors)) {
?>
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
}

if (isset($messages)) {

?>
    <div class="alert alert-info" id="success-alert">
        <p><span class="icon-info-sign"></span><i class="close icon-remove-circle"></i>
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