<?php
// Format text to json and split into chapter files
error_reporting(E_ALL);
ini_set('display_errors', '1');

$text_source = '../source-text/';
$json_source = '../source-json/';

// Traverse chapters
for ($i=0; $i < 10; $i++) 
{
	$php_array = [];

	$text = file_get_contents($text_source . "0$i.txt");
	$text_exp = preg_split('/( |\n)/', $text); // split by space or newline

	foreach ($text_exp as $index => $word) 
	{	
		$php_array[$index] = [ $word, '' ]; 
	}

	$json = json_encode($php_array);
	file_put_contents($json_source . "0$i.json", $json);
}

echo 'done';