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


function cdp_loadCategoriesItem(count) {

  $("#order_item_category" + count).html('<option value="">Seleccione</option>');
  $.ajax({
    type: "POST",
    url: 'ajax/select_categories_item.php',
    dataType: "json",
    success: function (data) {

      $.each(data, function (key, item) {
        $("#order_item_category" + count).append('<option value=' + item.id + '>' + item.name_item + '</option>');
      });
    }
  });
}




$(function () {

  $('#order_date').datepicker({
    format: "yyyy-mm-dd",
    autoclose: true
  });

  $('#register_customer_to_user').on('click', function () {

    if ($(this).is(':checked')) {

      $('#show_hide_user_inputs').removeClass('d-none');

    } else {

      $('#show_hide_user_inputs').addClass('d-none');
    }

  });
});






$(document).ready(function () {
  $('#code_prefix_select').hide();


  $('#prefix_check').on('change', function (event) {
    // alert(1)

    if ($('#prefix_check').is(":checked")) {

      $('#code_prefix_input').hide();
      $('#code_prefix_input').attr("disabled", true);

      $('#prefix_check').val(1);
      $('#code_prefix_select').show();
      $('#code_prefix_select').attr("disabled", false);

      $("#code_prefix_select").attr("required", "true");
    }
    else {

      $('#prefix_check').val(0);
      $('#code_prefix_select').hide();
      $('#code_prefix_select').attr("disabled", true);

      $('#code_prefix_input').show();
      $('#code_prefix_input').attr("disabled", false);

      $("#code_prefix_select").attr("required", "false");
    }


  });
});


