<?php include '../assets/header.php'; 
include '../assets/student_navbar.php'; 
include_once '../includes/dbh.inc.php'; 

?>

<div class="main-container margin-left-280">
    <?php
        if(isset($_SESSION['success'])) {
            echo '<div class="alert alert-success" role="alert" id="alert">' . $_SESSION['success'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
            unset($_SESSION['success']);
        } else if(isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger" role="alert" id="alert">' . $_SESSION['error'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
            unset($_SESSION['error']);
        }
    ?>
    <div class="header">
        <h2>Edit Student Information</h2>
    </div>
    <?php
        $olduin = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
        $stmt->bind_param("i", $olduin);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        foreach ($result as $row) {
        ?>
        <form class="edit-form flex flex-col flex-start align-start" action="../includes/process_user_student.php" method="post">
            <input type="hidden" name="UIN" value="<?php echo $row['UIN']; ?>">

            <label class="event-label text-black font-size-l pd-10" for="first_name">First Name</label>
            <input class="pd-20 border-radius-12 edit-input" id="first_name" type="text" placeholder="First Name" name="first_name" value="<?php echo $row['First_name']?>">
            
            <label class="event-label text-black font-size-l pd-10" for="m_initial">Middle Initial</label>
            <input class="pd-20 border-radius-12 edit-input" id="m_initial" type="text" name="m_initial" value="<?php echo $row['M_Initial']?>">

            <label class="event-label text-black font-size-l pd-10" for="last_name">Last Name</label>
            <input class="pd-20 border-radius-12 edit-input" id="last_name" type="text" placeholder="Last Name" name="last_name" value="<?php echo $row['Last_Name']?>">

            <label class="event-label text-black font-size-l pd-10" for="email">Email</label>
            <input class="pd-20 border-radius-12 edit-input" id="email" type="text" placeholder="Email" name="email" value="<?php echo $row['Email']?>">

            <label class="event-label text-black font-size-l pd-10" for="discord">Discord</label>
            <input class="pd-20 border-radius-12 edit-input" id="discord" type="text" placeholder="Discord" name="discord" value="<?php echo $row['Discord']?>">

            <label class="event-label text-black font-size-l pd-10" for="username">Username</label>
            <input class="pd-20 border-radius-12 edit-input" id="username" type="text" placeholder="Username" name="username" value="<?php echo $row['Username']?>">

            <label class="event-label text-black font-size-l pd-10" for="password">Password</label>
            <input class="pd-20 border-radius-12 edit-input" id="password" type="text" placeholder="Password" name="password" value="<?php echo $row['Passwords']?>">
            
            <div class="flex space-between width-50">
                <button type="submit" class="add-btn margin-top-20" name="update_btn">Update</button>
                <button type="submit" class="cancel-btn margin-top-20" name="delete_btn">Deactivate Account</button>
            </div>
        </form>
    <?php 
        } 
    ?>
</div>

<script src="../js/index.js"></script>
