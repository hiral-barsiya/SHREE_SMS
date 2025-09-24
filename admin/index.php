<?php
session_start();
if (
  isset($_SESSION['admin_id']) &&
  isset($_SESSION['role'])
) {

  if ($_SESSION['role'] == 'Admin') {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin - Home</title>
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

        .admin-dashboard-card {
          background: rgba(255, 255, 255, 0.97);
          border-radius: 18px;
          box-shadow: 0 6px 32px rgba(0, 0, 0, 0.13);
          padding: 48px 36px 36px 36px;
          max-width: 1100px;
          margin: 60px auto 0 auto;
        }

        .dashboard-title {
          font-size: 2.2rem;
          font-weight: 700;
          color: #2563eb;
          letter-spacing: 1px;
          margin-bottom: 32px;
          text-align: center;
        }

        .dashboard-grid .col {
          min-width: 180px;
        }

        .dashboard-grid a {
          transition: transform 0.18s, box-shadow 0.18s, background 0.18s;
          border-radius: 12px !important;
          font-size: 1.1rem;
          font-weight: 600;
          box-shadow: 0 2px 10px rgba(37, 99, 235, 0.08);
          border: none;
        }

        .dashboard-grid a:hover {
          transform: translateY(-7px) scale(1.04);
          box-shadow: 0 8px 32px rgba(37, 99, 235, 0.17);
          background: #2563eb !important;
          color: #fff !important;
        }

        .dashboard-grid .btn-primary {
          background: #2563eb;
          border: none;
        }

        .dashboard-grid .btn-warning {
          background: red;
          border: none;
          color: #fff;
        }

        @media (max-width: 900px) {
          .admin-dashboard-card {
            padding: 32px 10px 24px 10px;
            max-width: 98vw;
          }

          .dashboard-title {
            font-size: 1.4rem;
          }
        }
      </style>
    </head>

    <body>
      <?php
      include "inc/navbar.php";
      ?>

      <div class="admin-dashboard-card">
        <div class="dashboard-title">
          <img src="../logo2.png" alt="Logo" style="height:48px;width:48px;border-radius:50%;margin-right:10px;vertical-align:middle;border:2px solid #2563eb;background:#fff;">
          Shree School Admin Dashboard
        </div>
        <div class="container text-center">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 dashboard-grid justify-content-center">

            <a href="student.php" class="col btn btn-dark m-2 py-4">
              <i class="fa fa-graduation-cap fs-1 mb-2" aria-hidden="true"></i><br>
              Students
            </a>

            
            <a href="course.php" class="col btn btn-dark m-2 py-4">
              <i class="fa fa-book fs-1 mb-2" aria-hidden="true"></i><br>
              Course
            </a>
            <a href="section.php" class="col btn btn-dark m-2 py-4">
              <i class="fa fa-columns fs-1 mb-2" aria-hidden="true"></i><br>
              Section
            </a>
            <a href="message.php" class="col btn btn-dark m-2 py-4">
              <i class="fa fa-envelope fs-1 mb-2" aria-hidden="true"></i><br>
              Message
            </a>
            <a href="attendance.php" class="col btn btn-dark m-2 py-4">
              <i class="fa fa-calendar-check-o fs-1 mb-2" aria-hidden="true"></i><br>
              Attendance
            </a>
            <a href="result.php" class="col btn btn-dark m-2 py-4">
              <i class="fa fa-bar-chart fs-1 mb-2" aria-hidden="true"></i><br>
              Result
            </a>
            <a href="settings.php" class="col btn btn-primary m-2 py-4 col-5">
              <i class="fa fa-cogs fs-1 mb-2" aria-hidden="true"></i><br>
              Settings
            </a>
            <a href="../logout.php" class="col btn btn-warning m-2 py-4 col-4">
              <i class="fa fa-sign-out fs-1 mb-2" aria-hidden="true"></i><br>
              Logout
            </a>
          </div>
        </div>
      </div>
      <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        $(document).ready(function() {
          $("#navLinks li:nth-child() a").addClass('active');
        });
      </script> -->

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