<?php
include "tools.php";
session_start();

if (empty($_SESSION)) header("Location: index.php#");

$session_data = [
    date("o-m-d"),
    $_SESSION['cust']['name'],
    $_SESSION['cust']['email'],
    $_SESSION['cust']['mobile'],
    $_SESSION['movie']['id'] . " " . $_SESSION['movie']['day'] . " " . $_SESSION['movie']['hour'],
    $_SESSION['seats']['STA'],
    $_SESSION['seats']['STP'],
    $_SESSION['seats']['STC'],
    $_SESSION['seats']['FCA'],
    $_SESSION['seats']['FCP'],
    $_SESSION['seats']['FCC'],
    $_SESSION['total']
];

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
    <title>Receipt</title>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" id='stylecss' type="text/css" href="receipt_style.css">
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" id='wireframecss' type="text/css" href="../wireframe.css" disabled>

    <noscript>
        <link rel="stylesheet" id='wireframecss' type="text/css" href="../wireframe.css" disabled>
        <link rel="stylesheet" id='stylecss' type="text/css" href="receipt_style.css">
    </noscript>

    <script async defer src='../wireframe.js'></script>
</head>

<body>
    <header>
        <div>
            <span>Cinemax</span>
            <p>ABN: 00 123 456 789</p>
        </div>
    </header>
    <section>
        <table>
            <tr>
                <td>
                    <div id='cust-info'>
                        <h2>Customer info:</h2>
                        <table>
                            <tr>
                                <td>Name</td>
                                <td>: <?php echo $_SESSION['cust']['name'] ?></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: <?php echo $_SESSION['cust']['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td>: <?php echo $_SESSION['cust']['mobile'] ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <div id='movie-info'>
                        <h2>Movie info:</h2>
                        <table>
                            <tr>
                                <td>Day</td>
                                <td>: <?php echo $dayAbbr[$_SESSION['movie']['day']] ?></td>
                            </tr>
                            <tr>
                                <td>Hour</td>
                                <td>: <?php echo $hourAbbr[$_SESSION['movie']['hour']] ?></td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td>: <?php echo $_SESSION['cust']['mobile'] ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>