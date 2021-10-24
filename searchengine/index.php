<?php
    ob_start();
    session_start();
    if (isset($_SESSION["user"])) {
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="./img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>
<body>

<?php
    $error = "";

    if (isset($_POST["user"]) && isset($_POST["pwd"])) {
        require "connection.php";
        $user = $_POST["user"];
        $pwd = $_POST["pwd"];

        $sql = "SELECT * FROM Account WHERE username=? AND pwd=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user, $pwd);
        $stmt->execute();
        $result = $stmt->get_result();

        if (empty($user)) {
            $error = 'Please enter your username';
        }
        else if (empty($pwd)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pwd) < 6) {
            $error = 'Password must have at least 6 characters';
        }

        else if ($result->num_rows > 0){
            //success
            $_SESSION["user"] = $user;
            header('Location: dashboard.php');
        } else {
            $error = 'Invalid username or password';
        }
    }
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <img src="./img/logo.png"> 
    <a class="navbar-brand" href="index.php">ViLePanion</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Sign In</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="register.php">Sign Up</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">User Login</h3>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input name="user" value="<?php echo isset($_POST["user"]) ? $_POST["user"] : ''; ?>" id="user" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="pwd" value="<?php echo isset($_POST["pwd"]) ? $_POST["pwd"] : ''; ?>" id="pwd" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input <?= isset($_POST['remember']) ? 'checked' : '' ?> name="remember" type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Remember login</label>
                </div>
                <div class="form-group">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <button class="btn btn-success px-5">Login</button>
                </div>
                <div class="form-group">
                    <p>Don't have an account yet? <a href="register.php">Register now</a>.</p>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6 col-lg-5">
        NOTE:
            <p>Admin: ID: admin Password: admin123</p>
            <p>Teacher: ID: teacher Password: teacher123</p>
            <p>Student: ID: student Password: student123</p>
    </div>

</div>

</body>
</html>
