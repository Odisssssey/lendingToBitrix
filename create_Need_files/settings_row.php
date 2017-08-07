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


$html = ['div class="text-field js-text-field popup-cost-calc__text-field-inner"', 'div class="text-field__title popup-cost-calc__input-caption"',
    '/div', 'label class="text-field__label" for="popup-cost-calc-phone"',
    '/label', 'input class="text-field__input js-text-field__input popup-cost-calc__input" type="text" id="popup-cost-calc-phone"', '/div'];

$settingsTags = json_decode(file_get_contents ( "setting_row.json"));

createSettingsForInput($html, $settingsTags);