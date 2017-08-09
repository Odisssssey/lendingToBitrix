<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 04.08.2017
 * Time: 10:18
 *
 *
 * old
 *
 */
require_once('block_for_rowOLD.php');

function isBiblock($tag, $renameTags){
    preg_match_all('/class[="]+([\w]+)/i', $tag, $tagRow);
    if(isset($tagRow[1][0])){
        if(in_array($tagRow[1][0], $renameTags->biForRow)){
            return 1;
        }
        return 0;
    }

}

function oneBlock($tags, $renameTags, $keyAnotherBlock){
    $scopeTags = [];
    $treeTags = [];

    for ( ; ;$keyAnotherBlock++){

        $tag = $tags[$keyAnotherBlock];

        preg_match_all('/<([\w\S]+)[ >]+/i', $tag, $nameTag);

        $isBiblock = isBiblock($tag, $renameTags);

        if ($isBiblock == 1){
            array_push($scopeTags, $nameTag[1][0]);
            array_push($treeTags, $tag);
            continue;
        }

        if(count($scopeTags) > 0){

            preg_match_all('/[\w\S]/i',$nameTag[1][0], $nameTagSymbol);
            if ($nameTagSymbol[0][0] == "/"){
                array_pop($scopeTags);

            }else{
                if(!in_array($nameTag[1][0], $renameTags->isSoloTag)){
                    array_push($scopeTags, $nameTag[1][0]);
                }

            }
            array_push($treeTags, $tag);
        }

        if((count($scopeTags) == 0) && ($isBiblock == 0)){
            return $treeTags;
        }

    }

}

function isEqualClasses($festTag, $secondTag){
    preg_match_all('/class[="]+([\w- ]+)["]+/i', $festTag, $fest);
    preg_match_all('/class[="]+([\w- ]+)["]+/i', $secondTag, $second);

    if($fest == $second){
        return 1;
    }
    return 0;
}


function keyAnoutherBlock($tags, $oneBlock, $keyAnotherBlock){
    $keyOneBlock = 0;

    for ( ; $keyAnotherBlock < count($tags)-1; $keyAnotherBlock++){
        $tag = $tags[$keyAnotherBlock];

        if(!isset($oneBlock[$keyOneBlock])){
            $keyOneBlock = 0;
        }

        if(isEqualClasses($oneBlock[$keyOneBlock], $tag) == 1){    ///add bi-class butch
            //echo "\n".$tag;    //give all like blocks

        }else{
            ///изменить на сравнение по классам
            return $keyAnotherBlock; //the last key of another block
        }

        $keyOneBlock ++;

    }

    return $keyAnotherBlock;
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


function createSettingsForInput($newline, $settingsTags, $nameTagInputInRow, $biClassBlock){

    preg_match_all('/class[="]+([^"]+)["]+/i', $newline, $propertyClassInRow);

    if(isset($settingsTags->$biClassBlock->$nameTagInputInRow)){

        $textTagInputInRow = "\n".$settingsTags->inpbi->$nameTagInputInRow[0];
        $textTagInputInRow .= $propertyClassInRow[1][0];
        $textTagInputInRow .= $settingsTags->inpbi->$nameTagInputInRow[1];
        return $textTagInputInRow;
    }
    return $newline;

}


function classProperty($tag){
    preg_match_all('/class[="]+([^"]+)["]+/i', $tag, $propertyClass);
    return $propertyClass[1];
}

function createTagForSelect($classSelectProperty, $nameTagSelectInRow, $settingsTags){
    $textTagSelectInRow = "\n".$settingsTags->$nameTagSelectInRow[0];
    $textTagSelectInRow .= $classSelectProperty[0];
    $textTagSelectInRow .= $settingsTags->$nameTagSelectInRow[1];
    return $textTagSelectInRow;
}

function ignoreTag($nameTag){
    if($nameTag == "/option"){
        return 1;
    }
    return 0;
}


function createSettingsForSelect($tagSelectInRow, $settingsTags, $nameTagSelectInRow, $biClassBlock){

    $classSelectProperty = classProperty($tagSelectInRow);

    if($nameTagSelectInRow == "select") {
        $textTagSelectInRow = createTagForSelect($classSelectProperty, $nameTagSelectInRow, $settingsTags->$biClassBlock);

        return $textTagSelectInRow;
    }
    if($nameTagSelectInRow == "option") {

        $textTagSelectInRow = createTagForSelect($classSelectProperty, $nameTagSelectInRow, $settingsTags->$biClassBlock);

        return $textTagSelectInRow;

    }

}



function writeInFile($f, $oneBlock, $renameTags, $settingsTags){
    $biClassBlock = biClass($oneBlock[0], $renameTags);

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

        preg_match_all ( '/<([^>]+)>/i' , $newline , $originTags);

        $nameTagOfLine = explode(" ", $originTags[1][0])[0];



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

        }else {
            $textInTag = '';                                   // clean variable
            preg_match_all('/([^ =]+)[="]+([\w- ]+)["]+/i', $originTags[1][0], $propertyTagInOrigin);

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

function ctartContentFile($tags, $renameTags, $f, $settingsTags){
    $keyAnotherBlock = 0;

    writeStartText($renameTags, $f);

    while($keyAnotherBlock < count($tags)-1) {
        $oneBlock = oneBlock($tags, $renameTags, $keyAnotherBlock);  // give last new block

        writeInFile($f, $oneBlock, $renameTags, $settingsTags);

        //Block processing//
        $keyAnotherBlock = keyAnoutherBlock($tags, $oneBlock, $keyAnotherBlock); // give new key
    }



}

function startCreateFileRow($rowTags, $renameTags, $settingsTags){
    $f = fopen("form-row.php", 'w+');

    ctartContentFile($rowTags, $renameTags, $f, $settingsTags);

    fclose($f);
}

$templateTags = startCreateFile($html);  //in block_for_row file

var_dump($templateTags);

$settingsTags = json_decode(file_get_contents ( "setting_row.json"));

$renameTags = json_decode(file_get_contents ( "text_in_tag.json"));

//var_dump($templateTags[1]);
startCreateFileRow($templateTags[1], $renameTags, $settingsTags);