<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../../login.php");
    exit;
}
include '../../DB_connection.php';

if (
    isset($_POST['result_id']) &&
    isset($_POST['maths']) &&
    isset($_POST['gujarati']) &&
    isset($_POST['english'])
) {
    $result_id = $_POST['result_id'];
    $maths = floatval($_POST['maths']);
    $gujarati = floatval($_POST['gujarati']);
    $english = floatval($_POST['english']);

    $total = $maths + $gujarati + $english;
    $percentage = $total / 3;

    // Assign grade automatically
    if ($percentage >= 80) {
        $grade = 'A';
    } elseif ($percentage >= 70) {
        $grade = 'B';
    } elseif ($percentage >= 60) {
        $grade = 'C';
    } elseif ($percentage >= 50) {
        $grade = 'D';
    } else {
        $grade = 'F';
    }

    // Pass/Fail logic
    $result_status = ($maths < 33 || $gujarati < 33 || $english < 33) ? 'Fail' : 'Pass';

    $stmt = $conn->prepare("UPDATE result SET maths=?, gujarati=?, english=?, total=?, percentage=?, grade=?, result=? WHERE result_id=?");
    $stmt->execute([$maths, $gujarati, $english, $total, $percentage, $grade, $result_status, $result_id]);

    header("Location: ../result.php?success=Result+Updated");
    exit;
} else {
    header("Location: ../result.php?error=Invalid+Input");
    exit;
}