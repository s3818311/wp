<!DOCTYPE HTML>  
<html>
<head>
<style>
</style>
</head>
<body>  
<?php
    session_start();
    include 'tools.php';
    //preShow($_SESSION); Takes the comment out if you want to test the input
    if(empty($_SESSION["email"])){
        header("Location: index.php");    
    }
    $myfile = fopen("bookings.txt","a");
    $now = date('d/m h:i');
    $cells = array_merge(
        [$now],
        (array) $_SESSION["email"]
    );
    fputcsv($myfile, $cells);
    fclose($myfile);
?>


</body>
</html>