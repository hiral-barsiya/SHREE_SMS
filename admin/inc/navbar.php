<?php
  // No highlight logic needed
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="../logo2.png" width="40" style="border-radius:8px;box-shadow:0 2px 8px #2563eb55;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav nav-fill w-100 mb-lg-0" id="navLinks" style="flex: 1;">
        <li class="nav-item">
          <a class="nav-link text-center" aria-current="page" href="index.php">
            <i class="fa fa-dashboard"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" href="student.php">
            <i class="fa fa-users"></i> Student
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" href="course.php">
            <i class="fa fa-book"></i> Course
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" href="section.php">
            <i class="fa fa-th-large"></i> Section
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" href="message.php">
            <i class="fa fa-envelope"></i> Message
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" href="settings.php">
            <i class="fa fa-cogs"></i> Settings
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" href="attendance.php">
            <i class="fa fa-calendar-check-o"></i> Attendance
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-center" href="result.php">
            <i class="fa fa-bar-chart"></i> Result
          </a>
        </li>
      </ul>
      <ul class="navbar-nav me-right mb-2 mb-lg-0 bg-danger rounded">
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">
            <i class="fa fa-sign-out"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<style>
  /* Remove or comment out the highlight style */
  /*
  .nav-link.active {
    background: linear-gradient(90deg, #2563eb 0%, #b377f6ff 100%) !important;
    color: #fff !important;
    border-radius: 6px;
    font-weight: 700;
    box-shadow: 0 2px 8px #2563eb22;
  }
  */
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">