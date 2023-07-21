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

$userData = $user->cdp_getUserData();
if ($userData->userlevel == 1)
    cdp_redirect_to("login.php");


if (isset($_GET['id'])) {
    $data = cdp_getCourierPrint($_GET['id']);
}

if (!isset($_GET['id']) or $data['rowCount'] != 1) {
    cdp_redirect_to("courier_list.php");
}

$row_order = $data['data'];


$db->cdp_query("SELECT * FROM cdb_add_order_item WHERE order_id='" . $_GET['id'] . "'");
$order_items = $db->cdp_registros();

$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row_order->sender_id . "'");
$sender_data = $db->cdp_registro();

$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row_order->receiver_id . "'");
$receiver_data = $db->cdp_registro();


$db->cdp_query("SELECT * FROM cdb_address_shipments where order_track='" . $row_order->order_prefix . $row_order->order_no . "'");
$address_order = $db->cdp_registro();




if (isset($_POST["total_item"])) {

    $db = new Conexion;


    $sale_date   = date("Y-m-d H:i:s");

    $sql_payment_methods = "SELECT * FROM cdb_payment_methods where id=:id";

    $db->cdp_query($sql_payment_methods);

    $db->bind(':id',  trim($_POST["order_payment_method"]));


    $db->cdp_execute();

    $payment_methods = $db->cdp_registro();

    $days = $payment_methods->days;


    $days = intval($days);

    $due_date = cdp_sumardias($sale_date, $days);

    if ($days == 0) {

        $status_invoice = 1;
    } else {

        $status_invoice = 2;
    }



    $db->cdp_query("
                UPDATE  cdb_add_order SET                
                    
                    sender_address_id= :sender_address_id,
                    receiver_address_id = :receiver_address_id,

                    total_weight=:total_weight,                 
                    sub_total =:sub_total,
                    total_tax_insurance =:total_tax_insurance,
                    total_tax_custom_tariffis =:total_tax_custom_tariffis,
                    total_tax_discount=:total_tax_discount,                    
                    total_reexp=:total_reexp,                    
                    total_tax =:total_tax,
                    total_order =:total_order,                    
                    order_datetime =:order_datetime,
                    agency =:agency,
                    origin_off =:origin_off,
                    order_package =:order_package,
                    order_courier =:order_courier,
                    order_service_options =:order_service_options,
                    order_deli_time =:order_deli_time,                   
                    order_pay_mode =:order_pay_mode,
                    order_payment_method=:order_payment_method,
                    status_courier =:status_courier,
                    driver_id=:driver_id,
                    volumetric_percentage=:volumetric_percentage,
                    tax_value=:tax_value,
                    tax_insurance_value=:tax_insurance_value,
                    tax_custom_tariffis_value=:tax_custom_tariffis_value,
                    tax_discount=:tax_discount,
                    value_weight=:value_weight,
                    due_date=:due_date,
                    status_invoice= :status_invoice,
                    order_incomplete='1',
                    total_declared_value= :total_declared_value,
                    declared_value = :declared_value


                    WHERE order_no=:order_no
                 
                
            ");

    $db->bind(':due_date',  $due_date);
    $db->bind(':status_invoice',  $status_invoice);

    $db->bind(':order_payment_method',  cdp_sanitize($_POST["order_payment_method"]));

    $db->bind(':tax_value', floatval($_POST["tax_value"]));
    $db->bind(':tax_insurance_value', floatval($_POST["insurance_value"]));
    $db->bind(':tax_custom_tariffis_value', floatval($_POST["tariffs_value"]));
    $db->bind(':value_weight',  floatval($_POST["price_lb"]));

    $db->bind(':volumetric_percentage', $core->meter);
    $db->bind(':order_no',  $row_order->order_no);
    $db->bind(':order_datetime',  cdp_sanitize($_POST["order_date"]));

    $db->bind(':sender_address_id',  cdp_sanitize($_POST["sender_address_id"]));
    $db->bind(':receiver_address_id',  cdp_sanitize($_POST["recipient_address_id"]));

    $db->bind(':total_reexp',  floatval($_POST["reexpedicion_value"]));
    $db->bind(':total_declared_value',  floatval($_POST["declared_value_input"]));
    $db->bind(':declared_value',  floatval($_POST["declared_value_tax"]));

    $db->bind(':sub_total',  cdp_sanitize($_POST["subtotal_input"]));
    $db->bind(':tax_discount',  floatval($_POST["discount_value"]));
    $db->bind(':total_tax_discount',  floatval($_POST["discount_input"]));
    $db->bind(':total_tax_insurance',  cdp_sanitize($_POST["insurance_input"]));
    $db->bind(':total_tax_custom_tariffis',  cdp_sanitize($_POST["total_impuesto_aduanero_input"]));
    $db->bind(':total_tax',  cdp_sanitize($_POST["impuesto_input"]));
    $db->bind(':total_order',  cdp_sanitize($_POST["total_envio_input"]));
    $db->bind(':total_weight',  floatval($_POST["total_weight_input"]));

    $db->bind(':agency',  cdp_sanitize($_POST["agency"]));
    $db->bind(':origin_off',  cdp_sanitize($_POST["origin_off"]));
    $db->bind(':order_package',  cdp_sanitize($_POST["order_package"]));
    $db->bind(':order_courier',  cdp_sanitize($_POST["order_courier"]));
    $db->bind(':order_service_options',  cdp_sanitize($_POST["order_service_options"]));
    $db->bind(':order_deli_time',  cdp_sanitize($_POST["order_deli_time"]));
    $db->bind(':order_pay_mode',  cdp_sanitize($_POST["order_pay_mode"]));
    $db->bind(':status_courier',  cdp_sanitize($_POST["status_courier"]));
    $db->bind(':driver_id',  cdp_sanitize($_POST["driver_id"]));

    $db->cdp_execute();

    $order_id = $row_order->order_id;

    $db->cdp_query("DELETE FROM  cdb_add_order_item WHERE order_id='" . $order_id . "'");
    $db->cdp_execute();




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
    $db->bind(':action', 'acepted shipping pickup');
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
    $db->bind(':notification_description', 'There is a Shipment has been accepted, please check it');
    $db->bind(':shipping_type', '1');
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

    cdp_insertNotificationsUsers($notification_id, $sender_data->id);


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
                UPDATE cdb_address_shipments SET
                
                    sender_address= :sender_address,
                    sender_country= :sender_country,
                    sender_city= :sender_city,
                    sender_zip_code= :sender_zip_code,

                    recipient_address= :recipient_address,
                    recipient_country= :recipient_country,
                    recipient_city= :recipient_city,
                    recipient_zip_code=:recipient_zip_code  

                    WHERE order_track=:order_track

            ");



    $db->bind(':order_track',  $row_order->order_prefix . $row_order->order_no);

    $db->bind(':sender_address',  $sender_address);
    $db->bind(':sender_country',  $sender_country);
    $db->bind(':sender_city',  $sender_city);
    $db->bind(':sender_zip_code',  $sender_zip_code);

    $db->bind(':recipient_address',  $recipient_address);
    $db->bind(':recipient_country',  $recipient_country);
    $db->bind(':recipient_city',  $recipient_city);
    $db->bind(':recipient_zip_code',  $recipient_zip_code);

    $db->cdp_execute();




    header("location:courier_view.php?id=$row_order->order_id");
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
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <title><?php echo $lang['edit-courier1'] ?> | <?php echo $core->site_name ?></title>
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
        <?php $statusrow = $core->cdp_getStatusPickup(); ?>
        <?php $packrow = $core->cdp_getPack(); ?>
        <?php $payrow = $core->cdp_getPayment(); ?>
        <?php $paymethodrow = $core->cdp_getPaymentMethod(); ?>

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
                        <h4 class="page-title"><i class="ti-package" aria-hidden="true"></i> Edit Shipments</h4>
                    </div>
                </div>
            </div>

            <form method="post" id="invoice_form" name="invoice_form">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">

                                        <div class="form-group col-md-4">

                                            <label for="inputcom" class="control-label col-form-label"><?php echo $lang['add-title24'] ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><span style="color:#ff0000"><b># INVOICE</b></span></div>
                                                </div>
                                                <input type="text" class="form-control" name="order_no" id="order_no" value="<?php echo $row_order->order_prefix . $row_order->order_no; ?>" readonly>
                                            </div>

                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputlname" class="control-label col-form-label"><?php echo $lang['left201'] ?> </label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="agency" name="agency">
                                                    <option value="0">--<?php echo $lang['left202'] ?>--</option>
                                                    <?php foreach ($agencyrow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>" <?php if ($row_order->agency == $row->id) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row->name_branch; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>




                                        <?php if ($user->access_level = 'Admin') { ?>

                                            <div class="form-group col-md-4">
                                                <label for="inputname" class="control-label col-form-label"><?php echo $lang['add-title14'] ?></label>
                                                <div class="input-group mb-3">
                                                    <select class="custom-select col-12" id="origin_off" name="origin_off">
                                                        <option value="0">--<?php echo $lang['left343'] ?>--</option>

                                                        <?php foreach ($office as $row) : ?>
                                                            <option value="<?php echo $row->id; ?>" <?php if ($row_order->origin_off == $row->id) {
                                                                                                        echo 'selected';
                                                                                                    } ?>><?php echo $row->name_off; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
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

                                    <div class="row">

                                        <div class="col-md-12 ">

                                            <label class="control-label col-form-label"><?php echo $lang['sender_search_title'] ?></label>


                                            <div class="input-group">
                                                <select class="select2 form-control custom-select" style="width: 97%;" id="sender_id" name="sender_id" disabled>
                                                    <option value="<?php echo $sender_data->id; ?>"><?php echo $sender_data->fname . " " . $sender_data->lname; ?></option>
                                                </select>


                                            </div>
                                        </div>





                                        <div class="col-md-12 ">

                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['sender_search_address_title'] ?></label>

                                            <div class="input-group">
                                                <select class="select2 form-control" id="sender_address_id" name="sender_address_id" style="width: 97%;">
                                                    <option value="<?php echo $row_order->sender_address_id; ?>"><?php echo $address_order->sender_address; ?></option>
                                                </select>

                                                <div class="input-group-append input-sm">
                                                    <button id="add_address_sender" data-type_user="user_customer" data-toggle="modal" data-target="#myModalAddRecipientAddresses" type="button" class="btn btn-default"><i class="fa fa-plus"></i></button>
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

                                                <select class="select2 form-control custom-select" id="recipient_id" style="width: 97%;" name="recipient_id" disabled>
                                                    <option value="<?php echo $receiver_data->id; ?>"><?php echo $receiver_data->fname . " " . $receiver_data->lname; ?></option>
                                                </select>



                                            </div>
                                        </div>

                                        <div class="col-md-12">

                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['recipient_search_address_title'] ?></label>


                                            <div class="input-group">

                                                <select class="select2 form-control" id="recipient_address_id" name="recipient_address_id" style="width: 97%;">
                                                    <option value="<?php echo $row_order->receiver_address_id; ?>"><?php echo $address_order->recipient_address; ?></option>
                                                </select>

                                                <div class="input-group-append input-sm">
                                                    <button id="add_address_recipient" type="button" data-type_user="user_recipient" data-toggle="modal" data-target="#myModalAddRecipientAddresses" class="btn btn-default"><i class="fa fa-plus"></i></button>
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
                                                        <option value="<?php echo $row->id; ?>" <?php if ($row_order->order_package == $row->id) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row->name_pack; ?></option>
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
                                                        <option value="<?php echo $row->id; ?>" <?php if ($row_order->order_courier == $row->id) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row->name_com; ?></option>
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
                                                        <option value="<?php echo $row->id; ?>" <?php if ($row_order->order_service_options == $row->id) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row->ship_mode; ?></option>
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
                                                <input type='text' class="form-control" name="order_date" id="order_date" placeholder="--<?php echo $lang['left206'] ?>--" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title16'] ?>" value="<?php echo date("Y/m/d", strtotime($row_order->order_datetime)); ?>" readonly />
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['add-title20'] ?></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="order_deli_time" name="order_deli_time">
                                                    <option value="0">--<?php echo $lang['left207'] ?>--</option>
                                                    <?php foreach ($delitimerow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>" <?php if ($row_order->order_deli_time == $row->id) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row->delitime; ?></option>
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
                                                        <option value="<?php echo $row->id; ?>" <?php if ($row_order->driver_id == $row->id) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row->fname . ' ' . $row->lname; ?></option>
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
                                                        <option value="<?php echo $row->id; ?>" <?php if ($row_order->order_pay_mode == $row->id) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row->met_payment; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputEmail3" class="control-label col-form-label"><?php echo $lang['payment_methods'] ?></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="order_payment_method" name="order_payment_method">
                                                    <!-- <option value="0">--<?php echo $lang['left243'] ?>--</option> -->
                                                    <?php foreach ($paymethodrow as $row) : ?>
                                                        <option value="<?php echo $row->id; ?>"><?php echo $row->label; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!--/span-->


                                        <!--/span-->

                                        <div class="form-group col-md-4">
                                            <label for="inputcontact" class="control-label col-form-label"><?php echo $lang['add-title19'] ?> <i style="color:#ff0000" class="fas fa-shipping-fast"></i></label>
                                            <div class="input-group mb-3">
                                                <select class="custom-select col-12" id="status_courier" name="status_courier">
                                                    <option value="0">--<?php echo $lang['left210'] ?>--</option>
                                                    <?php foreach ($statusrow as $row) : ?>

                                                        <option value="<?php echo $row->id; ?>" <?php if ($row_order->status_courier == $row->id) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $row->mod_style; ?></option>

                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->

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

                                    <?php


                                    $sumador_total = 0;
                                    $sumador_valor_declarado = 0;
                                    $sumador_libras = 0;
                                    $sumador_volumetric = 0;
                                    $precio_total = 0;
                                    $total_impuesto = 0;
                                    $total_seguro = 0;
                                    $total_peso = 0;
                                    $total_descuento = 0;
                                    $total_impuesto_aduanero = 0;
                                    $count_item = 0;

                                    $total_valor_declarado = 0;
                                    if ($order_items) {

                                        foreach ($order_items as $row_item) {


                                            $description_item = $row_item->order_item_description;
                                            $weight_item = $row_item->order_item_weight;

                                            $total_metric = $row_item->order_item_length * $row_item->order_item_width * $row_item->order_item_height / $row_order->volumetric_percentage;

                                            // calculate weight x price
                                            if ($weight_item > $total_metric) {

                                                $calculate_weight = $weight_item;
                                                $sumador_libras += $weight_item; //Sumador

                                            } else {

                                                $calculate_weight = $total_metric;
                                                $sumador_volumetric += $total_metric; //Sumador
                                            }

                                            $precio_total = $calculate_weight * $core->value_weight;
                                            $precio_total = number_format($precio_total, 2, '.', ''); //Precio total formateado

                                            $sumador_total += $precio_total;
                                            $sumador_valor_declarado += $row_item->order_item_declared_value;

                                            if ($sumador_total > 200) {

                                                $total_impuesto = $sumador_total * $core->tax / 100;
                                            }

                                            if ($sumador_valor_declarado > $core->min_cost_declared_tax) {

                                                $total_valor_declarado = $sumador_valor_declarado * $row_order->declared_value / 100;
                                            }

                                            $total_descuento = $sumador_total * $row_order->tax_discount / 100;

                                            $total_peso = $sumador_libras + $sumador_volumetric;

                                            $total_seguro = $sumador_total * $core->insurance / 100;

                                            $total_impuesto_aduanero = $total_peso * $core->c_tariffs;



                                            $total_envio = ($sumador_total - $total_descuento) + $total_impuesto + $total_seguro + $total_impuesto_aduanero + $total_valor_declarado + $row_order->total_reexp;

                                            $sumador_total = number_format($sumador_total, 2, '.', '');
                                            $sumador_libras = number_format($sumador_libras, 2, '.', '');
                                            $sumador_volumetric = number_format($sumador_volumetric, 2, '.', '');
                                            $total_envio = number_format($total_envio, 2, '.', '');
                                            $total_seguro = number_format($total_seguro, 2, '.', '');
                                            $total_peso = number_format($total_peso, 2, '.', '');
                                            $total_impuesto_aduanero = number_format($total_impuesto_aduanero, 2, '.', '');
                                            $total_impuesto = number_format($total_impuesto, 2, '.', '');
                                            $total_descuento = number_format($total_descuento, 2, '.', '');
                                            $sumador_valor_declarado = number_format($sumador_valor_declarado, 2, '.', '');
                                            $total_valor_declarado = number_format($total_valor_declarado, 2, '.', '');

                                            $count_item++;
                                    ?>



                                            <div class="card-hover" id="row_id_<?php echo $count_item; ?>">
                                                <hr>

                                                <div class="row">

                                                    <div class="col-md-4">

                                                        <div class="form-group">


                                                            <label for="emailAddress1">Category</label>
                                                            <div class="input-group">
                                                                <select class="custom-select col-12 order_item_category<?php echo $count_item; ?>" id="order_item_category<?php echo $count_item; ?>" name="order_item_category[]" required>
                                                                    <option value="0">--Select Category--</option>
                                                                    <?php foreach ($categories as $row) :

                                                                    ?>
                                                                        <option value="<?php echo $row->id; ?>" <?php if ($row->id == $row_item->order_item_category) {
                                                                                                                    echo 'selected';
                                                                                                                }  ?>><?php echo $row->name_item; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-5">

                                                        <div class="form-group">

                                                            <label for="emailAddress1"><?php echo $lang['left213'] ?></label>
                                                            <div class="input-group">
                                                                <input type="text" name="order_item_description[]" id="order_item_description<?php echo $count_item; ?>" class="form-control input-sm order_item_description" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left225'] ?>" placeholder="<?php echo $lang['left224'] ?>" required value="<?php echo $description_item; ?>">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">

                                                        <div class="form-group">

                                                            <label for="emailAddress1"> Declared value</label>
                                                            <div class="input-group">

                                                                <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_declared_value[]" id="order_item_declared_value<?php echo $count_item; ?>" data-srno="1" class="form-control input-sm number_only order_item_declared_value" data-toggle="tooltip" data-placement="bottom" title="Declared value" value="<?php echo $row_item->order_item_declared_value; ?>" />

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
                                                                    <button type="button" class="btn btn-info" onclick="cdp_decrementInputNumber('order_item_quantity', <?php echo $count_item; ?>)"><i class="fa fa-minus"></i></button>
                                                                </div>
                                                                <input min="1" type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_quantity[]" id="order_item_quantity<?php echo $count_item; ?>" data-srno="1" class="form-control input-sm order_item_quantity" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['left227'] ?>" value="<?php echo $row_item->order_item_quantity; ?>" required />
                                                                <div class="input-group-append input-sm">
                                                                    <button type="button" class="btn btn-info" onclick="cdp_incrementInputNumber('order_item_quantity', <?php echo $count_item; ?>)"><i class="fa fa-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-2">

                                                        <div class="form-group">

                                                            <label for="emailAddress1"><?php echo $lang['left215']; ?></label>
                                                            <div class="input-group">

                                                                <div class="input-group-append input-sm">
                                                                    <button type="button" class="btn btn-info" onclick="cdp_decrementInputNumber('order_item_weight', <?php echo $count_item; ?>)"><i class="fa fa-minus"></i></button>
                                                                </div>

                                                                <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_weight[]" id="order_item_weight<?php echo $count_item; ?>" data-srno="1" class="form-control input-sm order_item_weight" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title31'] ?>" value="<?php echo $row_item->order_item_weight; ?>" />

                                                                <div class="input-group-append input-sm">
                                                                    <button type="button" class="btn btn-info" onclick="cdp_incrementInputNumber('order_item_weight', <?php echo $count_item; ?>)"><i class="fa fa-plus"></i></button>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="emailAddress1"><?php echo $lang['left216'] ?></label>
                                                            <div class="input-group">
                                                                <div class="input-group-append input-sm">
                                                                    <button type="button" class="btn btn-info" onclick="cdp_decrementInputNumber('order_item_length', <?php echo $count_item; ?>)"><i class="fa fa-minus"></i></button>
                                                                </div>

                                                                <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_length[]" id="order_item_length<?php echo $count_item; ?>" data-srno="1" class="form-control input-sm text_only order_item_length" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title37'] ?>" value="<?php echo $row_item->order_item_length; ?>" />
                                                                <div class="input-group-append input-sm">
                                                                    <button type="button" class="btn btn-info" onclick="cdp_incrementInputNumber('order_item_length', <?php echo $count_item; ?>)"><i class="fa fa-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-2">

                                                        <div class="form-group">

                                                            <label for="emailAddress1"><?php echo $lang['left217'] ?></label>
                                                            <div class="input-group">
                                                                <div class="input-group-append input-sm">
                                                                    <button type="button" class="btn btn-info" onclick="cdp_decrementInputNumber('order_item_width', <?php echo $count_item; ?>)"><i class="fa fa-minus"></i></button>
                                                                </div>

                                                                <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_width[]" id="order_item_width<?php echo $count_item; ?>" data-srno="1" class="form-control input-sm text_only order_item_width" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title38'] ?>" value="<?php echo $row_item->order_item_width; ?>" />
                                                                <div class="input-group-append input-sm">
                                                                    <button type="button" class="btn btn-info" onclick="cdp_incrementInputNumber('order_item_width', <?php echo $count_item; ?>)"><i class="fa fa-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">

                                                        <div class="form-group">

                                                            <label for="emailAddress1"><?php echo $lang['left218'] ?></label>
                                                            <div class="input-group">

                                                                <div class="input-group-append input-sm">
                                                                    <button type="button" class="btn btn-info" onclick="cdp_decrementInputNumber('order_item_height', <?php echo $count_item; ?>)"><i class="fa fa-minus"></i></button>
                                                                </div>

                                                                <input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_height[]" id="order_item_height<?php echo $count_item; ?>" data-srno="1" class="form-control input-sm number_only order_item_height" data-toggle="tooltip" data-placement="bottom" title="<?php echo $lang['add-title39'] ?>" value="<?php echo $row_item->order_item_height; ?>" />
                                                                <div class="input-group-append input-sm">
                                                                    <button type="button" class="btn btn-info" onclick="cdp_incrementInputNumber('order_item_height', <?php echo $count_item; ?>)"><i class="fa fa-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-1">
                                                        <div class="form-group  mt-4" align="right">
                                                            <button type="button" name="remove_row" id="<?php echo $count_item; ?>" class="btn btn-danger mt-2 remove_row"><i class="fa fa-trash"></i> Delete </button>
                                                        </div>
                                                    </div>




                                                </div>
                                                <hr>
                                            </div>

                                        <?php
                                        } ?>



                                        <div id="data_items"></div>

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div align="">
                                                    <button type="button" name="add_row" id="add_row" class="btn btn-success mb-2"><span class="fa fa-plus"></span> <?php echo $lang['left231'] ?></button>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="invoice-item-table" class="table">


                                                <tfoot>
                                                    <tr class="card-hover">
                                                        <td colspan="2"></td>
                                                        <td colspan="2" class="text-right"><b><?php echo $lang['left240'] ?></b></td>
                                                        <td colspan="2"></td>
                                                        <td class="text-center" id="subtotal">0.00</td>
                                                        <td></td>
                                                    </tr>

                                                    <tr class="card-hover">
                                                        <td colspan="1"><b>Price Lb:</b></td>
                                                        <td>
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
                                                        <td colspan="2"><b>Total declared value:</b> <span id="total_declared">0.00</span></td>
                                                        <td class="text-right" colspan="2"><b>Declared tax % </b></td>
                                                        <td colspan="2">
                                                            <input type="text" onkeypress="return cdp_soloNumeros(event)" onblur="cdp_cal_final_total();" class="form-control form-control-sm" value="<?php echo $core->declared_tax; ?>" name="declared_value_tax" id="declared_value_tax">
                                                        </td>
                                                        <td class="text-center" id="declared_value_label">0.00</td>
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

                                                <input type="hidden" name="total_item" id="total_item" value="<?php echo $count_item; ?>" />
                                            <?php
                                        } ?>
                                            </table>


                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-actions">
                                                <div class="card-body">
                                                    <div class="text-right">

                                                        <input type="hidden" name="sumador_valor_declarado" id="sumador_valor_declarado" alue="<?php echo $sumador_valor_declarado; ?>" />

                                                        <input type="hidden" name="declared_value_input" id="declared_value_input" value="<?php echo $sumador_valor_declarado; ?>" />

                                                        <input type="hidden" name="subtotal_input" id="subtotal_input" / value="<?php echo $sumador_total; ?>">

                                                        <input type="hidden" name="impuesto_input" id="impuesto_input" value="<?php echo $total_impuesto; ?>" />

                                                        <input type="hidden" name="discount_input" id="discount_input" / value="<?php echo $total_descuento; ?>">

                                                        <input type="hidden" name="insurance_input" id="insurance_input" / value="<?php echo $total_seguro; ?>">

                                                        <input type="hidden" name="total_impuesto_aduanero_input" id="total_impuesto_aduanero_input" / value="<?php echo $total_impuesto_aduanero; ?>">

                                                        <input type="hidden" name="total_envio_input" id="total_envio_input" value="<?php echo $total_envio; ?>" />

                                                        <input type="hidden" name="total_weight_input" id="total_weight_input" / value="<?php echo $total_peso; ?>">

                                                        <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-success" value="Update Invoice" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <input type="hidden" name="order_volumetric_percentage" id="order_volumetric_percentage" value="<?php echo $row_order->volumetric_percentage; ?>" />
                    <input type="hidden" name="core_min_cost_tax" id="core_min_cost_tax" value="<?php echo $core->min_cost_tax; ?>" />
                    <input type="hidden" name="core_min_cost_declared_tax" id="core_min_cost_declared_tax" value="<?php echo $core->min_cost_declared_tax; ?>" />

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
    <script src="dataJs/courier_accept.js"></script>




</body>

</html>