$(document).ready(function () {
  var count = 1;

  $(document).on('click', '#add_row', function () {
    count++;
    $('#total_item').val(count);


    var parent = $('#row_id_' + count);
    cdp_loadCategoriesItem(count);
    var html_code = '';

    html_code += '<div  class= "card-hover" id="row_id_' + count + '">';

    html_code += '<hr>';

    html_code += '<div class="row"> ';

    html_code += '<div class="col-md-4">' +
      '<div class="form-group">' +
      '<label for="emailAddress1">Category</label>' +
      '<div class="input-group">' +
      '<select class="custom-select col-12 order_item_category1" id="order_item_category' + count + '" name="order_item_category[]" required>' +
      '<option value="0">--Select Category--</option>' +
      '</select>' +
      '</div>' +
      '</div>' +
      '</div>';




    html_code += '<div class="col-md-5">' +

      '<div class="form-group">' +

      '<label for="emailAddress1">Description</label>' +
      '<div class="input-group">' +
      '<input type="text" name="order_item_description[]" id="order_item_description' + count + '" class="form-control input-sm order_item_description" data-toggle="tooltip" data-placement="bottom"   placeholder="Package description" required>' +
      '</div>' +
      '</div>' +
      '</div>';


    html_code += '<div class="col-md-3">' +
      '<div class="form-group">' +
      '<label for="emailAddress1">Declared value</label> ' +
      '<div class="input-group">' +
      '<input type="text" onkeypress="return cdp_soloNumeros(event)"  name="order_item_declared_value[]" id="order_item_declared_value' + count + '" class="form-control input-sm number_only order_item_declared_value" data-toggle="tooltip" data-placement="bottom" title="Declared value"  value="0"/>' +
      '</div>' +
      '</div>' +
      '</div>';



    html_code += '</div>';





    html_code += '<div class="row">';

    html_code += '<div class="col-md-2">' +
      '<div class="form-group">' +
      '<label for="emailAddress1">Quantity</label>' +
      '<div class="input-group">' +

      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber(1,  ' + count + ')"><i class="fa fa-minus"></i></button>' +
      '</div>' +

      '<input type="text" onkeypress="return cdp_soloNumeros(event)"  name="order_item_quantity[]" id="order_item_quantity' + count + '" class="form-control input-sm order_item_quantity" data-toggle="tooltip" data-placement="bottom" title="Quantity"  value="1" required />' +

      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber(1,  ' + count + ')"><i class="fa fa-plus"></i></button>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>';

    html_code += '<div class="col-md-2">' +
      '<div class="form-group">' +
      '<label for="emailAddress1">Weight (lb)</label>' +
      '<div class="input-group">' +
      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber(2,  ' + count + ')"><i class="fa fa-minus"></i></button>' +
      '</div>' +

      '<input type="text" onkeypress="return cdp_soloNumeros(event)"  name="order_item_weight[]" id="order_item_weight' + count + '"class="form-control input-sm order_item_weight" data-toggle="tooltip" data-placement="bottom" title="Weight (lb)" value="0" />' +

      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber(2,  ' + count + ')"><i class="fa fa-plus"></i></button>' +
      '</div>' +
      '</div>' +

      '</div>' +
      '</div>';

    html_code += '<div class="col-md-2">' +
      '<div class="form-group">' +
      '<label for="emailAddress1">Length (cm)</label>' +
      '<div class="input-group">' +

      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber(3,  ' + count + ')"><i class="fa fa-minus"></i></button>' +
      '</div>' +
      '<input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_length[]" id="order_item_length' + count + '" class="form-control input-sm text_only order_item_length" data-toggle="tooltip" data-placement="bottom" title="Length (cm)"  value="0" />' +

      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber(3,  ' + count + ')"><i class="fa fa-plus"></i></button>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>';


    html_code += '<div class="col-md-2">' +

      '<div class="form-group">' +
      '<label for="emailAddress1">Width (cm)</label>' +
      '<div class="input-group">' +
      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber(4,  ' + count + ')"><i class="fa fa-minus"></i></button>' +
      '</div>' +
      '<input type="text" onkeypress="return cdp_soloNumeros(event)" name="order_item_width[]" id="order_item_width' + count + '" class="form-control input-sm text_only order_item_width" data-toggle="tooltip" data-placement="bottom" title="Width (cm)"  value="0" />' +

      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber(4,  ' + count + ')"><i class="fa fa-plus"></i></button>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>';


    html_code += '<div class="col-md-2">' +

      '<div class="form-group">' +
      '<label for="emailAddress1">Height (cm)</label> ' +
      '<div class="input-group">' +
      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_decrementInputNumber(5,  ' + count + ')"><i class="fa fa-minus"></i></button>' +
      '</div>' +
      '<input type="text" onkeypress="return cdp_soloNumeros(event)"  name="order_item_height[]" id="order_item_height' + count + '" class="form-control input-sm number_only order_item_height" data-toggle="tooltip" data-placement="bottom" title="Height (cm)"  value="0"/>' +
      '<div class="input-group-append input-sm">' +
      '<button type="button" class="btn btn-default" onclick="cdp_incrementInputNumber(5,  ' + count + ')"><i class="fa fa-plus"></i></button>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>';




    html_code += '<div class="col-md-1">' +
      '<div class="form-group  mt-4" align="right">' +
      '<button type="button" name="remove_row" id="' + count + '" class="btn btn-danger mt-2 remove_row"><i class="fa fa-trash"></i>  Delete </button>' +
      '</div>' +
      '</div>';

    html_code += '</div>';

    html_code += '<hr>';

    html_code += '</div>';




    $('#data_items').append(html_code);
    $('#row_id_' + count).animate({
      'backgroundColor': '#18BC9C'
    }, 400);


    $('#add_row').attr("disabled", true);


    setTimeout(function () {

      $('#row_id_' + count).css({ 'background-color': '' });
      $('#add_row').attr("disabled", false);

    }, 900);

  });






  $(document).on('click', '.remove_row', function () {

    var row_id = $(this).attr("id");
    var parent = $('#row_id_' + row_id);


    parent.animate({
      'backgroundColor': '#FFBFBF'
    }, 400);

    count--;
    parent.fadeOut(400, function () {
      $('#row_id_' + row_id).remove();
      cdp_cal_final_total();
    });
    $('#total_item').val(count);

  });




  $(document).on('blur', '.order_item_weight', function () {


    cdp_cal_final_total();
  });

  $(document).on('blur', '.order_item_description', function () {


    cdp_cal_final_total();
  });

  $(document).on('blur', '.order_item_quantity', function () {


    cdp_cal_final_total();
  });

  $(document).on('blur', '.order_item_height', function () {


    cdp_cal_final_total();
  });

  $(document).on('blur', '.order_item_length', function () {


    cdp_cal_final_total();
  });

  $(document).on('blur', '.order_item_width', function () {


    cdp_cal_final_total();
  });

  $(document).on('blur', '.order_item_category', function () {


    cdp_cal_final_total();
  });


  $(document).on('blur', '.order_item_declared_value', function () {


    cdp_cal_final_total();
  });





  $('#create_invoice').on('click', function () {
    //data sender

    if ($.trim($('#recipient_id').val()).length == 0) {
      alert("Please select recipient customer");
      return false;
    }


    if ($.trim($('#recipient_address_id').val()).length == 0) {
      alert("Please select recipient customer address");
      return false;
    }


    //data sender

    if ($.trim($('#sender_id').val()).length == 0) {
      alert("Please select sender customer");

      return false;
    }

    if ($.trim($('#sender_address_id').val()).length == 0) {
      alert("Please select sender customer address");

      return false;
    }



    if ($.trim($('#agency').val()) == 0) {
      alert("Please Select Agency");
      return false;
    }

    if ($.trim($('#origin_off').val()) == 0) {
      alert("Please Select office");
      return false;
    }


    if ($.trim($('#order_package').val()) == 0) {
      alert("Please Select package name");
      return false;
    }

    if ($.trim($('#order_courier').val()) == 0) {
      alert("Please Select courier company");
      return false;
    }

    if ($.trim($('#order_service_options').val()) == 0) {
      alert("Please Select services options");
      return false;
    }

    if ($.trim($('#order_deli_time').val()) == 0) {
      alert("Please Select time delivery");
      return false;
    }


    if ($.trim($('#order_pay_mode').val()) == 0) {
      alert("Please Enter method payment");
      return false;
    }

    if ($.trim($('#status_courier').val()) == 0) {
      alert("Please Enter status courier");
      return false;
    }

    if ($.trim($('#driver_id').val()) == 0) {
      alert("Please Enter driver name");
      return false;
    }





    for (var no = 1; no <= count; no++) {
      if ($.trim($('#order_item_description' + no).val()).length == 0) {
        alert("Please Enter Description Name");
        $('#order_item_description' + no).focus();
        return false;
      }


      if ($.trim($('#order_item_category' + no).val()) == 0) {
        alert("Please select category");
        $('#order_item_category' + no).focus();
        return false;
      }

      if ($.trim($('#order_item_quantity' + no).val()).length == 0) {
        alert("Please Enter Quantity");
        $('#order_item_quantity' + no).focus();
        return false;
      }

      if ($.trim($('#order_item_weight' + no).val()).length == 0) {
        alert("Please Enter Weight");
        $('#order_item_weight' + no).focus();
        return false;
      }

      if ($.trim($('#order_item_length' + no).val()).length == 0) {
        alert("Please Enter length");
        $('#order_item_length' + no).focus();
        return false;
      }

      if ($.trim($('#order_item_width' + no).val()).length == 0) {
        alert("Please Enter width");
        $('#order_item_width' + no).focus();
        return false;
      }

      if ($.trim($('#order_item_height' + no).val()).length == 0) {
        alert("Please Enter height");
        $('#order_item_height' + no).focus();
        return false;
      }

      if ($.trim($('#order_item_declared_value' + no).val()).length == 0) {
        alert("Please enter declared value");
        $('#order_item_declared_value' + no).focus();
        return false;
      }


    }

    $('#invoice_form').submit();

  });



});







