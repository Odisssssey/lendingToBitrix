<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 01.08.2017
 * Time: 11:00
 */

function searchForRepetitions($tags){
    $classScope = [];
    $tagInScope = [[], []];

    foreach ($tags[1] as $key=>$tag){
        $allPropTag = explode(" ",$tag);
        $tagName = $allPropTag[0];
        array_shift ($allPropTag);
        $allPropTag = implode(" ", $allPropTag);

        preg_match_all ( '/([^=]+)[="]+([\w- ]+)["]+/i' , $allPropTag , $property);
        foreach ($property[1] as $keyProp=>$prop){
            if (str_replace(" ", "", $prop) == "class"){

                if (!(in_array($property[2][$keyProp], $classScope))) {
                    array_push($classScope, $property[2][$keyProp]);

                }else{
                    array_push($tagInScope[0], $property[2][$keyProp]);
                    array_push($tagInScope[1], $tagName);
                }
            }
        }

    }
    return $tagInScope;
}

function printTemplate($tags ,$tagInScope){
    $tagInStack = [];
    foreach ($tags[1] as $key=>$tag){
        $inScope = 0;
        $allPropTag = explode(" ",$tag);
        array_shift ($allPropTag);
        $allPropTag = implode(" ", $allPropTag);
        preg_match_all ( '/([^=]+)[="]+([\w- ]+)["]+/i' , $allPropTag , $property);

        foreach ($property[1] as $keyProp=>$prop){
            if (str_replace(" ", "", $prop) == "class"){
                if((in_array($property[2][$keyProp], $tagInScope[0]))){

                    $inScope = 1;
                    $findKey = array_search($property[2][$keyProp], $tagInScope[0]);
                    if($tagInScope[1][$findKey] !== "input"){
                        array_push($tagInStack, $tagInScope[1][$findKey]);
                        //echo "+++".$tagInScope[1][$findKey]."\n";
                    }

                }

            }
        }

        if($inScope != 1){
            if(isset($tagInStack[count($tagInStack)-1])){
                $noTag = "/".$tagInStack[count($tagInStack)-1];

            }else{
                $noTag = "";
            }
            if ($tag == $noTag) {
                array_pop($tagInStack);
            }else {
                echo $tags[0][$key] . "\n";
            }
        }

    }
}

function startCreateFile($html){
    preg_match_all ( '/<([^>]+)>/i' , $html , $tags);

    $tagInScope = searchForRepetitions($tags);

    printTemplate($tags ,$tagInScope);


    print_r($tagInScope);
}

$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");

startCreateFile($html);