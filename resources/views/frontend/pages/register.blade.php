@extends('layouts.master')

@section('content')

    <section class="user_register">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                              <h4 class="text-center">Account Register</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                @csrf
                                <div class="form-group">
                                    <label for="fname">First Name</label>
                                    <input type="text" name="fname" id="fname" class="form-control" placeholder="Enter First Name">
                                </div>
    
                                <div class="form-group">
                                    <label for="fname">Last Name</label>
                                    <input type="text" name="lname" id="lname" class="form-control" placeholder="Enter Last Name">
                                </div>
    
    
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
                                </div>
    
                                <div class="form-group">
                                  <label for="password">Password</label>
                                  <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                              </div>
    
                              <button type="submit" class="btn btn-dark btn-block save_user_btn">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


       <!-- Verification Code -->
    <section class="validOTPForm" style="display:none;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                              <h4 class="text-center">Account Verification</h4>
                        </div>
                        <div class="card-body">
                            <form>
                                @csrf
                                <div class="form-group">
                                    <label for="fname">Phone Number</label>
                                
                                    <input type="text" name="phone_no" id="number" class="form-control" placeholder="(Code) ******">
                                </div>
                                <div id="recaptcha-container"></div>
                              
                                <a href="#" id="getcode" class="btn btn-dark btn-sm get-code">Get Code</a>
    
                                <div class="form-group mt-4">
                                    <input type="text" id="codeToVerify" name="getcode" class="form-control" placeholder="Enter Code">
                                </div>
                                                              
                              <a class="btn btn-dark btn-block"  id="verifPhNum" >Verify Phone No</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script src="{{ asset('assets/js/firebase.js') }}"></script>

<script>
    $(document).ready(function () {
    $('.save_user_btn').on('click', function (e) {
        const fname       = $("#fname").val();
        const lname       = $("#lname").val();
        const email       = $("#email").val();
        const password    = $("#password").val();
      
        const form = $(this).parents('form');
    $(form).validate({
        rules: {
            fname: {
                required: true,
            },
            lname: {
                required: true,
            },
            email: {
                required: true,
            },
            password: {
                required: true,
                minlength: 6
            },
        },
        messages: {
            fname: "First Name is required.",
            lname: "Last Name is required.",
            email: "Email is requried.",
            password: "Password is required.",                
        },
        submitHandler: function () {
            var formData = new FormData(form[0]);
            $.ajax({
                type: 'POST',
                url: 'save_register',
                data: formData,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);
                    if (data.exists) {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text('Email already exists');
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 3000);
                    }
                    else if (data.success) {
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'green');
                        $('#notifDiv').text('User Registered Successfully.');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                                $('[name="fname"]').val('');
                                $('[name="lname"]').val('');
                                $('[name="email"]').val('');
                                $('[name="password"]').val('');  
                                $('.validOTPForm').show();
                                $('.user_register').hide();
                                $('.save_user_btn').removeAttr('disabled');
                                $('.save_user_btn').text('Save');                              
                      }
                    else {
                        $('#notifDiv').fadeIn();
                        $('#notifDiv').css('background', 'red');
                        $('#notifDiv').text('An error occured. Please try later');
                        setTimeout(() => {
                            $('#notifDiv').fadeOut();
                        }, 3000);
                        }  
                    },
                });
            }
        });
    });
});
</script>
@endpush