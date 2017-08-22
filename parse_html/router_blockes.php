<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 21.08.2017
 * Time: 10:24
 */


require_once("parse_and_create_blocks_on_row.php");
require_once ("../create_Need_files/nav/action_file_for_create_nav_files.php");
//require_once ("../create_Need_files/form/action_file_for_create_form_files.php");


function routeBlocks($block){
    if(nameOfClass($block[0][0]) == "navbi"){
//        var_dump($block[0]);
        actionNavFile(implode("", $block[1]));   //action_file_for_create_nav_files.php
    }
//    if(nameOfClass($block[0]) == "frmbi"){
//        actionFormFile($block);   //action_file_for_create_nav_files.php
//    }

}








$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/fool/index.html");
$needMegaBlock = ["/header", "/main"];

$allBigMegaBlock = startAction($html, $needMegaBlock);


$configBlocks = json_decode(file_get_contents ( "config_blocks.json"));
$configFile = json_decode(file_get_contents ( "../create_Need_files/config.json"));

$mass = getMiniBlocks($allBigMegaBlock[2], $configBlocks, $configFile->isSoloTag);////change to all mass
//var_dump($mass[0]);
//die;

//todo write in other files
//foreach ($allBigMegaBlock as $block){
   routeBlocks(getMiniBlocks($allBigMegaBlock[0], $configBlocks, $configFile->isSoloTag)[0]);/// for nav
//    routeBlocks($mass[0]);

//}


