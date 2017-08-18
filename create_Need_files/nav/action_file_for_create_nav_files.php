<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 11.08.2017
 * Time: 10:22
 */

require_once("create_source_for_nav_template_file.php");
require_once("create_nav_template_file.php");

$html = file_get_contents("http://university.netology.ru/user_data/tarutin//bitrix/nav/index.html");

$settingNavFile = json_decode(file_get_contents ( "setting_template_nav.json"));

$configFile = json_decode(file_get_contents ( "../config.json"));

$renameTags = json_decode(file_get_contents ( "text_in_tag_nav.json"));

$sources = sortForTemplateFileNavigate($html, $settingNavFile->allProperty, $configFile->isSoloTag);

startCreateTemplateNavFile($sources, $renameTags, $settingNavFile->allProperty, $settingNavFile);





