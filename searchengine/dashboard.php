<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }

   $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
   function generate_string($input, $strength = 16) {
       $input_length = strlen($input);
       $random_string = '';
       for($i = 0; $i < $strength; $i++) {
           $random_character = $input[mt_rand(0, $input_length - 1)];
           $random_string .= $random_character;
       }
    
       return $random_string;
   }
   require("connection.php");
   $user = $_SESSION['user'];
   $hidden = '';
   $admin_only = 'hidden';
   $sql = "SELECT activated FROM account WHERE username = '$user'";
   $result = mysqli_query($conn,$sql);
   

   $row = $result->fetch_assoc();
   $_SESSION["activecode"] = $row["activated"];
   if ($_SESSION["activecode"] == 2){
        $hidden = 'hidden';
    } else if ($_SESSION["activecode"] == 1){
        $hidden = 'hidden';
    } 

    if ($_SESSION["activecode"] == 0){
        $admin_only = '';
    }
?>



<!DOCTYPE html>

<html lang="en">
<head>
    <title>VilePanion</title>
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
    <a class="navbar-brand" href="dashboard.php">VilePanion</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item active col-lg-3" <?php echo $hidden ?>>
                <a class="nav-link button" data-toggle="modal" href="#addMaterialModal">Add Material</a>
            </li>
            <li class="nav-item active col-lg-3">
                <a class="nav-link button" data-toggle="modal" href="#surveyModal">Survey</a>
            </li>
            <li class="nav-item active col-lg-6">
                <form action="dashboard.php" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-3 col-sm-12 p-0">
                                    <select class="form-control search-slt" id="selectType" name="selectType">
                                        <option value="None">Type of Learners</option>
                                        <option value="Virtual">Virtual Learners</option>
                                        <option value="Aural">Aural Learners</option>
                                        <option value="Read/Write">Read/Write Learners</option>
                                        <option value="Kinesthetic">Kinesthetic Learners</option>
                                    </select> 
                                </div>
                                    <div class="col-lg-5 col-md-3 col-sm-12 p-0">
                                    <select class="form-control search-slt" id="selectSubject" name="selectSubject">
                                        <option value="None">Select Subject</option>                                    
                                        <option value="Math">Math</option> 
                                        <option value="Physics">Physics</option>                                    
                                        <option value="Chemistry">Chemistry</option>                                    
                                        <option value="Literature">Literature</option>                                    
                                    </select>
                                </div>
                                
                                <div class="col-lg-1 col-md-3 col-sm-12 p-0">
                                    <button type="submit" name="submit" value="Search" class="btn btn-primary wrn-btn">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </li>
        </ul>

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
                require("connection.php");
                $sql_list = "SELECT * FROM subjects";
                $result_list = mysqli_query($conn,$sql_list);
                while ($row_list = $result_list -> fetch_assoc()){
                    $subjectid = $row_list["subjectid"];
                    $subjectname = $row_list["subjectname"];
            ?>
                <li>
                    <a href="material.php?subjectid=<?php echo $subjectid ?>"><?php echo $subjectname ?></a>
                </li>
            <?php } ?>
        </ul>

    </nav>

    <!-- Main Start-->
    <div class="container" style="margin-top: 60px">

        <div class="row">
            
            <?php
                if (isset($_POST['submit'])) {
                    $materialtype = htmlspecialchars($_POST['selectType']);
                    $subjectname = htmlspecialchars($_POST['selectSubject']);

                if ($materialtype && $subjectname != "None"){
                    require("connection.php");
                    $materialid = '';
                    $subjectid = '';
                    $authorid = '';
                    $content = '';
                    $activecode = $_SESSION["activecode"];
                    $user = $_SESSION["user"];
    
                    $sql_subjectid = "SELECT subjectid FROM subjects WHERE subjectname = '$subjectname'";
                    $result4 = mysqli_query($conn,$sql_subjectid);
                    $row4 = $result4->fetch_assoc();
                    $subjectid = $row4["subjectid"];
    
                    $sql_list = "SELECT * FROM material WHERE subjectid='$subjectid' AND materialtype='$materialtype'";
                    $result_list = mysqli_query($conn,$sql_list);
                    while ($row_list = $result_list -> fetch_assoc())
                    {   
                        $materialid = $row_list["materialid"];
                        $subjectid = $row_list["subjectid"];
                        $content = $row_list["content"];
                        $authorid = $row_list["authorid"];
                        
                        $sql_accountid1 = "SELECT name FROM account WHERE accountid = '$authorid'";
                        $result3 = mysqli_query($conn,$sql_accountid1);
                        $row3 = $result3->fetch_assoc();
                        $authorname = $row3["name"];
                }                         
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
                if (($_SESSION["activecode"] == 0)){
            ?>    
                            <a href="delete_material.php?materialid=<?php echo $materialid ?>" class="btn btn-info btn-sm">Delete</a>
                            
                <?php } else {
                ?>
                            <a href="delete_material.php?materialid=<?php echo $materialid ?>" class="btn btn-info btn-sm" <?php echo $hidden ?>>Delete</a>
                    <?php } ?>
                        </div>
                    </div>
                </div>
            <?php
                } }
                else {
                    require("connection.php");
                    $materialid = '';
                    $subjectid = '';
                    $materialtype = '';
                    $authorid = '';
                    $content = '';
                    $activecode = $_SESSION["activecode"];
                    $user = $_SESSION["user"];

                    $sql_list = "SELECT * FROM material";
                    $result_list = mysqli_query($conn,$sql_list);
                    while ($row_list = $result_list -> fetch_assoc())
                    {   
                        $materialid = $row_list["materialid"];
                        $subjectid = $row_list["subjectid"];
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
                if (($_SESSION["activecode"] == 0)){
            ?>      
                            <a href="delete_material.php?materialid=<?php echo $materialid ?>" class="btn btn-info btn-sm">Delete</a>
                            
                <?php } else {
                ?>
                            <a href="delete_material.php?materialid=<?php echo $materialid ?>" class="btn btn-info btn-sm" <?php echo $hidden ?>>Delete</a>
                    <?php } ?>
                        </div>
                    </div>
                </div>
            <?php }
                } 
                 ?>
            
        </div>
    </div>
