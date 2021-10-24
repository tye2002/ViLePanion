<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
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

    ob_start();
    $error = '';
    $first_name = '';
    $last_name = '';
    $email = '';
    $user = '';
    $pwd = '';
    $pwd_confirm = '';

    require("connection.php");
    
    if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email'])
    && isset($_POST['user']) && isset($_POST['pwd']) && isset($_POST['pwd-confirm']))
    {
        $name ="";
        $first_name = $_POST['first'];
        $last_name = $_POST['last'];
        $email = $_POST['email'];
        $user = $_POST['user'];
        $pwd = $_POST['pwd'];
        $pwd_confirm = $_POST['pwd-confirm'];
        $message = "";

        if (empty($first_name)) {
            $error = 'Please enter your first name';
        }
        else if (empty($last_name)) {
            $error = 'Please enter your last name';
        }
        else if (empty($email)) {
            $error = 'Please enter your email';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'This is not a valid email address';
        }
        else if (empty($user)) {
            $error = 'Please enter your username';
        }
       
        else if (empty($pwd)) {
            $error = 'Please enter your password';
        }
        else if (strlen($pwd) < 6) {
            $error = 'Password must have at least 6 characters';
        }
        else if ($pwd != $pwd_confirm) {
            $error = 'Password does not match';
        }
        else {
            // register a new account
            $img = "./img/user.svg";
            $name = $first_name ." " . $last_name;
            $sql ="INSERT INTO Account(username, pwd, name, email, avatar)
            VALUES('$user','$pwd','$name','$email','$img')";
            $result= mysqli_query($conn,$sql);
            $message = "You're registered.";
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
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
            
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Create a new account</h3>
                <form method="post" action="" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First name</label>
                            <input value="<?= $first_name?>" name="first" required class="form-control" type="text" placeholder="First name" id="firstname">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last name</label>
                            <input value="<?= $last_name?>" name="last" required class="form-control" type="text" placeholder="Last name" id="lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="<?= $email?>" name="email" required class="form-control" type="email" placeholder="Email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="user">Username</label>
                        <input value="<?= $user?>" name="user" required class="form-control" type="text" placeholder="Username" id="user">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input name="pwd" required class="form-control" type="password" placeholder="Password" id="pwd">
                    </div>
                    <div class="form-group">
                        <label for="pwd2">Confirm Password</label>
                        <input name="pwd-confirm" required class="form-control" type="password" placeholder="Confirm Password" id="pwd2">
                    </div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>

                        <button type="submit" class="btn btn-success px-5 mt-3 mr-2">Register</button>

                        <?php
                            if (!empty($message)) {
                                echo "<div class='alert alert-success'>$message<a href='index.php'> Đăng nhập</a></div>";
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <p>Already have an account? <a href="index.php">Login</a> now.</p>
                    </div>
                    
                </form>

            </div>
        </div>

    </div>
</body>
</html>

