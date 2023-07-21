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

if (isset($_GET['id'])) {
    $data = cdp_getConsolidatePrint($_GET['id']);
}

if (!isset($_GET['id']) or $data['rowCount'] != 1) {
    cdp_redirect_to("consolidate_list.php");
}



$row = $data['data'];

$db->cdp_query("SELECT * FROM cdb_consolidate_detail WHERE consolidate_id='" . $_GET['id'] . "'");
$order_items = $db->cdp_registros();

$db->cdp_query("SELECT * FROM cdb_met_payment where id= '" . $row->order_pay_mode . "'");
$met_payment = $db->cdp_registro();


$db->cdp_query("SELECT * FROM cdb_courier_com where id= '" . $row->order_courier . "'");
$courier_com = $db->cdp_registro();

$fecha = date("Y-m-d :h:i A", strtotime($row->order_datetime));

$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->receiver_id . "'");
$receiver_data = $db->cdp_registro();



$db->cdp_query("SELECT * FROM cdb_address_shipments where order_track='" . $row->c_prefix . $row->c_no . "'");
$address_order = $db->cdp_registro();

$db->cdp_query("SELECT * FROM cdb_users where id= '" . $row->sender_id . "'");
$sender_data = $db->cdp_registro();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->

    <title>Tracking - <?php echo $row->c_prefix . $row->c_no; ?></title>
    <link type='text/css' href='assets/custom_dependencies/print.css' rel='stylesheet' />

</head>

