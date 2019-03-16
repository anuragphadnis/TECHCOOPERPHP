<?php
    session_start();
    if( !isset($_SESSION['id']) )
    {
        die('ACCESS DENIED');
    }
    if( $_SESSION['role'] != '1' )
    {
        die('ACCESS DENIED');
    }
    require_once "pdo.php";
?>
<html>
<head>
    <title>HRMS</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1">

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="style5.css">
    <style>
        .input-group-addon {
        min-width:150px;
        text-align:left;
    }
    </style>
</head>
<body>
            <div class="wrapper">
     <?php if (isset($_SESSION['id'])&&$_SESSION['role']=='1') include "navbar.php";
                else if(isset($_SESSION['id'])&&$_SESSION['role']=='2')  include "navbar_faculty.php";
                else include "navbar_tech.php";?>
    <div class="container-fluid row" id="container">
    <div class="page-header">
    <h1>UPDATE JOB ROLES</h1>
    </div>
    <?php
        if ( isset($_SESSION['error']) )
        {
            echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
            unset($_SESSION['error']);
        }
        if ( isset($_SESSION['success']))
        {
            echo('<p style="color: green;">'.$_SESSION['success']."</p>\n");
            unset($_SESSION['success']);
        }
    ?>

    <form method="GET" action="updatejobroles.php" class="col-xs-5">

    <div id="error" style="color: red; margin-left: 90px; margin-bottom: 20px;"></div>
    <div class="input-group">
    <span class="input-group-addon">Job Name </span>
    <input type="text" name="job_name" required class="form-control" id="job_name" placeholder="Computer No. (only integers)"> </div><br/>


    <input type="submit" value="Update Job" class="btn btn-info">
        <a class ="link-no-format" href="home.php"><div class="btn btn-my">Cancel</div></a>
    </form>

    </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript"src="script.js"></script>
</body>
</html>
