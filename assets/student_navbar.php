<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416       
     
     MAKE SURE THAT STUDENT AND ADMIN ARE SEPARATED                  
-->
<?php include_once '../includes/dbh.inc.php';  ?>
<nav class="navbar">
        <ul class="navbar-nav">
            <li class="welcome-wrapper">
                <a href="../pages/student_dashboard.php" class="welcome">WELCOME</a>
            </li>
        <li class="nav-item">
            <a href="../pages/user_student.php" class="nav-link" >User Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="../pages/application_information.php" class="nav-link">Application Information</a>
        </li>
        <!-- <li class="nav-item">
            <a href="../pages/program_management.php" class="nav-link">Program Management</a>
        </li> -->
        <li class="nav-item">
            <a href="../pages/progress_tracking.php" class="nav-link">Progress Tracking</a>
        </li>
        <li class="nav-item">
            <a href="../pages/documents_student.php" class="nav-link">Documents</a>
        </li>
        <li class="nav-item">
            <div class="btn-wrapper">
                <form action="../includes/logout.php" method="post">
                    <button type="submit" class="logout-btn">LOGOUT</button>
                </form>
            </div>
        <li>
    </ul>
</nav>

<?php
$UIN = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM college_student WHERE UIN = ?");
$stmt->bind_param("i", $UIN);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    header("Location: ../pages/user_student_info.php");
    exit();
}
?>