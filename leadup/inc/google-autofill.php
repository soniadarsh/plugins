<html>
    <head>
        <script src="https://apis.google.com/js/api:client.js"></script>
        <script>
            var googleUser = {};
            var startApp = function () {
                gapi.load('auth2', function () {
                    // Retrieve the singleton for the GoogleAuth library and set up the client.
                    auth2 = gapi.auth2.init({
                        client_id: '<?php echo get_option('google-api-key'); ?>',
                        cookiepolicy: 'single_host_origin',
                        // Request scopes in addition to 'profile' and 'email'
                        //scope: 'additional_scope'
                    });
                    attachSignin(document.getElementById('customBtn'));
                });
            };

            function attachSignin(element) {
//                console.log(element.id);
                auth2.attachClickHandler(element, {},
                        function (googleUser) {
                            jQuery("input#leaduser").val(googleUser.getBasicProfile().getName());
                            jQuery("input#leademail").val(googleUser.getBasicProfile().getEmail());
//                            document.getElementById('name').innerText = "Signed in: " +
//                                    googleUser.getBasicProfile().getName();
                        }, function (error) {
                    alert(JSON.stringify(error, undefined, 2));
                });
            }
        </script>
        <style type="text/css">
            #customBtn:hover {
                cursor: pointer;
            }
            span.label {
                font-family: serif;
                font-weight: normal;
            }
            span.icon {
                /*background: url('/identity/sign-in/g-normal.png') transparent 5px 50% no-repeat;*/
                display: inline-block;
                vertical-align: middle;
                width: 42px;
                height: 42px;
            }
            span.buttonText {
                display: inline-block;
                vertical-align: middle;
                padding-left: 42px;
                padding-right: 42px;
                font-size: 14px;
                font-weight: bold;
                /* Use the Roboto font that is loaded in the <head> */
                font-family: 'Roboto', sans-serif;
            }
            .inklead-google-btn{
                background-image: url(<?php echo plugins_url('images/google_button_icon.png', dirname(__FILE__)) ?>);
                background-image: url(<?php echo plugins_url('images/google_button_icon.svg', dirname(__FILE__)) ?>);
            }
        </style>
    </head>
    <body>
        <!-- In the callback, you would hide the gSignInWrapper element on a
        successful sign in -->
        <div id="gSignInWrapper">
            <a id="customBtn" class="customGPlusSignIn inklead-google-btn">Fill With Google</a>
        </div>
        <div id="name"></div>
        <script>startApp();</script>
    </body>
</html>