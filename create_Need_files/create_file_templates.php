<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 31.07.2017
 * Time: 17:43
 */



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
        foreach ($renameTags->endForm->insertAfter as $endTag){
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

    preg_match_all ( '/<([^>]+?[^>]+)>(.*?)<[^>]+?[^>]+>/i' , $html , $variable);


    $f = fopen("template.php", 'w+');

    foreach ($templateTags as $key=>$tag){

        $bitClass = serthBitClass($tag, $renameTags);

        actionTag($tag, $renameTags, $f, $bitClass);

        if(in_array($tag, $variable[1])){
            $findKey = array_search($tag, $variable[1]);
            fwrite($f, $variable[2][$findKey]);

        }

    }

    writeEndText($renameTags, $f);
    fclose($f);

    echo "\n"."template.php is done";
}


//require_once('division_file_on_row_and_template.php');
//
//$htmlForTemplate = divideFile($html, $settingRowTags->allProperty, $settingFile->isSoloTag); // in division_file_on_row_and_template
//
//
//$renameTags = json_decode(file_get_contents ( "text_in_tag.json"));
//
//startCreateFileTemplate($html, $htmlForTemplate[0], $renameTags);  ///$html in  division_file_on_row_and_template.php

