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


function actionFormFile($html){
    $settingFile = json_decode(file_get_contents ( __DIR__."/text_in_tag_form.json"));

    $settingRowTags = json_decode(file_get_contents ( __DIR__."/setting_row_form.json"));

    $configFile = json_decode(file_get_contents ( __DIR__."/../config.json"));

//    $html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");


    $htmlForFiles = divideFile($html, $settingRowTags->allProperty, $configFile->isSoloTag); //in division_file_on_row_and_template.php


    $arrRowFiles = formTagsForRowFiles($htmlForFiles[1], $settingRowTags->allProperty);  //in efficient_block_for_row.php

    startCreateFileRow($arrRowFiles, $settingFile, $settingRowTags);

    startCreateFileTemplate($html, $htmlForFiles[0], $settingFile);
}

//$settingFile = json_decode(file_get_contents ( "text_in_tag_form.json"));
//
//$settingRowTags = json_decode(file_get_contents ( "setting_row_form.json"));
//
//$configFile = json_decode(file_get_contents ( "../config.json"));
//
//$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");
//
//
//$htmlForFiles = divideFile($html, $settingRowTags->allProperty, $configFile->isSoloTag); //in division_file_on_row_and_template.php
//
//
//$arrRowFiles = formTagsForRowFiles($htmlForFiles[1], $settingRowTags->allProperty);  //in efficient_block_for_row.php
//
//startCreateFileRow($arrRowFiles, $settingFile, $settingRowTags);
//
//startCreateFileTemplate($html, $htmlForFiles[0], $settingFile);


