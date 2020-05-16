<?php
include "tools.php";
session_start();

if (empty($_SESSION)) header("Location: index.php#");

$movArr = $_SESSION['movie'];
$day = $movArr['day'];
$hour = $movArr['hour'];

if (
    (($day !== "SAT" || $day !== "SUN") && $hour === 'T12') ||
    ($day === "MON" || $day === "WED")
)
    $discount_flag = true;
else
    $discount_flag = false;

$boilerplate = <<<BOILERPLATE
<header>
    <div>
        <a href="index.php#">
            <span>Cinemax</span>
        </a>
        <p>ABN: 00 123 456 789</p>
    </div>
</header>
<section>
    <div class="container">
        <div class="row row-cols-2">
            <div class="col" id='cust-info'>
                <div class="row">
                    <h2>Customer info:</h2>
                </div>
                <div class="row">
                    <div class="col-sm-2">Name</div>
                    <div class="col-sm-10">: {$_SESSION['cust']['name']}</div>
                </div>
                <div class="row">
                    <div class="col-sm-2">Email</div>
                    <div class="col-sm-10">: {$_SESSION['cust']['email']}</div>
                </div>
                <div class="row">
                    <div class="col-sm-2">Mobile</div>
                    <div class="col-sm-10">: {$_SESSION['cust']['mobile']}</div>
                </div>
            </div>

            <div class="col" id='movie-info'>
                <div class="row">
                    <h2>Movie info:</h2>
                </div>
                <div class="row">
                    <div class="col-sm-2">Day</div>
                    <div class="col-sm-10">: {$dayAbbr[$day]}</div>
                </div>
                <div class="row">
                    <div class="col-sm-2">Hour</div>
                    <div class="col-sm-10">: {$hourAbbr[$hour]}</div>
                </div>
                <div class="row">
                    <div class="col-sm-2">Movie</div>
                    <div class="col-sm-10">: {$movieAbbr[$movArr['id']]}</div>
                </div>
            </div>
        </div>
        <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Seat type</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
BOILERPLATE;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemax Individual Ticket Printing</title>

    <!-- Linking Bootstrap -->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script defer src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script async defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" id='stylecss' type="text/css" href="receipt_style.css">
    <link rel="stylesheet" id='wireframecss' type="text/css" href="../wireframe.css" disabled>

    <noscript>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" id='wireframecss' type="text/css" href="../wireframe.css" disabled>
        <link rel="stylesheet" id='stylecss' type="text/css" href="receipt_style.css">
    </noscript>

    <script async defer src='../wireframe.js'></script>
</head>

<body onload="window.print();">
    <?php
    $iter = 1;
    foreach ($_SESSION['seats'] as $type => $amount) {
        for ($i = 0; $i < $amount; $i++) {
            $price = $discount_flag ? numToStr($priceArr[$type][0]) : numToStr($priceArr[$type][1]);
            $GST = $price * 1 / 11;
            echo $boilerplate;
            echo "<tr>";
            echo "<th scope=\"row\">{$iter}.{$i}</th>";
            echo "<td>{$seatAbbr[$type]}</td>";
            echo "<td>$" . "$price" . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th colspan=\"2\" scope=\"row\">GST</th>";
            echo "<td>$" . numToStr($GST) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th colspan=\"2\" scope=\"row\">Total</th>";
            echo "<td>$" . numToStr($price + $GST) . "</td>";
            echo "</tr>";

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</section>";
        }
        $iter++;
    }
    ?>
</body>

</html>

<aside>
    <?php
    echo "<h2>Your Input:</h2>";
    echo "\$_POST: ";
    preShow($_POST);
    echo "\$_SESSION: ";
    preShow($_SESSION);
    printMyCode();
    ?>
</aside>