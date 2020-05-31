<?php

$conn = mysqli_connect("localhost", "root", "root", "mydb", "3307");

$tables = mysqli_query($conn, "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'mydb'");

$category_table = mysqli_query($conn, "SELECT * FROM category;");
$item_table = mysqli_query($conn, "SELECT * FROM item;");
$admin_table = mysqli_query($conn, "SELECT * FROM admin;");
$topselling_table = mysqli_query($conn, "SELECT * FROM item ORDER BY units_sold DESC LIMIT 6;");

$_SESSION['cart'] = !empty($_SESSION['cart']) ? $_SESSION['cart'] :  array();

function getHtmlCard($cardName, $img_file)
{
    return <<<BOILERPLATE
<div class="card">
    <img src="./media/{$img_file}" alt="{$cardName}">
    <div class="card-overlay">
        <div class="card-caption">{$cardName}</div>
    </div>
</div>
BOILERPLATE;
}

function sanitizeInp($inp)
{
    return (string) htmlspecialchars(stripslashes(trim($inp)));
}

function numToStr($num)
{
    return number_format((float) $num, 2, '.', '');
}


function closeSqlConn($sqlConn)
{
    mysqli_close($sqlConn);
}
