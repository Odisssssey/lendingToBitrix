<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 10.08.2017
 * Time: 19:07
 */

function sortForTemplateFileNavigate($html, $propertyNewsFile, $SoloTags){
    $templateTags = [[], []];
    $timesTagsforTemplate = [];
    $tagInStack = [];
    $isBitrixBlock = 0;


    preg_match_all ( '/<([^>]+)>/i' , $html , $tags);
    foreach ($tags[1] as $keyOriginTag=>$tag) {
        $nameOriginTag = explode(" ",$tag)[0];

        $tagInStack = BitrixNewsBlock($tag, $nameOriginTag, $propertyNewsFile, $SoloTags, $tagInStack);

        $isBitrixBlock = isBitrixBlock($tagInStack);

        if($isBitrixBlock){
            array_push($timesTagsforTemplate, $tags[1][$keyOriginTag]);


        }else{

            if(count($timesTagsforTemplate) > 0){
                array_push($timesTagsforTemplate, $tags[1][$keyOriginTag]);    //get last tag in block
                array_push($templateTags[1], $timesTagsforTemplate);
                $timesTagsforTemplate = [];

                continue;
            }

            array_push($templateTags[0], $tags[1][$keyOriginTag]);

        }

    }

    echo "\n"."(news) source array is done";

    return $templateTags;


}


$html = file_get_contents("http://university.netology.ru/user_data/tarutin//bitrix/nav/index.html");

var_dump($html);



