<?php 
include '../assets/header.php'; 
include '../assets/navbar.php';
include_once '../includes/dbh.inc.php';  

$isEditMode = isset($_GET['CE_Num']);
$className = '';
$classDescription = '';
$classNum = '';

if ($isEditMode) {
    $classNum = $_GET['CE_Num'];

    // Assuming CE_Num is a foreign key in the Class_Enrollment table
    $stmt = $conn->prepare("
        SELECT c.Class_ID, c.Name, c.Description 
        FROM Classes c
        INNER JOIN Class_Enrollment ce ON c.Class_ID = ce.Class_ID
        WHERE ce.CE_Num = ?");
    $stmt->bind_param("i", $classNum);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $className = $row['Name'];
        $classDescription = $row['Description'];
    } else {
        // Handle case where no class is found
        $_SESSION['message'] = "No class found for the given ID.";
        header("Location: progress_tracking.php"); // Redirect if no class is found
        exit();
    }
    $stmt->close();
}
?>

<div class="main-container margin-left-280">
    <div class="header">
        <h2><?php echo $isEditMode ? 'Edit Class' : 'Add New Class'; ?></h2>
    </div>
    <form class="edit-form flex flex-col flex-start align-start" action="../includes/process_class.php" method="post">
        <!-- Class Name Input -->
        <div class="form-group">
            <label for="class-name">Class Name:</label>
            <input type="text" id="class-name" name="class_name" value="<?php echo htmlspecialchars($className); ?>" required>
        </div>
        
        <!-- Class Description Input -->
        <div class="form-group">
            <label for="class-desc">Class Description:</label>
            <textarea id="class-desc" name="class_description" required><?php echo htmlspecialchars($classDescription); ?></textarea>
        </div>
        
        <!-- Submit Button -->
        <div class="flex space-between width-24">
            <button type="submit" class="add-btn margin-top-20" name="submit-class"><?php echo $isEditMode ? 'Update Class' : 'Add Class'; ?></button>
            <a href="progress_tracking.php" class="cancel-btn margin-top-20">Back</a>
        </div>
        
        <input type="hidden" name="action" value="<?php echo $isEditMode ? 'edit' : 'add'; ?>">
        <?php if ($isEditMode): ?>
            <input type="hidden" name="class_id" value="<?php echo $classNum; ?>">
        <?php endif; ?>
    </form>
</div>
