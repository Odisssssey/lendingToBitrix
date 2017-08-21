<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 11.08.2017
 * Time: 10:29
 */



//require_once("create_source_for_nav_template_file.php");

function writeStartText($renameTags, $f){
    if(isset($renameTags->startlitbi->insertBefore)){
        foreach ($renameTags->startlitbi->insertBefore as $festTag){
            $textStartTag = "\n".$festTag;
            fwrite($f, $textStartTag);
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

    echo "\n"."(nav) sort block is done";
    return $originalBlocks;

}

function classProperty($tag){
    preg_match_all('/class[="]+([^"]+)["]+/i', $tag, $propertyClass);
    return $propertyClass[1];
}

function formSelectOrigin($propertyClassInRow, $settingsTags, $biClass, $biClassBlock){
    if(isset($settingsTags->$biClassBlock->$biClass)){
        $selectTagText = "\n".$settingsTags->$biClassBlock->$biClass[0];
        $selectTagText .= $propertyClassInRow[0];
        $selectTagText .= $settingsTags->$biClassBlock->$biClass[1];
        return $selectTagText;
    }
}

function createSlideForNav($tag, $propertyClassInRow, $settingsTags, $biClass, $biClassBlock){
    if(isset($settingsTags->$biClassBlock->$biClass)){
        $selectTagText = formSelectOrigin($propertyClassInRow, $settingsTags, $biClass, $biClassBlock);
        return $selectTagText;
    }
    return $tag;

}

function workWithTagOfLine($tag, $propertyClassInRow, $biClass, $biClassBlock, $settingNavFile){
    if ($biClass == "ancbi") {
        $textTag = createSlideForNav($tag, $propertyClassInRow, $settingNavFile, $biClass, $biClassBlock);
        return $textTag;

    }
}

function workWithNewLineOfBlock($f, $tag, $biClass, $biClassBlock, $settingNavFile, $selected){
    $propertyClassInRow = classProperty($tag);
    //$NameClassTag = findBitrixTag($tag, $settingNewsFile->allProperty);

    if($selected == 1 && $biClass == "ancbi"){
        $propertyClassInRow[0] .= " selected";
    }

    if(isset($settingNavFile->$biClassBlock->$biClass)){

        $textTag = workWithTagOfLine($tag, $propertyClassInRow, $biClass, $biClassBlock, $settingNavFile);

        fwrite($f, $textTag);

    }else{
        $textTag = "\n"."<".$tag.">";

        fwrite($f, $textTag);
    }

}

function formNewSelectBlock($f, $newLine, $biClass, $biClassBlock, $settingNavFile, $selected){


    workWithNewLineOfBlock($f, $newLine, $biClass, $biClassBlock, $settingNavFile, $selected);
}

function workWithBlock($f, $block, $biClassBlock, $settingNavFile, $selected){
    foreach ($block as $newLine){
        $biClass = findBitrixTag($newLine, $settingNavFile->$biClassBlock->allProperty);

        formNewSelectBlock($f, $newLine, $biClass, $biClassBlock, $settingNavFile, $selected);

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

function writeHeartOfTemplateFile($f, $heartArraysTags, $renameTags, $propertyNavFile, $settingNavFile){
    $originalBlocks = formTagsForRowFiles($heartArraysTags, $propertyNavFile);
    writeStartText($renameTags, $f);
    foreach ($originalBlocks as $block){
        $biClassBlock = findBitrixTag($block[0], $propertyNavFile);         ///in create_source_for_nav_template_file.php

        if ($biClassBlock == "litbi") {
            $textTag = "\n"."<?else:?>";
            fwrite($f, $textTag);
            $selected = 1;
            workWithBlock($f, $block, $biClassBlock, $settingNavFile, $selected);
        }
        $selected = 0;

        workWithBlock($f, $block, $biClassBlock, $settingNavFile, $selected);
    }
    writeEndText($renameTags, $f);

}



function startWriteInTemplateFile($f, $sourcesTags, $renameTags, $propertyNavFile, $settingNavFile){

    writeHeartOfTemplateFile($f, $sourcesTags[1], $renameTags, $propertyNavFile, $settingNavFile);

}


function startCreateTemplateNavFile($sourcesTags, $renameTags, $propertyNavFile, $settingNavFile){
    $f = fopen(__DIR__."/template_nav.php", 'w+');

    startWriteInTemplateFile($f, $sourcesTags, $renameTags, $propertyNavFile, $settingNavFile);

    fclose($f);
    echo "\n"."(nav) nav-template.php is done";
}


//$renameTags = json_decode(file_get_contents ( "text_in_tag_nav.json"));
//
//$sources = sortForTemplateFileNavigate($html, $settingNavFile->allProperty, $configFile->isSoloTag);
//
//startCreateTemplateNewsFile($sources, $renameTags, $settingNavFile->allProperty, $settingNavFile);

