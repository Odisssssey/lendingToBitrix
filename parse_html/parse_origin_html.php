<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 18.08.2017
 * Time: 19:29
 */
function nameOfTag($tag){
    $nameOfTag = explode(" ",$tag)[0];
    return $nameOfTag;
}


function startAction($html, $needMegaBlock){
    $htmlBlocks = [[],[],[]];
    $position = 0;
    preg_match_all ( '/<([^>]+)>/i' , $html , $tags);
    foreach($tags[1] as $tag){
        array_push($htmlBlocks[$position], $tag);
        $nameOfTag = nameOfTag($tag);
        if(isset($nameOfTag) && isset($needMegaBlock[$position])){
            if (nameOfTag($tag) == $needMegaBlock[$position]) {
                $position++;
            }
        }
    }
    var_dump($htmlBlocks);
}

$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/fool/index.html");
$needMegaBlock = ["/header", "/main"];

startAction($html, $needMegaBlock);







