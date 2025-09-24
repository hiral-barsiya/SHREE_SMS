<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       if (isset($_GET['searchKey'])) {

       $search_key = $_GET['searchKey'];
       include "../DB_connection.php";
       include "data/student.php";
       $students = searchStudents($search_key, $conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Search Students</title>
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
     <div class="students-card">
        <div class="school-header">
            <img src="../logo2.png" alt="Shree School Logo">
            <div>
                <div class="school-title">Shree School</div>
                <div style="font-size:1.1rem;color:#555;">Search Results</div>
            </div>
        </div>
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
                    <td>
                        <a href="student-edit.php?student_id=<?=$student['student_id']?>"
                           class="btn btn-warning">Edit</a>
                        <a href="student-delete.php?student_id=<?=$student['student_id']?>"
                           class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-3">
            <a href="student.php" class="btn btn-dark">Go Back</a>
        </div>
     </div>
     <?php }else{ ?>
         <div class="students-card text-center">
            <div class="school-header">
                <img src="../logo2.png" alt="Shree School Logo">
                <div>
                    <div class="school-title">Shree School</div>
                    <div style="font-size:1.1rem;color:#555;">Search Results</div>
                </div>
            </div>
            <div class="alert alert-info w-100 m-5" role="alert">
                No Results Found
            </div>
            <a href="student.php" class="btn btn-dark">Go Back</a>
         </div>
     <?php } ?>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(3) a").addClass('active');
        });
    </script>
</body>
</html>
<?php 
    }else {
      header("Location: student.php");
      exit;
    } 

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
    header("Location: ../login.php");
    exit;
} 

?>