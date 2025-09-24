<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}
include '../DB_connection.php';
$students = $conn->query("SELECT student_id, fname, lname FROM students")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Result</title>
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
        .result-add-card {
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
        .btn-success {
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .result-add-card {
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
    }
    </script>
</head>
<body>
<?php include "inc/navbar.php"; ?>
<div class="result-add-card">
    <div class="school-header">
        <img src="../logo2.png" alt="Shree School Logo">
        <div>
            <div class="school-title">Shree School</div>
            <div style="font-size:1.1rem;color:#555;">Add Result</div>
        </div>
    </div>
    <div class="text-center mb-3">
        <a href="result.php" class="btn btn-dark">Go Back</a>
    </div>
    <form method="post" action="req/result-add.php" oninput="updateTotalAndPercentage()">
        <div class="mb-3">
            <label class="form-label">Student</label>
            <select name="student_id" class="form-select" required>
                <option value="">Select Student</option>
                <?php foreach($students as $stu): ?>
                    <option value="<?= $stu['student_id'] ?>">
                        <?= $stu['student_id'] ?> - <?= htmlspecialchars($stu['fname'].' '.$stu['lname']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Maths Marks</label>
            <input type="number" step="0.01" name="maths" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gujarati Marks</label>
            <input type="number" step="0.01" name="gujarati" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">English Marks</label>
            <input type="number" step="0.01" name="english" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="text" id="total" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Percentage</label>
            <input type="text" id="percentage" class="form-control" readonly>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success px-5">Add Result</button>
        </div>
    </form>
</div>
<script>updateTotalAndPercentage();</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
         $("#navLinks .nav-link").removeClass("active");
         $("#navLinks .nav-link[href='result.php']").addClass('active');
    });
</script>
</body>
</html>