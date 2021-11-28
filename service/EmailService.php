<?php

class EmailService {
    
    public static function send($to, $subject, $message) {
        mail($to, $subject, $message); 
    }
}

?>