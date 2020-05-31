<?php
include_once "tools.php";
session_start();
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
                <li class="nav-item">
                    <a class="nav-link active" href="product.php#">Browse</a>
                </li>
            </ul>
            <form action="checkout.php#">
                <button class="btn btn-outline-success mr-1 my-2 my-sm-0" type="submit" id="checkOutBtn">🛒</button>
            </form>
            <form action="login.php#">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log In</button>
            </form>
        </div>
    </nav>

    <section class="container-fluid">
        <div id="filter-btn-container" class="row">
            <button class="filter-btn col" id="all">Show all</button>
            <?php
            while ($row = mysqli_fetch_assoc($category_table))
                echo "<button class=\"filter-btn col\" id=\"{$row['name']}\">{$row['name']}</button>";
            ?>
        </div>

        <div id="filter-div-container" class="row">
            <?php
            while ($row = mysqli_fetch_assoc($item_table)) {
                $category = mysqli_query($conn, "SELECT name FROM category WHERE id='{$row['category_id']}'");
                $category_name = mysqli_fetch_assoc($category)['name'];
                echo "<a href=\"item.php?category_id={$row["category_id"]}&item={$row["id"]}\" class=\"col-md-4 card {$category_name} no-hover\">";
                echo "    <img src=\"./media/{$row['img_name']}\" alt=\"{$category_name}\">";
                echo "    <div class=\"card-overlay\">";
                echo "        <div class=\"card-caption\">{$row['display_name']}</div>";
                echo "    </div>";
                echo "</a>";
            }
            ?>
        </div>
    </section>
</body>

</html>

<?php
closeSqlConn($conn);
?>