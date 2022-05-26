$(document).ready(function(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){ dd='0'+dd }
    if(mm<10){ mm='0'+mm }
    var today = mm+'/'+dd+'/'+yyyy;
    $('.bookingDate').daterangepicker({
		autoApply: true,
        singleDatePicker: true,
        timePicker: true,
        autoclose: true,
        showDropdowns: true,
        minDate:today,
		minYear: parseInt(moment().format('YYYY')),
        locale: {
            format: 'DD-MM-YYYY hh:mm A',
            separator: "-",
        }
	});
    $('#logout-user').click(function(){
        swal({
            title: "Are you sure?",
            text: "You want to logout!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "controller/user.php",
                data: {action:'logout'},
                dataType: "json",
                success: function (data) {
                    if (data.success){
                        location.href = 'dashboard.php';
                    } else {
                        swal({
                            title: "Error!",
                            text: data.message,
                            icon: "error",
                        }) 
                    }
                }
            });
        }
        });
    })
    $(".book-vehicle").click(function(ev) {
        var vehicleId = $(this).data("vehicle-id");
        $("#vehicleId").val(vehicleId)
        $('#bookVehicle').modal('show')
    });
    $(".clear-add-form").click(function(){
		$('#bookingForm').trigger("reset");
        $('.startDate').next().addClass('d-none').text('')
        $('.endDate').next().addClass('d-none').text('')
	})

    $("#bookVehicleSubmit").click(function (e) {
        e.preventDefault();
        var formData = $('#bookingForm')
        swal({
            title: "Are you sure?",
            text: "You want to book this vehicle!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "controller/vehicle.php",
                    data: formData.serialize(),
                    dataType: "json",
                    beforeSend:function(){
                        $('.startDate').next().addClass('d-none').text('')
                        $('.endDate').next().addClass('d-none').text('')
                    },
                    success: function (data) {
                        if (data.success){
                            swal({
                                title: "Success!",
                                text: data.message,
                                icon: "success",
                            }).then((value) => {
                                location.href = 'mybooking.php';
                            });
                            $('#bookVehicle').modal('hide');
                            $('.startDate').next().addClass('d-none').text('')
                            $('.endDate').next().addClass('d-none').text('')
                          } else if (data.error){
                            $.each(data.validationError, function( index, value ) {
                                $('.'+index).next().removeClass('d-none').text(value)
                            });
                        } else {
                            $('.already-booked').removeClass('d-none').text(data.message)
                        }
                        
                    }
              });
            }
          });
        
    });

    $(".cancel-vehicle").click(function(ev) {
        swal({
            title: "Are you sure?",
            text: "You want to cancel the booking!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
            var vehicleUserId = $(this).data("vehicle-user-id");
            $.ajax({
                type: "POST",
                url: "controller/vehicle.php",
                data: {action:'cancel_booking',vehicleUserId:vehicleUserId},
                dataType: "json",
                success: function (data) {
                    if (data.success){
                        swal({
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                        }).then((value) => {
                            location.href = 'mybooking.php';
                        });
                    } else {
                        swal({
                            title: "Error!",
                            text: data.message,
                            icon: "error",
                        })                    
                    }
                }
            });
        }
        });
    });
})