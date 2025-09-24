<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}
include '../DB_connection.php';

if (!isset($_GET['id'])) {
    header("Location: result.php?error=No+result+selected");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM result WHERE result_id=?");
$stmt->execute([$id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    header("Location: result.php?error=Result+not+found");
    exit;
}

$stu_stmt = $conn->prepare("SELECT student_id, fname, lname FROM students WHERE student_id=?");
$stu_stmt->execute([$result['student_id']]);
$student = $stu_stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Result</title>
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
        .result-edit-card {
            background: rgba(255,255,255,0.97);
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 36px 28px 24px 28px;
            max-width: 500px;
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
        .btn-primary, .btn-secondary {
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .result-edit-card {
                padding: 18px 2vw;
                max-width: 99vw;
            }
            .school-title {
                font-size: 1.2rem;
            }
        }
    </style>
    <script>
    function updateTotalAndPercentage() {
        let maths = parseFloat(document.getElementsByName('maths')[0].value) || 0;
        let gujarati = parseFloat(document.getElementsByName('gujarati')[0].value) || 0;
        let english = parseFloat(document.getElementsByName('english')[0].value) || 0;
        let total = maths + gujarati + english;
        let percentage = total / 3;
        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('percentage').value = percentage.toFixed(2);

        // Grade calculation (for display only)
        let grade = '';
        if (percentage >= 80) grade = 'A';
        else if (percentage >= 70) grade = 'B';
        else if (percentage >= 60) grade = 'C';
        else if (percentage >= 50) grade = 'D';
        else grade = 'F';
        document.getElementById('grade').value = grade;
    }
    </script>
</head>
<body>
<?php include "inc/navbar.php"; ?>
<div class="result-edit-card">
    <div class="school-header">
        <img src="../logo2.png" alt="Shree School Logo">
        <div>
            <div class="school-title">Shree School</div>
            <div style="font-size:1.1rem;color:#555;">Edit Result</div>
        </div>
    </div>
    <form method="post" action="req/result-edit.php" oninput="updateTotalAndPercentage()">
        <input type="hidden" name="result_id" value="<?= $result['result_id'] ?>">
        <div class="mb-3">
            <label class="form-label">Student</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($student['student_id'].' - '.$student['fname'].' '.$student['lname']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Maths Marks</label>
            <input type="number" step="0.01" name="maths" class="form-control" value="<?= htmlspecialchars($result['maths']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gujarati Marks</label>
            <input type="number" step="0.01" name="gujarati" class="form-control" value="<?= htmlspecialchars($result['gujarati']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">English Marks</label>
            <input type="number" step="0.01" name="english" class="form-control" value="<?= htmlspecialchars($result['english']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="text" id="total" class="form-control" value="<?= htmlspecialchars($result['total']) ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Percentage</label>
            <input type="text" id="percentage" class="form-control" value="<?= htmlspecialchars($result['percentage']) ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Grade</label>
            <input type="text" id="grade" class="form-control" value="<?= htmlspecialchars($result['grade']) ?>" readonly>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5">Update Result</button>
            <a href="result.php" class="btn btn-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
<script>
    updateTotalAndPercentage();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
         $("#navLinks .nav-link").removeClass("active");
         $("#navLinks .nav-link[href='result.php']").addClass('active');
    });
</script>
</body>
</html>