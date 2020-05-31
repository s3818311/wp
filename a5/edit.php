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

if ($_SERVER['REQUEST_METHOD'] == "GET")
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM {$_GET['table']} WHERE id = '{$_GET['id']}';"));

else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['edit']['category'])) {
        $img = $_FILES["uploaded_img"];
        if ($img['error'] == 2)
            $errMsg = "Max image size is 200KB";
        else if ($img['error'] == 4) {
            $id = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['category']['id']));
            $name = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['category']['name']));
            $query = "UPDATE category SET id='{$id}', name='{$name}' WHERE id='{$id}' OR name='{$name}'";
            if (mysqli_query($conn, $query) || !mysqli_error($conn))
                $errMsg = "Row editted successfully";
            else
                $errMsg = "Error: " . mysqli_error($conn);
        } else if (!in_array(pathinfo($img['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
            $errMsg = "Allowed file types are: JPG, JPEG, PNG and WEBP";
        else if (!@move_uploaded_file($img['tmp_name'], getcwd() . "/media/{$img['name']}"))
            $errMsg = "Can't upload selected image";
        else if ($img['error'] != 0)
            $errMsg = "An error occurred while uploading image";
        else {
            $id = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['category']['id']));
            $name = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['category']['name']));
            $img_name = mysqli_escape_string($conn, sanitizeInp($img['name']));

            $query = "UPDATE category SET id='{$id}', name='{$name}', img_name='{$img_name}' WHERE id='{$id}' OR name='{$name}' OR img_name='{$img_name}'";
            if (mysqli_query($conn, $query) || !mysqli_error($conn))
                $errMsg = "Row editted successfully";
            else
                $errMsg = "Error: " . mysqli_error($conn);
        }
    } else if (isset($_POST['edit']['item'])) {
        $img = $_FILES["uploaded_img"];
        if ($img['error'] == 2)
            $errMsg = "Max image size is 200KB";
        else if ($img['error'] == 4) {
            $id = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['id']));
            $display_name = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['display_name']));
            $category_id = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['category_id']));
            $units_sold = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['units_sold']));
            $price = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['price']));

            $query = "UPDATE item SET id='{$id}', display_name='{$display_name}', category_id='{$category_id}', units_sold='{$units_sold}', price='{$price}' WHERE id='{$id}' OR display_name='{$display_name}' OR category_id='{$category_id}' OR units_sold='{$units_sold}' OR price='{$price}'";
            if (mysqli_query($conn, $query) || !mysqli_error($conn))
                $errMsg = "Row editted successfully";
            else
                $errMsg = "Error: " . mysqli_error($conn);
        } else if (!in_array(pathinfo($img['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
            $errMsg = "Allowed file types are: JPG, JPEG, PNG and WEBP";
        else if (!@move_uploaded_file($img['tmp_name'], getcwd() . "/media/{$img['name']}"))
            $errMsg = "Can't upload selected image";
        else if ($img['error'] != 0)
            $errMsg = "An error occurred while uploading image";
        else {
            $id = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['id']));
            $display_name = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['display_name']));
            $category_id = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['category_id']));
            $units_sold = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['units_sold']));
            $price = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['item']['price']));
            $img_name = mysqli_escape_string($conn, sanitizeInp($img['name']));

            $query = "UPDATE item SET id='{$id}', display_name='{$display_name}', category_id='{$category_id}', units_sold='{$units_sold}', price='{$price}', img_name='{$img_name}' WHERE id='{$id}' OR display_name='{$display_name}' OR category_id='{$category_id}' OR units_sold='{$units_sold}' OR price='{$price}' OR img_name='{$img_name}'";
            if (mysqli_query($conn, $query) || !mysqli_error($conn))
                $errMsg = "Row editted successfully";
            else
                $errMsg = "Error: " . mysqli_error($conn);
        }
    } else if (isset($_POST['edit']['user'])) {
        $id = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['user']['id']));
        $username = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['user']['username']));
        $password = mysqli_escape_string($conn, sanitizeInp($_POST['edit']['user']['password']));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE admin SET id='{$id}', username='{$username}', password='{$password}' WHERE id='{$id}' OR username='{$username}' OR password='{$password}'";
        if (mysqli_query($conn, $query) || !mysqli_error($conn))
            $errMsg = "Row editted successfully";
        else
            $errMsg = "Error: " . mysqli_error($conn);
    }
} else header("admin.php#");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Personal Computer</title>

    <!-- Linking Bootstrap -->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script defer src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script async defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script async defer src='script.js'></script>

    <!-- Keep wireframe.css for debugging, add your css to style.css -->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" id='stylecss' type="text/css" href="style.css">
    <link rel="stylesheet" id='wireframecss' type="text/css" href="../wireframe.css" disabled>

    <noscript>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" id='wireframecss' type="text/css" href="../wireframe.css" disabled>
        <link rel="stylesheet" id='stylecss' type="text/css" href="style.css">
    </noscript>

    <script async defer src='../wireframe.js'></script>