function cdp_cal_final_total() {


  var count = $('#total_item').val();
  console.log(count);


  var sumador_total = 0;
  var sumador_valor_declarado = 0;
  var sumador_libras = 0;
  var sumador_volumetric = 0;

  var precio_total = 0;
  var total_impuesto = 0;
  var total_descuento = 0;
  var total_seguro = 0;
  var total_peso = 0;
  var total_impuesto_aduanero = 0;
  var total_valor_declarado = 0;

  var total_reexpedicion = 0;


  var tariffs_value = $('#tariffs_value').val();
  var declared_value_tax = $('#declared_value_tax').val();
  var insurance_value = $('#insurance_value').val();
  var tax_value = $('#tax_value').val();
  var discount_value = $('#discount_value').val();

  var reexpedicion_value = $('#reexpedicion_value').val();

  reexpedicion_value = parseFloat(reexpedicion_value);



  var price_lb = $('#price_lb').val();

  price_lb = parseFloat(price_lb);



  for (var i = 1; i <= count; i++) {

    var quantity = $('#order_item_quantity' + i).val();
    quantity = parseFloat(quantity);

    var description = $('#order_item_description' + i).val();
    var category = $('#order_item_category' + i).val();

    var weight = $('#order_item_weight' + i).val();
    weight = parseFloat(weight);

    var length = $('#order_item_length' + i).val();
    length = parseFloat(length);

    var width = $('#order_item_width' + i).val();
    width = parseFloat(width);

    var height = $('#order_item_height' + i).val();
    height = parseFloat(height);

    var declared_value_item = $('#order_item_declared_value' + i).val();
    declared_value_item = parseFloat(declared_value_item);


    var core_meter = $('#core_meter').val();
    var core_min_cost_tax = $('#core_min_cost_tax').val();
    var core_min_cost_declared_tax = $('#core_min_cost_declared_tax').val();

    // calculate weight columetric box size
    var total_metric = length * width * height / core_meter;

    // calculate weight x price
    if (weight > total_metric) {

      var calculate_weight = weight;
      sumador_libras += weight;//Sumador

    } else {

      var calculate_weight = total_metric;
      sumador_volumetric += total_metric;//Sumador
    }

    precio_total = calculate_weight * price_lb;
    sumador_total += precio_total;

    sumador_valor_declarado += declared_value_item;


    if (sumador_total > core_min_cost_tax) {

      total_impuesto = sumador_total * tax_value / 100;
    }

    if (sumador_valor_declarado > core_min_cost_declared_tax) {

      total_valor_declarado = sumador_valor_declarado * declared_value_tax / 100;
    }

    total_descuento = sumador_total * discount_value / 100;

    total_peso = sumador_libras + sumador_volumetric;

    total_seguro = sumador_total * insurance_value / 100;

    total_impuesto_aduanero = total_peso * tariffs_value;



  }


  var total_envio = (sumador_total - total_descuento) + total_seguro + total_impuesto + total_impuesto_aduanero + total_valor_declarado + reexpedicion_value;



  if (total_descuento > sumador_total) {


    alert('Discount cannot be greater than the subtotal');
    $('#discount_value').val(0);

    return false;

  } else if (discount_value < 0) {

    alert('Discount cannot be less than 0');
    $('#discount_value').val(0);

    return false;

  }

  $('#subtotal').html(sumador_total.toFixed(2));
  $('#total_declared').html(sumador_valor_declarado.toFixed(2));
  $('#sumador_valor_declarado').val(sumador_valor_declarado.toFixed(2));

  $('#declared_value_label').html(total_valor_declarado.toFixed(2));
  $('#declared_value_input').val(total_valor_declarado.toFixed(2));
  $('#discount').html(total_descuento.toFixed(2));
  $('#discount_input').val(total_descuento.toFixed(2));

  $('#subtotal_input').val(sumador_total.toFixed(2));

  $('#impuesto').html(total_impuesto.toFixed(2));
  $('#impuesto_input').val(total_impuesto.toFixed(2));

  $('#insurance').html(total_seguro.toFixed(2));
  $('#insurance_input').val(total_seguro.toFixed(2));

  $('#total_libras').html(sumador_libras.toFixed(2));

  $('#total_volumetrico').html(sumador_volumetric.toFixed(2));

  $('#total_peso').html(total_peso.toFixed(2));
  $('#total_weight_input').val(total_peso.toFixed(2));

  $('#total_impuesto_aduanero').html(total_impuesto_aduanero.toFixed(2));
  $('#total_impuesto_aduanero_input').val(total_impuesto_aduanero.toFixed(2));

  $('#total_envio').html(total_envio.toFixed(2));
  $('#total_envio_input').val(total_envio.toFixed(2));




}




