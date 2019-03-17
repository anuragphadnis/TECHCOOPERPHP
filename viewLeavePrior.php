<?php
  session_start();
  require_once("pdo.php");
  $now = new DateTime();
  $now->format('Y-m-d H:i:s');
  if(isset($_SESSION['id']))
  {
    $read =$pdo->prepare("SELECT * FROM Attendance WHERE member_id = :id");
    $read -> execute(array(":id"=>$_GET['id']));

  }
?>
<html>
<head>
    <title>Worst Hackathon</title>
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
                else if(isset($_SESSION['id'])&&$_SESSION['role']=='1')  include "navbar_user.php";
                else include "navbar_user.php";?>
      <div class="container-fluid row" id="content">
        <div class="page-header">
          <table class="table table-striped">
          <thead>
            <tr>
              <th>Working Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while($data = $read->fetch(PDO::FETCH_ASSOC))
            {
                echo"
              <tr>
                <td>".$data['working_date']."</td>
                <td>PRESENT</td>
              </tr>";

            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <a href="viewLeaveApplication.php"><button class="btn btn-primary" type="button">Back</button></a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
