<?php
include "./tools.php";
session_start();

$generalErr = "";
$chosenMov = "";
// ----------
$nameErr = "";
$nameInp = isset($_POST['cust']['name']) ? $_POST['cust']['name'] : $_SESSION['cust']['name'];
// ----------
$emailErr = "";
$emailInp = isset($_POST['cust']['email']) ? $_POST['cust']['email'] : $_SESSION['cust']['email'];
// ----------
$mobileErr = "";
$mobileInp = isset($_POST['cust']['mobile']) ? $_POST['cust']['mobile'] : $_SESSION['cust']['mobile'];
// ----------
$creditErr = "";
$creditInp = isset($_POST['cust']['card']) ? $_POST['cust']['card'] : $_SESSION['cust']['card'];
// ----------
$expiryErr = "";
$expiryInp = isset($_POST['cust']['expiry']) ? $_POST['cust']['expiry'] : $_SESSION['cust']['expiry'];
// ----------
$total = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $chosenMov = $_POST['movie']['id'];

    if (!empty($_POST['movie']['day']))
        $_SESSION['movie'] = $_POST['movie'];
    else
        $generalErr = "Please choose a time and date";

    if ($_POST['total'] != 0) {
        $total = $_POST['total'];
        $_SESSION['total'] = $total;
        $_SESSION['seats'] = $_POST['seats'];
    } else
        $generalErr = "At least 1 ticket is required";


    $nameCheck = checkInpErr($nameInp, "name", preg_match("/^[a-z \-\']+$/i", $nameInp));
    switch ($nameCheck[0]) {
        case 0:
            $nameInp = $nameCheck[1];
            $_SESSION['cust']['name'] = $nameInp;
            break;
        case 1:
            $nameErr = $nameCheck[1];
            break;
        case 2:
            $nameInp = $nameCheck[1];
            $nameErr = "Only letters, whitespaces, apostrophes(') and hypens(-) are allowed";
            break;
    }

    $emailCheck = checkInpErr($emailInp, "email", filter_var($emailInp, FILTER_VALIDATE_EMAIL));
    switch ($emailCheck[0]) {
        case 0:
            $emailInp = $emailCheck[1];
            $_SESSION['cust']['email'] = $emailInp;
            break;
        case 1:
            $emailErr = $emailCheck[1];
            break;
        case 2:
            $emailInp = $emailCheck[1];
            $emailErr = "Invalid email format";
            break;
    }

    $mobileCheck = checkInpErr($mobileInp, "mobile", preg_match("/^(\d\s*){9,10}$/", $mobileInp));
    switch ($mobileCheck[0]) {
        case 0:
            $mobileInp = $mobileCheck[1];
            $_SESSION['cust']['mobile'] = $mobileInp;
            break;
        case 1:
            $mobileErr = $mobileCheck[1];
            break;
        case 2:
            $mobileInp = $mobileCheck[1];
            $mobileErr = "Invalid mobile number format";
            break;
    }

    $creditCheck = checkInpErr($creditInp, "credit card number", preg_match("/^(\d\s*\-*){14,19}$/", $creditInp));
    switch ($creditCheck[0]) {
        case 0:
            $creditInp = $creditCheck[1];
            $_SESSION['cust']['card'] = $creditInp;
            break;
        case 1:
            $creditErr = $creditCheck[1];
            break;
        case 2:
            $creditInp = $creditCheck[1];
            $creditErr = "Invalid credit card format";
            break;
    }

    $expiryCheck = checkInpErr($expiryInp, "credit card's expiry date", (new Datetime($expiryInp))->format("Y-m") > date("Y-m", strtotime("+28 days")));
    switch ($expiryCheck[0]) {
        case 0:
            $expiryInp = $expiryCheck[1];
            $_SESSION['cust']['expiry'] = $expiryInp;
            break;
        case 1:
            $expiryErr = $expiryCheck[1];
            break;
        case 2:
            $expiryInp = $expiryCheck[1];
            $expiryErr = "Invalid date, must be greater than " . date("F Y", strtotime("+28 days"));
            break;
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
    <link rel="stylesheet" id='wireframecss' type="text/css" href="../wireframe.css" disabled>

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
                            <div class="col-sm-5 poster"><img src="../media/Avengers_Endgame_poster.webp" alt="Avengers: Endgame" id='movieACT'></div>
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
                            <div class="col-sm-5 poster"><img src="../media/Top_End_Wedding_poster.webp" alt="Top End Wedding" id='movieRMC'></div>
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
                            <div class="col-sm-5 poster"><img src="../media/Dumbo_poster.webp" alt="Dumbo" id='movieANM'></div>
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
                            <div class="col-sm-5 poster"><img src="../media/The_Happy_Prince_poster.webp" alt="The Happy Prince" id='movieAHF'></div>
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
                        <input type="radio" name="booking" id='SUN' class="booking-date-inp">
                        <label for='SUN' class="booking-date-label"></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='MON' class="booking-date-inp">
                        <label for='MON' class="booking-date-label"></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='TUE' class="booking-date-inp">
                        <label for='TUE' class="booking-date-label"></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='WED' class="booking-date-inp">
                        <label for='WED' class="booking-date-label"></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='THU' class="booking-date-inp">
                        <label for='THU' class="booking-date-label"></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='FRI' class="booking-date-inp">
                        <label for='FRI' class="booking-date-label"></label>
                    </div>
                    <div class='booking-date'>
                        <input type="radio" name="booking" id='SAT' class="booking-date-inp">
                        <label for='SAT' class="booking-date-label"></label>
                    </div>
                    <input type="hidden" name="movie[day]">
                    <input type="hidden" name="movie[hour]">

                    <!-- Seat types -->
                    <div class='row'>
                        <div class='booking-box col-md-6'>
                            <span>First Class</span>
                            <div class='inner'>
                                <label for="adults">Adults:</label>
                                <input type="number" name="seats[FCA]" id="adults" min="1" max="10" class="seats" <?php if (!empty($_POST['seats']['FCA'])) echo "value=\"{$_POST['seats']['FCA']}\""; ?>>
                                <label for="concession">Concession:</label>
                                <input type="number" name="seats[FCP]" id="concession" min="1" max="10" class="seats" <?php if (!empty($_POST['seats']['FCP'])) echo "value=\"{$_POST['seats']['FCP']}\""; ?>>
                                <label for="children">Children:</label>
                                <input type="number" name="seats[FCC]" id="children" min="1" max="10" class="seats" <?php if (!empty($_POST['seats']['FCC'])) echo "value=\"{$_POST['seats']['FCC']}\""; ?>>
                            </div>
                        </div>
                        <div class='booking-box col-md-6'>
                            <span>Standard</span>
                            <div class='inner'>
                                <label for="adults">Adults:</label>
                                <input type="number" name="seats[STA]" id="adults" min="1" max="10" class="seats" <?php if (!empty($_POST['seats']['STA'])) echo "value=\"{$_POST['seats']['STA']}\""; ?>>
                                <label for="concession">Concession:</label>
                                <input type="number" name="seats[STP]" id="concession" min="1" max="10" class="seats" <?php if (!empty($_POST['seats']['STP'])) echo "value=\"{$_POST['seats']['STP']}\""; ?>>
                                <label for="children">Children:</label>
                                <input type="number" name="seats[STC]" id="children" min="1" max="10" class="seats" <?php if (!empty($_POST['seats']['STC'])) echo "value=\"{$_POST['seats']['STC']}\""; ?>>
                            </div>
                        </div>
                    </div>
                    <label for='total'>Total: $</label>
                    <input type="text" name="total" id="total" readonly <?php if (!empty($_POST['total'])) echo "value=\"{$total}\"" ?>>

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
        </div>
    </footer>
    <?php
    echo "<h2>Your Input:</h2>";
    echo "\$_POST: ";
    preShow($_POST);
    echo "\$_SESSION: ";
    preShow($_SESSION);
    printMyCode();
    ?>
</body>

</html>