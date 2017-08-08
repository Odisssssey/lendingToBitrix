<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 07.08.2017
 * Time: 15:02
 */




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

function createSettingsForSelect($html, $settingsTags){

    foreach ($html as $tagSelectInRow){
        $nameTagSelectInRow = explode(" ", $tagSelectInRow)[0];
        $classSelectProperty = classProperty($tagSelectInRow);

        if(in_array($nameTagSelectInRow, $settingsTags->selbi->allProperty)){
            if($nameTagSelectInRow == "select") {
                $textTagSelectInRow = createTagForSelect($classSelectProperty, $nameTagSelectInRow, $settingsTags->selbi);

                echo $textTagSelectInRow;
            }
            if(($nameTagSelectInRow == "option") && (!isset($isComplete))){
                $isComplete = 1;
                $textTagSelectInRow = createTagForSelect($classSelectProperty, $nameTagSelectInRow, $settingsTags->selbi);

                echo $textTagSelectInRow;
            }

        }else{

            if(!ignoreTag($nameTagSelectInRow)){
                echo "\n".$tagSelectInRow;
            }

        }
    }
}


$html = [['div class="text-field js-text-field popup-cost-calc__text-field-inner"', 'div class="text-field__title popup-cost-calc__input-caption"',
    '/div', 'label class="text-field__label" for="popup-cost-calc-phone"',
    '/label', 'input class="text-field__input js-text-field__input popup-cost-calc__input" type="text" id="popup-cost-calc-phone"', '/div'],
    ['div class="selbi popup-cost-calc__dropdown popup-cost-calc__inputs-inner popup-cost-calc__inputs-inner--select"',
    'select class="popup-cost-calc__dropdown-select js-dropdown-battery-voltage"',
    'option class="popup-cost-calc__dropdown-option"', '/option', 'option class="popup-cost-calc__dropdown-option"', '/option',
    'option class="popup-cost-calc__dropdown-option"', '/option', 'option class="popup-cost-calc__dropdown-option"',
    '/option', 'option class="popup-cost-calc__dropdown-option"', '/option', '/select', '/div'
     ]];

$settingsTags = json_decode(file_get_contents ( "setting_row.json"));


//createSettingsForInput($html[0], $settingsTags);

createSettingsForSelect($html[1], $settingsTags);