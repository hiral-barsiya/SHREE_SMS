<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../../login.php");
    exit;
}
include '../../DB_connection.php';

if (isset($_POST['attendance'], $_POST['date'], $_POST['section_id'])) {
    $date = $_POST['date'];
    $section_id = $_POST['section_id'];
    foreach ($_POST['attendance'] as $student_id => $status) {
        // Prevent duplicate for same date/student
        $stmt = $conn->prepare("SELECT * FROM attendance WHERE student_id=? AND date=?");
        $stmt->execute([$student_id, $date]);
        if ($stmt->rowCount() == 0) {
            $ins = $conn->prepare("INSERT INTO attendance (student_id, date, status, section_id) VALUES (?, ?, ?, ?)");
            $ins->execute([$student_id, $date, $status, $section_id]);
        }
    }
    header("Location: ../attendance.php?section_id=$section_id&success=Attendance+Saved");
    exit;
}
header("Location: ../attendance.php?error=Invalid+Request");
exit;