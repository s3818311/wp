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

$catErrMsg = isset($_SESSION['category']['errMsg']) ? ("An error occurred: " . $_SESSION['category']['errMsg']) : "";
$catSucMsg = isset($_SESSION['category']['sucMsg']) ?  $_SESSION['category']['sucMsg'] : "";

$iteErrMsg = isset($_SESSION['item']['errMsg']) ? ("An error occurred: " . $_SESSION['item']['errMsg']) : "";
$iteSucMsg = isset($_SESSION['item']['sucMsg']) ?  $_SESSION['item']['sucMsg'] : "";

$useErrMsg = isset($_SESSION['user']['errMsg']) ? ("An error occurred: " . $_SESSION['user']['errMsg']) : "";
$useSucMsg = isset($_SESSION['user']['sucMsg']) ?  $_SESSION['user']['sucMsg'] : "";

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
    <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="#">Minimal Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="browse.php#">Browse</a>
                </li>
            </ul>
            <form action="checkout.php#">
                <button class="btn btn-outline-success mr-1 my-2 my-sm-0" type="submit" id="checkOutBtn">🛒</button>
            </form>
            <form action="index.php#" method="POST">
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="admin-logout">Log Out</button>
            </form>
        </div>
    </nav>


    <section id="admin-tables" class="container-fluid">
        <div class="tab">
            <button class="tablinks active">Categories</button>
            <button class="tablinks">Items</button>
            <button class="tablinks">Users</button>
        </div>

        <div id="Categories" class="tabcontent">
            <?php echo "<p class=\"err\">" . $catErrMsg . "</p>" ?>
            <?php echo "<p class=\"suc\">" . $catSucMsg . "</p>" ?>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">name</th>
                        <th scope="col">image</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($category_table) > 0) {
                        while ($row = mysqli_fetch_assoc($category_table)) {
                            echo "<tr class=\"adminTableRow\">";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td><img src='./media/{$row['img_name']}'></td>";
                            echo "<td><button type=\"button\">Edit</button></td>";
                            echo "<td><a href=\"delete.php?table=category&id={$row['id']}&img={$row['img_name']}\">Delete</a></td>";
                            echo "</tr>";
                        }
                    } else echo "<tr><td colspan=5>No results found</td></tr>";
                    ?>
                </tbody>
            </table>
            <form action="add.php#" method="POST" enctype="multipart/form-data">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th scope="row">id</td>
                        <td><input type="text" name="add[category][id]" required></td>
                    </tr>
                    <tr>
                        <th scope="row">name</th>
                        <td><input type="text" name="add[category][name]" required></td>
                    </tr>
                    <tr>
                        <th scope="row">image</th>
                        <td>
                            <input type="hidden" name="MAX_FILE_SIZE" value="200000">
                            <input type="file" name="uploaded_img" id="category-img-inp" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit" name="add[category-submit]">Add</button></td>
                    </tr>
                </table>
            </form>
        </div>

        <div id="Items" class="tabcontent">
            <?php echo "<p class=\"err\">" . $iteErrMsg . "</p>" ?>
            <?php echo "<p class=\"suc\">" . $iteSucMsg . "</p>" ?>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">display_name</th>
                        <th scope="col">category_id</th>
                        <th scope="col">image</th>
                        <th scope="col">units_sold</th>
                        <th scope="col">price</th>
                        <th scope="col">description</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($item_table) > 0) {
                        while ($row = mysqli_fetch_assoc($item_table)) {
                            echo "<tr class=\"adminTableRow\">";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['display_name']}</td>";
                            echo "<td>{$row['category_id']}</td>";
                            echo "<td><img src='./media/{$row['img_name']}'></td>";
                            echo "<td>{$row['units_sold']}</td>";
                            echo "<td>{$row['price']}</td>";
                            echo "<td>{$row['description']}</td>";
                            echo "<td><button type=\"button\">Edit</button></td>";
                            echo "<td><a href=\"delete.php?table=item&id={$row['id']}&img={$row['img_name']}\">Delete</a></td>";
                            echo "</tr>";
                        }
                    } else echo "<tr><td colspan=8>No results found</td></tr>";
                    ?>
                </tbody>
            </table>
            <form action="add.php#" method="POST" enctype="multipart/form-data">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th scope="row">id</th>
                        <td><input type="text" name="add[item][id]" required></td>
                    </tr>
                    <tr>
                        <th scope="row">display_name</th>
                        <td><input type="text" name="add[item][display_name]" required></td>
                    </tr>
                    <tr>
                        <th scope="row">category_id</th>
                        <td><input type="text" name="add[item][category_id]" required></td>
                    </tr>
                    <tr>
                        <th scope="row">image</th>
                        <td>
                            <input type="hidden" name="MAX_FILE_SIZE" value="200000" />
                            <input type="file" name="uploaded_img" id="item-img-inp" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">units_sold</th>
                        <td><input type="text" name="add[item][units_sold]" required></td>
                    </tr>
                    <tr>
                        <th scope="row">price</th>
                        <td><input type="text" name="add[item][price]" required></td>
                    </tr>
                    <tr>
                        <th scope="row">description<br>(each line starts with &amp;bull; and delimits with &lt;br&gt;)</th>
                        <td><textarea type="text" name="add[item][description]" required></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="add[item-submit]" value="Add"></td>
                    </tr>
                </table>
            </form>
        </div>

        <div id="Users" class="tabcontent">
            <?php echo "<p class=\"err\">" . $useErrMsg . "</p>" ?>
            <?php echo "<p class=\"suc\">" . $useSucMsg . "</p>" ?>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">username</th>
                        <th scope="col">password</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($admin_table) > 0) {
                        while ($row = mysqli_fetch_assoc($admin_table)) {
                            echo "<tr class=\"adminTableRow\">";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['username']}</td>";
                            echo "<td>{$row['password']}</td>";
                            echo "<td><button type=\"button\">Edit</button></td>";
                            echo "<td><a href=\"delete.php?table=admin&id={$row['id']}\">Delete</a></td>";
                            echo "</tr>";
                        }
                    } else echo "<tr><td colspan=5>No results found</td></tr>";
                    ?>
                </tbody>
            </table>
            <form action="add.php#" method="POST" enctype="multipart/form-data">
                <table class="table table-hover table-bordered">
                    <tr>
                        <th scope="row">id</th>
                        <td><input type="text" name="add[user][id]" required></td>
                    </tr>
                    <tr>
                        <th scope="row">display_name</th>
                        <td><input type="text" name="add[user][username]" required></td>
                    </tr>
                    <tr>
                        <th scope="row">category_id</th>
                        <td><input type="password" name="add[user][password]" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="add[user-submit]" value="Add"></td>
                    </tr>
                </table>
            </form>
        </div>

    </section>

    <footer>
        <div>
            <form method="POST">
                <input type="submit" value="Reset current session" name='session-reset'>
            </form>
        </div>
    </footer>
</body>

</html>

<?php
closeSqlConn($conn);
?>