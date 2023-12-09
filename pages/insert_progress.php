<!-- Written by Tarun Arumugam -->

<?php
include '../assets/header.php'; // Include the header
include '../assets/student_navbar.php'; // Include the student navigation bar
include_once '../includes/dbh.inc.php'; // Database connection file

// Initialize any variables you need
$className = '';
$classDescription = '';
$classType = '';
$classID = '';
$isEditMode = isset($_GET['Class_ID']);

// If the form is submitted
if ($isEditMode) {
    $classID = $_GET['Class_ID'];
    $stmt = $conn->prepare("SELECT Name, Description FROM Classes WHERE Class_ID = ?");
    $stmt->bind_param("i", $classID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $className = $row['Name'];
        $classDescription = $row['Description'];
    }
    $stmt->close();
}

?>

<div class="main-container margin-left-280">
    <div class="header">
        <h2><?php echo $isEditMode ? 'Edit Progress' : 'Add New Progress'; ?></h2>
    </div>
    <form class="edit-form flex flex-col flex-start align-start" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <!-- Input fields for the progress record -->
        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="class-id">Class ID: </label>
            <input class="font-size-l border-radius-12 pd-20 width-1350px" id="class-id" type="text" name="class_id" value="<?php echo htmlspecialchars($certification); ?>" required>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="class-name">Class Name: </label>
            <input class="font-size-l border-radius-12 pd-20 width-1350px" id="class-name" type="text" name="class_name" value="<?php echo htmlspecialchars($courseName); ?>" required>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="class-description">Class Description: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1300px" id="class-description" name="class_description" required><?php echo htmlspecialchars($progressDetail); ?></textarea>
        </div>

        <!-- Submit Button -->
        <div class="flex space-between width-24">
            <button type="submit" class="add-btn margin-top-20" name="submit-progress">Add Progress</button>
            <a href="progress_management.php" class="cancel-btn margin-top-20">Back</a>
        </div>

        <input type="hidden" name="action" value="<?php echo $isEditMode ? 'edit' : 'add'; ?>">
        <?php if ($isEditMode): ?>
            <input type="hidden" name="class_id" value="<?php echo $classID; ?>">
        <?php endif; ?>

    </form>
</div>
