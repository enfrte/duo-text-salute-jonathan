<?php error_reporting(E_ALL); ini_set('display_errors', '1'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<table><tbody>

<?php

$json_data = file_get_contents('updated-translations/dic_finished.json');
$array_data = json_decode($json_data);

$temp = '';

// Show all - this is a bit memory intensive
foreach ($array_data as $i => $v) {
	// use $i for id of english translation input
	//echo '<tr>.<td>'.($i + 1).'</td>' . '<td>'.$v[0].'</td>'  . '<td>'.$v[1].'</td></tr>';
}

$total_missing = 0;


// Show only missing
foreach ($array_data as $i => $v) {
	// use $i for id of english translation input
	if ( !empty($v[0]) && empty($v[1]) ) {
		echo '<tr>';
		
		echo '<td>'.$v[0].'</td>';
		echo "<td><input id='{$i}' data-source='{$v[0]}' type='hidden' name='translation' value=''></td>";
		
		echo "<td><button name='edit' type='button' value='{$i}'>Edit</button></td>";
		
		echo "<td><button disabled data-replace-one='{$i}' name='replace_one' type='button' value='{$i}'>Replace one</button></td>";
		echo "<td><button disabled data-replace-all='{$i}' name='replace_all' type='button' value='{$i}'>Replace all</button></td>";

		echo '</tr>';
		$total_missing++;
	}
}

?>

</tbody></table>

<?php echo 'Total missing: ' . $total_missing; ?>

<form 
	action="/duo-text-salute-jonathan/replace-word.php" 
	method="get" 
	id="replace_word">
	<input type="hidden" name="line">
	<input type="hidden" name="source">
	<input type="hidden" name="translation">
</form>

<script>

const edit_buttons = document.getElementsByName('edit');
//console.log(edit_buttons[0]);
let can_edit = true;
edit_buttons.forEach((value) => {
	value.addEventListener('click', (e) => {
		if (can_edit) {
			document.getElementById(e.target.value).type = 'text';
			const replace_all =	document.querySelector('[data-replace-all="'+e.target.value+'"]');
			replace_all.disabled = false;
			console.log(replace_all);
		}
		can_edit = false;
	});

});

const replace_all = document.getElementsByName('replace_all');
replace_all.forEach((value) => {
	value.addEventListener('click', (e) => {
		const translation = document.getElementById(e.target.value);
		form.elements['translation'].value = translation.value;
		form.elements['line'].value = translation.id;
		form.elements['source'].value = translation.dataset.source;
		form.submit();
		//console.log('value:',e.target.value);
		//console.log('data-:',e.target.dataset.replaceAll);		
	});

});

const form  = document.getElementById('replace_word');
form.addEventListener('submit', (event) => {
	//event.preventDefault();
});

</script>

</body>
</html>
