<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}
include '../DB_connection.php';

// Fetch sections
$sections = $conn->query("SELECT * FROM section")->fetchAll(PDO::FETCH_ASSOC);

$students = [];
if (isset($_GET['section_id'])) {
    $section_id = $_GET['section_id'];
    $students = $conn->prepare("SELECT * FROM students WHERE section=?");
    $students->execute([$section_id]);
    $students = $students->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background: url('../img/back.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .attendance-card {
            background: rgba(255,255,255,0.97);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 36px 28px 24px 28px;
            max-width: 700px;
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
        .btn-primary, .btn-success {
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .attendance-card {
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
<div class="attendance-card">
    <div class="school-header">
        <img src="../logo2.png" alt="Shree School Logo">
        <div>
            <div class="school-title">Shree School</div>
            <div style="font-size:1.1rem;color:#555;">Attendance</div>
        </div>
    </div>
    <form method="get" class="mb-4 text-center">
        <label class="mb-2"><b>Select Class/Section:</b></label>
        <select name="section_id" class="form-select d-inline-block" style="max-width:300px;display:inline-block;">
            <option value="">Select</option>
            <?php foreach($sections as $sec): ?>
                <option value="<?= $sec['section_id'] ?>" <?= (isset($_GET['section_id']) && $_GET['section_id']==$sec['section_id'])?'selected':'' ?>>
                    <?= htmlspecialchars($sec['section']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary ms-2">Show Students</button>
    </form>
    <?php if ($students): ?>
    <form method="post" action="req/attendance-add.php">
        <input type="hidden" name="section_id" value="<?= htmlspecialchars($_GET['section_id']) ?>">
        <div class="table-responsive">
        <table class="table table-bordered mt-3 n-table mx-auto">
            <thead>
                <tr>
                    <th>Roll No</th>
                    <th>Student Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($students as $stu): ?>
                <tr>
                    <td><?= htmlspecialchars($stu['roll_no']) ?></td>
                    <td><?= htmlspecialchars($stu['fname'].' '.$stu['lname']) ?></td>
                    <td>
                        <select name="attendance[<?= $stu['student_id'] ?>]" class="form-select">
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div class="mb-3 mt-3">
            <label><b>Date:</b></label>
            <input type="date" name="date" value="<?= date('Y-m-d') ?>" required class="form-control d-inline-block" style="max-width:200px;display:inline-block;">
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success mt-2 px-5">Submit Attendance</button>
        </div>
    </form>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
         $("#navLinks .nav-link").removeClass("active");
         $("#navLinks .nav-link[href='attendance.php']").addClass('active');
    });
</script>
</body>
</html>