<?php
include '../assets/header.php'; 
include '../assets/student_navbar.php';
include_once '../includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Progress Tracking</title>
    <style>
        .program-number {
            width: 10%;
        }
    </style>
</head>

<div class="main-container margin-left-280">
    <?php include '../assets/alerts.php';?>
    <div class="header">
        <h2>Progress Tracking</h2>
    </div>
    <div class="table-wrapper">
        <div class="flex flex-col align-end min-width-180">
            <button class="add-btn" onclick="window.location.href='insert_progress.php'">Insert</button>
        </div>
        <h3>Classes/Certifications</h3>
        <?php
            $stmt = $conn->prepare("SELECT * FROM classes");
            $stmt->execute();
            $result = $stmt->get_result();
            // while ($row = $result->fetch_assoc()){
            //     //Process each row from Classes
            //     echo "Class ID: " . $row['class_id'] . ", Class Name: " . $row['class_name'] . ", Class Description: ". $row['class_description'] . 
            //     ", Class Type: ". $row['class_type'] .;
            // }
            $stmt->close();

            // $stmt2 = $conn->prepare("SELECT * FROM certifications");
            // $stmt2->execute();
            // $result2 = $stmt2->get_result();
            // // Process the results from Certifications
            // while ($row = $result2->fetch_assoc()) {
            //     // Process each row from Certifications
            //     echo "Certification ID: " . $row['certification_id'] . ", Certification Name: " . $row['certification_name'] . 
            //     ", Certification Description: ". $row['certification_description'] . ", Certification Level: ". $row['certification_level'] .;
            // }
            // $stmt2->close();
        ?>
        <div class="table-container">
            <table id="programTable">
                <thead>
                    <tr>
                        <th class="program-number">Class ID</th>
                        <th>Class Name</th>
                        <th>Class Description</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Class_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Class_Name']); ?></td>
                                <td class="description"><?php echo htmlspecialchars($row['Description']); ?></td>
                                <td>
                                    <!-- <button onclick="location.href='../includes/edit_program.php?Program_Num=<?php echo $row['Class_ID']; ?>'" class="table-btn edit-btn">Edit</button> -->
                                    <button onclick="location.href='insert_progress.php?Program_Num=<?php echo $row['Class_ID']; ?>'" class="table-btn edit-btn">Update</button>
                                </td>
                                <td> -->
                                <form action="../includes/delete_progress.php" method="POST">
                                    <input type="hidden" name="class_id" value="<?php echo $row['Class_ID']; ?>">
                                    <button type="submit" name="delete_progress" class="table-btn delete-btn" onclick="return confirm('Are you sure you want to delete this program?');">Delete</button>
                                </form>                                    
                                </td>
                                <td>
                                    <form action="../includes/_program.php" method="POST">
                                        <input type="hidden" name="program_num" value="<?php echo $row['Program_Num']; ?>">
                                        <button type="submit" name="hide_program" class="table-btn hide-btn">Select</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No programs found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../js/index.js"></script>
<script src="../js/app.js"></script>