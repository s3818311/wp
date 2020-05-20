<?php
include "tools.php";
session_start();

if (isset($_POST['session-reset'])) {
    $reset_flag = session_destroy();
    if ($reset_flag) {
        unset($_POST['session-reset']);
        header("Location: index.php#");
    } else exit("Session failed to reset");
}

if (!isset($_SESSION['login']['username']) || !isset($_SESSION['login']['password'])) header("Location: index.php#");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimal Shop</title>

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
            </ul>
            <form action="index.php#" method="POST">
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="admin-logout">Log Out</button>
            </form>
        </div>
    </nav>


    <section id="admin-tables">
        <div class="tab">
            <button class="tablinks active">Categories</button>
            <button class="tablinks">Items</button>
            <button class="tablinks">Users</button>
        </div>

        <div id="Categories" class="tabcontent">
            <form action="admin.php#" method="POST">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">name</th>
                            <th scope="col">img_name</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($category_table)) {
                            echo "<tr class=\"categoryRow\">";
                            echo "<td><input name=\"category[name][{$row['name']}]\" type=\"text\" value=\"{$row['name']}\" readonly></td>";
                            echo "<td><input name=\"category[img_name][{$row['img_name']}]\" type=\"text\" value=\"{$row['img_name']}\" readonly></td>";
                            echo "<td><button type=\"button\">Edit</button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>

        <div id="Items" class="tabcontent">
            <h3>Paris</h3>
            <p>Paris is the capital of France.</p>
        </div>

        <div id="Users" class="tabcontent">
            <h3>Tokyo</h3>
            <p>Tokyo is the capital of Japan.</p>
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