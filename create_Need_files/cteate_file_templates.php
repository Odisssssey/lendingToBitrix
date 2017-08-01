<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 31.07.2017
 * Time: 17:43
 */
require_once('block_for_row.php');


function actionTag($tag, $renameTags, $f){

    $allPropTag = explode(" ",$tag);
    $TegName = $allPropTag[0];

    $text = "\n"."<".$tag.">";

    foreach ($renameTags[0] as $key=>$tagChenge){
        if ($TegName == $tagChenge){
            fwrite($f, $renameTags[2][$key]);

            $text = "\n"."<".$tag." ".$renameTags[1][$key].">";

        }

    }

    fwrite($f, $text);


}

function writeTagWithText($text, $f){
    fwrite($f, $text);
}

function startCreateFileTemplate($html, $templateTags, $renameTags){
    preg_match_all ( '/<([^>]+)>/i' , $templateTags , $tags);
    print_r($tags);
    preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable);
    print_r($variable);

    $f = fopen("template.php", 'w+');


    foreach ($tags[0] as $key=>$tag){

        actionTag($tags[1][$key], $renameTags, $f);

        if(in_array($tag, $variable[1])){
            $findKey = array_search($tag, $variable[1]);
            writeTagWithText($variable[2][$findKey], $f);

        }

    }

    fclose($f);
}

$templateTags = startCreateFile($html);  //in block_for_row file

$tegsNeedChenge = ["form", "input"];

$whoNeedChengeInTegs = ['action="<?= POST_FORM_ACTION_URI ?>" method="post" id="iblock_add_request_call"', ''];

$insertAfterTegs = ['<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); } use Bitrix\Main\Localization\Loc; Loc::loadMessages(__FILE__); $this->setFrameMode(true); ?><? if ($arResult["AJAX_CALL"]) : $APPLICATION->RestartBuffer(); endif;<? if ($arResult["AJAX_CALL"]) : $APPLICATION->RestartBuffer(); endif; ?>',
    ''];

$renameTags = [$tegsNeedChenge, $whoNeedChengeInTegs, $insertAfterTegs];

startCreateFileTemplate($html, implode(" ", $templateTags[0]), $renameTags);




//preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги без значений

//preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable); // значения тегов

//; //preg_match_all ( '/([^=]+)[="]+([\w-]+)["]+/i' , $str[1] , $property)
