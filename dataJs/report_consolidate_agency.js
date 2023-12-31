"use strict";

$(function () {
	$("#main-wrapper").AdminSettings({
		Theme: false, // this can be true or false ( true means dark and false means light ),
		Layout: 'vertical',
		LogoBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6 
		NavbarBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
		SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
		SidebarColor: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
		SidebarPosition: true, // it can be true / false ( true means Fixed and false means absolute )
		HeaderPosition: true, // it can be true / false ( true means Fixed and false means absolute )
		BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid ) 
	});
});
$(function () {
	cdp_select2_init();

	var start = moment().startOf('month');
	var end = moment().endOf('month');

	$('#daterange').daterangepicker({
		startDate: start,
		endDate: end,
		locale: {
			'format': 'Y/M/D',

		},

		ranges: {
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],

		}
	}).on('change', function (e) {
		cdp_load(1);
	});

	cdp_load(1);

});


//Cargar datos AJAX
function cdp_load(page) {
	var status_courier = $("#status_courier").val();
	var agency = $("#agency").val();
	var daterange = $("#daterange").val();
	var parametros = { "page": page, 'status_courier': status_courier, 'range': daterange, 'agency': agency };
	$("#loader").fadeIn('slow');
	$.ajax({
		url: './ajax/reports/report_consolidate_agency_ajax.php',
		data: parametros,
		beforeSend: function (objeto) {
		},
		success: function (data) {
			$(".outer_div").html(data).fadeIn('slow');
		}
	})
}


function cdp_select2_init() {

	$(".select2").select2({
		ajax: {
			url: "ajax/customers_select2.php",
			dataType: 'json',

			delay: 250,
			data: function (params) {
				return {
					q: params.term // search term
				};
			},
			processResults: function (data) {
				// parse the results into the format expected by Select2.
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data
				console.log(data)
				return {
					results: data
				};
			},
			cache: true
		},
		minimumInputLength: 2,
		placeholder: "Select Customer",
		allowClear: true
	}).on('change', function (e) {
		cdp_load(1);
	});
}


function cdp_exportExcel() {

	var status_courier = $("#status_courier").val();
	var daterange = $("#daterange").val();
	var agency = $("#agency").val();


	window.open('report_consolidate_agency_excel.php?range=' + daterange + '&status_courier=' + status_courier + '&agency=' + agency);

}


function cdp_exportPrint() {

	var status_courier = $("#status_courier").val();
	var daterange = $("#daterange").val();
	var agency = $("#agency").val();


	window.open('report_consolidate_agency_print.php?range=' + daterange + '&status_courier=' + status_courier + '&agency=' + agency);

}