<pre>
<?php

require_once __DIR__ . '/service/Configuration.php';
require_once __DIR__ . '/service/EmailService.php';
require_once __DIR__ . '/service/NameDayService.php';
require_once __DIR__ . '/service/FacebookService.php';
require_once __DIR__ . '/util/TextUtil.php';

echo "***********************************************\n";
echo "Welcome to NameDays daily job\n";
echo "***********************************************\n";
echo "Job started at " . date("Y-m-d h:i:sa") . "\n";

checkAccess();
process();

echo "Job finished at " . date("Y-m-d h:i:sa") . "\n";
echo "***********************************************\n";


function process() {
    $ini = Configuration::getIni();
    
    $facebookService = new FacebookService($ini["appId"], $ini["appSecret"], $ini["accessToken"]);
    $names = NameDayService::getTodaysNames();
    $email = "Results:\n";
    
    $messages = $ini["message"];
    shuffle($messages);
    
    foreach ($names as $index => $name) {
        $photo = TextUtil::replaceSpecChars($name) . ".jpg";
        $message = sprintf($messages[$index % count($messages)], $name, $name);
        $result = $facebookService->publishPhoto($ini["pageId"], $ini["photoFolder"], $photo, $message);
        echo $result;
        $email.=$result;
    }
    
    echo "Sending mail to recipients: " . $ini["mailTo"] . "...\n";
    EmailService::send($ini["mailTo"], $ini["subject"], $email);
    
}



function checkAccess() {
    $ini = Configuration::getIni();
    $securityKey = $ini["securityKey"];
    if ($securityKey != null && (!isset($_GET["securityKey"]) || $_GET["securityKey"] != $securityKey)) {
        echo "Error: security key not provided.\n";
        exit(1);
	}
}

?>
</pre>