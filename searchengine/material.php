<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }
    require("connection.php");
    $subjectid = $_GET["subjectid"];

    $sql_subjectname = "SELECT subjectname FROM subjects WHERE subjectid = '$subjectid'";
    $result1 = mysqli_query($conn,$sql_subjectname);
    $subjectname = $result1->fetch_assoc();

    $user = $_SESSION['user'];
    $hidden = '';
    $sql = "SELECT activated FROM account WHERE username = '$user'";
    $result = mysqli_query($conn,$sql);
    $row = $result->fetch_assoc();
    $_SESSION["activecode"] = $row["activated"];

    if ($_SESSION["activecode"] == 2){
            $hidden = 'hidden';
        } else {
            $hidden = '';
        } 

    ?>


    
<!DOCTYPE html>

<html lang="en">
<head>
    <title><?php echo $subjectname['subjectname'] ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="./img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <img src="./img/logo.png"> 
    <a class="navbar-brand" href="dashboard.php">ViLePanion</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <li><img src="./img/user.svg" alt="" class="icon"> </li>
                <li class="ml-auto"> Hi, <?php echo $_SESSION['user']; ?></li>
            </li>

            <li class="nav-item active">
                <a href="logout.php">
                    <img src="./img/logout.svg" alt="" class="icon">
                </a>
            </li>
        </ul>
    </div>
</nav>


<div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">

        <ul class="list-unstyled components">
            <h3>Dashboard</h3>
            <?php             
                $sql_list = "SELECT * FROM subjects";
                
                $result_list = mysqli_query($conn,$sql_list);
                while ($row_list = $result_list -> fetch_assoc()){
                    $subjectid = $row_list["subjectid"];
                    $subjectname = $row_list["subjectname"];
            ?>
                <li>
                    <a href="material.php?subjectid=<?php echo $subjectid?>"><?php echo $subjectname?></a>
                </li>
            <?php } ?>
        </ul>

    </nav>

    <!-- Main -->
    <div class="container" style="margin-top: 60px">

        <div class="row">
                    
            <?php
                require("connection.php");
                $subjectid = $_GET["subjectid"];
                $materialid = '';
                $materialtype = '';
                $authorid = '';
                $content = '';
                $activecode = $_SESSION["activecode"];
                $user = $_SESSION["user"];

                $sql_list = "SELECT * FROM material WHERE subjectid = '$subjectid'";
                    
                $result_list = mysqli_query($conn,$sql_list);
                while ($row_list = $result_list -> fetch_assoc())
                {
                    $materialid = $row_list["materialid"];
                    $materialtype = $row_list["materialtype"];
                    $content = $row_list["content"];
                    $authorid = $row_list["authorid"];
                    
                    $sql_accountid1 = "SELECT name FROM account WHERE accountid = '$authorid'";
                    $result3 = mysqli_query($conn,$sql_accountid1);
                    $row3 = $result3->fetch_assoc();
                    $authorname = $row3["name"];

                    $sql_subjectname = "SELECT subjectname FROM subjects WHERE subjectid = '$subjectid'";
                    $result4 = mysqli_query($conn,$sql_subjectname);
                    $row4 = $result4->fetch_assoc();
                    $subjectname = $row4["subjectname"];
                    
                                
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="<?php echo $content ?>" class="card-img-top" alt="...">

                        <div class="card-body">
                            <a href="detail_material.php?subjectid=<?php echo $subjectid ?>&materialid=<?php echo $materialid?>"><?php echo $subjectname. " - " . $materialtype ?></a>
                            <p class="card-text"><?php echo $authorname ?></p>
                            <span jsslot="" class="XuQwKc"><span class="GmuOkf"><svg focusable="false" width="24" height="24" viewBox="0 0 24 24" class=" NMm5M"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7.55 0c.14-.15.33-.25.55-.25s.41.1.55.25c.12.13.2.31.2.5 0 .41-.34.75-.75.75s-.75-.34-.75-.75c0-.19.08-.37.2-.5zM19 5v10.79C16.52 14.37 13.23 14 12 14s-4.52.37-7 1.79V5h14zM5 19v-.77C6.74 16.66 10.32 16 12 16s5.26.66 7 2.23V19H5z"></path><path d="M12 13c1.94 0 3.5-1.56 3.5-3.5S13.94 6 12 6 8.5 7.56 8.5 9.5 10.06 13 12 13zm0-5c.83 0 1.5.67 1.5 1.5S12.83 11 12 11s-1.5-.67-1.5-1.5S11.17 8 12 8z"></path></svg></span></span>
                            <span jsslot="" class="XuQwKc"><span class="GmuOkf"><svg focusable="false" width="24" height="24" viewBox="0 0 24 24" class=" NMm5M"><path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z"></path></svg></span></span>
            <?php
                if ($_SESSION["activecode"] == 0){
            ?>    
                            <a href="delete_material.php?materialid=<?php echo $materialid ?>" class="btn btn-info btn-sm">Delete</a>
                            
                <?php } else if (($_SESSION["activecode"] != 0)) {
                ?>
                            <a href="delete_material.php?materialid=<?php echo $materialid ?>" class="btn btn-info btn-sm" <?php echo $hidden ?>>Delete</a>
                    <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
        </div>
    </div>
</div>

</body>
</html>