function cdp_soloNumeros(e) {
  var key = e.charCode;
  return key >= 44 && key <= 57;
}



$(function () {

  cdp_select2_init_sender();
  cdp_select2_init_sender_address();
  cdp_select2_init_recipient_address();
  cdp_select2_init_recipient();


});



function cdp_select2_init_sender() {

  $("#sender_id").select2({
    ajax: {
      url: "ajax/select2_sender.php",
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
    placeholder: "Search sender customer",
    allowClear: true
  }).on('change', function (e) {

    var sender_id = $("#sender_id").val();



    $("#sender_address_id").attr("disabled", true);

    $("#recipient_id").attr("disabled", true);

    $("#recipient_address_id").attr("disabled", true);
    $("#add_address_sender").attr("disabled", true);
    $("#add_recipient").attr("disabled", true);

    $("#add_address_recipient").attr("disabled", true);


    $("#recipient_id").val(null);
    $("#sender_address_id").val(null);
    $("#recipient_address_id").val(null);

    if (sender_id != null) {


      $("#add_address_sender").attr("disabled", false);

      $("#sender_address_id").attr("disabled", false);

      $("#recipient_id").attr("disabled", false);

      $("#add_recipient").attr("disabled", false);
    }

    cdp_select2_init_sender_address();
    cdp_select2_init_recipient_address();
    cdp_select2_init_recipient();


  });
}



function cdp_select2_init_sender_address() {

  var sender_id = $("#sender_id").val();

  $("#sender_address_id").select2({
    ajax: {
      url: "ajax/select2_sender_addresses.php?id=" + sender_id,
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


    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    // minimumInputLength: 1,
    templateResult: cdp_formatAdress, // omitted for brevity, see the source of this page
    templateSelection: cdp_formatAdressSelection, // omitted for brevity, see the source of this page
    // minimumInputLength: 2,
    placeholder: "Search sender customer address",
    allowClear: true
  });
}


function cdp_formatAdress(item) {

  if (item.loading) return item.text;

  console.log(item)

  var markup = "<div class='select2-result-repository clearfix'>";


  markup += "<div class='select2-result-repository__statistics'>" +
    "<div class='select2-result-repository__forks'><i class='la la-code-fork mr-0'></i> <b> Address: </b> " + item.text + " | <b>Country: </b>" + item.country + " | <b>City: </b>" + item.city + " | <b>Zip code: </b>" + item.zip_code + " </div>" +

    "</div>" +
    "</div></div>";

  return markup;
}

function cdp_formatAdressSelection(repo) {
  return repo.text;
}





function cdp_select2_init_recipient() {

  var sender_id = $("#sender_id").val();


  $("#recipient_id").select2({
    ajax: {
      url: "ajax/select2_recipient.php?id=" + sender_id,
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

    // minimumInputLength: 2,
    placeholder: "Search recipient customer",
    allowClear: true
  }).on('change', function (e) {


    var recipient_id = $("#recipient_id").val();

    $("#add_address_recipient").attr("disabled", true);
    $("#recipient_address_id").attr("disabled", true);
    $("#recipient_address_id").val(null);

    if (recipient_id != null) {


      $("#recipient_address_id").attr("disabled", false);
      $("#add_address_recipient").attr("disabled", false);


    }

    cdp_select2_init_recipient_address();



  });
}

function cdp_select2_init_recipient_address() {

  var recipient_id = $("#recipient_id").val();

  $("#recipient_address_id").select2({
    ajax: {
      url: "ajax/select2_recipient_addresses.php?id=" + recipient_id,
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

    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    // minimumInputLength: 1,
    templateResult: cdp_formatAdress, // omitted for brevity, see the source of this page
    templateSelection: cdp_formatAdressSelection, // omitted for brevity, see the source of this page
    // minimumInputLength: 2,
    placeholder: "Search recipient customer address",
    allowClear: true
  });

}





$('#myModalAddUser').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var type_user = button.data('type_user') // Extract info from data-* attributes
  $('#type_user').val(type_user);

  if (type_user == 'user_customer') {

    $('#modal_add_user_title').html('Add Sender/Customer');

  } else {

    $('#modal_add_user_title').html('Add Recipient/Customer');
  }

})


//Registro de datos

$("#add_user_from_modal_shipments").on('submit', function (event) {

  var count = $('#total_address').val();
  var validate = 0;


  if ($.trim($('#address_modal_user').val()).length == 0) {
    alert("Please enter address");
    $('#address').focus();

    return false;
  }


  if ($.trim($('#country_modal_user').val()).length == 0) {
    alert("Please enter country");
    $('#country').focus();

    return false;
  }

  if ($.trim($('#city_modal_user').val()).length == 0) {
    alert("Please enter city");
    $('#city').focus();

    return false;
  }

  if ($.trim($('#postal_modal_user').val()).length == 0) {
    alert("Please enter zip code");
    $('#postal').focus();

    return false;
  }




  if (iti.isValidNumber()) {

    var sender_id = $('#sender_id').val();

    var type = $('#type_user').val();

    $('#save_data_user').attr("disabled", true);

    var parametros = $(this).serialize();

    $.ajax({
      type: "POST",
      url: "ajax/courier/add_users_ajax.php?sender=" + sender_id,
      data: parametros,

      success: function (datos) {

        cdp_select2_init_sender();

        if (type === 'user_customer') {

          $(".resultados_ajax_add_user_modal_sender").html(datos);

        } else {

          $(".resultados_ajax_add_user_modal_recipient").html(datos);

        }


        $('#save_data_user').attr("disabled", false);


        $("#myModalAddUser").modal('hide');

        window.setTimeout(function () {
          $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
          });
        }, 5000);

      }
    });

  } else {

    input.classList.add("error");
    var errorCode = iti.getValidationError();
    errorMsg.innerHTML = errorMap[errorCode];
    errorMsg.classList.remove("hide");

  }



  event.preventDefault();

})




