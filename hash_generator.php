<?php
    class HashGen{
        public static function GenerateHash(array $args){
            $string = "";
            for($i = 0; $i < count($args); $i++){
                $string .= $args[$i];
            }
    
            return hash("sha256", $string);
        }
    }

    // echo HashGen::GenerateHash(["2022-07-19 14:34:33", 1, "emmafikayomi2004@gmail.com", "bankole emmanuel"]);
    // ac360cad1a0e23a1533ddd0e9aab1214cd9a34f2b88128be3904e11ba6b28c77
    // f09a95e48aebb2ca481659bf504cacdeab175a2fb4552e066a864b7afea361a2
    // print_r(md5(date("d-m-y H:I:s") . rand(0, 1000)))
    // print_r(password_hash("adelekecharles", PASSWORD_BCRYPT));
?>