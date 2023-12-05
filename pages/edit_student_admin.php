<!-- Written by Patrick Keating -->

<?php include '../assets/user_admin_header.php'; 
include '../assets/navbar.php'; 
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
        <h2>Edit Student Details</h2>
        <h3>Recheck the drop down menus</h3>
    </div>
    <?php
        if (isset($_POST['student_btn'])) {
            $uin = $_POST['UIN'];
            $stmt = $conn->prepare("SELECT * FROM college_student WHERE UIN = ?");
            $stmt->bind_param("i", $uin);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            ?>
            <form action="../includes/process_student.php" method="post">
                <input type="hidden" name="stu_uin" id="stu_uin" value="<?php echo $uin; ?>">

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

                <br>
                <label class="event-label text-black font-size-l pd-10" for="m_initial">Race</label>
                <input class="pd-20 border-radius-12 edit-input" id="race" type="text" name="race" value="<?php echo $user['Race']?>">

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

                <br>
                <input type="date" placeholder="Date of Birth" id="dob" name="dob">

                <br>
                <label class="event-label text-black font-size-l pd-10" for="m_initial">GPA</label>
                <input class="pd-20 border-radius-12 edit-input" id="gpa" type="text" name="gpa" value="<?php echo $user['GPA']?>">
                
                <br>
                <label class="event-label text-black font-size-l pd-10" for="m_initial">Major</label>
                <input class="pd-20 border-radius-12 edit-input" id="major" type="text" name="major" value="<?php echo $user['Major']?>">

                <br>
                <label class="event-label text-black font-size-l pd-10" for="m_initial">Minor #1</label>
                <input class="pd-20 border-radius-12 edit-input" id="minor1" type="text" name="minor1" value="<?php echo $user['Minor_1']?>">

                <br>
                <label class="event-label text-black font-size-l pd-10" for="m_initial">Minor #2</label>
                <input class="pd-20 border-radius-12 edit-input" id="minor2" type="text" name="minor2" value="<?php echo $user['Minor_2']?>">

                <br>
                <label class="event-label text-black font-size-l pd-10" for="m_initial">Expected Graduation Year</label>
                <input class="pd-20 border-radius-12 edit-input" id="expected_graduation" type="text" name="expected_graduation" value="<?php echo $user['Expected_Graduation']?>">

                <br>
                <label class="event-label text-black font-size-l pd-10" for="m_initial">School</label>
                <input class="pd-20 border-radius-12 edit-input" id="school" type="text" name="school" value="<?php echo $user['School']?>">

                <br>
                <select name="classification" id="classification">
                    <option value="Freshman">Freshman</option>
                    <option value="Sophomore">Sophomore</option>
                    <option value="Junior">Junior</option>
                    <option value="Senior">Senior</option>
                    <option value="Other">Other</option>
                </select>

                <br>
                <label class="event-label text-black font-size-l pd-10" for="m_initial">Phone Number (No Dashes)</label>
                <input class="pd-20 border-radius-12 edit-input" id="phone" type="text" name="phone" value="<?php echo $user['Phone']?>">
                
                <br>

                <select name="student_type" id="student_type">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>

                <br>
                <br>

                <button type="submit" class="add-btn" name="update_student" id="update_student">Update</button>
                <a href="user_admin.php">Cancel</a>
            </form>
        <?php 
             
        } else {
            ?> <h1>BROKEN</h1>
            <?php 
        }
    ?>
</div>
