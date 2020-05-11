<?php
// $filename = "../week_9/index.php";
// $linesOrBigString = "";

// $fp = fopen($filename, 'r');
// flock($fp, LOCK_SH);
// echo "<ol>";
// while ($line = fgets($fp)) {
//     $linesOrBigString .= $line;
//     echo "<li>$line</li>";
// }
// flock($fp, LOCK_UN);
// fclose($fp);

// echo "</ol>";

// $filename = 'processing.php';
// $fp = fopen($filename, 'w');
// flock($fp, LOCK_EX);
// fwrite($fp, $linesOrBigString);
// flock($fp, LOCK_UN);
// fclose($filename);

// --------------------------------------
$records = [];
$filename = 'text.csv';

$fp = fopen($filename, "r");
flock($fp, LOCK_SH);
$headings = fgetcsv($fp);
while ($aLineOfCells = fgetcsv($fp)) {
    $records[] = $aLineOfCells;
}
echo

flock($fp, LOCK_UN);
fclose($fp);

$fp = fopen("student.txt", "w");
flock($fp, LOCK_EX);
fputcsv($fp, $headings);
foreach ($records as $record) {
    fputcsv($fp, $record);
}
flock($fp, LOCK_UN);
fclose($fp);
