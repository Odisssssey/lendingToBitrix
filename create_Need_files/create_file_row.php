<?php
/**
 * Created by PhpStorm.
 * User: anton.tarutin
 * Date: 04.08.2017
 * Time: 10:18
 */
require_once('block_for_row.php');

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
            var_dump($treeTags);
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

function ctartContentFile($tags, $renameTags){
    $keyAnotherBlock = 0;

    while($keyAnotherBlock < count($tags)-1) {
        $oneBlock = oneBlock($tags, $renameTags, $keyAnotherBlock);  // give last new block

        //Block processing//
        $keyAnotherBlock = keyAnoutherBlock($tags, $oneBlock, $keyAnotherBlock); // give new key

        echo "\n".$tags[$keyAnotherBlock].$keyAnotherBlock;
    }



}

function startCreateFileRow($rowTags, $renameTags){
    $f = fopen("form-row.php", 'w+');

    ctartContentFile($rowTags, $renameTags);

    fclose($f);
}

$templateTags = startCreateFile($html);  //in block_for_row file

$renameTags = json_decode(file_get_contents ( "text_in_tag.json"));

//var_dump($templateTags[1]);
startCreateFileRow($templateTags[1], $renameTags);