<?php
include "./tools.php";
session_start();

if (empty($_SESSION)) header("Location: index.php#");

$movArr = $_SESSION['movie'];
$day = $movArr['day'];
$hour = $movArr['hour'];
$total = $_SESSION['total'];

$GST = $total * 1 / 11;

$session_data = [
    date("o-m-d"),
    $_SESSION['cust']['name'],
    $_SESSION['cust']['email'],
    $_SESSION['cust']['mobile'],
    $movArr['id'] . " " . $day . " " . $hour,
    $_SESSION['seats']['STA'],
    $_SESSION['seats']['STP'],
    $_SESSION['seats']['STC'],
    $_SESSION['seats']['FCA'],
    $_SESSION['seats']['FCP'],
    $_SESSION['seats']['FCC'],
    $total
];

if (
    (($day !== "SAT" || $day !== "SUN") && $hour === 'T12') ||
    ($day === "MON" || $day === "WED")
)
    $discount_flag = true;
else
    $discount_flag = false;

$fp = fopen("bookings.txt", "a");
flock($fp, LOCK_EX);
fputcsv($fp, $session_data, "\t");
flock($fp, LOCK_UN);
fclose($fp);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemax Receipt</title>

    <!-- Linking Bootstrap -->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script defer src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script async defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script async defer src='script.js'></script>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" id='stylecss' type="text/css" href="receipt_style.css">
    <link rel="stylesheet" id='wireframecss' type="text/css" href="../wireframe.css" disabled>

    <noscript>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" id='wireframecss' type="text/css" href="../wireframe.css" disabled>
        <link rel="stylesheet" id='stylecss' type="text/css" href="receipt_style.css">
    </noscript>

    <script async defer src='../wireframe.js'></script>
</head>

<body>
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
                        <div class="col-sm-10">: <?php echo $_SESSION['cust']['name'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">Email</div>
                        <div class="col-sm-10">: <?php echo $_SESSION['cust']['email'] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">Mobile</div>
                        <div class="col-sm-10">: <?php echo $_SESSION['cust']['mobile'] ?></div>
                    </div>
                </div>

                <div class="col" id='movie-info'>
                    <div class="row">
                        <h2>Movie info:</h2>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">Day</div>
                        <div class="col-sm-10">: <?php echo $dayAbbr[$day] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">Hour</div>
                        <div class="col-sm-10">: <?php echo $hourAbbr[$hour] ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">Movie</div>
                        <div class="col-sm-10">: <?php echo $movieAbbr[$movArr['id']] ?></div>
                    </div>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Seat type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $iter = 1;
                    foreach ($_SESSION['seats'] as $type => $amount) {
                        if ($amount) {
                            $price = $discount_flag ? numToStr($priceArr[$type][0] * $amount) : numToStr($priceArr[$type][1] * $amount);
                            echo "<tr>";
                            echo "<th scope=\"row\">{$iter}</th>";
                            echo "<td>{$seatAbbr[$type]}</td>";
                            echo "<td>{$amount}</td>";
                            echo "<td>$" . $price . "</td>";
                            echo "</tr>";

                            $iter++;
                        }
                    }
                    echo "<tr>";
                    echo "<th colspan=\"3\" scope=\"row\">GST</th>";
                    echo "<td>$" . numToStr($GST) . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<th colspan=\"3\" scope=\"row\">Total</th>";
                    echo "<td>$" . numToStr($total + $GST) . "</td>";
                    echo "</tr>";
                    ?>
                    <tr id="buttons">
                        <td colspan="2">
                            <button type="button" class="btn btn-dark btn-block btn-lg" onclick="window.print();">Print group ticket</button>
                        </td>
                        <td colspan="2">
                            <form action="individual_ticket.php" method="post">
                                <input type="submit" value="Print individual ticket(s)" class="btn btn-dark btn-block btn-lg">
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <footer>
        <div>
            Cinemax&trade; | Contact at: inquiries@cinemax.com | 0123456789 | 123A Nguyen Van Linh, District 7, Ho Chi Minh City, Vietnam
        </div>
        <div>&copy;
            <script>
                document.write(new Date().getFullYear());
            </script> Huynh Ngoc Tuyen - s38318311. Last modified
            <?= date("Y F d  H:i", filemtime($_SERVER['SCRIPT_FILENAME'])); ?>.
        </div>
        <div>
            Disclaimer: This website is not a real website and is being developed as part of a School of Science Web Programming course at RMIT University in
            Melbourne, Australia.
        </div>
        <div>
            <button id='toggleWireframeCSS' onclick='toggleWireframe()'>Toggle Wireframe CSS</button>
            <form method="POST">
                <input type="submit" value="Reset current session" name='session-reset'>
            </form>
        </div>
    </footer>
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