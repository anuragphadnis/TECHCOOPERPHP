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

    $salt='new_ton56*';

    if(isset($_POST['id']) )
    {
        if ( strlen($_POST['id']) < 1 || strlen($_POST['name']) < 1 || strlen($_POST['pass']) < 1 || strlen($_POST['c_pass']) < 1)
        {
            $_SESSION['error'] = "All Fields are required";
            header('Location: addmember.php');
            return;
        }
        else
        {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM Members WHERE id = :id AND role = :role');
            $stmt->execute(array(':id' => $_POST['id'], ':role' => $_POST['role']));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['COUNT(*)'] !== '0')
            {
                $_SESSION['error'] = "This ID already exists";
                header('Location: addmember.php');
                return;
            }

            if($_POST['pass'] === $_POST['c_pass'])
            {
                if(strlen($_POST['pass'])<8)
                {
                    $_SESSION['error'] = "Password must be atleast 8 character long";
                    header('Location: addmember.php');
                    return;
                }
                else
                {
                    //`address`, `ph`, `email`, `bio`, `image`, `education`, `experience`,
                    // NULL, NULL, NULL, NULL, NULL, NULL, NULL,
                    $check = hash('md5', $salt.$_POST['pass']);
                    $stmt = $pdo->prepare('INSERT INTO `Members`
                        ( `id`, `name`,  `pass`, `role`)
                        VALUES
                        (:id, :fn, :pw,:role)');
                    $stmt->execute(array(':id' => $_POST['id'], ':fn' => $_POST['name'], ':pw' => $check, ':role' => $_POST['role']));

                    $_SESSION['success'] = "Member Added Successfully";
                    header('Location: home.php');
                    return;
                }
            }
            else
            {
                $_SESSION['error'] = "Passwords do not match";
                header('Location: addmember.php');
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
    <?php if (isset($_SESSION['id'])&&$_SESSION['role']=='0') include "navbar.php";
                else if(isset($_SESSION['id'])&&$_SESSION['role']=='1')  include "navbar_faculty.php";
                else include "navbar_tech.php";?>
      <div class="container-fluid row" id="content">
        <div class="page-header">
    <h1>ADD NEW MEMBER</h1>
    </div>
    <div id="error" style="color: red; margin-left: 90px; margin-bottom: 20px;"></div>
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

    <form method="POST" action="addmember.php"  class="col-xs-5">

    <p>Role : &nbsp&nbsp&nbsp
    <input type="radio" name="role" value="1"> HR Manager &nbsp&nbsp&nbsp
    <input type="radio" name="role" value="2" checked> Project Manager &nbsp&nbsp&nbsp
    <input type="radio" name="role" value="3"> Employee
    </p>

    <div class="input-group">
    <span class="input-group-addon">ID</span>
    <input type="text" name="id" required="" class="form-control" placeholder="Enter Employee ID" id="Mid" onchange="labs('Mid')"> </div><br/>

    <div class="input-group">
    <span class="input-group-addon">Name</span>
    <input type="text" name="name" required="" class="form-control" id="fname" onchange="Names('fname')" placeholder="Name"> </div><br/>

    <div class="input-group">
    <span class="input-group-addon">Password</span>
    <input type="password" name="pass" required="" class="form-control" placeholder="min. 8 characters" id="npswrd" onchange="newp('npswrd')"> </div><br/>

    <div class="input-group">
    <span class="input-group-addon">Confirm Password</span>
    <input type="password" required="" name="c_pass" class="form-control" placeholder="min. 8 characters" id="cpswrd" onchange="conp('cpswrd')"> </div><br/>

    <input type="submit" value="Add Member" class="btn btn-info">
    <a class ="link-no-format" href="home.php"><div class="btn btn-my">Cancel</div></a>
    </form>

    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
