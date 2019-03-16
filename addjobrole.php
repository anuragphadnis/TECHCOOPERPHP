<?php
    session_start();
    require_once "pdo.php";
    if( !isset($_SESSION['id']) )
    {
        die('ACCESS DENIED');
    }
    if( $_SESSION['role'] != '1' )
    {
        die('ACCESS DENIED');
    }
    if(isset($_POST['cancel']))
    {
        header("Location: home.php");
        return;
    }

    if(isset($_POST['jt']) )
    {
        if ( strlen($_POST['jt']) < 1 || strlen($_POST['js']) < 1 || strlen($_POST['ps']) < 1 || strlen($_POST['l']) < 1)
        {
            $_SESSION['error'] = "All Fields are required";
            header('Location: addjobrole.php');
            return;
        }
        else
        {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM job WHERE job_name = :name');
            $stmt->execute(array(':name' => $_POST['jt']));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['COUNT(*)'] !== '0')
            {
                $_SESSION['error'] = "This Job already exists";
                header('Location: addjobrole.php');
                return;
            }
            else
            {
                $stmt = $pdo->prepare('INSERT INTO job (job_name, job_specification, pay_structures, leaves) VALUES (:jt, :js, :ps, :l)');
                $stmt->execute(array(':jt' => $_POST['jt'],':js' =>$_POST['js'], ':ps' =>$_POST['ps'], ':l' =>$_POST['l']));
                $_SESSION['success'] = "Job Role Added Successfully";
                    header('Location: home.php');
                    return;
            }

        }
    }
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
                else if(isset($_SESSION['id'])&&$_SESSION['role']=='1')  include "navbar_faculty.php";
                else include "navbar_tech.php";?>
      <div class="container-fluid row" id="content">
        <div class="page-header">
        <h1>ADD JOB ROLE</h1>
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
        <div class="col-xs-5">
        <form method="POST" action="addjobrole.php">

        <div class="input-group">
        <span class="input-group-addon">Job Title </span>
        <input type="text" name="jt" required class="form-control" placeholder="Specification of Hardware"> </div><br/>

        <div class="input-group">
        <span class="input-group-addon">Job Specification </span>
        <input type="text" name="js" required class="form-control" placeholder="Specification of Hardware"> </div><br/>

        <div class="input-group">
        <span class="input-group-addon">Pay Structure </span>
        <input type="text" name="ps" required class="form-control" placeholder="Specification of Hardware"> </div><br/>

        <div class="input-group">
        <span class="input-group-addon">No. of leaves allowed </span>
        <input type="text" name="l" required class="form-control" placeholder="Specification of Hardware"> </div><br/>

        <input type="submit" value="Add Job Role" class="btn btn-info">
        <a class ="link-no-format" href="home.php"><div class="btn btn-my">Cancel</div></a>
        </form>

    </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
