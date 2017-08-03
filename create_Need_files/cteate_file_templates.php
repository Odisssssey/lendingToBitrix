<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 31.07.2017
 * Time: 17:43
 */
require_once('block_for_row.php');


function actionTag($tag, $renameTags, $f, $bitClass){

    if(isset($renameTags->$bitClass)){

        foreach ($renameTags->$bitClass->insertBefore as $insertBefore){
            $textInsertBefore = "\n".$insertBefore;
            fwrite($f, $textInsertBefore);
        }


        $textTag = "\n"."<".$tag;
        foreach ($renameTags->$bitClass->addInTag as $addInTag){
            $textTag .= " ".$addInTag;
        }
        $textTag .= ">";
        fwrite($f, $textTag);

        foreach ($renameTags->$bitClass->insertAfter as $insertAfter){
            $textInsertAfter = "\n".$insertAfter;
            fwrite($f, $textInsertAfter);
        }

    }else{
        $textTag = "\n"."<".$tag.">";
        fwrite($f, $textTag);
    }

}

function writeEndText($renameTags, $f){
    if(isset($renameTags->end->insertAfter)){
        foreach ($renameTags->end->insertAfter as $endTag){
            $textEndTag = "\n".$endTag;
            fwrite($f, $textEndTag);
        }
    }
}

function serthBitClass($tag, $renameTags)
{
    preg_match_all('/class[="]+([\w]+)/i', $tag, $tags);

    foreach ($tags[1] as $needTag) {
        if (isset($renameTags->$needTag)) {
            return $needTag;
        }
    }

    return 0;
}

function startCreateFileTemplate($html, $templateTags, $renameTags){
    preg_match_all ( '/<([^>]+)>/i' , $templateTags , $tags);

    preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable);


    $f = fopen("template.php", 'w+');


    foreach ($tags[0] as $key=>$tag){

        $bitClass = serthBitClass($tags[1][$key], $renameTags);

        actionTag($tags[1][$key], $renameTags, $f, $bitClass);

        if(in_array($tag, $variable[1])){
            $findKey = array_search($tag, $variable[1]);
            fwrite($f, $variable[2][$findKey]);

        }

    }

    writeEndText($renameTags, $f);
    fclose($f);
}

$templateTags = startCreateFile($html);  //in block_for_row file

$renameTags = json_decode(file_get_contents ( "text_in_tag.json"));

startCreateFileTemplate($html, implode(" ", $templateTags[0]), $renameTags);




//preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги без значений

//preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable); // значения тегов

//; //preg_match_all ( '/([^=]+)[="]+([\w-]+)["]+/i' , $str[1] , $property)
