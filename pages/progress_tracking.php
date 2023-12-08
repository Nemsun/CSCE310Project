<?php
include '../assets/header.php'; 
include '../assets/student_navbar.php';
include_once '../includes/dbh.inc.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Program Management</title>
    <style>
        .program-number {
            width: 10%;
        }
    </style>
</head>

<div class="main-container margin-left-280">
    <?php include '../assets/alerts.php';?>
    <div class="header">
        <h2>Classes</h2>
    </div>
    <div class="table-wrapper">
        <div class="flex flex-col align-end min-width-180">
            <button class="add-btn" onclick="window.location.href='add_program.php'">Add Class</button>
        </div>
        <h3>Classes</h3>
        <?php
            if (isset($_SESSION['user_id'])) {
                $userUin = $_SESSION['user_id'];
                $stmt = $conn->prepare("SELECT * FROM student_class_view WHERE UIN = ?");
                $stmt->bind_param("i", $userUin);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
            } else {
                echo "User is not logged in.";
            }
        ?>
        <div class="table-container">
            <table id="programTable">
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Semester</th>
                        <th>Year</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ClassName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ClassDescription']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Semester']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Year']) . "</td>";
                            echo "<td>";
                            echo "<button onclick=\"location.href='edit_class.php?Class_ID=" . $row['Class_ID'] . "'\" class=\"table-btn edit-btn\">Edit</button>";
                            echo "</td>";
                            echo "<td>";
                            echo "<form action=\"../includes/process_class.php\" method=\"POST\">";
                            echo "<input type=\"hidden\" name=\"class_id\" value=\"" . $row['Class_ID'] . "\">";
                            echo "<button type=\"submit\" name=\"delete_class\" class=\"table-btn delete-btn\" onclick=\"return confirm('Are you sure you want to delete this class?');\">Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No classes found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="table-wrapper">
    <div class="flex flex-col align-end min-width-180">
        <button class="add-btn" onclick="window.location.href='add_certification.php'">Add Certification</button>
    </div>
        <h3>Certifications</h3>
        <?php
            if (isset($_SESSION['user_id'])) {
                $userUin = $_SESSION['user_id'];
                $stmt = $conn->prepare("SELECT * FROM user_certification_view WHERE UIN = ?");
                $stmt->bind_param("i", $userUin);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
            } else {
                echo "User is not logged in.";
            }
        ?>
        <div class="table-container">
            <table id="certificationTable">
                <thead>
                    <tr>
                        <th>Certification Name</th>
                        <th>Description</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Training Status</th>
                        <th>Semester</th>
                        <th>Year</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($result) && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['CertName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['CertDescription']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Level']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Training_Status']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Semester']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Year']) . "</td>";
                            echo "<td><button onclick=\"location.href='edit_certification.php?CertE_Num=" . $row['CertE_Num'] . "'\" class=\"table-btn edit-btn\">Edit</button></td>";
                            echo "<td>";
                            echo "<form action=\"../includes/process_certification.php\" method=\"POST\">";
                            echo "<input type=\"hidden\" name=\"certe_num\" value=\"" . $row['CertE_Num'] . "\">";
                            echo "<button type=\"submit\" name=\"delete_certification\" class=\"table-btn delete-btn\" onclick=\"return confirm('Are you sure you want to delete this certification?');\">Delete</button>";
                            echo "</form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No certifications found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


</div>

<script src="../js/index.js"></script>
<script src="../js/app.js"></script>