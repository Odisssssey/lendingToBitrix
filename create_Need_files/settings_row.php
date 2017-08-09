<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 07.08.2017
 * Time: 15:02
 *
 * times
 */

require_once('efficient_block_for_row.php');


function createSettingsForInput($html, $settingsTags){

    foreach ($html as $tagInputInRow){
        $nameTagInputInRow = explode(" ", $tagInputInRow)[0];

        if(in_array($nameTagInputInRow, $settingsTags->inpbi->allProperty)){
            preg_match_all('/class[="]+([^"]+)["]+/i', $tagInputInRow, $propertyClassInRow);

            if(isset($settingsTags->inpbi->$nameTagInputInRow)){

                $textTagInputInRow = "\n".$settingsTags->inpbi->$nameTagInputInRow[0];
                $textTagInputInRow .= $propertyClassInRow[1][0];
                $textTagInputInRow .= $settingsTags->inpbi->$nameTagInputInRow[1];
                echo $textTagInputInRow;
            }

        }else{
            echo "\n".$tagInputInRow;
        }

    }
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

function createSettingsForSelect($block, $settingsTags){
    //foreach($html as $block){
        foreach ($block as $tagSelectInRow) {
            $nameTagSelectInRow = explode(" ", $tagSelectInRow)[0];
            $classSelectProperty = classProperty($tagSelectInRow);

            if (in_array($nameTagSelectInRow, $settingsTags->selbi->allProperty)) {
                if ($nameTagSelectInRow == "select") {
                    $textTagSelectInRow = createTagForSelect($classSelectProperty, $nameTagSelectInRow,
                        $settingsTags->selbi);

                    echo $textTagSelectInRow;
                }
                if (($nameTagSelectInRow == "option") && (!isset($isComplete))) {
                    $isComplete = 1;
                    $textTagSelectInRow = createTagForSelect($classSelectProperty, $nameTagSelectInRow,
                        $settingsTags->selbi);

                    echo $textTagSelectInRow;
                }

            } else {

                if (!ignoreTag($nameTagSelectInRow)) {
                    echo "\n" . "<" . $tagSelectInRow . ">";
                }

            }
        }
    //}
}




$settingsTags = json_decode(file_get_contents ( "setting_row.json"));


$arrRowFiles = formTagsForRowFiles($htmlForRow, $settingRowTags->allProperty);

createSettingsForSelect($arrRowFiles[1], $settingsTags);