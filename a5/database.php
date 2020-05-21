<?php

$category_table = getCategoryTable();
$item_table = getItemTable();
$admin_table = getAdminTable();
$topselling_table = mysqli_query($conn, "SELECT * FROM item ORDER BY units_sold DESC;");

function getCategoryTable()
{
    global $conn;
    return mysqli_query($conn, "SELECT * FROM category;");
}

function getItemTable()
{
    global $conn;
    return mysqli_query($conn, "SELECT * FROM item;");
}

function getAdminTable()
{
    global $conn;
    return mysqli_query($conn, "SELECT * FROM admin;");
}