$('#myModalAddRecipientAddresses').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var type_user = button.data('type_user') // Extract info from data-* attributes
  $('#type_user_address').val(type_user);

  if (type_user == 'user_customer') {

    $('#modal_add_address_title').html('Add Sender/Customer  address');

  } else {

    $('#modal_add_address_title').html('Add Recipient/Customer address');
  }

})


//Registro de datos

$("#add_address_from_modal_shipments").on('submit', function (event) {

  if ($.trim($('#address').val()).length == 0) {
    alert("Please enter address");
    $('#address').focus();

    return false;
  }


  if ($.trim($('#country').val()).length == 0) {
    alert("Please enter country");
    $('#country').focus();

    return false;
  }

  if ($.trim($('#city').val()).length == 0) {
    alert("Please enter city");
    $('#city').focus();

    return false;
  }

  if ($.trim($('#postal').val()).length == 0) {
    alert("Please enter zip code");
    $('#postal').focus();

    return false;
  }



  var sender_id = $('#sender_id').val();
  var recipient_id = $('#recipient_id').val();

  $('#save_data_address').attr("disabled", true);
  var parametros = $(this).serialize();
  var type = $('#type_user_address').val();

  $.ajax({

    type: "POST",
    url: "ajax/courier/add_address_users_ajax.php?sender=" + sender_id + '&recipient=' + recipient_id,
    data: parametros,

    success: function (datos) {

      $('#save_data_address').attr("disabled", false);



      if (type === 'user_customer') {

        $(".resultados_ajax_add_user_modal_sender").html(datos);

      } else {

        $(".resultados_ajax_add_user_modal_recipient").html(datos);

      }
      $("#myModalAddRecipientAddresses").modal('hide');

      window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
          $(this).remove();
        });
      }, 5000);




    }
  });


  event.preventDefault();

})



