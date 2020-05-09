<?php
$array1 = ['A', 'B', 'C'];
$array2 = array('A', 'B', 'C');
$array3[0] = 'A';
$array3[1] = 'B';
$array3[2] = 'C';

var_dump($array1);

$assoc1 = ['A' => 'Apple', 'B' => 'Bear', 'C' => 'Chair'];
$assoc2 = array('A' => 'Apple', 'B' => 'Bear', 'C' => 'Chair');
$assoc3['A'] = 'Apple';
$assoc3['B'] = 'Bear';
$assoc3['C'] = 'Chair';

$output = print_r($assoc1, true);
echo "<br>";
echo "<pre> {$output} </pre>";
