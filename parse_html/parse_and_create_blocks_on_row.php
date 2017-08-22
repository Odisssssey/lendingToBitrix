<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 22.08.2017
 * Time: 11:29
 *
 * new
 *
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

function tagWithout($html){
    $lines = [];
    preg_match_all ( '/[^\n]+/i' , $html , $line);


    foreach ($line[0] as $sequence){
        if(isset($sequence)){
            array_push($lines, trim($sequence));
        }
    }
    return $lines;

}

function createArrayOnlyTag($line){
    $tags = [];
    foreach ($line as $row){
        preg_match_all ( '/<([^>]+)>/i' ,$row ,$sequence);
        if(isset($sequence[1][0])){
            array_push($tags, trim($sequence[1][0]));
        }else{
            array_push($tags, " ");
        }
    }
    return $tags;
}


function startAction($html, $needMegaBlock){
    $htmlBlocks = [[[],[]],[[],[]],[[],[]]];
    $position = 0;

    $line = tagWithout($html);

    ///need work with $line[0] it is origin tag!!!

    $tags = createArrayOnlyTag($line);


    foreach($tags as $key=>$tag){
        array_push($htmlBlocks[$position][0], $tag);///tag
        array_push($htmlBlocks[$position][1], $line[$key]);///line
        $nameOfTag = nameOfTag($tag);
        if(isset($nameOfTag) && isset($needMegaBlock[$position])){
            if (nameOfTag($tag) == $needMegaBlock[$position]) {
                $position++;
            }
        }
    }

    return $htmlBlocks;
}

function isOpenOriginTag($nameTag){
    preg_match_all ( '/[^ ]/i' , $nameTag , $symbolOfWord);
    if($symbolOfWord[0][0] == "/"){
        return 0;
    }
    return 1;
}

function BitrixNewsBlock($nameOfTeg, $SoloTags, $tagInStack){

    if(count($tagInStack)>0){
        if(isOpenOriginTag($nameOfTeg)){

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
    $nextMiniBlock = [[],[]];


    foreach ($block[0] as $key=>$lain){
        if($lain == " "){
            continue;
        }

        $nameOfTeg = nameOfTag($lain);


        if(array_key_exists($nameOfTeg, $configBlocks)) {
            $nameOfClass = nameOfClass($lain);
            if($configBlocks->$nameOfTeg->biclass == $nameOfClass){
                array_push($tagInStack, $nameOfTeg);
//                echo count($tagInStack);
//                echo " ".$lain."\n";

                array_push($nextMiniBlock[0], $lain);
                array_push($nextMiniBlock[1], $block[1][$key]);
                continue;
            }

        }

        $tagInStack = BitrixNewsBlock($nameOfTeg,$SoloTags, $tagInStack);


        if(isset($isNewMiniBlock)){
            $isOldMiniBlock = $isNewMiniBlock;
//            echo count($tagInStack);
//            echo " ".$lain."\n";

            if ($isNewMiniBlock) {
                array_push($nextMiniBlock[0], $lain);
                array_push($nextMiniBlock[1], $block[1][$key]);
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
//
//$needMegaBlock = ["/header", "/main"];
//
//$configBlocks = json_decode(file_get_contents ( "config_blocks.json"));
//$configFile = json_decode(file_get_contents ( "../create_Need_files/config.json"));
//
//
//$allBigMegaBlock = startAction($html, $needMegaBlock);
//
//
//getMiniBlocks($allBigMegaBlock[0], $configBlocks, $configFile->isSoloTag);


