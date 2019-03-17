<?php
    session_start();
    require_once "pdo.php";
    if( !isset($_SESSION['id']) )
    {
        die('ACCESS DENIED');
    }
    if( $_SESSION['role'] <> '1' )
    {
        die('ACCESS DENIED');
    }
    if(isset($_POST['cancel']))
    {
        header("Location: home.php");
        return;
    }
    $jobNameData = $pdo->query("SELECT * FROM job WHERE 1");
    $salt='new_ton56*';

    if(isset($_POST['it']) )
    {
        if ( strlen($_POST['it']) < 1 || strlen($_POST['ae']) < 1 || strlen($_POST['ot']) < 1 || strlen($_POST['com']) < 1)
        {
            $_SESSION['error'] = "All Fields are required";
            header('Location: timesheet.php');
            return;
        }
        else
        {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM time_sheet WHERE employee_id = :id AND sheet_date = :sd');
            $stmt->execute(array(':id' => $_SESSION['id'], ':sd' => date('Y-m-d')));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['COUNT(*)'] !== '0')
            {
                $_SESSION['error'] = "You already did Entry Today";
                header('Location: timesheet.php');
                return;
            }

            $stmt = $pdo->prepare('INSERT INTO `time_sheet`
                ( `employee_id`, `sheet_date`,  `incourse_time`, `outof_course_time`, `compensation`, `additional_expenses`)
                VALUES
                (:eid, :sd, :it,:ot, :com, :ae)');
            $stmt->execute(array(':eid' => $_SESSION['id'], ':sd' => date('Y-m-d'), ':it' => $_POST['it'], ':ot' => $_POST['ot'], ':com' => $_POST['com'], ':ae' => $_POST['ae']));

            $_SESSION['success'] = "Time Sheet Filled Successfully";
            header('Location: home.php');
            return;
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
                else if(isset($_SESSION['id'])&&$_SESSION['role']=='2')  include "navbar_faculty.php";
                else include "navbar_tech.php";?>
      <div class="container-fluid row" id="content">
        <div class="page-header">
    <h1>ENTER TIMESHEET</h1>
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

    <form method="POST" action="timesheet.php"  class="col-xs-5">

    <div class="form-group">
    <div class="input-group">
    <span class="input-group-addon">Incourse Time</span>
    <input type="text" name="it" required="" class="form-control" placeholder="Enter Employee ID" id="Mid" onchange="labs('Mid')"> </div><br/>

    <div class="input-group">
    <span class="input-group-addon">Outcourse Time</span>
    <input type="text" name="ot" required="" class="form-control" id="fname" placeholder="Name"> </div><br/>

    <div class="input-group">
    <span class="input-group-addon">Compensation</span>
    <input type="text" name="com" required="" class="form-control" placeholder="min. 8 characters" id="npswrd" > </div><br/>

    <div class="input-group">
    <span class="input-group-addon">Additional Expanses</span>
    <input type="text" required="" name="ae" class="form-control" placeholder="min. 8 characters" id="cpswrd"> </div><br/>

    <input type="submit" value="add timestamp" class="btn btn-info">
    <a class ="link-no-format" href="home.php"><div class="btn btn-my">Cancel</div></a>
    </form>

    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
