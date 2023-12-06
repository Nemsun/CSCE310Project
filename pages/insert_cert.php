<?php 
include '../assets/header.php'; 
include '../assets/navbar.php';
include_once '../includes/dbh.inc.php';  

$isEditMode = isset($_GET['Cert_ID']);
$certName = '';
$certDescription = '';
$certNum = '';

if ($isEditMode) {
    $certNum = $_GET['Cert_ID'];
    $stmt = $conn->prepare("SELECT Name, Description FROM Certification WHERE Cert_ID = ?");
    $stmt->bind_param("i", $certNum);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $certName = $row['Name'];
        $certDescription = $row['Description'];
    }
    $stmt->close();
}
?>

<div class="main-container margin-left-280">
    <div class="header">
        <h2><?php echo $isEditMode ? 'Edit Certification' : 'Add New Certification'; ?></h2>
    </div>
    <form class="edit-form flex flex-col flex-start align-start" action="../includes/process_cert.php" method="post">
        <!-- Certification Name Input -->
        <div class="form-group">
            <label for="cert-name">Certification Name:</label>
            <input type="text" id="cert-name" name="cert_name" value="<?php echo htmlspecialchars($certName); ?>" required>
        </div>
        
        <!-- Certification Description Input -->
        <div class="form-group">
            <label for="cert-desc">Certification Description:</label>
            <textarea id="cert-desc" name="cert_description" required><?php echo htmlspecialchars($certDescription); ?></textarea>
        </div>
        
        <div class="flex space-between width-24">
            <button type="submit" class="add-btn margin-top-20" name="submit-program"><?php echo $isEditMode ? 'Update Program' : 'Add Program'; ?></button>
            <a href="progress_tracking.php" class="cancel-btn margin-top-20">Back</a>
        </div>
        
        <input type="hidden" name="action" value="<?php echo $isEditMode ? 'edit' : 'add'; ?>">
        <?php if ($isEditMode): ?>
            <input type="hidden" name="cert_id" value="<?php echo $certNum; ?>">
        <?php endif; ?>
    </form>
</div>