<?php
include "tools.php";
session_start();

if (isset($_POST['session-reset']) || isset($_POST['admin-logout'])) {
    $reset_flag = session_destroy();
    if ($reset_flag) {
        unset($_POST['session-reset']);
        header("Location: index.php#");
    } else exit("Session failed to reset");
}

$category = isset($_GET['category']) ? $_GET['category'] : "";
$item = isset($_GET['item']) ? $_GET['item'] : "";

if ((bool) $category && (bool) $item) header("Location: index.php#");

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
            <form action="login.php#">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log In</button>
            </form>
        </div>
    </nav>

    <?php
    if ($item) {
        $itemInfo = mysqli_query($conn, "SELECT * FROM item I, cpu C WHERE I.id = '{$_GET['item']}' AND C.id = I.id;");
        if (mysqli_num_rows($itemInfo) != 1) {
            echo "An error has occurred. Redirecting back to home page";
            sleep(3);
            header("Location: index.php#");
        }
        $row = mysqli_fetch_assoc($itemInfo);
        $overclockable = (bool) $row['overclockable'] ? "Yes" : "No";
        $base_clock = numToStr($row['base_clock']);
        $boost_clock = numToStr($row['max_boost_clock']);
        echo <<<BOILERPLATE
<section id="item-section" class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <img src="./media/{$row['img_name']}" alt="{$row['display_name']}">
        </div>
        <div class="col-md-6">
            <h2>{$row['display_name']}</h2>
            <ul>
                <li>Number of cores: {$row['cores']}</li>
                <li>Number of threads: {$row['threads']}</li>
                <li>Unlocked/Overclockable: {$overclockable}</li>
                <li>Base clock: {$base_clock}GHz</li>
                <li>Max Boost Clock: {$boost_clock}GHz</li>
                <li>Integrated Graphics: {$row['igpu']}</li>
                <li>TDP: {$row['tdp']}W</li>
                <li>Socket: {$row['socket']}</li>
            </ul>
            <form action="checkout.php#" method="POST" id="itemForm">
                <label for="amount">Amount</label>
                <input type="number" name="itemAmount" id="amount" max="10">
                <input type="submit" value="Add to cart">
            </form>
        </div>
    </div>
</section>
BOILERPLATE;
    }
    ?>
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