</head>

<body>
    <?php echo (isset($errMsg) ? $errMsg : "")  ?>
    <form action="edit.php#" method="post" enctype="multipart/form-data">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <?php
                    if ($_GET['table'] == 'category') {
                        echo "<th scope=\"col\">id</th>";
                        echo "<th scope=\"col\">name</th>";
                        echo "<th scope=\"col\">image</th>";
                    } else if ($_GET['table'] == 'item') {
                        echo "<th scope=\"col\">id</th>";
                        echo "<th scope=\"col\">display_name</th>";
                        echo "<th scope=\"col\">category_id</th>";
                        echo "<th scope=\"col\">image</th>";
                        echo "<th scope=\"col\">units_sold</th>";
                        echo "<th scope=\"col\">price</th>";
                        echo "<th scope=\"col\">description</th>";
                    } else if ($_GET['table'] == 'admin') {
                        echo "<th scope=\"col\">id</th>";
                        echo "<th scope=\"col\">username</th>";
                        echo "<th scope=\"col\">password</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if ($_GET['table'] == 'category') {
                        echo "<td><input type=\"text\" value=\"{$row['id']}\" name=\"edit[category][id]\"></td>";
                        echo "<td><input type=\"text\" value=\"{$row['name']}\" name=\"edit[category][name]\"></td>";
                        echo "<td><input type=\"file\" name=\"uploaded_img\"></td>";
                    } else if ($_GET['table'] == 'item') {
                        echo "<td><input type=\"text\" value=\"{$row['id']}\" name=\"edit[item][id]\"></td>";
                        echo "<td><input type=\"text\" value=\"{$row['display_name']}\" name=\"edit[item][display_name]\"></td>";
                        echo "<td><input type=\"text\" value=\"{$row['category_id']}\" name=\"edit[item][category_id]\"></td>";
                        echo "<td><input type=\"file\" name=\"uploaded_img\"></td>";
                        echo "<td><input type=\"text\" value=\"{$row['units_sold']}\" name=\"edit[item][units_sold]\"></td>";
                        echo "<td><input type=\"text\" value=\"{$row['price']}\" name=\"edit[item][price]\"></td>";
                        echo "<td><input type=\"text\" value=\"{$row['description']}\" name=\"edit[item][description]\"></td>";
                    } else if ($_GET['table'] == 'admin') {
                        echo "<td><input type=\"text\" value=\"{$row['id']}\" name=\"edit[user][id]\"></td>";
                        echo "<td><input type=\"text\" value=\"{$row['username']}\" name=\"edit[user][username]\"></td>";
                        echo "<td><input type=\"password\" name=\"edit[user][password]\"></td>";
                    }
                    ?>
                </tr>
                <tr>
                    <td colspan=<?php echo sizeof($row); ?>><input type="submit" value="Submit"></td>
                </tr>
            </tbody>
        </table>
    </form>
    <form action="admin.php#">
        <input type="submit" value="Back to admin page">
    </form>
</body>

</html>