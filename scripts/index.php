<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once('dic.php'); // $db

$text = file_get_contents('text.txt');

$text_exp = preg_split('/( |\n)/', $text);

$translation_table = [];

$punctuation = ['·', '»', '«', '!', '?', ',', '.', '(', ')', ';', '“', '”', ':', '"'];

foreach ($text_exp as $index => $word) {
    
    $word_trimmed = str_replace($punctuation, "", $word);

    $translation_table[$index] = [ $word, '' ]; // default if no translation found

    foreach ($db as $ie => $en) {
        if (strcasecmp($word_trimmed, $ie) == 0) {
            $translation_table[$index] = [ $word, $en ];
            break;
        }
        elseif ( in_array($word, $punctuation) || $word === '-' ) { // If check is punctuation, copy it as is. Hyphen is a special case.
            $translation_table[$index] = [ $word, $word ];
            break;
        }
    }
}

echo '<pre>';

//print_r($text_exp);
//print_r($translation_table);

$json = json_encode($translation_table);

//echo $json;

file_put_contents('duo-text/finished.json', $json);

echo 'done';