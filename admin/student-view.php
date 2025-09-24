<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/student.php";
       include "data/section.php";

       if(isset($_GET['student_id'])){

       $student_id = $_GET['student_id'];
       $student = getStudentById($student_id, $conn);    
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student - View</title>
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
        .student-view-card {
            background: rgba(255,255,255,0.97);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 36px 28px 24px 28px;
            max-width: 480px;
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
        .student-img {
            display: block;
            margin: 0 auto 18px auto;
            border-radius: 50%;
            border: 3px solid #2563eb;
            width: 110px;
            height: 110px;
            object-fit: cover;
            background: #fff;
        }
        .list-group-item {
            font-size: 1.05rem;
        }
        .table th {
            width: 40%;
        }
        .card-link {
            color: #2563eb;
            font-weight: 600;
        }
        @media (max-width: 600px) {
            .student-view-card {
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
        if ($student != 0) {
     ?>
     <div class="student-view-card">
        <div class="school-header mb-2">
            <img src="../logo2.png" alt="Shree School Logo">
            <div>
                <div class="school-title">Shree School</div>
                <div style="font-size:1.1rem;color:#555;">Student Details</div>
            </div>
        </div>
        <img src="../img/student-<?=$student['gender']?>.png" class="student-img" alt="Student">
        <h5 class="text-center mb-3">@<?=htmlspecialchars($student['username'])?></h5>
        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item"><b>Roll No:</b> <?= htmlspecialchars($student['roll_no']) ?></li>
            <li class="list-group-item"><b>First name:</b> <?= htmlspecialchars($student['fname']) ?></li>
            <li class="list-group-item"><b>Last name:</b> <?= htmlspecialchars($student['lname']) ?></li>
            <li class="list-group-item"><b>Username:</b> <?= htmlspecialchars($student['username']) ?></li>
            <li class="list-group-item"><b>Address:</b> <?= htmlspecialchars($student['address']) ?></li>
            <li class="list-group-item"><b>Date of birth:</b> <?= htmlspecialchars($student['date_of_birth']) ?></li>
            <li class="list-group-item"><b>Email address:</b> <?= htmlspecialchars($student['email_address']) ?></li>
            <li class="list-group-item"><b>Gender:</b> <?= htmlspecialchars($student['gender']) ?></li>
            <li class="list-group-item"><b>Date of joined:</b> <?= htmlspecialchars($student['date_of_joined']) ?></li>
            <li class="list-group-item"><b>Section:</b> 
                 <?php 
                    $section = $student['section'];
                    $s = getSectioById($section, $conn);
                    echo htmlspecialchars($s['section']);
                  ?>
            </li>
        </ul>
        <h6 class="mt-3 mb-2 text-primary">Parent Information</h6>
        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item"><b>Parent first name:</b> <?= htmlspecialchars($student['parent_fname']) ?></li>
            <li class="list-group-item"><b>Parent last name:</b> <?= htmlspecialchars($student['parent_lname']) ?></li>
            <li class="list-group-item"><b>Parent phone number:</b> <?= htmlspecialchars($student['parent_phone_number']) ?></li>
        </ul>
        <table class="table table-bordered mb-3">
            <tr>
              <th>Caste</th>
              <td><?= htmlspecialchars($student['caste']) ?></td>
            </tr>
            <tr>
              <th>Mobile Number</th>
              <td><?= htmlspecialchars($student['mobile_number']) ?></td>
            </tr>
        </table>
        <div class="text-center">
            <a href="student.php" class="card-link">Go Back</a>
        </div>
     </div>
     <?php 
        }else {
          header("Location: student.php");
          exit;
        }
     ?>
     
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