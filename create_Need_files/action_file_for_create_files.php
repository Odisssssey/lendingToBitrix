<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 09.08.2017
 * Time: 16:12
 */


require_once('division_file_on_row_and_template.php');
require_once ("efficient_block_for_row.php");
require_once ("create_file_row.php");
require_once ("create_file_templates.php");



$settingFile = json_decode(file_get_contents ( "text_in_tag.json"));

$settingRowTags = json_decode(file_get_contents ( "setting_row.json"));

$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");


$htmlForFiles = divideFile($html, $settingRowTags->allProperty, $settingFile->isSoloTag); //in division_file_on_row_and_template.php


$arrRowFiles = formTagsForRowFiles($htmlForFiles[1], $settingRowTags->allProperty);  //in efficient_block_for_row.php

startCreateFileRow($arrRowFiles, $settingFile, $settingRowTags);

startCreateFileTemplate($html, $htmlForFiles[0], $settingRowTags);



//
/////start block template
//
//$htmlForTemplate = divideFile($html, $settingRowTags->allProperty, $settingFile->isSoloTag); // in division_file_on_row_and_template
//
//
//startCreateFileTemplate($html, $htmlForTemplate[0], $renameTags);  ///$html in  division_file_on_row_and_template.php
//
/////end block template
