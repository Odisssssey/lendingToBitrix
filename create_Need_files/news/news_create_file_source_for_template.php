<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 09.08.2017
 * Time: 18:26
 *
 *
 * sort tags for news file template
 *
 */



function findBitrixTag($tag, $propertyNewsFile){
    preg_match_all ( '/class="([\w]+)/i' , $tag, $potentiallyBitrixClass);
    if(isset($potentiallyBitrixClass[1][0])){
        if(in_array($potentiallyBitrixClass[1][0],  $propertyNewsFile)){
            return $potentiallyBitrixClass[1][0];
        }
    }
}

function isBitrixTag($tag, $propertyNewsFile){
    if (findBitrixTag($tag, $propertyNewsFile) != ""){
        return 1;
    }else{
        return 0;
    }
}

function isOpenTag($nameTag){
    preg_match_all ( '/[^ ]/i' , $nameTag , $symbolOfWord);
    if($symbolOfWord[0][0] == "/"){
        return 0;
    }
    return 1;
}

function BitrixNewsBlock($tag, $nameOriginTag, $propertyNewsFile, $SoloTags, $tagInStack){

    if(isBitrixTag($tag, $propertyNewsFile)){
        array_push($tagInStack, $nameOriginTag);
        return $tagInStack;
    }

    if(count($tagInStack)>0){
        if(isOpenTag($nameOriginTag)){

            if(!in_array($nameOriginTag, $SoloTags)){
                array_push($tagInStack, $nameOriginTag);
            }

        }else{
            array_pop ($tagInStack);
        }

    }

    return $tagInStack;
}

function isBitrixBlock($tagInStack){
    if(count($tagInStack) > 0){
        return 1;
    }
    return 0;
}

function sortForTemplateFileNewsList($html, $propertyNewsFile, $SoloTags){
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

//$settingNewsFile = json_decode(file_get_contents ( "setting_template_news.json"));
//
//$html = file_get_contents("http://university.netology.ru/user_data/tarutin//bitrix/newslist/index.html");
//
//$configFile = json_decode(file_get_contents ( "../config.json"));
//
//
//
//startCreateNewsListFileTemplate($html, $settingNewsFile->allProperty, $configFile->isSoloTag);
