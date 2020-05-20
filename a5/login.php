<?php
include "tools.php";
session_start();

if (isset($_POST['session-reset'])) {
    $reset_flag = session_destroy();
    if ($reset_flag) {
        unset($_POST['session-reset']);
        header("Location: index.php#");
    } else exit("Session failed to reset");
}

$usernameInp = isset($_POST['login']['username']) ? $_POST['login']['username'] : "";
$passwordInp = isset($_POST['login']['password']) ? $_POST['login']['password'] : "";
$userInpErr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        empty($usernameInp) ||
        empty($passwordInp) ||
        !preg_match("/^[a-z0-9]+$/i", $usernameInp) ||
        !filter_var($passwordInp, FILTER_SANITIZE_STRING)
    ) {
        $usernameInp = sanitizeInp($usernameInp);
        $userInpErr = "Invalid login details";
    } else {
        $usernames = mysqli_query($conn, "SELECT * FROM admin WHERE username = '{$usernameInp}';");
        if (!$usernames) $userInpErr = "Invalid login details";
        else {
            while ($row = mysqli_fetch_assoc($usernames))
                if (password_verify($passwordInp, $row['password'])) {
                    $_SESSION['login']['username'] = $usernameInp;
                    $_SESSION['login']['password'] = $passwordInp;
                    header("Location: admin.php#");
                }

            $userInpErr = "Invalid login details";
        }
    };
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
            </ul>
            <form action="login.php#" method="POST">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log In</button>
            </form>
        </div>
    </nav>

    <section id="login-section">
        <div>
            <form action="login.php" method="post">
                <table>
                    <tr>
                        <td><label for="username">Username</label></td>
                        <td><input type="text" name="login[username]" id="username" <?php echo "value=\"$usernameInp\"" ?>></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password</label></td>
                        <td><input type="password" name="login[password]" id="password"></td>
                    </tr>
                    <?php
                    if ($userInpErr) echo "<tr><td class=\"err\" colspan=2>{$userInpErr}</td></tr>";
                    ?>
                    <tr>
                        <td colspan=2>
                            <input type="submit" value="Login">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </section>

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