</div>
    <!-- Main End-->

<!-- Survey Clone Start -->
<!-- Modal Start -->
<div class="modal fade" id="surveyModal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Do this survey</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <h6>Do this to find out your learners type</h6>
                <iframe src="https://vark-learn.com/the-vark-questionnaire/the-vark-questionnaire-for-younger-people/?fbclid=IwAR3FOlbe2C7HN-MQxUYKmzPSjvVfq8bxElsM2M9Y9OBzspzYP4qJ0El_u4c"
                    width="100%" height="500px" id="iframe1" marginheight="0" frameborder="0"></iframe>

            </div>
        </div>
    </div>
</div>
<!-- Modal End -->
<!-- Survey Clone End -->

<!-- Add Material Start -->
<!-- Modal Start -->
<div class="modal fade" id="addMaterialModal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Material</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="subjectname">Subject Name</label>
                        <input required class="form-control" type="text" placeholder="Subject Name" name="subjectname">
                    </div>
                    <div class="form-group">
                        <label for="classroom">Material Type</label>
                        <input required class="form-control" type="text" placeholder="Material Type" name="materialtype">
                    </div>
                    <br><br>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-info btn-sm" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->
        <?php

            $subjectid = '';
            $materialid = '';
            $subjectname = '';
            $materialtype = '';
            $content = '';
            $user = $_SESSION["user"];

            require("connection.php");
            
            if (isset($_POST['subjectname']) && isset($_POST['materialtype']))
            {
                $subjectname = $_POST['subjectname'];
                $materialtype = $_POST['materialtype'];
                
                $sql_accountid = "SELECT accountid FROM account WHERE username = '$user'";
                $result1 = mysqli_query($conn,$sql_accountid);
                $row1 = $result1->fetch_assoc();
                $accountid = $row1["accountid"];

                $sql_subjectid = "SELECT subjectid FROM subjects WHERE subjectname = '$subjectname'";
                $result2 = mysqli_query($conn,$sql_subjectid);
                $row2 = $result2->fetch_assoc();
                $subjectid = $row2["subjectid"];

                // Add material
                $materialid = generate_string($permitted_chars, 5); 
                $content = "http://placehold.it/700x300";
                $sql= "INSERT INTO material(subjectid, materialid, materialtype, authorid, content) VALUES ('$subjectid','$materialid','$materialtype','$accountid','$content')";
                $result = mysqli_query($conn,$sql);
                $sql_materialid = "SELECT materialid FROM material WHERE subjectid = '$subjectid'";
                $result2 = mysqli_query($conn,$sql_materialid);
                $row2 = $result2->fetch_assoc();
                $materialid = $row2["materialid"];

                $sql3= "INSERT INTO classbeloong(materialid, accountid) VALUES ('$materialid','$accountid')";
                $result3 = mysqli_query($conn,$sql3);
            }
        ?>
<!-- Add Material End -->



</body>
</html>