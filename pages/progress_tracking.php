<?php
include '../assets/header.php'; 
include '../assets/student_navbar.php';
include_once '../includes/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$uin = $_SESSION['user_id'];

// Fetch class enrollments for the logged-in user
$stmtClasses = $conn->prepare("
    SELECT ce.CE_Num, ce.Class_ID, ce.Status, ce.Semester, ce.Year, cl.Name AS ClassName, cl.Description AS ClassDescription 
    FROM Class_Enrollment ce
    INNER JOIN Classes cl ON ce.Class_ID = cl.Class_ID
    WHERE ce.UIN = ?
");
$stmtClasses->bind_param("i", $uin);
$stmtClasses->execute();
$classesResult = $stmtClasses->get_result();
$stmtClasses->close();

// Fetch certification enrollments for the logged-in user
$stmtCerts = $conn->prepare("
    SELECT ce.CertE_Num, ce.Cert_ID, ce.Status, ce.Training_Status, ce.Program_Num, ce.Semester, ce.Year, c.Name AS CertName, c.Description AS CertDescription 
    FROM Cert_Enrollment ce
    INNER JOIN Certification c ON ce.Cert_ID = c.Cert_ID
    WHERE ce.UIN = ?
");
$stmtCerts->bind_param("i", $uin);
$stmtCerts->execute();
$certsResult = $stmtCerts->get_result();
$stmtCerts->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Progress Tracking</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="main-container margin-left-280">
    <?php include '../assets/alerts.php'; ?>

    <!-- Class Enrollments Table -->
    <div class="header">
        <h2>Class Management</h2>
    </div>
    <div class="table-wrapper">
        <div class="flex flex-col align-end min-width-180">
            <button class="add-btn" onclick="window.location.href='insert_class.php'">Insert New Class</button>
        </div>
        <h3>Classes</h3>
        <div class="table-container">
            <table id="classEnrollmentTable">
                <thead>
                    <tr>
                        <th>Class ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Semester</th>
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($classesResult->num_rows > 0) {
                        while ($row = $classesResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['Class_ID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ClassName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ClassDescription']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Semester']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Year']) . "</td>";
                            echo "<td>
                                    <button onclick=\"location.href='view_class.php?CE_Num=" . $row['CE_Num'] . "'\" class='table-btn view-btn'>View</button>
                                    <button onclick=\"location.href='insert_class.php?CE_Num=" . $row['CE_Num'] . "'\" class='table-btn edit-btn'>Edit</button>
                                    <form action='process_class.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this class enrollment?\");'>
                                        <input type='hidden' name='action' value='delete'>
                                        <input type='hidden' name='type' value='class'>
                                        <input type='hidden' name='CE_Num' value='" . $row['CE_Num'] . "'>
                                        <button type='submit' class='table-btn delete-btn'>Delete</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No class enrollments found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Certification Enrollments Table -->
    <div class="header">
        <h2>Certification Management</h2>
    </div>
    <div class="table-wrapper">
        <div class="flex flex-col align-end min-width-180">
            <button class="add-btn" onclick="window.location.href='insert_cert.php'">Insert New Certification</button>
        </div>
        <h3>Certifications</h3>
        <div class="table-container">
            <table id="certEnrollmentTable">
                <thead>
                    <tr>
                        <th>Certification ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Semester</th>
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($certsResult->num_rows > 0) {
                        while ($row = $certsResult->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['Cert_ID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['CertName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['CertDescription']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Semester']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Year']) . "</td>";
                            echo "<td>
                                    <button onclick=\"location.href='view_cert.php?CertE_Num=" . $row['CertE_Num'] . "'\" class='table-btn view-btn'>View</button>
                                    <button onclick=\"location.href='edit_cert.php?CertE_Num=" . $row['CertE_Num'] . "'\" class='table-btn edit-btn'>Edit</button>
                                    <form action='process_cert.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this certification enrollment?\");'>
                                        <input type='hidden' name='action' value='delete'>
                                        <input type='hidden' name='type' value='cert'>
                                        <input type='hidden' name='CertE_Num' value='" . $row['CertE_Num'] . "'>
                                        <button type='submit' class='table-btn delete-btn'>Delete</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No certification enrollments found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../js/index.js"></script>
</body>
</html>