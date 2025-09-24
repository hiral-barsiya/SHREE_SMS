<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['student_id'])) {

  if ($_SESSION['role'] == 'Admin') {
     include "../DB_connection.php";
     include "data/student.php";

     $id = $_GET['student_id'];
     // Optionally, you can also get roll_no if you want to show/delete by roll_no
     // $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : null;

     if (removeStudent($id, $conn)) {
         $sm = "Successfully deleted!";
        header("Location: student.php?success=$sm");
        exit;
     }else {
        $em = "Unknown error occurred";
        header("Location: student.php?error=$em");
        exit;
     }

  }else {
    header("Location: student.php");
    exit;
  } 
}else {
    header("Location: student.php");
    exit;
}