var errorMsg = document.querySelector("#error-msg");
var validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];


var input = document.querySelector("#phone_custom");
var iti = window.intlTelInput(input, {

  geoIpLookup: function (callback) {
    $.get("http://ipinfo.io", function () { }, "jsonp").always(function (resp) {
      var countryCode = (resp && resp.country) ? resp.country : "";
      callback(countryCode);
    });
  },
  initialCountry: "auto",
  nationalMode: true,

  separateDialCode: true,
  utilsScript: "assets/js/input-js/utils.js",
});




var reset = function () {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
  validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function () {
  reset();
  if (input.value.trim()) {

    if (iti.isValidNumber()) {

      $('#phone').val(iti.getNumber());

      validMsg.classList.remove("hide");

    } else {

      input.classList.add("error");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");

    }
  }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);





function cdp_validateTrackNumber(value) {

  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "./ajax/validate_track_number_customer_courier.php?track=" + value,
    success: function (data) {

      var main = $('#order_no_main').val();

      if (data) {

        alert("This shipping number is already registered.");
        $('#order_no').val(main);
      }


    }
  });
}


function cdp_incrementInputNumber(input, count) {

  switch (input) {

    case 1:
      input = 'order_item_quantity';

      break;

    case 2:

      input = 'order_item_weight';

      break

    case 3:

      input = 'order_item_length';

      break

    case 4:

      input = 'order_item_width';

      break

    case 5:

      input = 'order_item_height';

      break

  }

  var quantity = parseInt($('#' + input + count).val());

  $('#' + input + count).val(quantity + 1);
  cdp_cal_final_total();

}


function cdp_decrementInputNumber(input, count) {



  switch (input) {

    case 1:
      input = 'order_item_quantity';

      break;

    case 2:

      input = 'order_item_weight';

      break

    case 3:

      input = 'order_item_length';

      break

    case 4:

      input = 'order_item_width';

      break

    case 5:

      input = 'order_item_height';

      break

  }
  var quantity = parseInt($('#' + input + count).val());

  if (quantity > 0) {

    $('#' + input + count).val(quantity - 1);
  }

  cdp_cal_final_total();

}

