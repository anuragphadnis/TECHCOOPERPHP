<?php
  session_start();
  require_once("pdo.php");
  $now = new DateTime();
  $now->format('Y-m-d H:i:s');


  $read=$pdo->query("SELECT * FROM leaves JOIN Lead on leaves.employe_id = Lead.member_id AND leaves.approved=0");
?>
<html>
<head>
    <title>Hackathon</title>
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
              <th>Name</th>
              <th>Starting Date</th>
              <th>Ending Date</th>
              <th>Leave Type</th>
              <th>Short Description</th>
              <th>Approve/Reject</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while($data = $read->fetch(PDO::FETCH_ASSOC))
            {
              $data_member=$pdo->prepare("SELECT * FROM Members WHERE member_id = :id");
              $data_member->execute(array(":id"=>$data['member_id']));
              $data_member = $data_member->fetch(PDO::FETCH_ASSOC);
              $data_leave = $pdo->prepare("SELECT * FROM leave_type WHERE leave_type_id = :id");
              $data_leave->execute(array(":id"=>$data['leave_type']));
              $data_leave =$data_leave->fetch(PDO::FETCH_ASSOC);
                echo"
              <tr>
                <td><a class='link-black' href='viewLeavePrior.php?id=".$data['member_id']."'>".$data_member['name']."</a></td>
                <td>".$data['date_from']."</td>
                <td>".$data['date_to']."</td>
                <td>".$data_leave['leave_name']."</td>
                <td>".$data['short_description']."</td>
                <td><a class='link-black' href='ApproveLeave.php?id=".$data['leave_id']."'>Approve</a>/<a class='link-black' href='RejectLeave.php?id=".$data['leave_id']."'>Reject</a></td>
              </tr>";

            }
            ?>
          </tbody>
        </table>
      </div>
      <button class="btn btn-primary" type="button">Back</button>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
