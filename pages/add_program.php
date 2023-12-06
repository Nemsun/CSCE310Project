<?php include '../assets/user_admin_header.php'; 
include '../assets/navbar.php';
include_once '../includes/dbh.inc.php';  


$isEditMode = isset($_GET['Program_Num']);
$programName = '';
$programDescription = '';
$programNum = '';

if ($isEditMode) {
    $programNum = $_GET['Program_Num'];
    $stmt = $conn->prepare("SELECT Name, Description FROM Programs WHERE Program_Num = ?");
    $stmt->bind_param("i", $programNum);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $programName = $row['Name'];
        $programDescription = $row['Description'];
    }
    $stmt->close();
}
?>

<div class="main-container margin-left-280">
    <div class="header">
        <h2><?php echo $isEditMode ? 'Edit Program' : 'Add New Program'; ?></h2>
    </div>
    <form class="edit-form flex flex-col flex-start align-start" action="../includes/process_program.php" method="post">
        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="program-name">Program Name: </label>
            <input class="font-size-l border-radius-12 pd-20 width-1350px" id="program-name" type="text" placeholder="Program Name" name="program_name" value="<?php echo htmlspecialchars($programName); ?>" required>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="program-desc">Program Description: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1300px" id="program-desc" placeholder="Program Description" name="program_description" required><?php echo htmlspecialchars($programDescription); ?></textarea>
        </div>

        <div class="flex space-between width-24">
            <button type="submit" class="add-btn margin-top-20" name="submit-program"><?php echo $isEditMode ? 'Update Program' : 'Add Program'; ?></button>
            <a href="program_management.php" class="cancel-btn margin-top-20">Back</a>
        </div>
        <input type="hidden" name="action" value="<?php echo $isEditMode ? 'edit' : 'add'; ?>">
        <?php if ($isEditMode): ?>
            <input type="hidden" name="program_num" value="<?php echo $programNum; ?>">
        <?php endif; ?>
    </form>
</div>
