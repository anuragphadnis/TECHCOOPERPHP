<?php
    session_start();
    require_once "pdo.php";
    if ( ! isset($_SESSION['id']) )
    {
        die('ACCESS DENIED');
    }
    if ( isset($_POST['cancel']) )
    {
        header('Location: home.php');
        return;
    }
    if ( isset($_POST['jt']) && isset($_POST['js']) && isset($_POST['ps']) && isset($_POST['l']))
    {
        if ( strlen($_POST['jt'])<1 || strlen($_POST['js'])<1 || strlen($_POST['ps'])<1 || strlen($_POST['l'])<1)
        {
            $_SESSION['failure'] = "All fields are required";
            header("Location: updatejobroles.php?job_name=".$_REQUEST['job_name']);
            return;
        }

        {
            $stmtreadd = $pdo->prepare("SELECT * FROM job where job_name = :xyz");
            $stmtreadd->execute(array(":xyz" => $_GET['job_name']));
            $roww = $stmtreadd->fetch(PDO::FETCH_ASSOC);
            $sql = "UPDATE job SET job_name = :jt, job_specification = :js, pay_structures= :ps, leaves = :l WHERE job_id = :job_id";
            $stmtwrite = $pdo->prepare($sql);
            $stmtwrite->execute(array(
                ':jt' => $_POST['jt'],
                ':js' => $_POST['js'],
                ':ps' => $_POST['ps'],
                ':l' => $_POST['l'],
                ':job_id' => $roww['job_id']));
            $_SESSION['success'] ="Job Role Updates Successfully";
            header('Location: home.php');
            return;
        }
    }
    $stmtread = $pdo->prepare("SELECT * FROM job where job_name = :xyz");
    $stmtread->execute(array(":xyz" => $_GET['job_name']));
    $row = $stmtread->fetch(PDO::FETCH_ASSOC);
    if ( $row === false )
    {
        $_SESSION['error'] = 'No such Job role exist';
        header( 'Location: home.php' ) ;
        return;
    }
    $jt = htmlentities($row['job_name']);
    $js = htmlentities($row['job_specification']);
    $ps = htmlentities($row['pay_structures']);
    $l = htmlentities($row['leaves']);
    $jid = $row['job_id'];
?>

<html>
<head>
    <title>HRMS</title>
</head>
<body>
    <h1>UPDATE JOB ROLE</h1>
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
    ?>
    <div class="col-xs-5">
    <form method="POST" action="updatejobroles.php?job_name=<?= $jt ?>">

    <div class="input-group">
    <span class="input-group-addon">Job Title </span>
    <input type="text" name="jt" required class="form-control" value="<?= $jt ?>"> </div><br/>

    <div class="input-group">
    <span class="input-group-addon">Job Specification </span>
    <input type="text" name="js" required class="form-control" value="<?= $js ?>"> </div><br/>

    <div class="input-group">
    <span class="input-group-addon">Pay Structure </span>
    <input type="text" name="ps" required class="form-control" value="<?= $ps ?>"> </div><br/>

    <div class="input-group">
    <span class="input-group-addon">No. of leaves allowed </span>
    <input type="text" name="l" required class="form-control" value="<?= $l ?>"> </div><br/>

    <input type="submit" value="Update Job Role" class="btn btn-info">
    <a class ="link-no-format" href="home.php"><div class="btn btn-my">Cancel</div></a>
    </form>

</div>

</body>
</html>
