<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 30.07.2017
 * Time: 20:14
 */

function createFile($name){
    $file = $name.".php";
    $f = fopen($file, 'w+');
    return $f;
}

function closeFile($f){
    return fclose($f);
}

function valBlock($tag, $valBlock, $needblock){
    $allPropTag = explode(" ",$tag);
    $TegName = $allPropTag[0];
    foreach ($needblock as $needName){
        if($TegName == $needName){
            $valBlock = 1;
        }

        if($TegName == "/".$needName){
            if ($valBlock == 1){
                $valBlock = 2;
            }else{
                $valBlock = 0;
            }
        }
    }

    return $valBlock;
}

function isNewMegaBlock($tag, $needMegaBlock , $isNewMegaBlock){
    $allPropTag = explode(" ",$tag);
    $TegName = $allPropTag[0];


    foreach ($needMegaBlock[0] as $needName){
        if($TegName == "/".$needName){
            $isNewMegaBlock = 1;
        }
    }

    return $isNewMegaBlock;
}

function parsePropertyTag($key, $tag){
    $allPropTag = explode(" ",$tag);
    $TegName = $allPropTag[0];
    preg_match_all('/[ ]+([^= ]+)[="]+([\w- ]+)["]+/i', $tag, $property);

}

function NewBlok(){
    echo "\n";
}

function getBlok($tag, $valBlock){
    if(($valBlock == 1) || ($valBlock == 2)){
        print_r($tag);
    }
    if($valBlock == 2){
        NewBlok();
        $valBlock = 0;
    }
    return $valBlock;
}


function parseHtml($html, $needblock, $needMegaBlock){
    preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги

    $valBlock = 0;
    $isNewMegaBlock = 0;
    $keyFile = 0;

    $f = createFile($needMegaBlock[1][$keyFile]);

    foreach ($tags[1] as $key=>$tag){

        fwrite($f, $tags[0][$key]);

        $isNewMegaBlock = isNewMegaBlock($tag, $needMegaBlock , $isNewMegaBlock);

        if($isNewMegaBlock == 1) {
            $keyFile++;

            if (isset($needMegaBlock[0][$keyFile])) {
                closeFile($f);
                $f = createFile($needMegaBlock[1][$keyFile]);
            }

            $isNewMegaBlock = 0;
        }

        $valBlock = valBlock($tag, $valBlock, $needblock);

        $valBlock = getBlok($tag, $valBlock);

        if (count(explode(" ",$tag)) > 1){
            parsePropertyTag($key, $tag);
        }
    }

    closeFile($f);
}


$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");

$needblock = ["form", "nav"];
$needMegaBlock = [["header", "main", "footer"], ["header.php", "index.php", "footer.php"]];

parseHtml($html, $needblock, $needMegaBlock);


//preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги без значений

//preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable); // значения тегов

//preg_match_all ( '/([^=]+)[="]+([\w-]+)["]+/i' , $str[1] , $property); //

