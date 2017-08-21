<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 21.08.2017
 * Time: 10:24
 */


require_once("parse_origin_html.php");




$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/fool/index.html");
$needMegaBlock = ["/header", "/main"];

$allBigMegaBlock = startAction($html, $needMegaBlock);


$configBlocks = json_decode(file_get_contents ( "config_blocks.json"));
$configFile = json_decode(file_get_contents ( "../create_Need_files/config.json"));




//todo write in other files
//foreach ($allBigMegaBlock as $block){
    var_dump(getMiniBlocks($allBigMegaBlock[0], $configBlocks, $configFile->isSoloTag));

//}


