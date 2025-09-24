<?php
session_start();
if (
  isset($_SESSION['student_id']) &&
  isset($_SESSION['role'])
) {

  if ($_SESSION['role'] == 'Student') {
    include "../DB_connection.php";
    include "data/student.php";
    include "data/section.php";

    $student_id = $_SESSION['student_id'];

    $student = getStudentById($student_id, $conn);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Student - Home</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="../css/style.css">
      <link rel="icon" href="../logo2.png">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>
        body {
          background: url('../img/back.jpg') no-repeat center center fixed;
          background-size: cover;
          font-family: 'Segoe UI', Arial, sans-serif;
        }

        .student-card {
          background: rgba(255, 255, 255, 0.97);
          border-radius: 14px;
          box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
          padding: 36px 32px 28px 32px;
          max-width: 650px;
          margin: 50px auto 0 auto;
        }

        .student-header {
          text-align: center;
          margin-bottom: 18px;
        }

        .student-header img {
          width: 90px;
          height: 90px;
          border-radius: 50%;
          border: 3px solid #b377f6ff;
          background: #fff;
        }

        .student-username {
          font-size: 1.2rem;
          color: #b377f6ff;
          font-weight: 600;
          margin-top: 8px;
        }

        .student-info-table th {
          background: #b377f6ff;
          color: #fff;
          width: 40%;
        }

        .student-info-table td {
          background: #f4f6fa;
          color: #222;
        }

        .student-info-table {
          border-radius: 10px;
          overflow: hidden;
          margin-bottom: 0;
        }
      </style>
    </head>

    <body>
      <?php
      include "inc/navbar.php";
      ?>
      <?php
      if ($student != 0) {
      ?>
        <div class="student-card">
          <div class="student-header">
            <img src="../img/student-<?= $student['gender'] ?>.png" alt="Student Photo">
            <div class="student-username">@<?= $student['username'] ?></div>
            <h4 style="font-weight:700;margin-top:10px;letter-spacing:1px;">Student Information</h4>
          </div>
          <table class="table table-bordered student-info-table">
            <tr>
              <th>Roll No</th>
              <td><?= htmlspecialchars($student['roll_no']) ?></td>
            </tr>
            <tr>
              <th>First Name</th>
              <td><?= $student['fname'] ?></td>
            </tr>
            <tr>
              <th>Last Name</th>
              <td><?= $student['lname'] ?></td>
            </tr>
            <tr>
              <th>Address</th>
              <td><?= $student['address'] ?></td>
            </tr>
            <tr>
              <th>Date of Birth</th>
              <td><?= $student['date_of_birth'] ?></td>
            </tr>
            <tr>
              <th>Class</th>
              <td>
                <?php
                $section = $student['section'];
                $s = getSectionById($section, $conn);
                echo $s['section'];
                ?>
              </td>
            </tr>
            <tr>
              <th>Email Address</th>
              <td><?= $student['email_address'] ?></td>
            </tr>
            <tr>
              <th>Caste</th>
              <td><?= $student['caste'] ?></td>
            </tr>
            <tr>
              <th>Mobile Number</th>
              <td><?= $student['mobile_number'] ?></td>
            </tr>
            <tr>
              <th>Parent First Name</th>
              <td><?= $student['parent_fname'] ?></td>
            </tr>
            <tr>
              <th>Parent Last Name</th>
              <td><?= $student['parent_lname'] ?></td>
            </tr>
            <tr>
              <th>Parent Phone Number</th>
              <td><?= $student['parent_phone_number'] ?></td>
            </tr>
          </table>
        </div>
      <?php
      } else {
        header("Location: student.php");
        exit;
      }
      ?>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
<?php

  } else {
    header("Location: ../login.php");
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}

?>