
<!-- Sidebar Holder -->
<nav id="sidebar">
    <div class="sidebar-header">
        <?php
        if (!isset($_SESSION['id']))
            echo '<a href="index.php"><h3>Machine Tracking</h3></a>';
        else
            echo '<a href="home.php"><h3>Machine Tracking</h3></a>';
        ?>
    </div>

    <ul class="list-unstyled components">
        <p>Menu</p>

         <li class="">
            <a href="#detailsmenu" data-toggle="collapse" aria-expanded="false">Details</a>
            <ul class="collapse list-unstyled" id="detailsmenu">
                <li><a href="ViewUserDetails.php">View Details</a></li>
                <li><a href="userdetailsadd.php">Edit Details</a></li>
            </ul>
        </li>
        <li class="">
           <a href="#attendance" data-toggle="collapse" aria-expanded="false">Attendance</a>
           <ul class="collapse list-unstyled" id="attendance">
               <li><a href="MarkAttendance.php">Mark Attendance</a></li>
               <li><a href="ViewAttendance.php">View Attendance</a></li>
           </ul>
       </li>

       <li class="">

              <li><a href="LeaveApplication.php">Send Leave Application</a></li>
      </li>

        <?php
        if(isset($_SESSION['id']))
        {
            echo "<hr>";
            echo "<li>";
                echo '<a href="logout.php">Logout</a>';
            echo "</li>";
        }
        ?>
         <hr>
    <hr>
    </ul>
</nav>
<div class="container" id="content">
<div class="page-header">
<button type="button" id="sidebarCollapse" class="navbar-btn">
<span></span>
<span></span>
<span></span>
</button>
