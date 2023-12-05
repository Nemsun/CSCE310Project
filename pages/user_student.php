<!-- Written by Patrick Keating -->

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
        <h2>Edit Account Information</h2>
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
                <button type="submit" class="add-btn margin-top-20" name="update_btn">Update Account</button>
                <button type="submit" class="cancel-btn margin-top-20" name="delete_btn">Deactivate Account</button>
            </div>
        </form>
    <?php 
        } 
    ?>

<div class="header">
        <h2>Edit Student Information</h2>
    </div>
    <?php
        $olduin = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT * FROM college_student WHERE UIN = ?");
        $stmt->bind_param("i", $olduin);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        foreach ($result as $row) {
        ?>
        <form class="edit-form flex flex-col flex-start align-start" action="../includes/process_user_student.php" method="post">
            <br>
            <select name="gender" id="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <br>

            <select name="hispanic" id="hispanic">
                <option value="1">Hispanic/Latino</option>
                <option value="0">Not Hispanic/Latino</option>
            </select>

            <label class="event-label text-black font-size-l pd-10" for="uin-id">Race</label>
            <input class="pd-20 border-radius-12 edit-input" id="race" type="text" placeholder="Race" name="race" value="<?php echo $row['Race']?>">

            <br>
            <select name="citizen" id="citizen">
                <option value="1">US Citizen</option>
                <option value="0">Not US Citizen</option>
            </select>

            <br>
            <select name="first_generation" id="first_generation">
                <option value="1">First Generation Student</option>
                <option value="0">Not First Generation Student</option>
            </select>

            <label class="event-label text-black font-size-l pd-10" for="uin-id">Date of Birth</label>
            <input type="date" placeholder="Date of Birth" id="dob" name="dob">

            <label class="event-label text-black font-size-l pd-10" for="uin-id">GPA</label>
            <input class="pd-20 border-radius-12 edit-input" id="gpa" type="text" placeholder="GPA" name="gpa" value="<?php echo $row['GPA']?>">
            
            <label class="event-label text-black font-size-l pd-10" for="uin-id">Major</label>
            <input class="pd-20 border-radius-12 edit-input" id="major" type="text" placeholder="Major" name="major" value="<?php echo $row['Major']?>">

            <label class="event-label text-black font-size-l pd-10" for="uin-id">Minor #1</label>
            <input class="pd-20 border-radius-12 edit-input" id="minor1" type="text" placeholder="Minor #1" name="minor1" value="<?php echo $row['Minor_1']?>">

            <label class="event-label text-black font-size-l pd-10" for="uin-id">Minor #2</label>
            <input class="pd-20 border-radius-12 edit-input" id="minor2" type="text" placeholder="Minor #2" name="minor2" value="<?php echo $row['Minor_2']?>">

            <label class="event-label text-black font-size-l pd-10" for="uin-id">Expected Graduation Year</label>
            <input class="pd-20 border-radius-12 edit-input" id="expected_graduation" type="text" placeholder="Expected Graduation Year" 
            name="expected_graduation" value="<?php echo $row['Expected_Graduation']?>">

            <label class="event-label text-black font-size-l pd-10" for="uin-id">School</label>
            <input class="pd-20 border-radius-12 edit-input" id="school" type="text" placeholder="School" name="school" value="<?php echo $row['School']?>">

            <br>
            <select name="classification" id="classification">
                <option value="Freshman">Freshman</option>
                <option value="Sophomore">Sophomore</option>
                <option value="Junior">Junior</option>
                <option value="Senior">Senior</option>
                <option value="Other">Other</option>
            </select>

            <label class="event-label text-black font-size-l pd-10" for="uin-id">Phone Number (No Dashes)</label>
            <input class="pd-20 border-radius-12 edit-input" id="phone" type="text" placeholder="Phone Number" name="phone" value="<?php echo $row['Phone']?>">
            
            <br>
            <div class="flex space-between width-50">
                <button type="submit" class="add-btn margin-top-20" name="update_student_btn">Update Student</button>
            </div>
        </form>
    <?php 
        } 
    ?>
</div>

<script src="../js/index.js"></script>
