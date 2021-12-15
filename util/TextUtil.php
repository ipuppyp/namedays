<?php

class TextUtil {

private static $HU = array('/é/','/É/','/á/','/Á/','/ó/','/Ó/','/ö/','/Ö/','/ő/','/Ő/','/ú/','/Ú/','/ű/','/Ű/','/ü/','/Ü/','/í/','/Í/','/ /');
private static $EN = array('e','E','a','A','o','O','o','O','o','O','u','U','u','U','u','U','i','I','_');

   public static function replaceSpecChars($str) {
       return strtolower(preg_replace(TextUtil::$HU, TextUtil::$EN, $str));
   }
   
}
?>
