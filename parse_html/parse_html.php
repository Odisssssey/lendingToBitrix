<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 30.07.2017
 * Time: 20:14
 */

$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");


$dom = new DOMDocument;

$dom->loadHTML($html);


preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги



preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable); // значения тегов

$str = explode(" ", $tags[1][7]);
var_dump($str);
preg_match_all ( '/([^=]+)[="]+([\w-]+)["]+/i' , $str[1] , $property); //


print_r($tags[1][7]);
//print_r($variable);
print_r($property);
