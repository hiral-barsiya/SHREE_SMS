<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['student_id'])) {

    if ($_SESSION['role'] == 'Admin') {
      
       include "../DB_connection.php";
       include "data/student.php";
       include "data/section.php";
       $sections = getAllsections($conn);
       
       $student_id = $_GET['student_id'];
       $student = getStudentById($student_id, $conn);

       if ($student == 0) {
         header("Location: student.php");
         exit;
       }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Student</title>
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
        .student-edit-card {
            background: rgba(255,255,255,0.97);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 36px 28px 24px 28px;
            max-width: 650px;
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
        .btn-dark, .btn-primary {
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .student-edit-card {
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
    <?php include "inc/navbar.php"; ?>
    <div class="student-edit-card">
        <div class="school-header">
            <img src="../logo2.png" alt="Shree School Logo">
            <div>
                <div class="school-title">Shree School</div>
                <div style="font-size:1.1rem;color:#555;">Edit Student Information</div>
            </div>
        </div>
        <div class="text-center mb-3">
            <a href="student.php" class="btn btn-dark">Go Back</a>
        </div>
        <form method="post" action="req/student-edit.php">
            <?php if (isset($_GET['error'])) { ?>
              <div class="alert alert-danger" role="alert">
               <?= $_GET['error'] ?>
              </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
              <div class="alert alert-success" role="alert">
               <?= $_GET['success'] ?>
              </div>
            <?php } ?>
            <div class="mb-3">
              <label class="form-label">Roll No</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($student['roll_no']) ?>" name="roll_no" required>
            </div>
            <div class="mb-3">
              <label class="form-label">First name</label>
              <input type="text" class="form-control" value="<?= $student['fname'] ?>" name="fname">
            </div>
            <div class="mb-3">
              <label class="form-label">Last name</label>
              <input type="text" class="form-control" value="<?= $student['lname'] ?>" name="lname">
            </div>
            <div class="mb-3">
              <label class="form-label">Address</label>
              <input type="text" class="form-control" value="<?= $student['address'] ?>" name="address">
            </div>
            <div class="mb-3">
              <label class="form-label">Email address</label>
              <input type="text" class="form-control" value="<?= $student['email_address'] ?>" name="email_address">
            </div>
            <div class="mb-3">
              <label class="form-label">Date of birth</label>
              <input type="date" class="form-control" value="<?= $student['date_of_birth'] ?>" name="date_of_birth">
            </div>
            <div class="mb-3">
              <label class="form-label">Gender</label><br>
              <input type="radio" value="Male" <?php if($student['gender'] == 'Male') echo 'checked';  ?> name="gender"> Male
              &nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" value="Female" <?php if($student['gender'] == 'Female') echo 'checked';  ?> name="gender"> Female
            </div>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" value="<?= $student['username'] ?>" name="username">
            </div>
            <input type="hidden" value="<?= $student['student_id'] ?>" name="student_id">
            <div class="mb-3">
              <label class="form-label">Class</label>
              <div class="row row-cols-5">
                <?php 
                $section_ids = str_split(trim($student['section']));
                foreach ($sections as $section){ 
                  $checked =0;
                  foreach ($section_ids as $section_id ) {
                    if ($section_id == $section['section_id']) {
                       $checked =1;
                    }
                  }
                ?>
                <div class="col">
                  <input type="radio"
                         name="section"
                         <?php if($checked) echo "checked"; ?>
                         value="<?= $section['section_id'] ?>">
                         <?= $section['section'] ?>
                </div>
                <?php } ?>
              </div>
            </div>
            <!-- Static Subjects Display (not editable, not from DB) -->
            <div class="mb-3">
              <label class="form-label">Subjects</label>
              <ul class="list-group">
                <li class="list-group-item">Maths</li>
                <li class="list-group-item">Gujarati</li>
                <li class="list-group-item">English</li>
              </ul>
              <small class="text-muted">Subjects are static and cannot be changed.</small>
            </div>
            <hr>
            <h5 class="mb-3">Parent Information</h5>
            <div class="mb-3">
              <label class="form-label">Parent first name</label>
              <input type="text" class="form-control" value="<?= $student['parent_fname'] ?>" name="parent_fname">
            </div>
            <div class="mb-3">
              <label class="form-label">Parent last name</label>
              <input type="text" class="form-control" value="<?= $student['parent_lname'] ?>" name="parent_lname">
            </div>
            <div class="mb-3">
              <label class="form-label">Parent phone number</label>
              <input type="text" class="form-control" value="<?= $student['parent_phone_number'] ?>" name="parent_phone_number">
            </div>
            <div class="mb-3">
              <label class="form-label">Caste</label>
              <input type="text" name="caste" class="form-control" value="<?= htmlspecialchars($student['caste']) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Mobile Number</label>
              <input type="text" name="mobile_number" class="form-control" value="<?= htmlspecialchars($student['mobile_number']) ?>" required>
            </div>
            <div class="text-center mt-4">
              <button type="submit" class="btn btn-primary px-5">Update</button>
            </div>
        </form>
    </div>
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
    header("Location: student.php");
    exit;
} 

?>