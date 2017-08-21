<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 18.08.2017
 * Time: 19:29
 */

function nameOfTag($tag){
    $nameOfTag = explode(" ",$tag)[0];
    return $nameOfTag;
}

function getClass($line){
    preg_match_all('/class[="]+([^"]+)["]+/i', $line, $classOfLine);
    return $classOfLine[1][0];
}

function nameOfClass($line){
    return  nameOfTag(getClass($line));
}


function startAction($html, $needMegaBlock){
    $htmlBlocks = [[],[],[]];
    $position = 0;
    preg_match_all ( '/<([^>]+)>/i' , $html , $tags);
    foreach($tags[1] as $tag){
        array_push($htmlBlocks[$position], $tag);
        $nameOfTag = nameOfTag($tag);
        if(isset($nameOfTag) && isset($needMegaBlock[$position])){
            if (nameOfTag($tag) == $needMegaBlock[$position]) {
                $position++;
            }
        }
    }
    return $htmlBlocks;
}

function isOpenTag($nameTag){
    preg_match_all ( '/[^ ]/i' , $nameTag , $symbolOfWord);
    if($symbolOfWord[0][0] == "/"){
        return 0;
    }
    return 1;
}

function BitrixNewsBlock($nameOfTeg, $SoloTags, $tagInStack){

    if(count($tagInStack)>0){
        if(isOpenTag($nameOfTeg)){

            if(!in_array($nameOfTeg, $SoloTags)){
                array_push($tagInStack, $nameOfTeg);
            }

        }else{

            array_pop ($tagInStack);
        }

    }

    return $tagInStack;
}

function isMiniBlock($tagInStack){
    if(count($tagInStack) > 0){
        return 1;
    }
    return 0;
}


function getMiniBlocks($block, $configBlocks,  $SoloTags){
    $allMiniBlocks = [];
    $tagInStack = [];
    $nextMiniBlock = [];

    foreach ($block as $lain){
        $nameOfTeg = nameOfTag($lain);


        if(array_key_exists($nameOfTeg, $configBlocks)) {
            $nameOfClass = nameOfClass($lain);
            if($configBlocks->$nameOfTeg->biclass == $nameOfClass){
                array_push($tagInStack, $nameOfTeg);
//                echo count($tagInStack);
//                echo " ".$lain."\n";

                array_push($nextMiniBlock, $lain);
                continue;
            }

        }

        $tagInStack = BitrixNewsBlock($nameOfTeg,$SoloTags, $tagInStack);


        if(isset($isNewMiniBlock)){
            $isOldMiniBlock = $isNewMiniBlock;
//            echo count($tagInStack);
//            echo " ".$lain."\n";

            if ($isNewMiniBlock) {
                array_push($nextMiniBlock, $lain);

            }
        }


        $isNewMiniBlock = isMiniBlock($tagInStack);
        if(isset($isOldMiniBlock)){
            if($isOldMiniBlock == 1 && $isNewMiniBlock == 0){
                array_push($allMiniBlocks, $nextMiniBlock);
                $nextMiniBlock = [];
            }
        }

    }
    return $allMiniBlocks;


}


//$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/fool/index.html");
//$needMegaBlock = ["/header", "/main"];
//
//$allBigMegaBlock = startAction($html, $needMegaBlock);


//$configBlocks = json_decode(file_get_contents ( "config_blocks.json"));
//$configFile = json_decode(file_get_contents ( "../create_Need_files/config.json"));
//foreach ($allBigMegaBlock as $block){
//    var_dump(getMiniBlocks($block, $configBlocks, $configFile->isSoloTag));
//}




