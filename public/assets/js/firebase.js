



const firebaseConfig = {
    apiKey: "AIzaSyB-JxYn47yMuH9pAkqhHkYq0ojxvVvwsqk",
    authDomain: "testapp-22576.firebaseapp.com",
    databaseURL: "https://testapp-22576.firebaseio.com",
    projectId: "testapp-22576",
    storageBucket: "testapp-22576.appspot.com",
    messagingSenderId: "296655750742",
    appId: "1:296655750742:web:11aa7ef82bd8ab4dd09df7",
    measurementId: "G-XW3CYJL6XC"
  };

  
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'invisible',
        'callback': function (response) {
            // reCAPTCHA solved, allow signInWithPhoneNumber.
            console.log('recaptcha resolved');
        }
    });



    $(document).ready(function() {
        $('#getcode').on('click', function () {
            var phoneNo = $('#number').val();
            console.log(phoneNo);
            getCode(phoneNo);
            var appVerifier = window.recaptchaVerifier;
            firebase.auth().signInWithPhoneNumber(phoneNo, appVerifier)
            .then(function (confirmationResult) {
                // SMS sent. Prompt user to type the code from the message, then sign the
                // window.location.href = ''
                //   window.location.href = "{{URL::to('restaurants/20')}}"
                  //s is in lowercase
                window.confirmationResult=confirmationResult;
                coderesult=confirmationResult;
                console.log(coderesult);
            }).catch(function (error) {
                console.log(error);
                // window.location.href = ''
            });
        });


        $('#verifPhNum').on('click', function() {
            var code = $('#codeToVerify').val();
            console.log(code);
            $(this).attr('disabled', 'disabled');
            $(this).text('Processing..');
            confirmationResult.confirm(code).then(function (result) {
                //location.href = "/dashboard";
                $.ajax({
                    type: 'GET',
                    url: '/verify_phone_num/' + phoneNumber,
                    success: function (response) {
                        if (response === "failed") {
                            $(this).removeAttr('disabled');
                            $(this).text('Failed');
                            return;
                        }
                        $(this).text('Phone Verified');
                        window.location = '/login';
                    }.bind($(this))
                });
                // ...
            }.bind($(this))).catch(function (error) {
                // User couldn't sign in (bad verification code?)
                // ...
                $(this).removeAttr('disabled');
                $(this).text('Invalid Code');
                setTimeout(() => {
                    $(this).text('Verify Phone No');
                }, 2000);
            }.bind($(this)));
        });
    });




  function getCode(phoneNumber) {
    var appVerifier = window.recaptchaVerifier;
    firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
        .then(function (confirmationResult) {
            // SMS sent. Prompt user to type the code from the message, then sign the
            // user in with confirmationResult.confirm(code).
            window.confirmationResult = confirmationResult;
            $('#getcode').removeAttr('disabled');
            $('#getcode').text('RESEND');
        }).catch(function (error) {
            // Error; SMS not sent
            // ...
        });
  }  