<?php

// Put your PHP functions and modules here
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
    echo "<script>";
    echo "var {$jsName} = " . json_encode($phpName, JSON_PRETTY_PRINT | JSON_HEX_TAG);
    echo "</script>\n";
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

function &mysqliConn() {
    $conn = mysqli_connect("localhost", "root", "root", "mydb", "3307");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
