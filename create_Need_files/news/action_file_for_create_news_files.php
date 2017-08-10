<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 10.08.2017
 * Time: 12:28
 */


require_once("news_create_file_source_for_template.php");
require_once("create_news_template_file.php");

$settingNewsFile = json_decode(file_get_contents ( "setting_template_news.json"));

$html = file_get_contents("http://university.netology.ru/user_data/tarutin//bitrix/newslist/index.html");

$configFile = json_decode(file_get_contents ( "../config.json"));

$sources = sortForTemplateFileNewsList($html, $settingNewsFile->allProperty, $configFile->isSoloTag);



$renameTags = json_decode(file_get_contents ( "text_in_tag_news.json"));

startCreateTemplateNewsFile($sources, $settingNewsFile->allProperty, $renameTags, $settingNewsFile);








