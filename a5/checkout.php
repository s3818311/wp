<?php
session_start();
include_once "tools.php";

$nameErr = "";
$nameInp = isset($_POST['cust']['name']) ? $_POST['cust']['name'] : $_SESSION['cust']['name'];
// ----------
$emailErr = "";
$emailInp = isset($_POST['cust']['email']) ? $_POST['cust']['email'] : $_SESSION['cust']['email'];
// ----------
$mobileErr = "";
$mobileInp = isset($_POST['cust']['phone']) ? $_POST['cust']['phone'] : $_SESSION['cust']['phone'];
// ----------
$creditErr = "";
$creditInp = isset($_POST['cust']['card']) ? $_POST['cust']['card'] : $_SESSION['cust']['card'];
// ----------
$generalErr = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['item']['submit'])) {
        $new_item = true;
        foreach ($_SESSION['cart'] as $item_idx => $detail)
            if ($_SESSION['cart'][$item_idx]['name'] == $_POST['item']['name']) {
                $_SESSION['cart'][$item_idx]['amount']++;
                $new_item = false;
            }

        if ($new_item) array_push($_SESSION['cart'], $_POST['item']);
    }

    if (isset($_POST['remove-item']))
        array_splice($_SESSION['cart'], $_POST['remove']['idx'], 1);

    if (isset($_POST['order']['submit'])) {
        if (sizeof($_SESSION['cart']) > 0)
            $generalErr = "Cart is empty";
        else {
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
        }
    }
}
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
                    <a class="nav-link" href="browse.php#">Browse</a>
                </li>
            </ul>
            <form action="checkout.php#">
                <button class="btn btn-outline-success mr-1 my-2 my-sm-0 active" type="submit" id="checkOutBtn">🛒</button>
            </form>
            <form action="login.php#">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log In</button>
            </form>
        </div>
    </nav>

    <section class="container-fluid" id="checkout-section">
        <div class="row">
            <div class="col-md-7">
                <div class="row" id="checkout-header">
                    <div class="col-md-3">
                        <span>Item name</span>
                    </div>
                    <div class="col-md-3">
                        <span>Amount</span>
                    </div>
                    <div class="col-md-3">
                        <span>Price</span>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <?php
                if (sizeof($_SESSION['cart']) > 0) {
                    $sum_total = 0;
                    foreach ($_SESSION['cart'] as $item => $detail) {
                        $item_total = $detail['price'] * $detail['amount'];
                        $sum_total += $item_total;
                        echo "<div class=\"row\">";
                        echo "  <div class=\"col-md-3 border bg-light\">{$detail['name']}</div>";
                        echo "  <div class=\"col-md-3 border bg-light\">{$detail['amount']}</div>";
                        echo "  <div class=\"col-md-3 border bg-light\">{$item_total}</div>";
                        echo "  <div class=\"col-md-3 border bg-light\">";
                        echo "      <form action=\"checkout.php#\" method=\"POST\">";
                        echo "          <input type=\"hidden\" name=\"remove[idx]\" value=\"{$item}\">";
                        echo "          <input type=\"submit\" name=\"remove-item\" value=\"Remove\">";
                        echo "      </form>";
                        echo "  </div>";
                        echo "</div>";
                    }
                    echo "<div class=\"row\">";
                    echo "  <div class=\"col-md-6 border bg-light\">Sum total</div>";
                    echo "  <div class=\"col-md-3 border bg-light\">{$sum_total}</div>";
                    echo "  <div class=\"col-md-3 border bg-light\"></div>";
                    echo "</div>";
                } else {
                    echo "<div class=\"row\">";
                    echo "  <div class=\"col-md-9\">";
                    echo "      <span>There is nothing in your cart</span>";
                    echo "  </div>";
                    echo "  <div class=\"col-md-3\">";
                    echo "  </div>";
                    echo "</div>";
                }

                unset($_SERVER['REQUEST_METHOD']);
                ?>

            </div>
            <div class="col-md-5" id="customer-info">
                <h2>Your shipping information</h2>
                <form action="checkout.php" method="post">
                    <div class="row">
                        <div class='col'>
                            <label for="name">Name</label>
                        </div>
                        <div class='col'>
                            <input type="text" name="cust[name]" id="name" required <?php echo "value=\"{$nameInp}\" ";
                                                                                    if ($nameErr !== "") echo "class=\"err-input\""; ?>>
                        </div>
                    </div>
                    <?php if ($nameErr !== "") echo "<div class=\"row err\">{$nameErr}</div>" ?>
                    <div class="row">
                        <div class='col'>
                            <label for="phone">Phone number</label>
                        </div>
                        <div class='col'>
                            <input type="tel" name="cust[phone]" id="phone" required <?php echo "value=\"{$mobileInp}\" ";
                                                                                        if ($mobileErr !== "") echo "class=\"err-input\""; ?>>
                        </div>
                    </div>
                    <?php if ($mobileErr !== "") echo "<div class=\"row err\">{$mobileErr}</div>" ?>
                    <div class="row">
                        <div class='col'>
                            <label for="email">Email</label>
                        </div>
                        <div class='col'>
                            <input type="text" name="cust[email]" id="email" required <?php echo "value=\"{$emailInp}\" ";
                                                                                        if ($emailErr !== "") echo "class=\"err-input\""; ?>>
                        </div>
                    </div>
                    <?php if ($emailErr !== "") echo "<div class=\"err row\">{$emailErr}</div>" ?>
                    <div class="row">
                        <div class='col'>
                            <label for="address">Address</label>
                        </div>
                        <div class='col'>
                            <input type="text" name="cust[address]" id="address" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col'>
                            <label for="card">Credit card number</label>
                        </div>
                        <div class='col'>
                            <input type="text" name="cust[card]" id="card" required <?php echo "value=\"{$creditInp}\" ";
                                                                                    if ($creditErr !== "") echo "class=\"err-input\""; ?>>
                        </div>
                    </div>
                    <?php if ($creditErr !== "") echo "<div class=\"err row\">{$creditErr}</div>" ?>
                    <div class="row">
                        <div class='col'>
                            <input type="submit" name="order[submit]" value="Order">
                        </div>
                    </div>
                </form>
                <?php if ($generalErr !== "") echo "<div class=\"err row\">{$generalErr}</div>" ?>
            </div>
        </div>
    </section>

</body>

</html>

<?php
closeSqlConn($conn);
?>