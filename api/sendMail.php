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
            $this->message .= `<div class="email-container" style="border-radius: 20px;width: 40%;padding: 10px; text-align: center; background: #880fc4; font-family: Arial, Helvetica, sans-serif;">
                <img src='./images/logo.png' style="padding: 20px;width: 200px;" alt='Buckvest Logo'/>
                <h1 style="color: #fff;">BuckVest Email Verification</h1>
                <p style="color: #ababab;">Welcome to buckvest, {$fullname} we are glad to have you ear more and buid your income from here. Click the link brlow to verify your email</a><br>
                <a href='http://buckvest.com/verifyAccount?access_code={$access_code}' style='padding: 20px; display: inline-block; width: 50%; margin-top: 20px; border-radius: 10px; padding: 20px; line-break: anywhere; background-color: #1d39f2; color: #eee;text-decoration: none;'>Link to verify Yor account</a>
                <div style="padding: 20px; color: #fff;">&copy; Buckvest 2022. All rights Reserved</div>
            </div>`;
            
            if($this->sendMail()){
                return true;
            }
            return false;
        }
    }

    $test = new Emailer();
    $test->email = 'codewithdripzy@gmail.com';

    $test->sendAccountVerificationMail('BCKVST', 'Bankole Emmanuel');
?>