<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 30.07.2017
 * Time: 20:14
 */

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

function parseHtml($html, $needblock){
    preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги

    $valBlock = 0;

    foreach ($tags[1] as $key=>$tag){
        $valBlock = valBlock($tag, $valBlock, $needblock);

        $valBlock = getBlok($tag, $valBlock);

        if (count(explode(" ",$tag)) > 1){
            parsePropertyTag($key, $tag);
        }
    }
}


$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");

$needblock = ["form", "nav"];

parseHtml($html, $needblock);


//preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги без значений

//preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable); // значения тегов

//preg_match_all ( '/([^=]+)[="]+([\w-]+)["]+/i' , $str[1] , $property); //

