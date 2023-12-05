<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416 -->
<?php
// HELPER FUNCTIONS FOR APPLICATIONS PAGE

/**
 * This function adds an application to the applications table in the database
 * 
 * @param $conn - the connection to the database
 * @param $uin - the UIN of the student
 * @param $programNum - the program number of the program the student is applying to
 * @param $uncomCert - the uncompleted certificate of the student
 * @param $comCert - the completed certificate of the student
 * @param $purposeStmt - the purpose statement of the student
 */
function addApplication($conn, $uin, $programNum, $uncomCert, $comCert, $purposeStmt) {
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO applications (UIN, Program_Num, Uncom_Cert, Com_Cert, Purpose_Statement) 
                            VALUES (?, ?, ?, ?, ?)");
    // Bind parameters to the statement
    $stmt->bind_param("iisss", $uin, $programNum, $uncomCert, $comCert, $purposeStmt);
    
    // Execute the statement
    // If successful, redirect to application_information page with success message
    // If unsuccessful, redirect to application_information page with failure message
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Application added successfully!';
        header("Location: ../pages/application_information.php?addapp=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("application_information", "addapp=failure", 'Application failed to add!');
        $stmt->close();
    }
}