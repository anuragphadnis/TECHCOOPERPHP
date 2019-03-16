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
    <title>Machine Tracking</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device-width, initial-scale = 1">

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="style5.css">
</head>
<body>
                  <div class="wrapper">
       <?php if (isset($_SESSION['id'])&&$_SESSION['role']=='1') include "navbar.php";
                else if(isset($_SESSION['id'])&&$_SESSION['role']=='2')  include "navbar_faculty.php";
                else include "navbar_tech.php";?>

    <div class="container-fluid row" id="container">

    <div class="page-header">
    <h1>JOB ROLES</h1>
    </div>
    <?php

        if ( isset($_SESSION['success']))
        {
            echo('<p style="color: green;">'.$_SESSION['success']."</p>\n");
                unset($_SESSION['success']);
        }
        if ( isset($_SESSION['error']))
        {
            echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
            unset($_SESSION['error']);
        }
        //echo('<p><a href="logout.php">Logout</a></p>');
        $stmtcnt = $pdo->query("SELECT COUNT(*) FROM job ");
        $row = $stmtcnt->fetch(PDO::FETCH_ASSOC);

        if($row['COUNT(*)']!=='0')
        {
            $i=1;
            $stmtread = $pdo->query("SELECT * FROM job ORDER BY job_id");
            echo ("<table class=\"table table-striped\">
                <tr> <th>S.no.</th><th>Job Name</th><th>Job Specification</th><th>Pay Structure</th><th>Leaves</th> </tr>");
            while ( $row = $stmtread->fetch(PDO::FETCH_ASSOC) )
            {
                echo ("<tr>");
                echo ("<td>");
                echo($i);
                echo("</td>");
                echo ("<td>");
                echo(htmlentities($row['job_name']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['job_specification']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['pay_structures']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['leaves']));
                echo ("</td>");
                $i++;
            }
            echo('</table>');
        }
    ?>

    </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
