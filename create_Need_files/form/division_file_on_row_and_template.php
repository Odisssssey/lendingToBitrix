<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 08.08.2017
 * Time: 14:26
 * new
 */


function findBitrixTag($tag, $settingRowTags){
    preg_match_all ( '/class="([\w]+)/i' , $tag, $potentiallyBitrixClass);
    if(isset($potentiallyBitrixClass[1][0])){
        if(in_array($potentiallyBitrixClass[1][0],  $settingRowTags)){
            return $potentiallyBitrixClass[1][0];
        }
    }
}

function isBitrixTag($tag, $settingRowTags){
    if (findBitrixTag($tag, $settingRowTags) != ""){
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


function BitrixBlock($tag, $nameOriginTag, $settingRowTags, $SoloTags,$tagInStack){

    if(isBitrixTag($tag, $settingRowTags)){
        array_push($tagInStack, $nameOriginTag);
        return $tagInStack;
    }

    if(count($tagInStack)>0){
        if(isOpenTag($nameOriginTag)){

            if(!in_array($nameOriginTag, $SoloTags)){
                array_push($tagInStack, $nameOriginTag);
            }

        }else{
            array_shift ($tagInStack);
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


function divideFile($html, $settingRowTags, $SoloTags){
    $templateTags = [[], []];
    $timesTagsforRow = [];
    $tagInStack = [];
    $isBitrixBlock = 0;

    preg_match_all ( '/<([^>]+)>/i' , $html , $tags);
    foreach ($tags[1] as $keyOriginTag=>$tag){

        $nameOriginTag = explode(" ",$tag)[0];

        $tagInStack = BitrixBlock($tag, $nameOriginTag, $settingRowTags, $SoloTags, $tagInStack);

        $isBitrixBlock = isBitrixBlock($tagInStack);

        if($isBitrixBlock){
            array_push($timesTagsforRow, $tags[1][$keyOriginTag]);

        }else{

            if(count($timesTagsforRow) > 0){
                array_push($timesTagsforRow, $tags[1][$keyOriginTag]);    //get last tag in block
                array_push($templateTags[1], $timesTagsforRow);
                $timesTagsforRow = [];
                continue;
            }

            array_push($templateTags[0], $tags[1][$keyOriginTag]);
        }

    }
    echo "\n"."(form) tags for files is done";
    return $templateTags;
}



//$settingFile = json_decode(file_get_contents ( "text_in_tag_form.json"));
//
//$settingRowTags = json_decode(file_get_contents ( "setting_row_form.json"));
//
//$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");
//
//divideFile($html, $settingRowTags->allProperty, $settingFile->isSoloTag);
