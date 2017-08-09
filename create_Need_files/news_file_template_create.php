<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 09.08.2017
 * Time: 18:26
 */

function startCreateNewsListFileTemplate($html, $SoloTags){
    preg_match_all ( '/<([^>]+)>/i' , $html , $tags);
    foreach ($tags[1] as $tag) {
        $nameOriginTag = explode(" ",$tag)[0];



    }

}

$settingFile = json_decode(file_get_contents ( "text_in_tag.json"));
$html = file_get_contents("http://university.netology.ru/user_data/tarutin//bitrix/newslist/index.html");




startCreateNewsListFileTemplate($html, $settingFile->isSoloTag);
