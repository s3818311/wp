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

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    unset($_SESSION['category']['errMsg']);
    unset($_SESSION['category']['sucMsg']);
    unset($_SESSION['item']['errMsg']);
    unset($_SESSION['item']['sucMsg']);
    unset($_SESSION['user']['errMsg']);
    unset($_SESSION['user']['sucMsg']);
    if (isset($_POST['add']['category-submit'])) {
        $img = $_FILES['uploaded_img'];
        if ($img['error'] == 2)
            $_SESSION['category']['errMsg'] = "Max image size is 200KB";
        else if (!in_array(pathinfo($img['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
            $_SESSION['category']['errMsg'] = "Allowed file types are: JPG, JPEG, PNG and WEBP";
        else if (!@move_uploaded_file($img['tmp_name'], getcwd() . "/media/{$img['name']}"))
            $_SESSION['category']['errMsg'] = "Can't upload selected image";
        else if ($img['error'] != 0)
            $_SESSION['category']['errMsg'] = "An error occurred while uploading image";
        else {
            $id = mysqli_escape_string($conn, sanitizeInp($_POST['add']['category']['id']));
            $name = mysqli_escape_string($conn, sanitizeInp($_POST['add']['category']['name']));
            $img_name = mysqli_escape_string($conn, sanitizeInp($img['name']));

            $query = "INSERT INTO category VALUES ('{$id}', '{$name}', '{$img_name}')";
            if (mysqli_query($conn, $query)) $_SESSION['category']['sucMsg'] = "Row added successfully";
            else $_SESSION['category']['errMsg'] = "Error: " . mysqli_error($conn);
        }

        unset($_POST['add']['category-submit']);
    } else if (isset($_POST['add']['item-submit'])) {
        $img = $_FILES['uploaded_img'];
        if ($img['error'] == 2)
            $_SESSION['item']['errMsg'] = "Max image size is 200KB";
        else if (!in_array(pathinfo($img['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
            $_SESSION['item']['errMsg'] = "Allowed file types are: JPG, JPEG, PNG and WEBP";
        else if (!@move_uploaded_file($img['tmp_name'], getcwd() . "/media/{$img['name']}"))
            $_SESSION['item']['errMsg'] = "Can't upload selected image";
        else if ($img['error'] != 0)
            $_SESSION['item']['errMsg'] = "An error occurred while uploading image";
        else {
            $id = mysqli_escape_string($conn, sanitizeInp($_POST['add']['item']['id']));
            $display_name = mysqli_escape_string($conn, sanitizeInp($_POST['add']['item']['display_name']));
            $category_id = mysqli_escape_string($conn, sanitizeInp($_POST['add']['item']['category_id']));
            $units_sold = mysqli_escape_string($conn, sanitizeInp($_POST['add']['item']['units_sold']));
            $price = mysqli_escape_string($conn, sanitizeInp($_POST['add']['item']['price']));
            $img_name = mysqli_escape_string($conn, sanitizeInp($img['name']));

            $query = "INSERT INTO item VALUES ('{$id}', '{$display_name}', '{$category_id}', '{$img_name}', '{$units_sold}', '{$price}')";
            if (mysqli_query($conn, $query)) $_SESSION['item']['sucMsg'] = "Row added successfully";
            else $_SESSION['item']['errMsg'] = "Error: " . mysqli_error($conn);
        }

        unset($_POST['add']['item-submit']);
    } else if (isset($_POST['add']['user-submit'])) {
        $id = mysqli_escape_string($conn, sanitizeInp($_POST['add']['user']['id']));
        $username = mysqli_escape_string($conn, sanitizeInp($_POST['add']['user']['username']));
        $password = mysqli_escape_string($conn, sanitizeInp($_POST['add']['user']['password']));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO admin VALUES ('{$id}', '{$username}', '{$password}')";
        if (mysqli_query($conn, $query)) $_SESSION['user']['sucMsg'] = "Row added successfully";
        else $_SESSION['user']['errMsg'] = "Error: " . mysqli_error($conn);

        unset($_POST['add']['item-submit']);
    }
}

header("Location: admin.php#");
