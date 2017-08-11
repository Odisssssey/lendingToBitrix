<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 10.08.2017
 * Time: 12:47
 */

//require_once("news_create_file_source_for_template.php");

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

    echo "\n"."(news) sort block is done";
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

function classProperty($tag){
    preg_match_all('/class[="]+([^"]+)["]+/i', $tag, $propertyClass);
    return $propertyClass[1];
}

function createSlideForNews($tag, $settingsTags, $biClass, $biClassBlock){

    $propertyClassInRow = classProperty($tag);

    if(isset($settingsTags->$biClassBlock->$biClass)){

        $textTagTextareaInRow = "\n".$settingsTags->$biClassBlock->$biClass[0];
        $textTagTextareaInRow .= $propertyClassInRow[0];
        $textTagTextareaInRow .= $settingsTags->$biClassBlock->$biClass[1];
        $textTagTextareaInRow .= $propertyClassInRow[0];
        $textTagTextareaInRow .= $settingsTags->$biClassBlock->$biClass[2];
        return $textTagTextareaInRow;
    }
    return $tag;

}

function workWithTagOfLine($tag, $biClass, $biClassBlock, $settingNewsFile, $renameTags){

    if(isset($settingNewsFile->$biClassBlock->allProperty) && in_array($biClass, $settingNewsFile->$biClassBlock->allProperty)) {

        if ($biClassBlock == "slibi") {

            $textTag = createSlideForNews($tag, $settingNewsFile, $biClass, $biClassBlock);

        }
    }else{

        $textTag = "\n" . "<" . $tag;
        foreach ($renameTags->$biClass->addInTag as $addInTag) {
            $textTag .= " " . $addInTag;
        }
        $textTag .= ">";
    }

    return $textTag;

}

function workWithNewLineOfBlock($f, $tag, $biClass, $biClassBlock, $renameTags, $settingNewsFile){
    if(isset($renameTags->$biClass)){

        foreach ($renameTags->$biClass->insertBefore as $insertBefore){
            $textInsertBefore = "\n".$insertBefore;
            fwrite($f, $textInsertBefore);
        }


        $textTag = workWithTagOfLine($tag, $biClass, $biClassBlock, $settingNewsFile, $renameTags);


        fwrite($f, $textTag);

        foreach ($renameTags->$biClass->insertAfter as $insertAfter){
            $textInsertAfter = "\n".$insertAfter;
            fwrite($f, $textInsertAfter);
        }

    }else{
        $textTag = "\n"."<".$tag.">";
        fwrite($f, $textTag);
    }

}

function workWithBlock($f, $block, $biClassBlock, $renameTags, $settingNewsFile){
    foreach ($block as $newLine){
        $biClass = biClass($newLine, $renameTags);             //need existence in text_in_tag $renameTags->'biClass'
        workWithNewLineOfBlock($f, $newLine, $biClass, $biClassBlock, $renameTags, $settingNewsFile);
    }

}

function writeEndText($renameTags, $f){
    if(isset($renameTags->endslibi->insertBefore)){
        foreach ($renameTags->endslibi->insertBefore as $lastTag){
            $textStartTag = "\n".$lastTag;
            fwrite($f, $textStartTag);
        }
    }
}

function writeHeartOfTemplateFile($f, $heartArraysTags, $propertyNewsFile, $renameTags, $settingNewsFile){

    $originalBlocks = formTagsForRowFiles($heartArraysTags, $propertyNewsFile);

    foreach ($originalBlocks as $block){
        $biClassBlock = biClass($block[0], $renameTags);
        workWithBlock($f, $block, $biClassBlock, $renameTags, $settingNewsFile);

    }
    writeEndText($renameTags, $f);
}


function writeEndOfFile($f, $sourcesTagsForEnd){
    foreach ($sourcesTagsForEnd as $tag){
        if(!isOpenTag($tag)){
            $textEndTag = "\n"."<".$tag.">";
            fwrite($f, $textEndTag);
        }
    }
}


function startWriteInTemplateFile($f, $sourcesTags, $propertyNewsFile, $renameTags, $settingNewsFile){


    writeInceptionOfFile($f, $sourcesTags[0], $renameTags);

    writeHeartOfTemplateFile($f, $sourcesTags[1], $propertyNewsFile, $renameTags, $settingNewsFile);


    writeEndOfFile($f, $sourcesTags[0]);

}


function startCreateTemplateNewsFile($sourcesTags, $propertyNewsFile, $renameTags, $settingNewsFile){
    $f = fopen("template_news.php", 'w+');

    startWriteInTemplateFile($f, $sourcesTags, $propertyNewsFile, $renameTags, $settingNewsFile);

    fclose($f);
    echo "\n"."(news) news-template.php is done";
}


//$renameTags = json_decode(file_get_contents ( "text_in_tag_news.json"));
//
//$sources = sortForTemplateFileNewsList($html, $settingNewsFile->allProperty, $configFile->isSoloTag);
//
//startCreateTemplateNewsFile($sources, $settingNewsFile->allProperty, $renameTags, $settingNewsFile);








