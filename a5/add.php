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

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['add']['category-submit'])) {
        $img = $_FILES['category_img'];
        if ($img['size'] > 200000)
            $_SESSION['errMsg'] = "Max image size is 200KB";
        else if (!in_array(pathinfo($img['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
            $_SESSION['errMsg'] = "Allowed file types are: JPG, JPEG, PNG and WEBP";
        else if (!@move_uploaded_file($img['tmp_name'], getcwd() . "/media/{$img['name']}"))
            $_SESSION['errMsg'] = "An error occurred while uploading image";
        else {
            $id = mysqli_escape_string($conn, sanitizeInp($_POST['add']['category']['id']));
            $name = mysqli_escape_string($conn, sanitizeInp($_POST['add']['category']['name']));
            $img_name = mysqli_escape_string($conn, sanitizeInp($img['name']));

            $query = "INSERT INTO category VALUES ('{$id}', '{$name}', '{$img_name}')";
            if (mysqli_query($conn, $query)) $_SESSION['errMsg'] = "Row added successfully";
            else $_SESSION['errMsg'] = "Error: " . mysqli_error($conn);
        }
    } else if (isset($_SESSION['add']['item-submit'])) {
    }
}

header("Location: admin.php#");
