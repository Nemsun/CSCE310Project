<?php 
// Include necessary files and establish database connection
include '../assets/user_admin_header.php'; 
include '../assets/navbar.php';
include_once '../includes/dbh.inc.php';

// Retrieve program number from URL parameter
$programNumber = isset($_GET['Program_Num']) ? intval($_GET['Program_Num']) : 0; // Default to 0 if not provided

// Prepare and execute the SQL query
$query = "SELECT * FROM ProgramDetailedReport WHERE Program_Num = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $programNumber); // Bind the integer type parameter
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Program Report</title>
    <!-- Add any additional CSS or meta tags here -->
</head>
<body>
    <div class="main-container margin-left-280">
        <?php
        if ($result && $result->num_rows > 0) {
            // Fetch the data for the specified program
            $row = $result->fetch_assoc();
            echo "<h2>Program: " . htmlspecialchars($row['Program_Name']) . "</h2>";
            echo "<p>Total Students: " . $row['Total_Students'] . "</p>";
            echo "<p>Completed Certifications: " . $row['Completed_Certifications'] . "</p>";
            echo "<p>Foreign Language Courses: " . $row['Foreign_Language_Courses'] . "</p>";
            echo "<p>Cryptography Courses: " . $row['Cryptography_Courses'] . "</p>";
            echo "<p>Data Science Courses: " . $row['Data_Science_Courses'] . "</p>";
            echo "<p>Other Courses: " . $row['Other_Courses'] . "</p>";
            echo "<p>Enrolled DoD Training: " . $row['Enrolled_DoD_Training'] . "</p>";
            echo "<p>Completed DoD Training: " . $row['Completed_DoD_Training'] . "</p>";
            echo "<p>Passed DoD Exam: " . $row['Passed_DoD_Exam'] . "</p>";
            echo "<p>Minority Participation: " . $row['Minority_Participation'] . "</p>";
            echo "<p>K-12 Summer Camp Enrollments: " . $row['K12_Summer_Camp_Enrollments'] . "</p>";
            echo "<p>Accepted Federal Internships: " . $row['Accepted_Federal_Internships'] . "</p>";
            echo "<p>Student Majors: " . htmlspecialchars($row['Student_Majors']) . "</p>";
        } else {
            echo "<p>No data found for Program Number: $programNumber</p>";
        }
        ?>
    </div>

    <?php
    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
