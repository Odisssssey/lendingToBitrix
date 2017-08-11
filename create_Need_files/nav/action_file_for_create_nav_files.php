<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 11.08.2017
 * Time: 10:22
 */

require_once("create_source_for_nav_template_file.php");

$html = file_get_contents("http://university.netology.ru/user_data/tarutin//bitrix/nav/index.html");

$settingNavFile = json_decode(file_get_contents ( "setting_template_nav.json"));

$configFile = json_decode(file_get_contents ( "../config.json"));

sortForTemplateFileNavigate($html, $settingNavFile->allProperty, $configFile->isSoloTag);








