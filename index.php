<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once('dic.php'); // $db

$text = file_get_contents('text.txt');

$text_exp = preg_split('/( |\n)/', $text);

$translation_table = [];

foreach ($text_exp as $index => $word) {
    
    $word_trimmed = str_replace(['!', '?', ',', '.', '(', ')', ';', '“', '”', ':', '"'], "", $word);

    foreach ($db as $ie => $en) {
        if (strcasecmp($word_trimmed, $ie) == 0) {
            $translation_table[$index] = [ $word, $en ];
            break;
        }
        else {
            $translation_table[$index] = [ $word, '' ];
        }
    }
}

echo '<pre>';

//print_r($text_exp);
//print_r($translation_table);

$json = json_encode($translation_table);

echo $json;

file_put_contents('duo-text/finished.json', $json);
