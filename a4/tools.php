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

$movieAbbr = [
    "movieACT" => "Avengers: Endgame",
    "movieRMC" => "Top End Wedding",
    "movieANM" => "Dumbo",
    "movieAHF" => "The Happy Prince",
];

$seatAbbr = [
    'FCA' => "First Class Adult",
    'FCP' => "First Class Concession",
    'FCC' => "First Class Children",
    'STA' => "Standard Adult",
    'STP' => "Standard Concession",
    'STC' => "Standard Children",
];

$priceArr = [
    'FCA' => [24, 30],
    'FCP' => [22.5, 27],
    'FCC' => [21, 24],
    'STA' => [14, 19.8],
    'STP' => [12.5, 17.5],
    'STC' => [11, 15.3],
];

function preShow($arr, $returnAsString = false)
{
    $ret = '<pre>' . print_r($arr, true) . '</pre>';
    if ($returnAsString) {
        return $ret;
    } else {
        echo $ret;
    }
}

function printMyCode()
{
    $lines = file($_SERVER['SCRIPT_FILENAME']);
    echo "<pre class='mycode'><ol>";
    foreach ($lines as $line) {
        echo '<li>' . rtrim(htmlentities($line)) . '</li>';
    }

    echo '</ol></pre>';
}

function php2js($phpName, $jsName)
{
    echo "<script>var {$jsName} = " . json_encode($phpName, JSON_PRETTY_PRINT | JSON_HEX_TAG) . "</script>\n";
}

function anyInArr($arr)
{
    foreach ($arr as $val) {
        if ($val) {
            return true;
        }
    }
    return false;
}

function sanitizeInp($inp)
{
    return (string) htmlspecialchars(stripslashes(trim($inp)));
}

function numToStr($num)
{
    return number_format((float) $num, 2, '.', '');
}

function checkInpErr($rawInp, $fieldName, $validated)
{
    if (empty($rawInp)) return [1, "Please enter your {$fieldName}"];
    else if ($validated) return [0, sanitizeInp($rawInp)];
    else {
        $rawInp = sanitizeInp($rawInp);
        return [2, $rawInp];
    }
}
