<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 09.08.2017
 * Time: 11:04
 *
 * new
 *
 */

//require_once ("efficient_block_for_row.php");

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

function createSettingsForInput($newline, $settingsTags, $nameTagInputInRow, $biClassBlock){

    $propertyClassInRow = classProperty($newline);

    if(isset($settingsTags->$biClassBlock->$nameTagInputInRow)){

        $textTagInputInRow = "\n".$settingsTags->$biClassBlock->$nameTagInputInRow[0];
        $textTagInputInRow .= $propertyClassInRow[0];
        $textTagInputInRow .= $settingsTags->$biClassBlock->$nameTagInputInRow[1];
        return $textTagInputInRow;
    }
    return $newline;

}


function createTagForSelect($classSelectProperty, $nameTagSelectInRow, $settingsTags){
    $textTagSelectInRow = "\n".$settingsTags->$nameTagSelectInRow[0];
    $textTagSelectInRow .= $classSelectProperty[0];
    $textTagSelectInRow .= $settingsTags->$nameTagSelectInRow[1];
    return $textTagSelectInRow;
}

function createTagForOption($classSelectProperty, $nameTagSelectInRow, $settingsTags){
    $textTagSelectInRow = "\n".$settingsTags->$nameTagSelectInRow[0];
    $textTagSelectInRow .= $classSelectProperty[0];
    $textTagSelectInRow .= $settingsTags->$nameTagSelectInRow[1];
    $textTagSelectInRow .= $classSelectProperty[0];
    $textTagSelectInRow .= $settingsTags->$nameTagSelectInRow[2];
    return $textTagSelectInRow;
}

function createSettingsForSelect($tagSelectInRow, $settingsTags, $nameTagSelectInRow, $biClassBlock){

    $classSelectProperty = classProperty($tagSelectInRow);

    if($nameTagSelectInRow == "select") {
        $textTagSelectInRow = createTagForSelect($classSelectProperty, $nameTagSelectInRow, $settingsTags->$biClassBlock);

        return $textTagSelectInRow;
    }
    if($nameTagSelectInRow == "option") {

        $textTagSelectInRow = createTagForOption($classSelectProperty, $nameTagSelectInRow, $settingsTags->$biClassBlock);

        return $textTagSelectInRow;

    }

}

function createSettingsForTextarea($newline, $settingsTags, $nameTagTextareaInRow, $biClassBlock){

    $propertyClassInRow = classProperty($newline);

    if(isset($settingsTags->$biClassBlock->$nameTagTextareaInRow)){

        $textTagTextareaInRow = "\n".$settingsTags->$biClassBlock->$nameTagTextareaInRow[0];
        $textTagTextareaInRow .= $propertyClassInRow[0];
        $textTagTextareaInRow .= $settingsTags->$biClassBlock->$nameTagTextareaInRow[1];
        return $textTagTextareaInRow;
    }
    return $newline;

}


function ignoreTag($nameTag){
    if($nameTag == "/option"){
        return 1;
    }
    return 0;
}

function writeInFile($f, $oneBlock, $renameTags, $settingsTags){
    $biClassBlock = biClass($oneBlock[0], $renameTags);             //need existence in text_in_tag $renameTags->'biClass'

    if(isset($biClassBlock)){
        $startinpbi = "start".$biClassBlock;
        if(isset($renameTags->$startinpbi->insertBefore)) {
            foreach ($renameTags->$startinpbi->insertBefore as $startInsertBefore) {
                $textStartInsertBefore = "\n" . $startInsertBefore;
                fwrite($f, $textStartInsertBefore);
            }
        }
    }
    foreach ($oneBlock as $newline){

        $biClass = biClass($newline, $renameTags);

        if(isset($biClass)){
            foreach ($renameTags->$biClass->insertBefore as $insertBefore){
                $textInsertBefore = "\n".$insertBefore;
                fwrite($f, $textInsertBefore);
            }
        }

        $nameTagOfLine = explode(" ", $newline)[0];

        if(isset($settingsTags->$biClassBlock->allProperty) && in_array($nameTagOfLine, $settingsTags->$biClassBlock->allProperty)){

            if($biClassBlock == "inpbi"){

                $textInTag = createSettingsForInput($newline, $settingsTags, $nameTagOfLine, $biClassBlock);

            }
            if($biClassBlock == "selbi"){

                $textInTag = createSettingsForSelect($newline, $settingsTags, $nameTagOfLine, $biClassBlock);

                if($nameTagOfLine == "option") {
                    if(!isset($isCompleteOption)){
                        $isCompleteOption = 1;
                    }else{
                        $textInTag = '';
                    }
                }
            }
            if($biClassBlock == "texbi"){

                $textInTag = createSettingsForTextarea($newline, $settingsTags, $nameTagOfLine, $biClassBlock);

            }

        }else {
            $textInTag = '';                                   // clean variable
            preg_match_all('/([^ =]+)[="]+([\w- ]+)["]+/i', $newline, $propertyTagInOrigin);

            if(!ignoreTag($nameTagOfLine)) {

                $textInTag = "\n" . "<" . $nameTagOfLine;
                foreach ($propertyTagInOrigin[1] as $keyNameProperty => $NameProperty) {
                    $textInTag .= ' ' . $NameProperty . '="';

                    $textInTag .= $propertyTagInOrigin[2][$keyNameProperty];

                    if (isset($renameTags->$biClass->addInProperty->$NameProperty)) {
                        foreach ($renameTags->$biClass->addInProperty->$NameProperty as $addInProperty) {
                            $textInTag .= $addInProperty;
                        }
                    }

                    $textInTag .= '"';
                }
                $textInTag .= ">";
            }
        }


        fwrite($f, $textInTag);


        if(isset($biClass)){
            foreach ($renameTags->$biClass->insertAfter as $insertAfter){
                $textInsertAfter = "\n".$insertAfter;
                fwrite($f, $textInsertAfter);
            }
        }

    }



    if(isset($biClassBlock)) {
        $nameEndBlock = "end".$biClassBlock;
        if (isset($renameTags->$nameEndBlock->insertAfter)) {
            foreach ($renameTags->$nameEndBlock->insertAfter as $endBlock) {
                $textEndBlock = "\n" . $endBlock;
                fwrite($f, $textEndBlock);
            }
        }
    }


}

function writeStartText($renameTags, $f){
    if(isset($renameTags->startRow->insertBefore)){
        foreach ($renameTags->startRow->insertBefore as $festTag){
            $textStartTag = "\n".$festTag;
            fwrite($f, $textStartTag);
        }
    }
}

function ctartContentFile($arrTags, $renameTags, $f, $settingsTags){

    writeStartText($renameTags, $f);

    foreach ($arrTags as $tags){
        writeInFile($f, $tags, $renameTags, $settingsTags);
    }

}


function startCreateFileRow($rowTags, $renameTags, $settingsTags){
    $f = fopen("form-row.php", 'w+');

    ctartContentFile($rowTags, $renameTags, $f, $settingsTags);

    fclose($f);
    echo "\n"."form-row.php is done";
}


//$settingsTags = json_decode(file_get_contents ( "setting_row.json"));
//
//$renameTags = json_decode(file_get_contents ( "text_in_tag.json"));
//
//
//$arrRowFiles = formTagsForRowFiles($htmlForRow, $settingRowTags->allProperty);  //in efficient_block_for_row.php
//
//
//startCreateFileRow($arrRowFiles, $renameTags, $settingsTags);
