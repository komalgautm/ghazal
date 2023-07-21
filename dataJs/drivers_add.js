


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









$(function () {

  var count = 1;

  $(document).on('click', '#add_row', function () {

    count++;

    $('#total_address').val(count);

    var html_code = '';
    var parent = $('#div_parent_' + count);



    html_code += '<div id="div_parent_' + count + '">';
    html_code += '<hr>';

    html_code += '<h4>Address ' + count + '</h4>';


    html_code += '<div class="row">';

    html_code += '<div class="col-md-6">' +
      '<div class="form-group">' +
      '<label for="phoneNumber1">Address</label>' +
      '<input type="text" class="form-control" name="address[]"  id="address' + count + '"placeholder="Address">' +
      '</div>' +
      '</div>';

    html_code += '<div class="col-md-6">' +
      '<div class="form-group">' +
      '<label for="emailAddress1">Country</label>' +
      '<input type="text" class="form-control" name="country[]"  id="country' + count + '" placeholder="Country">' +
      '</div>' +
      '</div>';


    html_code += '</div>';


    html_code += '<div class="row">';

    html_code += '<div class="col-md-6">' +
      '<div class="form-group">' +
      '<label for="phoneNumber1">City</label>' +
      '<input type="text" class="form-control" id="city' + count + '" name="city[]" placeholder="City">' +
      '</div>' +
      '</div>';

    html_code += '<div class="col-md-6">' +
      '<div class="form-group">' +
      '<label for="phoneNumber1">Zip code</label>' +
      '<input type="text" class="form-control" name="postal[]" id="postal' + count + '" placeholder="Zip code">' +
      '</div>' +
      '</div>';

    html_code += '</div>';

    html_code += '<div class="row pull-">';
    html_code += '<div align="right" class="col-md-12">' +
      '<button type="button" name="remove_row" id="' + count + '" class="btn btn-danger   remove_row mt-2 mb-3"><span class="fa fa-trash"></span> Delete</button>' +
      '</div>';

    html_code += '</div>';


    html_code += '</div>'; //div parent

    $('#div_address_multiple').append(html_code);







  });



  $(document).on('click', '.remove_row', function () {

    var row_id = $(this).attr("id");
    var parent = $('#div_parent_' + row_id);



    count--;
    parent.fadeOut(400, function () {

      $('#div_parent_' + row_id).remove();

    });
    $('#total_address').val(count);

  });


});


//Registro de datos

$("#save_user").on('submit', function (event) {


  var count = $('#total_address').val();
  var validate = 0;

  for (var no = 1; no <= count; no++) {

    if ($.trim($('#address' + no).val()).length == 0) {
      alert("Please enter address");
      $('#address' + no).focus();

      return false;
    }


    if ($.trim($('#country' + no).val()).length == 0) {
      alert("Please enter country");
      $('#country' + no).focus();

      return false;
    }

    if ($.trim($('#city' + no).val()).length == 0) {
      alert("Please enter city");
      $('#city' + no).focus();

      return false;
    }

    if ($.trim($('#postal' + no).val()).length == 0) {
      alert("Please enter zip code");
      $('#postal' + no).focus();

      return false;
    }

  }


  // if(validate==0){
  if (iti.isValidNumber()) {


    $('#save_data').attr("disabled", true);
    var parametros = $(this).serialize();
    var vehiclecode = $('#vehiclecode').val();
    var enrollment = $('#enrollment').val();
    var inputFileImage = document.getElementById("avatar");
    var username = $('#username').val();
    var email = $('#email').val();
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var notes = $('#notes').val();
    var phone = $('#phone').val();
    var gender = $('#gender').val();
    var locker = $('#locker').val();
    var password = $('#password').val();
    var notify = $('#notify:checked').val();
    var active = $('input:radio[name=active]:checked').val();
    var newsletter = $('input:radio[name=newsletter]:checked').val();
    var total_address = $('#total_address').val();

    var address = document.getElementsByName('address[]');
    var country = document.getElementsByName('country[]');
    var city = document.getElementsByName('city[]');
    var postal = document.getElementsByName('postal[]');
    console.log(address);

    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('enrollment', enrollment);
    data.append('vehiclecode', vehiclecode);
    data.append('avatar', file);
    data.append('locker', locker);
    data.append('username', username);
    data.append('password', password);
    data.append('fname', fname);
    data.append('lname', lname);
    data.append('email', email);
    data.append('phone', phone);
    data.append('gender', gender);
    data.append('active', active);
    data.append('newsletter', newsletter);
    data.append('notes', notes);
    data.append('notify', notify);
    data.append('total_address', total_address);

    for (var a of address) { data.append('address[]', a.value); }
    for (var c of country) { data.append('country[]', c.value); }
    for (var ci of city) { data.append('city[]', ci.value); }
    for (var p of postal) { data.append('postal[]', p.value); }

    $.ajax({

      type: "POST",
      url: "ajax/drivers/drivers_add_ajax.php",
      data: data,
      contentType: false,       // The content type used when sending data to the server.
      cache: false,             // To unable request pages to be cached
      processData: false,
      beforeSend: function (objeto) {
        $("#resultados_ajax").html("<img src='assets/images/loader.gif'/><br/>Wait a moment please...");
      },
      success: function (datos) {
        $("#resultados_ajax").html(datos);
        $('#save_data').attr("disabled", false);

        $('html, body').animate({
          scrollTop: 0
        }, 600);

      }
    });

  } else {

    input.classList.add("error");
    var errorCode = iti.getValidationError();
    errorMsg.innerHTML = errorMap[errorCode];
    errorMsg.classList.remove("hide");
    $('#phone_custom').focus();


  }



  event.preventDefault();

})


