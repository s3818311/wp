<?php
include_once "tools.php";
session_start();

if (isset($_POST['session-reset'])) {
    $reset_flag = session_destroy();
    if ($reset_flag) {
        unset($_POST['session-reset']);
        header("Location: index.php#");
    } else exit("Session failed to reset");
}

if (!isset($_SESSION['login']['username']) || !isset($_SESSION['login']['password'])) header("Location: index.php#");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    unset($_SESSION['category']['errMsg']);
    unset($_SESSION['category']['sucMsg']);
    unset($_SESSION['item']['errMsg']);
    unset($_SESSION['item']['sucMsg']);
    unset($_SESSION['user']['errMsg']);
    unset($_SESSION['user']['sucMsg']);
    $query = "DELETE FROM {$_GET['table']} WHERE id = '{$_GET['id']}';";
    if (
        mysqli_query($conn, $query) &&
        unlink(getcwd() . "/media/{$_GET['img']}")
    ) $_SESSION['errMsg'] = 'Row deleted successfully';
    else $_SESSION['errMsg'] = 'Error: ' . mysqli_error($conn);
}

header("Location: admin.php#");
