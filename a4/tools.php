<?php

// Put your PHP functions and modules here

$dayAbbr = [
    'SUN' => "Sunday",
    'MON' => "Monday",
    'TUE' => "Tuesday",
    'WED' => "Wednesday",
    'THU' => "Thursday",
    'FRI' => "Friday",
    'SAT' => "Saturday",
];

$hourAbbr = [
    'T12' => '12:00',
    'T15' => '15:00',
    'T18' => '18:00',
    'T21' => '21:00',
];

function preShow($arr, $returnAsString = false) {
    $ret = '<pre>' . print_r($arr, true) . '</pre>';
    if ($returnAsString) {
        return $ret;
    } else {
        echo $ret;
    }
}

function printMyCode() {
    $lines = file($_SERVER['SCRIPT_FILENAME']);
    echo "<pre class='mycode'><ol>";
    foreach ($lines as $line) {
        echo '<li>' . rtrim(htmlentities($line)) . '</li>';
    }

    echo '</ol></pre>';
}

function php2js($phpName, $jsName) {
    echo "<script>var {$jsName} = " . json_encode($phpName, JSON_PRETTY_PRINT | JSON_HEX_TAG) . "</script>\n";
}

function anyInArr($arr) {
    foreach ($arr as $val) {
        if ($val) {
            return true;
        }
    }
    return false;
}

function sanitizeInp($inp) {
    return (string) htmlspecialchars(stripslashes(trim($inp)));
}
