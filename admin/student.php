<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/student.php";
       include "data/section.php";
       
       $sections = getAllSections($conn);

       // Filter students by section if selected
       $selected_section = isset($_GET['section_id']) ? $_GET['section_id'] : '';
       if ($selected_section && $selected_section != 'all') {
           $students = getStudentsBySection($selected_section, $conn);
       } else {
           $students = getAllStudents($conn);
       }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Students</title>
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
        .students-card {
            background: rgba(255,255,255,0.97);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 36px 28px 24px 28px;
            max-width: 1100px;
            margin: 50px auto 0 auto;
        }
        .school-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-bottom: 18px;
        }
        .school-header img {
            height: 56px;
            width: 56px;
            border-radius: 50%;
            border: 2px solid #2563eb;
            background: #fff;
        }
        .school-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2563eb;
            letter-spacing: 1px;
        }
        .table thead th {
            background: #2563eb;
            color: #fff;
            text-align: center;
        }
        .table td, .table th {
            text-align: center;
            vertical-align: middle;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 0;
        }
        .btn-dark, .btn-primary, .btn-warning, .btn-danger {
            font-weight: 600;
        }
        .input-group .form-control {
            border-radius: 8px 0 0 8px;
        }
        .input-group .btn {
            border-radius: 0 8px 8px 0;
        }
        @media (max-width: 900px) {
            .students-card {
                padding: 18px 2vw;
                max-width: 99vw;
            }
            .school-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if ($students != 0) {
     ?>
     <div class="container mt-4">
      <div class="card shadow-lg" style="border-radius:18px;background:rgba(255,255,255,0.97);">
        <div class="card-body">
          <div class="school-header mb-2">
            <img src="../logo2.png" alt="Shree School Logo">
            <div>
              <div class="school-title">Shree School</div>
              <div style="font-size:1.1rem;color:#555;">Student List</div>
            </div>
          </div>
          <div class="text-center mb-3">
              <a href="student-add.php" class="btn btn-dark">Add New Student</a>
          </div>
          <!-- Section/Class Filter -->
          <form method="get" class="mb-3" style="max-width:350px;margin:auto;">
            <div class="input-group">
              <select name="section_id" class="form-select" onchange="this.form.submit()">
                <option value="all">All Classes</option>
                <?php foreach($sections as $section): ?>
                  <option value="<?= $section['section_id'] ?>" <?= ($selected_section == $section['section_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($section['section']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <button class="btn btn-primary" type="submit">Filter</button>
            </div>
          </form>
          <form action="student-search.php" class="mt-3 n-table" method="get" style="max-width:400px;margin:auto;">
              <div class="input-group mb-3">
                  <input type="text" class="form-control" name="searchKey" placeholder="Search...">
                  <button class="btn btn-primary">
                      <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
              </div>
          </form>

          <?php if (isset($_GET['error'])) { ?>
              <div class="alert alert-danger mt-3 n-table text-center" role="alert">
                <?=$_GET['error']?>
              </div>
          <?php } ?>

          <?php if (isset($_GET['success'])) { ?>
              <div class="alert alert-info mt-3 n-table text-center" role="alert">
                <?=$_GET['success']?>
              </div>
          <?php } ?>

          <div class="table-responsive">
              <table class="table table-bordered mt-3 n-table mx-auto">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Roll No</th>
                      <th scope="col">ID</th>
                      <th scope="col">First Name</th>
                      <th scope="col">Last Name</th>
                      <th scope="col">Username</th>
                      <th scope="col">Caste</th>
                      <th scope="col">Mobile Number</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; foreach ($students as $student ) { 
                      $i++;  ?>
                    <tr>
                      <th scope="row"><?=$i?></th>
                      <td><?=htmlspecialchars($student['roll_no'])?></td>
                      <td><?=$student['student_id']?></td>
                      <td>
                        <a href="student-view.php?student_id=<?=$student['student_id']?>">
                          <?=$student['fname']?>
                        </a>
                      </td>
                      <td><?=$student['lname']?></td>
                      <td><?=$student['username']?></td>
                      <td><?= htmlspecialchars($student['caste']) ?></td>
                      <td><?= htmlspecialchars($student['mobile_number']) ?></td>
                      <td>
                          <a href="student-edit.php?student_id=<?=$student['student_id']?>" class="btn btn-warning">Edit</a>
                          <a href="student-delete.php?student_id=<?=$student['student_id']?>" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                  <?php } ?>
                  </tbody>
              </table>
          </div>
        </div>
      </div>
     </div>
     <?php }else{ ?>
         <div class="students-card text-center">
            <div class="school-header">
                <img src="../logo2.png" alt="Shree School Logo">
                <div>
                    <div class="school-title">Shree School</div>
                    <div style="font-size:1.1rem;color:#555;">Student List</div>
                </div>
            </div>
            <div class="alert alert-info w-100 m-5" role="alert">
                Empty!
            </div>
         </div>
     <?php } ?>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
</body>
</html>
<?php 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
    header("Location: ../login.php");
    exit;
} 

?>