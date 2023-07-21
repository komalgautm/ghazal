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
  cdp_load(1);
});


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


//Cargar datos AJAX
function cdp_load(page) {
  var search = $("#search").val();
  var status_courier = $("#status_courier").val();
  var filterby = $("#filterby").val();
  var parametros = { "page": page, 'search': search, 'status_courier': status_courier, 'filterby': filterby };
  $("#loader").fadeIn('slow');
  $.ajax({
    url: './ajax/consolidate/courier_list_add_ajax.php',
    data: parametros,
    beforeSend: function (objeto) {
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn('slow');
    }
  })
}


$("#save_data").on('submit', function (event) {
  var parametros = $(this).serialize();

  $.ajax({
    type: "POST",
    url: "ajax/tools/category/category_add_ajax.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax").html("Please wait...");
    },
    success: function (datos) {
      $("#resultados_ajax").html(datos);

      $('html, body').animate({
        scrollTop: 0
      }, 600);


    }
  });
  event.preventDefault();

})






$(function () {
  var count = $('#total_item').val();

  $(document).on('click', '.remove_row', function () {
    var row_id = $(this).attr("id");
    var parent = $('#row_id_' + row_id);

    new Messi('<p class="messi-warning"><i class="icon-warning-sign icon-3x pull-left"></i>Are you sure you want to delete this record?<br /><strong>This action cannot be undone!!!</strong></p>', {
      title: 'Delete shipment',
      titleClass: '',
      modal: true,
      closeButton: true,
      buttons: [{
        id: 0,
        label: 'Delete',
        class: '',
        val: 'Y'
      }],
      callback: function (val) {
        if (val === 'Y') {
          $.ajax({
            type: 'post',
            url: './ajax/consolidate/consolidate_item_delete_ajax.php',
            data: {
              'id': row_id,
            },
            beforeSend: function () {
              parent.animate({
                'backgroundColor': '#FFBFBF'
              }, 400);
            },
            success: function (data) {

              var index = selected.indexOf(row_id);

              selected.splice(index, 1);

              parent.animate({
                'backgroundColor': '#FFBFBF'
              }, 400);

              count--;
              parent.fadeOut(400, function () {
                // parent.remove();
                $('#row_id_' + row_id).remove();
                cdp_cal_final_total();
              });

              $('#total_item').val(selected.length);

              cdp_load(1);
            }
          });
        }
      }
    });

  });





  $('#create_invoice').on('click', function () {



    // data receiver

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



    if ($.trim($('#total_item').val()) <= 1) {
      alert("You must select at least 2 packages to consolidate");
      return false;
    }


    if ($.trim($('#order_no').val()).length == 0) {
      alert("Please Select Invoice number");
      return false;
    }

    if ($.trim($('#agency').val()) == 0) {
      alert("Please Select Agency");
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





    $('#invoice_form').submit();

  });

});



function cdp_cal_final_total() {


  var count = $('#total_item').val();

  var sumador_total = 0;
  var sumador_libras = 0;
  var sumador_volumetric = 0;

  var precio_total = 0;
  var total_impuesto = 0;
  var total_descuento = 0;
  var total_seguro = 0;
  var total_peso = 0;
  var total_impuesto_aduanero = 0;
  var calculate_weight = 0;

  var order_volumetric_percentage = $('#order_volumetric_percentage').val();
  var order_value_weight = $('#order_value_weight').val();
  var order_min_cost_tax = $('#order_min_cost_tax').val();
  var order_tax_value = $('#order_tax_value').val();
  var order_tax_discount = $('#order_tax_discount').val();
  var order_tax_insurance_value = $('#order_tax_insurance_value').val();
  var order_tax_custom_tariffis_value = $('#order_tax_custom_tariffis_value').val();





  console.log(selected)


  selected.forEach(function (valor, indice, array) {

    console.log("En el índice " + indice + " hay este valor: " + valor);


    var weight = $('#weight_' + valor).val();
    weight = parseFloat(weight);

    console.log(weight + ' weight');

    var height = $('#height_' + valor).val();
    height = parseFloat(height);

    console.log(height + ' height');

    var length = $('#length_' + valor).val();
    length = parseFloat(length);

    console.log(length + ' length');


    var width = $('#width_' + valor).val();
    width = parseFloat(width);

    console.log(width + ' width');



    var total_vol = $('#total_vol_' + valor).val();
    total_vol = parseFloat(total_vol);

    // calculate weight columetric box size
    var total_metric = length * width * height / order_volumetric_percentage;

    // calculate weight x price
    if (weight > total_metric) {

      calculate_weight = weight;
      sumador_libras += weight;//Sumador

    } else {

      calculate_weight = total_metric;
      sumador_volumetric += total_metric;//Sumador
    }

    precio_total = calculate_weight * order_value_weight;
    sumador_total += precio_total;

    if (sumador_total > order_min_cost_tax) {

      total_impuesto = sumador_total * order_tax_value / 100;
    }

    total_descuento = sumador_total * order_tax_discount / 100;
    total_peso = sumador_libras + sumador_volumetric;
    total_seguro = sumador_total * order_tax_insurance_value / 100;

    total_impuesto_aduanero = total_peso * order_tax_custom_tariffis_value;



  });

  var total_envio = (sumador_total - total_descuento) + total_seguro + total_impuesto + total_impuesto_aduanero;





  $('#subtotal').html(sumador_total.toFixed(2));

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




function cdp_add_item(id, total_vol, weight, length, width, height, tracking, order_no, order_prefix) {



  if (selected.includes(id)) {

    $('#modal_consolidate').html(
      '<div class="alert alert-danger" id="success-alert">' +
      '<p><span class="icon-minus-sign"></span><i class="close icon-remove-circle"></i>' +
      '  <span>Error! </span> This package is already selected in the list.' +
      '</p>' +
      '</div>');

  } else {

    count++;

    $('#modal_consolidate').html('');
    console.log(selected + " antes");
    selected.push(id);

    console.log(selected + " despues");
    $('#total_item').val(selected.length);




    var parent = $('#row_id_' + id);

    var html_code = '';
    html_code += '<tr class="card-hover " id="row_id_' + id + '">';

    html_code += '<td class="" colspan="3"> <b>' + tracking + ' </b></td>';
    html_code += '<td class="text-center"  colspan="2">' + weight + '</td>';
    html_code += '<td class="text-center"></td>';
    html_code += '<td class="text-right">' + total_vol + '</td>';

    html_code += '<input type="hidden"  id="total_vol_' + id + '"  value="' + total_vol + '" name="weight_vol[]">';
    html_code += '<input type="hidden"   value="' + order_prefix + '" name="prefix[]">';
    html_code += '<input type="hidden"   value="' + order_no + '" name="order_no_item[]">';
    html_code += '<input type="hidden" id="weight_' + id + '"   value="' + weight + '" name="weight[]">';

    html_code += '<input type="hidden" id="length_' + id + '"   value="' + length + '" name="length[]">';
    html_code += '<input type="hidden" id="height_' + id + '"   value="' + height + '" name="height[]">';
    html_code += '<input type="hidden" id="width_' + id + '"   value="' + width + '" name="width[]">';
    html_code += '<input type="hidden" id="order_id_' + id + '"   value="' + id + '" name="order_id[]">';


    html_code += '<td class="text-center"><button type="button" name="remove_row" id="' + id + '" class="btn btn-danger btn-xs remove_row mt-2"><i class="fa fa-trash"></i></button></td>';


    html_code += '</tr>';

    $('#invoice-item-table').append(html_code);

    $('#row_id_' + id).animate({
      'backgroundColor': '#18BC9C'
    }, 400);

    cdp_cal_final_total();

    $('#add_row').attr("disabled", true);


    setTimeout(function () {

      $('#row_id_' + id).css({ 'background-color': '' });
      $('#add_row').attr("disabled", false);

    }, 900);




  }





}




$(document).ready(function () {

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

