<?php 
include '../assets/user_admin_header.php'; 
include '../assets/navbar.php';
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
        <h2>Program Management</h2>
    </div>
    <div class="table-wrapper">
        <div class="flex flex-col align-end min-width-180">
            <button class="add-btn" onclick="window.location.href='add_program.php'">Add Program</button>
        </div>
        <h3>Programs</h3>
        <?php
            $stmt = $conn->prepare("SELECT * FROM Programs");
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        ?>
        <div class="table-container">
            <table id="programTable">
                <thead>
                    <tr>
                        <th class="program-number">Program Number</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Active</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $activeStatus = $row['IsActive'] ? 'Yes' : 'No';
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Program_Num']); ?></td>
                                <td><?php echo htmlspecialchars($row['Name']); ?></td>
                                <td class="description"><?php echo htmlspecialchars($row['Description']); ?></td>
                                <td><?php echo $activeStatus; ?></td>
                                <td>
                                    <button onclick="location.href='add_program.php?Program_Num=<?php echo $row['Program_Num']; ?>'" class="table-btn edit-btn">Edit</button>
                                </td>
                                <td>
                                    <form action="../includes/process_program.php" method="POST">
                                        <input type="hidden" name="program_num" value="<?php echo $row['Program_Num']; ?>">
                                        <button type="submit" name="delete_program" class="table-btn delete-btn" onclick="return confirm('Are you sure you want to delete this program?');">Delete</button>
                                    </form>                                    
                                </td>
                                <td>
                                    <form action="../includes/process_program.php" method="POST">
                                        <input type="hidden" name="program_num" value="<?php echo $row['Program_Num']; ?>">
                                        <button type="submit" name="hide_program" class="table-btn"><?php echo $row['IsActive'] ? 'Hide' : 'Show'; ?></button>
                                    </form>
                                </td>
                                <td>
                                    <button onclick="location.href='view_report.php?Program_Num=<?php echo $row['Program_Num']; ?>'" class="table-btn edit-btn">Select</button>
                                </td>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='8'>No programs found.</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<script src="../js/index.js"></script>
<script src="../js/app.js"></script>