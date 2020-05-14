<?php
include "tools.php";
session_start();
mysqliConn();

$generalErr = "";
$chosenMov = "";
// ----------
$nameErr = "";
$nameInp = "";
// ----------
$emailErr = "";
$emailInp = "";
// ----------
$mobileErr = "";
$mobileInp = "";
// ----------
$creditErr = "";
$creditInp = "";
// ----------
$expiryErr = "";
$expiryInp = "";
// ----------

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['movie'])) {
        $chosenMov = $_POST['movie']['id'];
        $_SESSION['movie'] = $_POST['movie'];
    }

    if (anyInArr($_POST['seats']))
        $_SESSION['seats'] = $_POST['seats'];
    else
        $generalErr = "At least 1 ticket is required";

    if (empty($_POST['booking']))
        $generalErr = "Please choose a time and date";

    $nameInp = $_POST['cust']['name'];
    if (empty($_POST['cust']['name']))
        $nameErr = "Please enter a name";
    else if (!preg_match("/^[a-z \-\']+$/i", $nameInp)) {
        $nameErr = "Only letters, whitespaces, apostrophes(') and hypens(-) are allowed";
        $nameInp = sanitizeInp($nameInp);
    } else {
        $nameInp = sanitizeInp($nameInp);
        $_SESSION['cust']['name'] = $nameInp;
    }

    $emailInp = $_POST['cust']['email'];
    if (empty($_POST['cust']['email']))
        $nameErr = "Please enter an email";
    else if (!filter_var($emailInp, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $emailInp = sanitizeInp($emailInp);
    } else {
        $emailInp = sanitizeInp($emailInp);
        $_SESSION['cust']['email'] = $emailInp;
    }

    $mobileInp = $_POST['cust']['mobile'];
    if (empty($_POST['cust']['mobile']))
        $nameErr = "Please enter your mobile number";
    else if (!preg_match("/^(\d\s*){9,10}$/", $mobileInp)) {
        $mobileErr = "Invalid mobile number format";
        $mobileInp = sanitizeInp($mobileInp);
    } else {
        $mobileInp = sanitizeInp($mobileInp);
        $_SESSION['cust']['mobile'] = $mobileInp;
    }

    $creditInp = $_POST['cust']['card'];
    if (empty($_POST['cust']['card']))
        $creditErr = "Please enter your credit card number";
    else if (!preg_match("/^(\d\s*){14,19}$/", $creditInp)) {
        $creditErr = "Invalid credit card format";
        $creditInp = sanitizeInp($creditInp);
    } else {
        $creditInp = sanitizeInp($creditInp);
        $_SESSION['cust']['card'] = $creditInp;
    }

    $expiryInp = $_POST['cust']['expiry'];
    if (empty($_POST['cust']['expiry']))
        $expiryErr = "Please the expiry date of your credit card";
    else if ((new Datetime($expiryInp))->format("Y-m") < date("Y-m")) {
        $expiryErr = "Invalid date, must be greater than " . date("F Y");
        $expiryInp = sanitizeInp($expiryInp);
    } else {
        $expiryInp = sanitizeInp($expiryInp);
        $_SESSION['cust']['expiry'] = $expiryInp;
    }

    if (empty($generalErr . $nameErr . $emailErr . $mobileErr . $creditErr . $expiryErr)) header("Location: receipt.php#");
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assignment 4</title>

    <!-- Passing certain PHP variables to script.js -->
    <?php
    php2js($chosenMov, 'chosenMov');
    ?>

    <!-- Linking Bootstrap -->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script defer src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script async defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script async defer src='script.js'></script>

    <!-- Keep wireframe.css for debugging, add your css to style.css -->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" id='stylecss' type="text/css" href="style.css">
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" id='wireframecss' type="text/css" href="../wireframe.css" disabled>

    <noscript>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" id='wireframecss' type="text/css" href="../wireframe.css" disabled>
        <link rel="stylesheet" id='stylecss' type="text/css" href="style.css">
    </noscript>

    <script async defer src='../wireframe.js'></script>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

    <header class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <img src="../media/cinema_logo.webp" alt="Cinema Logo">
            </div>
            <div class="col-lg-8">Cinemax</div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="navigation">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="#anchor1">About Us</a>
                <a class="nav-item nav-link" href="#anchor2">Pricing</a>
                <a class="nav-item nav-link" href="#anchor3">Now Showing</a>
            </div>
    </nav>

    <main>
        <div class="anchor" id="anchor1"></div>
        <article id="section1" class="parallax">
            <div id="section1-content-wrapper" class="container-fluid">
                <div class="row align-items-center">
                    <p><span>The wait is over!</span></p>
                    <p>The cinema has reopened after extensive improvements and renovations.</p>
                    <p>
                        The projection and sound systems are upgraded with 3D Dolby Vision projection and Dolby Atmos sound.
                        For more information about Dolby,
                        <a href="https://www.dolby.com/us/en/cinema" target="_blank" rel="noopener">click here</a>.
                    </p>
                    <p>There are new seats available with reclinable first class seats and standard seats.</p>
                </div>
                <div id='seatings' class="row align-items-start">
                    <div class="col-lg-6">
                        <p><span>First class seating</span></p>
                        <img src="../media/first_class_seat.webp" alt="First class seat">
                    </div>
                    <div class="col-lg-6">
                        <p><span>Standard seating</span></p>
                        <img src="../media/standard_seat.webp" alt="Standard seat" id="standard-seat">
                    </div>
                </div>
            </div>
        </article>

        <div class="anchor" id="anchor2"></div>
        <article id="section2">
            <p>PRICING</p>
            <div id="pricing-table" class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-4 px-0">
                        <div class="ticket first-class m-1 py-4">
                            <p class="ticket-name">First Class Adult</p>
                            <p class="price-special FCA"></p>
                            <p class="price-normal FCA"></p>
                        </div>
                    </div>
                    <div class="col-lg-4 px-0">
                        <div class="ticket first-class m-1 py-4">
                            <p class="ticket-name">First Class Concession</p>
                            <p class="price-special FCP"></p>
                            <p class="price-normal FCP"></p>
                        </div>
                    </div>
                    <div class="col-lg-4 px-0">
                        <div class="ticket first-class m-1 py-4">
                            <p class="ticket-name">First Class Child</p>
                            <p class="price-special FCC"></p>
                            <p class="price-normal FCC"></p>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-4 px-0">
                        <div class="ticket m-1 py-4">
                            <p class="ticket-name">Standard Adult</p>
                            <p class="price-special STA"></p>
                            <p class="price-normal STA"></p>
                        </div>
                    </div>
                    <div class="col-lg-4 px-0">
                        <div class="ticket m-1 py-4">
                            <p class="ticket-name">Standard Concession</p>
                            <p class="price-special STP"></p>
                            <p class="price-normal STP"></p>
                        </div>
                    </div>
                    <div class="col-lg-4 px-0">
                        <div class="ticket m-1 py-4">
                            <p class="ticket-name">Standard Child</p>
                            <p class="price-special STC"></p>
                            <p class="price-normal STC"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="special">
                <span>* Only applied on Monday, Wednesday and 12pm on Weekdays</span>
            </div>
        </article>

        <div class="anchor" id="anchor3"></div>
        <article id="section3">
            <p>NOW SHOWING</p>
            <div id="movies" class="container-fluid">

                <div class="row align-items-center">
                    <div class="movie col-lg-6">
                        <div class="row align-items-center">
                            <div id="poster" class="col-sm-5"><img src="../media/Avengers_Endgame_poster.webp" alt="Avengers: Endgame" id='movieACT'></div>
                            <div class="movie-info col-sm-7">
                                <p>Avengers: Endgame</p>
                                <p>(M)</p>
                                <table>
                                    <tr>
                                        <td>Monday</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Tuesday</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Wednesday</td>
                                        <td>21:00</td>
                                    </tr>
                                    <tr>
                                        <td>Thursday</td>
                                        <td>21:00</td>
                                    </tr>
                                    <tr>
                                        <td>Friday</td>
                                        <td>21:00</td>
                                    </tr>
                                    <tr>
                                        <td>Saturday</td>
                                        <td>18:00</td>
                                    </tr>
                                    <tr>
                                        <td>Sunday</td>
                                        <td>18:00</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="movie col-lg-6">
                        <div class="row align-items-center">
                            <div id="poster" class="col-sm-5"><img src="../media/Top_End_Wedding_poster.webp" alt="Top End Wedding" id='movieRMC'></div>
                            <div class="movie-info col-sm-7">
                                <p>Top End Wedding</p>
                                <p>(M)</p>
                                <table>
                                    <tr>
                                        <td>Monday</td>
                                        <td>18:00</td>
                                    </tr>
                                    <tr>
                                        <td>Tuesday</td>
                                        <td>18:00</td>
                                    </tr>
                                    <tr>
                                        <td>Wednesday</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Thursday</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Friday</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Saturday</td>
                                        <td>15:00</td>
                                    </tr>
                                    <tr>
                                        <td>Sunday</td>
                                        <td>15:00</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="movie col-lg-6">
                        <div class="row align-items-center">
                            <div id="poster" class="col-sm-5"><img src="../media/Dumbo_poster.webp" alt="Dumbo" id='movieANM'></div>
                            <div class="movie-info col-sm-7">
                                <p>Dumbo</p>
                                <p>(PG)</p>
                                <table>
                                    <tr>
                                        <td>Monday</td>
                                        <td>12:00</td>
                                    </tr>
                                    <tr>
                                        <td>Tuesday</td>
                                        <td>12:00</td>
                                    </tr>
                                    <tr>
                                        <td>Wednesday</td>
                                        <td>18:00</td>
                                    </tr>
                                    <tr>
                                        <td>Thursday</td>
                                        <td>18:00</td>
                                    </tr>
                                    <tr>
                                        <td>Friday</td>
                                        <td>18:00</td>
                                    </tr>
                                    <tr>
                                        <td>Saturday</td>
                                        <td>12:00</td>
                                    </tr>
                                    <tr>
                                        <td>Sunday</td>
                                        <td>12:00</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="movie col-lg-6">
                        <div class="row align-items-center">
                            <div id="poster" class="col-sm-5"><img src="../media/The_Happy_Prince_poster.webp" alt="The Happy Prince" id='movieAHF'></div>
                            <div class="movie-info col-sm-7">
                                <p>The Happy Prince</p>
                                <p>(MA15+)</p>
                                <table>
                                    <tr>
                                        <td>Monday</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Tuesday</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Wednesday</td>
                                        <td>12:00</td>
                                    </tr>
                                    <tr>
                                        <td>Thursday</td>
                                        <td>12:00</td>
                                    </tr>
                                    <tr>
                                        <td>Friday</td>
                                        <td>12:00</td>
                                    </tr>
                                    <tr>
                                        <td>Saturday</td>
                                        <td>21:00</td>
                                    </tr>
                                    <tr>
                                        <td>Sunday</td>
                                        <td>21:00</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='anchor' id='synopsis-anchor'></div>
            <div id="synopsis" class="container-fluid">
                <form action="index.php#synopsis-anchor" method="POST" id='booking-form'>
                    <!-- Movie -->
                    <div class="row align-items-center synopsis-row">
                        <div id="info" class="col-lg-7">
                            <p><span></span><span></span></p>
                            <br>
                            <p></p>
                            <p></p>
                            <input type="hidden" name="movie[id]">
                        </div>
                        <div class="col-lg-5 embed-responsive embed-responsive-16by9 trailer">
                            <iframe class="embed-responsive-item" src="" allowfullscreen></iframe>
                        </div>
                    </div>

                    <!-- Date -->
                    <p>Make a booking for: <span></span></p>
                    <p><span class="err-span"><?php echo $generalErr ?></span></p>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='SUN' <?php if ($generalErr === "" && $_POST['movie']['day'] === 'SUN') echo "checked" ?>>
                        <label for='SUN'></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='MON' <?php if ($generalErr === "" && $_POST['movie']['day'] === 'MON') echo "checked" ?>>
                        <label for='MON'></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='TUE' <?php if ($generalErr === "" && $_POST['movie']['day'] === 'TUE') echo "checked" ?>>
                        <label for='TUE'></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='WED' <?php if ($generalErr === "" && $_POST['movie']['day'] === 'WED') echo "checked" ?>>
                        <label for='WED'></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='THU' <?php if ($generalErr === "" && $_POST['movie']['day'] === 'THU') echo "checked" ?>>
                        <label for='THU'></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='FRI' <?php if ($generalErr === "" && $_POST['movie']['day'] === 'FRI') echo "checked" ?>>
                        <label for='FRI'></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='SAT' <?php if ($generalErr === "" && $_POST['movie']['day'] === 'SAT') echo "checked" ?>>
                        <label for='SAT'></label>
                    </div>
                    <input type="hidden" name="movie[day]">
                    <input type="hidden" name="movie[hour]">

                    <!-- Seat types -->
                    <div class='row'>
                        <div class='booking-box col-md-6'>
                            <span>First Class</span>
                            <div class='inner'>
                                <label for="adults">Adults:</label>
                                <input type="number" name="seats[FCA]" id="adults" min="1" max="10" class="seats" <?php if ($generalErr === "") echo "value=\"{$_POST['seats']['FCA']}\""; ?>>
                                <label for="concession">Concession:</label>
                                <input type="number" name="seats[FCP]" id="concession" min="1" max="10" class="seats" <?php if ($generalErr === "") echo "value=\"{$_POST['seats']['FCP']}\""; ?>>
                                <label for="children">Children:</label>
                                <input type="number" name="seats[FCC]" id="children" min="1" max="10" class="seats" <?php if ($generalErr === "") echo "value=\"{$_POST['seats']['FCC']}\""; ?>>
                            </div>
                        </div>
                        <div class='booking-box col-md-6'>
                            <span>Standard</span>
                            <div class='inner'>
                                <label for="adults">Adults:</label>
                                <input type="number" name="seats[STA]" id="adults" min="1" max="10" class="seats" <?php if ($generalErr === "") echo "value=\"{$_POST['seats']['STA']}\""; ?>>
                                <label for="concession">Concession:</label>
                                <input type="number" name="seats[STP]" id="concession" min="1" max="10" class="seats" <?php if ($generalErr === "") echo "value=\"{$_POST['seats']['STP']}\""; ?>>
                                <label for="children">Children:</label>
                                <input type="number" name="seats[STC]" id="children" min="1" max="10" class="seats" <?php if ($generalErr === "") echo "value=\"{$_POST['seats']['STC']}\""; ?>>
                            </div>
                        </div>
                    </div>
                    <p id='total'>Total: $0.00</p>

                    <!-- User info -->
                    <div class='booking-box'>
                        <span>Info</span>
                        <div class='inner' id='info-table'>
                            <table>
                                <tr>
                                    <td>
                                        <label for="name">Name</label>
                                    </td>
                                    <td>
                                        <input type="text" id="name" name="cust[name]" required <?php echo "value=\"{$nameInp}\" ";
                                                                                                if ($nameErr !== "") echo "class=\"err-input\""; ?>>
                                    </td>
                                </tr>
                                <?php if ($nameErr !== "") echo "<tr class=\"err-row\"><td colspan=2><span class=\"err-span\"> {$nameErr} </span></td></tr>" ?>
                                <tr>
                                    <td>
                                        <label for="email">Email</label>
                                    </td>
                                    <td>
                                        <input type="email" id="email" name="cust[email]" required <?php echo "value=\"{$emailInp}\" ";
                                                                                                    if ($emailErr !== "") echo "class=\"err-input\""; ?>>
                                    </td>
                                </tr>
                                <?php if ($emailErr !== "") echo "<tr class=\"err-row\"><td colspan=2><span class=\"err-span\"> {$emailErr} </span></td></tr>" ?>
                                <tr>
                                    <td>
                                        <label for="mobile">Mobile</label>
                                    </td>
                                    <td>
                                        <input type="tel" id="mobile" name="cust[mobile]" required <?php echo "value=\"{$mobileInp}\" ";
                                                                                                    if ($mobileErr !== "") echo "class=\"err-input\""; ?>>
                                    </td>
                                </tr>
                                <?php if ($mobileErr !== "") echo "<tr class=\"err-row\"><td colspan=2><span class=\"err-span\"> {$mobileErr} </span></td></tr>" ?>
                                <tr>
                                    <td>
                                        <label for="credit">Credit Card</label>
                                    </td>
                                    <td>
                                        <input type="text" id="credit" name="cust[card]" required <?php echo "value=\"{$creditInp}\" ";
                                                                                                    if ($creditErr !== "") echo "class=\"err-input\""; ?>>
                                    </td>
                                </tr>
                                <?php if ($creditErr !== "") echo "<tr class=\"err-row\"><td colspan=2><span class=\"err-span\"> {$creditErr} </span></td></tr>" ?>
                                <tr>
                                    <td>
                                        <label for="expiry">Expiry</label>
                                    </td>
                                    <td>
                                        <input type="month" id="expiry" name="cust[expiry]" required <?php echo "value=\"{$expiryInp}\" ";
                                                                                                        if ($expiryErr !== "") echo "class=\"err-input\""; ?>>
                                    </td>
                                </tr>
                                <?php if ($expiryErr !== "") echo "<tr class=\"err-row\"><td colspan=2><span class=\"err-span\"> {$expiryErr} </span></td></tr>" ?>
                            </table>
                        </div>
                    </div>

                    <input type="submit" value="Order" id='orderBtn'>
                </form>
            </div>

        </article>

    </main>

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

    <?php
    echo "<h2>Your Input:</h2>";
    echo "\$_POST: ";
    preShow($_POST);
    echo "\$_SESSION: ";
    preShow($_SESSION);
    ?>
</body>

</html>