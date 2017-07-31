<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 31.07.2017
 * Time: 17:43
 */

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

function startCreateFile($html, $renameTags){
    preg_match_all ( '/<([^>]+)>/i' , $html , $tags);
    print_r($tags);
    preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable);
    print_r($variable);

    $f = fopen("template.php", 'w+');

    $keyVariable = 0;

    foreach ($tags[0] as $key=>$tag){

        actionTag($tags[1][$key], $renameTags, $f);

        if(isset($variable[1][$keyVariable])) {

            if ($tag == $variable[1][$keyVariable]) {
                writeTagWithText($variable[2][$keyVariable], $f);

                $keyVariable++;
            }
        }

    }

    fclose($f);
}

$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");

$tegsNeedChenge = ["form", "input"];

$whoNeedChengeInTegs = ['action="<?= POST_FORM_ACTION_URI ?>" method="post"', ''];

$insertAfterTegs = ['<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); } use Bitrix\Main\Localization\Loc; Loc::loadMessages(__FILE__); $this->setFrameMode(true); ?>',
    ''];

$renameTags = [$tegsNeedChenge, $whoNeedChengeInTegs, $insertAfterTegs];

startCreateFile($html, $renameTags);




//preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги без значений

//preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable); // значения тегов

//preg_match_all ( '/([^=]+)[="]+([\w-]+)["]+/i' , $str[1] , $property); //