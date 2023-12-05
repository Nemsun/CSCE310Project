<!-- Written by Patrick Keating -->

<?php
include_once '../includes/dbh.inc.php'; 
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/registration.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <div class = "main-container margin-left-35">
        <?php
            if(isset($_SESSION['success'])) {
                echo '<div class="alert alert-success" role="alert" id="alert">' . $_SESSION['success'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
                unset($_SESSION['success']);
            } else if(isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger" role="alert" id="alert">' . $_SESSION['error'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
                unset($_SESSION['error']);
            }
        ?>
    </div>
    <body>
        <div class="student-container">
        <h1>SIGNUP</h1>
            <form action="../includes/process_student.php" method="post">
                <br>
                <div class="flex justify-center">
                    <select name="gender" id="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <br>
                
                <div class="flex justify-center">
                    <select name="hispanic" id="hispanic">
                        <option value="1">Hispanic/Latino</option>
                        <option value="0">Not Hispanic/Latino</option>
                    </select>
                </div>

                <br>
                <input type="text" placeholder="Race" id="race" name="race" required>

                <br>
                <div class="flex justify-center">
                    <select name="citizen" id="citizen">
                        <option value="1">US Citizen</option>
                        <option value="0">Not US Citizen</option>
                    </select>
                </div>

                <br>
                <div class="flex justify-center">
                    <select name="first_generation" id="first_generation">
                        <option value="1">First Generation Student</option>
                        <option value="0">Not First Generation Student</option>
                    </select>
                </div>

                <br>
                <input type="date" placeholder="Date of Birth" id="dob" name="dob" required>

                <br>
                <input type="text" placeholder="GPA" id="gpa" name="gpa" required>
                
                <br>
                <input type="text" placeholder="Major" id="major" name="major" required>

                <br>
                <input type="text" placeholder="Minor #1 (Optional)" id="minor1" name="minor1">

                <br>
                <input type="text" placeholder="Minor #2 (Optional)" id="minor2" name="minor2">

                <br>
                <input type="text" placeholder="Expected Graduation Year" id="expected_graduation" name="expected_graduation" required>

                <br>
                <input type="text" placeholder="School" id="school" name="school" required>

                <br>
                <div class="flex justify-center">
                    <select name="classification" id="classification">
                        <option value="Freshman">Freshman</option>
                        <option value="Sophomore">Sophomore</option>
                        <option value="Junior">Junior</option>
                        <option value="Senior">Senior</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
               

                <br>
                <input type="text" placeholder="Phone Number (No dashes)" id="phone" name="phone" required>
                
                <br>
                
                <button type="submit" name="create_student" id="signup-button" class="register-btn">SUBMIT</button>
                <a href="../index.php" class="cancel-register">Cancel</a>
            </form>
        </div>
    </body>
</html>

<script src="../js/index.js"></script>


        