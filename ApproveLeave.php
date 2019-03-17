<?php
  require_once("pdo.php");
  if(isset($_GET['id']))
  {
    $data = $pdo->prepare(
      "UPDATE leaves
      SET approved = 1
      WHERE leave_id =:id
      ");
    $data->execute(array(":id"=>$_GET['id']));
    header("Location:viewLeaveApplication.php");
  }
?>
