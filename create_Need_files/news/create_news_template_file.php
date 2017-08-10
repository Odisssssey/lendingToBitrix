<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 10.08.2017
 * Time: 12:47
 */

require_once("news_create_file_source_for_template.php");

function writeStartText($renameTags, $f){
    if(isset($renameTags->startTemplate->insertBefore)){
        foreach ($renameTags->startTemplate->insertBefore as $festTag){
            $textStartTag = "\n".$festTag;
            fwrite($f, $textStartTag);
        }
    }
}

function writeInceptionOfFile($f, $sourcesTagsForBegin, $renameTags){

    writeStartText($renameTags, $f);

    foreach ($sourcesTagsForBegin as $tag){
        if(isOpenTag($tag)){
            $textBegintag = "\n"."<".$tag.">";
            fwrite($f, $textBegintag);
        }
    }
}

function formTagsForRowFiles($heartArraysTags, $propertyNewsFile){
    $originalBlocks = [];
    $usedBiBlocks = [];

    foreach ($heartArraysTags as $blockInHeart){
        $bitrixClass = findBitrixTag($blockInHeart[0], $propertyNewsFile);
        if(isset($bitrixClass)){
            if (!in_array(findBitrixTag($blockInHeart[0], $propertyNewsFile), $usedBiBlocks)) {
                array_push($usedBiBlocks, findBitrixTag($blockInHeart[0], $propertyNewsFile));
                array_push($originalBlocks, $blockInHeart);
            }
        }

    }

//    echo "\n"."(news) sort block for row is done";
    return $originalBlocks;

}

function biClass($tag, $renameTags){
    preg_match_all('/class[="]+([\w]+)/i', $tag, $tagRow);
    if(isset($tagRow[1][0])){
        $biClass = $tagRow[1][0];
        if(isset($renameTags->$biClass)){
            return $biClass;
        }
    }

}

function workWithNewLineOfBlock($f, $biClassBlock, $renameTags){
    if(isset($renameTags->$biClassBlock)){

        foreach ($renameTags->$biClassBlock->insertBefore as $insertBefore){
            $textInsertBefore = "\n".$insertBefore;
            fwrite($f, $textInsertBefore);
        }

    }
}

function writeHeartOfTemplateFile($f, $heartArraysTags, $propertyNewsFile, $renameTags){

    $originalBlocks = formTagsForRowFiles($heartArraysTags, $propertyNewsFile);

    foreach ($originalBlocks as $block){
        $biClassBlock = biClass($block[0], $renameTags);             //need existence in text_in_tag $renameTags->'biClass'
        /////begin work
        workWithNewLineOfBlock($f, $biClassBlock, $renameTags);

    }
}


function writeEndOfFile($f, $sourcesTagsForEnd){
    foreach ($sourcesTagsForEnd as $tag){
        if(!isOpenTag($tag)){
            $textEndTag = "\n"."<".$tag.">";
            fwrite($f, $textEndTag);
        }
    }
}


function startWriteInTemplateFile($f, $sourcesTags, $propertyNewsFile, $renameTags){


    writeInceptionOfFile($f, $sourcesTags[0], $renameTags);

    writeHeartOfTemplateFile($f, $sourcesTags[1], $propertyNewsFile, $renameTags);


    writeEndOfFile($f, $sourcesTags[0]);

}


function startCreateTemplateNewsFile($sourcesTags, $propertyNewsFile, $renameTags){
    $f = fopen("template_news.php", 'w+');

    startWriteInTemplateFile($f, $sourcesTags, $propertyNewsFile, $renameTags);

    fclose($f);
//    echo "\n"."(news) form-row.php is done";
}


$renameTags = json_decode(file_get_contents ( "text_in_tag_news.json"));

$sources = sortForTemplateFileNewsList($html, $settingNewsFile->allProperty, $configFile->isSoloTag);

startCreateTemplateNewsFile($sources, $settingNewsFile->allProperty, $renameTags);








