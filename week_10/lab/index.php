<!DOCTYPE HTML>
<html>
<head>
<style>
   .error {color: #FF0000;}
</style>
</head>
<body>
<?php
session_start();

include 'tools.php';

$errorFound = 0;
$cleanData = $_POST["email"];

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
};

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and whitespace are allowed.";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $errorFound++;
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $errorFound++;
        }
    }
    if ($errorFound == 0) {
        $_SESSION['email'] = $cleanData;
        // header("Location: receipt.php");
    }
}
if (isset($_POST['session-reset'])) {
    unset($_SESSION["email"]);
}
?>



<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  Name: <input type="text" name="name">
  <span class="error">* <?php echo $nameErr; ?></span>
  <br><br>
  E-mail: <input type="text" name="email">
  <span class="error">* <?php echo $emailErr; ?></span>
  <br><br>
  <br><br>
  <input type="submit" name="submit" value="Submit">
  <input type="submit" name="session-reset" value="Reset the session">
</form>

<?php
echo "<h2>Your Input:</h2>";
preShow($_POST);
preShow($_SESSION);
?>

</body>
</html>