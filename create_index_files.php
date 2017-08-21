<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 21.08.2017
 * Time: 10:12
 */

require_once("./parse_html/parse_origin_html.php");

/*get all mega-blocks*/

$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/fool/index.html");
$needMegaBlock = ["/header", "/main"];

$allBigMegaBlock = startAction($html, $needMegaBlock);

/*parse every mega blocks*/

foreach ($allBigMegaBlock as $megaBlock){
    var_dump($megaBlock);
}


