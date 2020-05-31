<?php
session_start();
include_once "tools.php";
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
                    <a class="nav-link active" href="index.php#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="browse.php#">Browse</a>
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

    <section>
        <div id="showcaseCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="carousel-image" id="carousel-img1"></div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-image" id="carousel-img2"></div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-image" id="carousel-img3"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="category-section" class="container-fluid">
        <div class="section-header"><span>CATEGORIES</span></div>
        <div id="categories" class="row">
            <?php
            while ($row = mysqli_fetch_assoc($category_table)) {
                echo "<a href=\"browse.php?category={$row["name"]}\" class=\"col-md-4\">";
                echo getHtmlCard($row["name"], $row["img_name"]);
                echo "</a>";
            }
            ?>
        </div>
    </section>

    <section id="topselling-section" class="container-fluid">
        <div class="section-header"><span>TOP SELLING PRODUCTS</span></div>
        <div id="topselling" class="row">
            <?php
            while ($row = mysqli_fetch_assoc($topselling_table)) {
                echo "<a href=\"item.php?category_id={$row["category_id"]}&item={$row["id"]}\" class=\"col-md-4\">";
                echo getHtmlCard($row["display_name"], $row["img_name"]);
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