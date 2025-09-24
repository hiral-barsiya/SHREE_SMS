<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        
if (
    isset($_POST['admin_pass']) &&
    isset($_POST['student_id']) &&
    (
        isset($_POST['new_pass']) && isset($_POST['c_new_pass']) // For password change
        || isset($_POST['roll_no']) // For roll number change
    )
) {
    include '../../DB_connection.php';
    include "../data/admin.php";

    $admin_pass = $_POST['admin_pass'];
    $student_id = $_POST['student_id'];
    $id = $_SESSION['admin_id'];
    $data = 'student_id='.$student_id.'#change_password';

    // Verify admin password
    if (empty($admin_pass)) {
        $em  = "Admin password is required";
        header("Location: ../student-edit.php?perror=$em&$data");
        exit;
    } else if (!adminPasswordVerify($admin_pass, $conn, $id)) {
        $em  = "Incorrect admin password";
        header("Location: ../student-edit.php?perror=$em&$data");
        exit;
    }

    // Change password
    if (isset($_POST['new_pass']) && isset($_POST['c_new_pass'])) {
        $new_pass = $_POST['new_pass'];
        $c_new_pass = $_POST['c_new_pass'];

        if (empty($new_pass)) {
            $em  = "New password is required";
            header("Location: ../student-edit.php?perror=$em&$data");
            exit;
        } else if (empty($c_new_pass)) {
            $em  = "Confirmation password is required";
            header("Location: ../student-edit.php?perror=$em&$data");
            exit;
        } else if ($new_pass !== $c_new_pass) {
            $em  = "New password and confirm password does not match";
            header("Location: ../student-edit.php?perror=$em&$data");
            exit;
        } else {
            // hashing the password
            $new_pass_hashed = password_hash($new_pass, PASSWORD_DEFAULT);

            $sql = "UPDATE students SET password = ? WHERE student_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$new_pass_hashed, $student_id]);
            $sm = "The password has been changed successfully!";
            header("Location: ../student-edit.php?psuccess=$sm&$data");
            exit;
        }
    }

    // Change roll number
    if (isset($_POST['roll_no'])) {
        $roll_no = $_POST['roll_no'];
        if (empty($roll_no)) {
            $em  = "Roll number is required";
            header("Location: ../student-edit.php?perror=$em&$data");
            exit;
        }
        // Check for duplicate roll_no in the same section
        $section_stmt = $conn->prepare("SELECT section FROM students WHERE student_id=?");
        $section_stmt->execute([$student_id]);
        $section_row = $section_stmt->fetch(PDO::FETCH_ASSOC);
        $section = $section_row ? $section_row['section'] : null;

        $dup_stmt = $conn->prepare("SELECT * FROM students WHERE roll_no = ? AND section = ? AND student_id != ?");
        $dup_stmt->execute([$roll_no, $section, $student_id]);
        if ($dup_stmt->rowCount() > 0) {
            $em = "Roll number already exists in this section!";
            header("Location: ../student-edit.php?perror=$em&$data");
            exit;
        }

        $sql = "UPDATE students SET roll_no = ? WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$roll_no, $student_id]);
        $sm = "Roll number has been updated successfully!";
        header("Location: ../student-edit.php?psuccess=$sm&$data");
        exit;
    }

} else {
    $em = "An error occurred";
    header("Location: ../student-edit.php?error=$em&$data");
    exit;
}

  } else {
    header("Location: ../../logout.php");
    exit;
  } 
} else {
    header("Location: ../../logout.php");
    exit;
}
