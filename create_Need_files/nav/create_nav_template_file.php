<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 11.08.2017
 * Time: 10:29
 */



require_once("create_source_for_nav_template_file.php");


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

    echo "\n"."(nav) sort block is done";
    return $originalBlocks;

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
        return $textTagTextareaInRow;
    }
    return $tag;

}

function workWithTagOfLine($tag, $biClass, $biClassBlock, $settingNewsFile){


    if ($biClassBlock == "ancbi") {

        $textTag = createSlideForNews($tag, $settingNewsFile, $biClass, $biClassBlock);

    }

    return $textTag;

}

function workWithNewLineOfBlock($f, $tag, $biClass, $biClassBlock, $settingNewsFile){
    if(isset($settingNewsFile->$biClassBlock->$biClass)){

        $textTag = workWithTagOfLine($tag, $biClass, $biClassBlock, $settingNewsFile);


        fwrite($f, $textTag);

    }else{
        $textTag = "\n"."<".$tag.">";
        fwrite($f, $textTag);
    }

}

function workWithBlock($f, $block, $biClassBlock, $settingNewsFile){
    foreach ($block as $newLine){
        $biClass = findBitrixTag($newLine, $settingNewsFile->$biClassBlock->allProperty);

        //workWithNewLineOfBlock($f, $newLine, $biClass, $biClassBlock, $settingNewsFile);
    }

}

function writeEndText($renameTags, $f){
    if(isset($renameTags->endlitbi->insertBefore)){
        foreach ($renameTags->endlitbi->insertBefore as $lastTag){
            $textStartTag = "\n".$lastTag;
            fwrite($f, $textStartTag);
        }
    }
}

function writeHeartOfTemplateFile($f, $heartArraysTags, $renameTags, $propertyNewsFile, $settingNewsFile){

    $originalBlocks = formTagsForRowFiles($heartArraysTags, $propertyNewsFile);

    writeStartText($renameTags, $f);

    foreach ($originalBlocks as $block){
        $biClassBlock = findBitrixTag($block[0], $propertyNewsFile);         ///in create_source_for_nav_template_file.php
        workWithBlock($f, $block, $biClassBlock, $settingNewsFile);
    }
    writeEndText($renameTags, $f);

}



function startWriteInTemplateFile($f, $sourcesTags, $renameTags, $propertyNewsFile, $settingNewsFile){

    writeHeartOfTemplateFile($f, $sourcesTags[1], $renameTags, $propertyNewsFile, $settingNewsFile);

}


function startCreateTemplateNewsFile($sourcesTags, $renameTags, $propertyNewsFile, $settingNewsFile){
    $f = fopen("template_nav.php", 'w+');

    startWriteInTemplateFile($f, $sourcesTags, $renameTags, $propertyNewsFile, $settingNewsFile);

    fclose($f);
//    echo "\n"."(nav) nav-template.php is done";
}


$renameTags = json_decode(file_get_contents ( "text_in_tag_nav.json"));

$sources = sortForTemplateFileNavigate($html, $settingNavFile->allProperty, $configFile->isSoloTag);

startCreateTemplateNewsFile($sources, $renameTags, $settingNavFile->allProperty, $settingNavFile);