<body>
    <div id="page-wrap">
        <table width="100%">
            <tr>
                <td style="border: 0;  text-align: left" width="18%">
                    <div id="logo">
                        <?php echo ($core->logo) ? '<img src="assets/' . $core->logo . '" alt="' . $core->site_name . '" width="190" height="39"/>' : $core->site_name; ?>
                </td>
                <td style="border: 0;  text-align: center" width="56%">
                    <?php echo $lang['inv-shipping1'] ?>: <?php echo $core->c_nit; ?> </br>
                    <?php echo $lang['inv-shipping2'] ?>: <?php echo $core->c_phone; ?></br>
                    <?php echo $lang['inv-shipping3'] ?>: <?php echo $core->site_email; ?></br>
                    <?php echo $lang['inv-shipping4'] ?>: <?php echo $core->c_address; ?> - <?php echo $core->c_country; ?>-<?php echo $core->c_city; ?>
                </td>
                <td style="border: 0;  text-align: center" width="48%">
                    </br><img src='https://barcode.tec-it.com/barcode.ashx?data=<?php echo $row->c_prefix . $row->c_no; ?>&code=Code128&multiplebarcodes=false&translate-esc=false&unit=Fit&dpi=72&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0&modulewidth=50' alt='' />
                </td>
    </div>
    </tr>
    </table>
    <hr>
    </br>
    <div id="customer">

        <table id="meta">
            <tr>
                <td rowspan="5" style="border: 1px solid white; border-right: 1px solid black; text-align: left" width="62%">
                    <strong><?php echo $lang['inv-shipping5'] ?></strong> </br>
                    <table id="items">
                        <b><?php echo $sender_data->fname . " " . $sender_data->lname; ?></b></br> </br>
                        <?php echo $address_order->sender_address; ?> </br>
                        <?php echo $address_order->sender_country . " | " . $address_order->sender_city; ?> </br>
                        <?php echo $sender_data->phone; ?> </br>
                        <?php echo $sender_data->email; ?>
                    </table>
                </td>
                <td class="meta-head">
                    <p style="color:white;"><?php echo $lang['inv-shipping6'] ?></p>
                </td>
                <td>
                    <?php echo $met_payment->met_payment; ?>
                </td>
            </tr>
            <tr>
                <td class="meta-head">
                    <p style="color:white;"><?php echo $lang['inv-shipping7'] ?></p>
                </td>
                <td><?php echo $courier_com->name_com; ?></td>
            </tr>
            <tr>
                <td class="meta-head">
                    <p style="color:white;"><?php echo $lang['inv-shipping8'] ?></p>
                </td>
                <td><?php echo $fecha; ?></td>
            </tr>
            <tr>
                <td class="meta-head">
                    <p style="color:white;"><?php echo $lang['inv-shipping9'] ?>.</p>
                </td>
                <td><b><?php echo $row->c_prefix . $row->c_no; ?></b></td>
            </tr>
        </table>
    </div>
    <table id="items">
        <tr>
            <th colspan="3" style="color:white;"><b><?php echo $lang['ltracking'] ?></b></th>
            <th colspan="3" style="color:white;" class="text-right"><b>Weights</b></th>
            <th colspan="2" style="color:white;" class="text-right"><b>Weight Vol.</b></th>
        </tr>

        <?php
        $sumador_total = 0;
        $sumador_libras = 0;
        $sumador_volumetric = 0;

        $precio_total = 0;
        $total_impuesto = 0;
        $total_seguro = 0;
        $total_peso = 0;
        $total_descuento = 0;
        $total_impuesto_aduanero = 0;

        foreach ($order_items as $row_order_item) {

            $weight_item = $row_order_item->weight;

            $total_metric = $row_order_item->length * $row_order_item->width * $row_order_item->height / $row->volumetric_percentage;

            // calculate weight x price
            if ($weight_item > $total_metric) {

                $calculate_weight = $weight_item;
                $sumador_libras += $weight_item; //Sumador

            } else {

                $calculate_weight = $total_metric;
                $sumador_volumetric += $total_metric; //Sumador
            }

            $precio_total = $calculate_weight * $row->value_weight;
            $precio_total = number_format($precio_total, 2, '.', ''); //Precio total formateado

            $sumador_total += $precio_total;

            if ($sumador_total > 200) {

                $total_impuesto = $sumador_total * $row->tax_value / 100;
            }

            $total_descuento = $sumador_total * $row->tax_discount / 100;
            $total_peso = $sumador_libras + $sumador_volumetric;

            $total_seguro = $sumador_total * $row->tax_insurance_value / 100;

            $total_impuesto_aduanero = $total_peso * $row->tax_custom_tariffis_value;

            $total_envio = ($sumador_total - $total_descuento) + $total_impuesto + $total_seguro + $total_impuesto_aduanero + $row->total_reexp;

            $sumador_total = number_format($sumador_total, 2, '.', '');
            $sumador_libras = number_format($sumador_libras, 2, '.', '');
            $sumador_volumetric = number_format($sumador_volumetric, 2, '.', '');
            $total_envio = number_format($total_envio, 2, '.', '');
            $total_seguro = number_format($total_seguro, 2, '.', '');
            $total_peso = number_format($total_peso, 2, '.', '');
            $total_impuesto_aduanero = number_format($total_impuesto_aduanero, 2, '.', '');
            $total_impuesto = number_format($total_impuesto, 2, '.', '');
            $total_descuento = number_format($total_descuento, 2, '.', '');

        ?>

            <tr class="card-hover">
                <td colspan="3"><b><?php echo $row_order_item->order_prefix . $row_order_item->order_no; ?> </b></td>
                <td colspan="3" class="text-right"><?php echo $weight_item; ?></td>
                <td colspan="2" class="text-right"><?php echo $row_order_item->weight_vol; ?></td>


            </tr>
        <?php

        } ?>

        <tr class="card-hover">
            <td colspan="3"></td>
            <!-- <td  colspan="2"></td> -->
            <td colspan="3" class="text-right"><b><?php echo $lang['left240'] ?></b></td>
            <td colspan="2" class="text-right"><?php echo $sumador_total; ?></td>

            <!--  -->
        </tr>

        <tr class="">
            <td colspan="3"><b>Price Lb:</b> <?php echo $row->value_weight; ?></td>
            <!-- <td  colspan="2"></td> -->


            <td colspan="3" class="text-right"><b>Discount <?php echo $row->tax_discount; ?> % </b></td>
            <td class="text-right" colspan="2"><?php echo $total_descuento; ?></td>

        </tr>

        <tr>
            <td colspan="3"><b><?php echo $lang['left232'] ?>:</b> <span id="total_libras"><?php echo $sumador_libras; ?></span></td>
            <!-- <td  colspan="2"></td> -->

            <td colspan="3" class="text-right"><b>Shipping insurance <?php echo $row->tax_insurance_value; ?> % </b></td>
            <td class="text-right" colspan="2" id="insurance"><?php echo $total_seguro; ?></td>

        </tr>

        <tr>
            <td colspan="3"><b><?php echo $lang['left234'] ?>:</b> <span id="total_volumetrico"><?php echo $sumador_volumetric; ?></span></td>
            <!-- <td  colspan="2"></td> -->

            <td colspan="3" class="text-right"> <b>Customs tariffs <?php echo $row->tax_custom_tariffis_value; ?> %</b></td>
            <td class="text-right" id="total_impuesto_aduanero" colspan="2"><?php echo $total_impuesto_aduanero; ?></td>


        </tr>

        <tr>
            <td colspan="3"><b><?php echo $lang['left236'] ?></b>: <span id="total_peso"><?php echo $total_peso; ?></span></td>
            <!-- <td  colspan="2"></td> -->

            <td colspan="3" class="text-right"><b>Tax <?php echo $row->tax_value; ?> % </b></td>
            <td class="text-right" colspan="2" id="impuesto"><?php echo $total_impuesto; ?></td>

        </tr>


        <tr>
            <td colspan="3"></td>
            <!-- <td  colspan="2"></td> -->

            <td colspan="3" class="text-right"><b>Re expedition</b></td>
            <td class="text-right" colspan="2" id="impuesto"><?php echo $row->total_reexp; ?></td>

        </tr>

        <tr>
            <td colspan="3"></td>
            <!-- <td  colspan="2"></td> -->

            <td colspan="3" class="text-right"><b><?php echo $lang['add-title44'] ?> &nbsp; <?php echo $core->currency; ?></b></td>
            <td class="text-right" colspan="2" id="total_envio"><?php echo $total_envio; ?></td>


        </tr>
    </table>

    <!--    end related transactions -->

    <div id="terms">
        <h5><?php echo $lang['inv-shipping18'] ?></h5>
        <table id="related_transactions" style="width: 100%">
            <p align="justify"><?php echo cdp_cleanOut($core->interms); ?></p>
        </table>
        </br></br></br></br>
        <table id="signing">
            <tr class="noBorder">
                <td align="center">
                    <h4></h4>
                </td>
                <td align="center">
                    <h4></h4>
                </td>
            </tr>
            <tr class="noBorder">
                <td align="center"><?php echo $core->signing_company; ?></td>
                <td align="center"><?php echo $core->signing_customer; ?></td>
            </tr>
        </table>
    </div>
    <button class='button -dark center no-print' onClick="window.print();" style="font-size:16px"><?php echo $lang['inv-shipping19'] ?>&nbsp;&nbsp; <i class="fa fa-print"></i></button>
    </div>

</body>

</html>