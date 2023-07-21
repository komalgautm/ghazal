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

$db = new Conexion;

$recipient = cdp_sanitize($_REQUEST['id']);

$list = array();
$data = [];



$sql = "SELECT *  FROM cdb_users_multiple_addresses WHERE user_id='" . $recipient . "'";

$db->cdp_query($sql);
$db->cdp_execute();

$datas = $db->cdp_registros();

foreach ($datas as $key) {

	$data[] = array(

		'id' => $key->id_addresses,
		'text' => $key->address,
		'country' => $key->country,
		'city' => $key->city,
		'zip_code' => $key->zip_code,

	);
}

echo json_encode($data);
