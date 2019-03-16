<?php
  session_start();
  require_once("pdo.php");
  $read=$pdo->prepare("SELECT * FROM Members WHERE member_id = :id");
  $read->execute(array(":id"=>$_SESSION['id']));
  $data = $read->fetch(PDO::FETCH_ASSOC);
  if(is_null($data['address']))
    $add="";
  else
    $add = $data['address'];
  if(is_null($data['ph']))
    $cno="";
  else
    $cno = $data['ph'];
  if(is_null($data['bio']))
    $bio="";
  else
    $bio = $data['bio'];
  if(is_null($data['dob']))
    $dob="";
  else
    $dob = $data['dob'];
  if(is_null($data['experience']))
    $expe="";
  else
    $expe = $data['experience'];
  if(is_null($data['education']))
    $edu="";
  else
    $edu = $data['education'];
?>
<html>
<head>
    <title>Machine Tracking</title>
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
        <h1>View Personal Information</h1>
        </div>
        <div id="error" style="color: red; margin-left: 90px; margin-bottom: 20px;">
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
        <form method="POST" >
        <div class="input-group">
          <span class="input-group-addon">Date of Birth:</span>
          <input type="date" name="dob" required class="form-control" placeholder="Date of Birth" id="dob" value = <?php echo $dob;?>>
        </div><br/>
        <div class="input-group">
          <span class="input-group-addon">Address</span>
          <input type="text" name="address" required class="form-control" placeholder="Address" id="add" value = <?php echo $add;?>>
        </div><br/>
        <div class="input-group">
          <span class="input-group-addon">Contact Number</span>
          <input type="text" name="cno" required class="form-control" placeholder="Contact Number" id="add" value = <?php echo $cno;?>>
        </div><br/>
        <div class="input-group">
          <span class="input-group-addon">Bio</span>
          <input type="text" name="bio" required class="form-control" placeholder="BIO" id="bio" value = <?php echo $bio;?>>
        </div><br/>
        <div class="input-group">
          <span class="input-group-addon">Education</span>
          <input type="text" name="education" required class="form-control" placeholder="Education" id="bio" value = <?php echo $edu;?>>
        </div><br/>
        <div class="input-group">
          <span class="input-group-addon">Experience</span>
          <input type="text" name="exp" required class="form-control" placeholder="BIO" id="bio" value = <?php echo $expe;?>>
        </div><br/>
        <div class="input-group">
          <span class="input-group-addon">Profile Image</span>
          <input type="text" name="image" required class="form-control" placeholder="Profile Image" id="bio">
        </div><br/>
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
