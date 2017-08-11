<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 10.08.2017
 * Time: 19:07
 */

function findBitrixTag($tag, $propertyNavFile){

    preg_match_all ( '/class="([\w]+)/i' , $tag, $potentiallyBitrixClass);
    if(isset($potentiallyBitrixClass[1][0])){
        if(in_array($potentiallyBitrixClass[1][0],  $propertyNavFile)){
            return $potentiallyBitrixClass[1][0];
        }
    }
}

function isBitrixTag($tag, $propertyNavFile){
    if (findBitrixTag($tag, $propertyNavFile) != ""){
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

function BitrixNavBlock($tag, $nameOriginTag, $propertyNavFile, $SoloTags, $tagInStack){

    if(isBitrixTag($tag, $propertyNavFile)){
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

function sortForTemplateFileNavigate($html, $propertyNavFile, $SoloTags){
    $templateTags = [[], []];
    $timesTagsforTemplate = [];
    $tagInStack = [];
    $isBitrixBlock = 0;


    preg_match_all ( '/<([^>]+)>/i' , $html , $tags);
    foreach ($tags[1] as $keyOriginTag=>$tag) {
        $nameOriginTag = explode(" ",$tag)[0];

        $tagInStack = BitrixNavBlock($tag, $nameOriginTag, $propertyNavFile, $SoloTags, $tagInStack);

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

    echo "\n"."(nav) source array is done";

    return $templateTags;

}


$html = file_get_contents("http://university.netology.ru/user_data/tarutin//bitrix/nav/index.html");

$settingNavFile = json_decode(file_get_contents ( "setting_template_nav.json"));

$configFile = json_decode(file_get_contents ( "../config.json"));
//
//sortForTemplateFileNavigate($html, $settingNavFile->allProperty, $configFile->isSoloTag);
