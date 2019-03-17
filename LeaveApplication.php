<?php
  session_start();
  require_once("pdo.php");
  $now = new DateTime();
  $now->format('Y-m-d H:i:s');
  if(isset($_SESSION['id']))
  {
    $read =$pdo->prepare("SELECT * FROM Attendance WHERE member_id = :id");
    $read -> execute(array(":id"=>$_SESSION['id']));
    $leaveNameData = $pdo->query("SELECT * FROM leave_type");
  }
  if(isset($_POST['starting_date'])&&isset($_POST['ending_date'])&&isset($_POST['desc']))
  {
    $data = $pdo->prepare("INSERT INTO leaves
    (employe_id,short_description,date_from,date_to,leave_type)
    VALUES
    (:id , :description ,:start_date,:end_date,:leave_type)
    ");
    $data->execute(array(
      ":id"=>$_SESSION['id'],
      ":description"=>$_POST['desc'],
      ":start_date"=>$_POST['starting_date'],
      ":end_date"=>$_POST['ending_date'],
      ":leave_type"=>$_POST['leave_type']
  ));
  }
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
          else if(isset($_SESSION['id'])&&$_SESSION['role']=='1')  include "navbar_faculty.php";
          else include "navbar_user.php";?>
     <div class="container-fluid row" id="content">

  <div class="page-header">
  <h1>TO-DO...</h1>
  </div>

  <?php
      if ( isset($_SESSION['success']))
      {
          echo('<p style="color: green;">'.$_SESSION['success']."</p>");
          unset($_SESSION['success']);
      }
      if ( isset($_SESSION['error']))
      {
          echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
          unset($_SESSION['error']);
      }
?>
      <form method="POST"  class="col-xs-5">

      <div class="form-group">
      <span class="input-group-addon">Type of Leave</span>
      <select name="leave_type" class="form-control">
      <?php
        while($data = $leaveNameData->fetch(PDO::FETCH_ASSOC))
        {
            echo "<option value =".$data['leave_type_id'].">".$data['leave_name']."</option>";
        }
      ?>
      </select>
      </div>
      <div class="input-group">
      <span class="input-group-addon">Date (From)</span>
      <input type="date" name="starting_date" required="" class="form-control" placeholder="Enter Starting Date " id="Mid"> </div><br/>

      <div class="input-group">
      <span class="input-group-addon">Date (To)</span>
      <input type="date" name="ending_date" required="" class="form-control" placeholder="Enter Ending Date " id="Mid"> </div><br/>

      <div class="input-group">
      <span class="input-group-addon">Short Description</span>
      <input type="text" name="desc" required="" class="form-control" placeholder="Enter Description" id="Mid"> </div><br/>

      <input type="submit" value="Apply for Leave" class="btn btn-info">
      <a class ="link-no-format" href="home.php"><div class="btn btn-my">Cancel</div></a>

      </form>

    </div>
  </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
