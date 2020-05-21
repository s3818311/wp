<?php
include "tools.php";

if (isset($_POST['session-reset'])) {
    $reset_flag = session_destroy();
    if ($reset_flag) {
        unset($_POST['session-reset']);
        header("Location: index.php#");
    } else exit("Session failed to reset");
}

if (!isset($_SESSION['login']['username']) || !isset($_SESSION['login']['password'])) header("Location: index.php#");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $query = "DELETE FROM {$_GET['table']} WHERE id = '{$_GET['id']}';";
    mysqli_query($conn, $query);
}

header("Location: admin.php#");
