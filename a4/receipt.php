<?php
include "tools.php";
session_start();

if (!isset($_SESSION)) header("Location: index.php#");

$session_data = [
    date("o-m-d"),
    $_SESSION['cust']['name'],
    $_SESSION['cust']['email'],
    $_SESSION['cust']['mobile'],
    $_SESSION['movie']['id'] . " " . $_SESSION['movie']['day'] . " " . $_SESSION['movie']['hour'],
    $_SESSION['seats']['STA'],
    $_SESSION['seats']['STP'],
    $_SESSION['seats']['STC'],
    $_SESSION['seats']['FCA'],
    $_SESSION['seats']['FCP'],
    $_SESSION['seats']['FCC'],
    $_SESSION['total']
];

$fp = fopen("bookings.txt", "a");
flock($fp, LOCK_EX);
fputcsv($fp, $session_data, "\t");
flock($fp, LOCK_UN);
fclose($fp);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
</head>

<body>

</body>

</html>