<?php include '../assets/header.php'; 
include '../assets/student_navbar.php'; 
include_once '../includes/dbh.inc.php'; 

?>



<div class="main-container margin-left-280">
    <h2> Hello <?php echo $_SESSION['first_name']; ?>! You can view your documents here.</h2>
</div>

<div class="margin-left-280">
    <h1>Upload Documents</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
    <label for="file">Select Document:</label>
    <input type="file" id="file" name="file" required>

    <label for="name">Document Name:</label>
    <input type="text" id="name" name="name" required>

    <input type="submit" value="Upload">
    </form>
</div>

<?php

// Connect to database
$con = mysqli_connect('localhost', 'root', '', 'cybersecdata');

if (!$con) {
  die('Connection failed: ' . mysqli_connect_error());
}

// Check if file uploaded
if (isset($_FILES['file'])) {
  // Get file information

  
$fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];

  
$fileType = $_FILES['file']['type'];

  // Check for upload errors
  if ($fileError !== UPLOAD_ERR_OK) {
    echo 'Error uploading file: ' . $fileError;
    exit;
  }

  // Get document name
  $documentName = $_POST['name'];

  // Validate document name length
  if (strlen($documentName) > 255) {
    echo 'Document name is too long. Please shorten it.';
    exit;
  }

  // Generate unique file name (optional)
  $newFileName = uniqid() . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

  // Open file for reading in binary mode
  $fileHandle = fopen($fileTmpName, 'rb');

  // Read file contents as binary string
  $fileContent = fread($fileHandle, $fileSize);

  $uin = $_SESSION['user_id'];

  // Close the file
  fclose($fileHandle);

  // Prepare SQL statement
  $sql = "INSERT INTO documents (file_name, file, UIN) VALUES (?, ?, ?)";

  // Prepare statement with mysqli_stmt
  $stmt = mysqli_prepare($con, $sql);

  // Bind parameters to the statement
  mysqli_stmt_bind_param($stmt, 'sss', $fileName, $fileContent, $uin);

  // Execute the prepared statement
  mysqli_stmt_execute($stmt);

  // Close the prepared statement
  mysqli_stmt_close($stmt);

  if (mysqli_affected_rows($con) > 0) {
    echo 'Document uploaded successfully!';
  } else {
    echo 'Error .';
  }
}

// Close connection
mysqli_close($con);

?>

<div class="margin-left-280">

<?php
  // Connect to database
  $con = mysqli_connect('localhost', 'root', '', 'cybersecdata');

  if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
  }

  $UIN = $_SESSION['user_id'];

  // Get all documents
  $sql = "SELECT * FROM documents WHERE UIN = $UIN";
  $result = mysqli_query($con, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<thead>';
    echo '<tr><th>File Name</th><th>UIN</th><th>Action</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
      $id = $row['id'];
      $fileName = $row['file_name'];
      $uin = $row['UIN'];

      echo "<tr>";
      echo "<td>$fileName</td>";
      echo "<td>$uin</td>";
      echo "<td>";
      echo "<a href='?action=edit&id=$id'>Rename</a> | ";
      echo "<a href='?action=download&id=$id'>Download</a> | ";
      echo "<a href='?action=delete&id=$id' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>";
      echo "</td>";
      echo "</tr>";
    }

    echo '</tbody>';
    echo '</table>';
  } else {
    echo '<p>No documents found.</p>';
  }

    // Handle delete action
    if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    
        // Delete document from database
        $sql = "DELETE FROM documents WHERE id = ?";
    
        // Prepare statement and bind parameters
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
    
        // Execute statement and check result
        if (mysqli_stmt_execute($stmt) && mysqli_affected_rows($con) > 0) {
            echo '<p>Document deleted successfully!</p>';
        } else {
            echo '<p>Error deleting document.</p>';
        }
    
        // Close connection
        mysqli_stmt_close($stmt);
    
        // Redirect back to manage page
        header('Location: ?');
        exit;
        } else {
        echo '<p>Invalid document ID.</p>';
        }
    }
// -----------------------------------------------------------------------------------------------------------------------------
    // Handle edit/rename action
    if (isset($_GET['action']) && $_GET['action'] === 'edit') {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    
        // Get document data
        $sql = "SELECT file_name, uin FROM documents WHERE id = ?";
    
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
    
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $fileName = $row['file_name'];
            $uin = $row['uin'];
        } else {
            echo '<p>Document not found.</p>';
            exit;
        }
    
        // Close resources
        mysqli_stmt_close($stmt);
    
        // Display edit form
        echo '<h2>Edit Document</h2>';
        echo '<form action="?action=update&id=' . $id . '" method="post">';
        echo '<label for="file_name">File Name:</label>';
        echo '<input type="text" id="file_name" name="file_name" value="' . $fileName . '" required>';
        echo '<label for="uin">UIN:</label>';
        echo '<input type="text" id="uin" name="uin" value="' . $uin . '" required>';
        echo '<input type="submit" value="Save Changes">';
        echo '</form>';
        } else {
        echo '<p>Invalid document ID.</p>';
        }
    }
    
    // Handle update action after form submission
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    
        $fileName = $_POST['file_name'];
        $uin = $_POST['uin'];
    
        // Validate data
        if (strlen($fileName) > 255 || strlen($uin) > 20) {
            echo '<p>Document name or UIN is too long. Please shorten it.</p>';
            exit;
        }
    
        // Update document data
        $sql = "UPDATE documents SET file_name = ?, uin = ? WHERE id = ?";
    
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $fileName, $uin, $id);
    
        if (mysqli_stmt_execute($stmt)) {
            echo '<p>Document updated successfully!</p>';
        } else {
            echo '<p>Error updating document.</p>';
        }
    
        // Close connection
        mysqli_stmt_close($stmt);
    
        // Redirect back to manage page
        header('Location: ?');
        exit;
        } else {
        echo '<p>Invalid document ID.</p>';
        }
    }


//-----------------------------------------------------------------------------------------------------------------------------------------
    // Handle download action
    if (isset($_GET['action']) && $_GET['action'] === 'download') {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    
        // Get document data
        $sql = "SELECT file, file_name FROM documents WHERE id = ?";
    
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
    
    
        
    if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $fileContent = $row['file'];
            $fileName = $row['file_name'];
    
            // Set headers for download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Content-Length: ' . strlen($fileContent));
    
            // Output file content
            echo $fileContent;
    
            exit;
        } else {
            echo '<p>Error downloading document.</p>';
        }
    
        // Close resources
        mysqli_stmt_close($stmt);
        } else {
        echo '<p>Invalid document ID.</p>';
        }
    }





// Close connection
  mysqli_close($con);
  ?>

</div>
