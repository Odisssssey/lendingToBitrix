<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 08.08.2017
 * Time: 16:49
 */

require_once('division_file_on_row_and_template.php');



function formTagsForRowFiles($htmlForRow, $settingRowTags){           //this part for others blocks with equal class
    $originalBlocks = [];
    $usedBiBlocks = [];

    foreach ($htmlForRow as $blockInRow){
        $bitrixClass = findBitrixTag($blockInRow[0], $settingRowTags);
        if(isset($bitrixClass)){
            if (!in_array(findBitrixTag($blockInRow[0], $settingRowTags), $usedBiBlocks)) {
                array_push($usedBiBlocks, findBitrixTag($blockInRow[0], $settingRowTags));
                array_push($originalBlocks, $blockInRow);
            }
        }

    }
    return $originalBlocks;

}



$htmlForRow = divideFile($html, $settingRowTags->allProperty, $settingFile->isSoloTag)[1];


formTagsForRowFiles($htmlForRow, $settingRowTags->allProperty);
















