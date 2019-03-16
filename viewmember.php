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
       <?php if (isset($_SESSION['id'])&&$_SESSION['role']=='0') include "navbar.php";
                else if(isset($_SESSION['id'])&&$_SESSION['role']=='1')  include "navbar_faculty.php";
                else include "navbar_tech.php";?>

    <div class="container-fluid row" id="container">

    <div class="page-header">
    <h1>MEMBERS</h1>
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
        $stmtcnt = $pdo->query("SELECT COUNT(*) FROM Members ");
        $row = $stmtcnt->fetch(PDO::FETCH_ASSOC);

        if($row['COUNT(*)']!=='0')
        {
            $i=1;
            $stmtread = $pdo->query("SELECT * FROM Members WHERE role<>0 ORDER BY id");
            echo ("<table class=\"table table-striped\">
                <tr> <th>S.no.</th><th>I.D.</th><th>Name</th><th>Address</th><th>Contact</th><th></th><th>Email</th><th>Bio</th><th>Education</th><th>Experience</th> </tr>");
            while ( $row = $stmtread->fetch(PDO::FETCH_ASSOC) )
            {
                echo ("<tr>");
                echo ("<td>");
                echo($i);
                echo("</td>");
                echo ("<td>");
                echo(htmlentities($row['id']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['name']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['address']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['ph']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['email']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['bio']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['education']));
                echo ("</td>");
                echo ("<td>");
                echo(htmlentities($row['experience']));
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
