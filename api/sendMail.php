<?php
    class Emailer{
        public $email;
        Public $subject;
        public $message;
        public $header = "";

        function sendMail(){
            $this->header .= "From:info@buckvest.com \r\n";
            $this->header .= "Cc:{$this->email} \r\n";
            $this->header .= "MIME-Version: 1.0\r\n";
            $this->header .= "Content-type: text/html\r\n";

            // ini_set("SMPT", "sxb1plzcpnl489427.prod.sxb1.secureserver.net");
            // ini_set("sendmail_from", "info@buckvest.com");
            // ini_set("smtp_port", 465);

            if(mail($this->email, $this->subject, $this->message, $this->header)){
                return true;
            }
            return false;
        }

        function sendAccountVerificationMail($access_code, $fullname){
            $this->subject = 'Account Verification';
            $this->message .= `<body class="email-container" marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
            <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
                style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
                <tr>
                    <td>
                        <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0"
                            align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="height:80px;">&nbsp;</td>
                            </tr>
    
                            <tr>
                                <td style="height:20px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                        style="max-width:670px; background:#880fc4; border-radius:12px; padding: 10px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                        <tr>
                                            <td style="height:40px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;">
                                                <a href="http://buckvest.com" title="logo" target="_blank">
                                                    <img src='./images/logo.png' style="padding: 20px; width: 250px;"
                                                        alt='Buckvest Logo' />
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 35px;">
                                                <h1
                                                    style="color:#fff;  margin:0;font-size:32px;font-family:'Rubik',sans-serif;">
                                                    BuckVest Email Verification
                                                </h1>
                                                <p style="font-size:16px; color:#ababab; margin:8px 0 0; line-height:24px;">
                                                    Welcome to buckvest, {$fullname} we are glad to have you ear more and
                                                    buid your
                                                    income from here. Click the link below to verify your email</a><br>
                                                </p>
                                                <a href="login.html"
                                                    style="background-color: #1d39f2; color: #eee; text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px; padding:16px 24px;display:inline-block;border-radius:50px;">Link
                                                    to verify
                                                    to your Account</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:40px;">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">
                                    <p
                                        style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                        &copy; <strong>Buckvest 2022. All rights Reserved</strong> </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:80px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
    `;
            
            if($this->sendMail()){
                return true;
            }
            return false;
        }
    }

    $test = new Emailer();
    $test->email = 'codewithdripzy@gmail.com';

    $test->sendAccountVerificationMail('BCKVST', 'Bankole Emmanuel');
