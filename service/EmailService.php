<?php

class EmailService {
    
    public static function send($to, $subject, $message) {
        if (!isset($_GET["dryRun"])) {
            mail($to, $subject, $message);
        }
    }
}

?>