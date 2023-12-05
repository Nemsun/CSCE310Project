<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416
-->
<?php include '../assets/header.php'; 
include '../assets/student_navbar.php';
include_once '../includes/dbh.inc.php';  
?>
<?php
    $appNum = "";
    $programNum = "";
    $programName = "";
    $programDesc = "";
    $uncomCert = "";
    $comCert = "";
    $purposeStatement = "";
    if (isset($_POST['view_app_btn'])) {
        $appNum = $_POST['view_app_id'];
        $stmt = $conn->prepare("SELECT * FROM applications WHERE App_Num = ?");
        $stmt->bind_param("i", $appNum);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stmt->close();
            foreach ($result as $row) {
                $appNum = $row['App_Num'];
                $programNum = $row['Program_Num'];
                $uncomCert = $row['Uncom_Cert'];
                $comCert = $row['Com_Cert'];
                $purposeStatement = $row['Purpose_Statement'];
            }
        }
        
        $programStmt = $conn->prepare("SELECT * FROM programs WHERE Program_Num = ?");
        $programStmt->bind_param("i", $programNum);
        if ($programStmt->execute()) {
            $programResult = $programStmt->get_result();
            $programStmt->close();
            foreach ($programResult as $row) {
                $programName = $row['Name'];
                $programDesc = $row['Description'];
            }
        }
    }
?>
<div class="main-container margin-left-280">
    <div class="header">
        <h2>Application Information</h2>
    </div>
    <form class="edit-form flex flex-col flex-start align-start" action="../includes/process_user_applications.php" method="post">
        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="app-num">Application Number: </label>
            <input class="font-size-l border-radius-12 width-48px text-align-center" id="app-num" type="text" placeholder="Application Number" name="app_num" value="<?php echo $appNum; ?>" disabled>
        </div>
        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="program-num">Program Number: </label>
            <input class="font-size-l border-radius-12 width-auto text-align-center" id="program-num" type="text" placeholder="Program Number" name="program_num" value="<?php echo $programNum; ?>">
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="program-name">Program Name: </label>
            <input class="font-size-l border-radius-12 pd-20 width-1350px" id="program-name" type="text" placeholder="Program Name" name="program_name" value="<?php echo $programName; ?>" disabled>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="program-desc">Program Description: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1300px" id="program-desc" type="text" placeholder="Program Description" name="program_desc" disabled><?php echo $programDesc; ?></textarea>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="uncom-cert">Uncompleted Certificates: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1250px" id="uncom-cert" type="text" placeholder="Uncompleted Certificates" name="uncom_cert"><?php echo $uncomCert; ?></textarea>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="com-cert">Completed Certificates: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1275px" id="com-cert" type="text" placeholder="Completed Certificates" name="com_cert"><?php echo $comCert; ?></textarea>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="purpose-statement">Purpose Statement: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1315px" id="purpose-statement" type="text" placeholder="Purpose Statement" name="purpose_statement"><?php echo $purposeStatement; ?></textarea>
        </div>

        <div class="flex space-between width-24">
            <input type="hidden" name="edit_app_id" value="<?php echo $appNum; ?>">
            <button type="submit" class="add-btn margin-top-20" name="update_app_btn">Update</button>
            <a href="application_information.php" class="cancel-btn margin-top-20">Back</a>
        </div>
    </form>
</div>