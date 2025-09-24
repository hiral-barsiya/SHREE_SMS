<?php
session_start();
if (!isset($_SESSION['student_id']) || $_SESSION['role'] != 'Student') {
    header("Location: ../login.php");
    exit;
}
include '../DB_connection.php';
$student_id = $_SESSION['student_id'];
$stmt = $conn->prepare("SELECT * FROM result WHERE student_id=?");
$stmt->execute([$student_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch student info
$stu_stmt = $conn->prepare("SELECT s.student_id, s.fname, s.lname, s.section, sec.section AS section_name FROM students s LEFT JOIN section sec ON s.section = sec.section_id WHERE s.student_id=?");
$stu_stmt->execute([$student_id]);
$student = $stu_stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Results - Shree School</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo2.png">
    <style>
        body {
            background: url('../img/back.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .result-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
            padding: 32px 28px 24px 28px;
            max-width: 700px;
            margin: 40px auto;
        }

        .school-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-bottom: 18px;
        }

        .school-header img {
            height: 64px;
            width: 64px;
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

        .student-info {
            margin-bottom: 18px;
            background: #f4f6fa;
            border-radius: 8px;
            padding: 16px 18px;
            font-size: 1.1rem;
        }

        .result-table th {
            background: #2563eb;
            color: #fff;
            text-align: center;
        }

        .result-table td {
            text-align: center;
            font-weight: 500;
        }

        .result-table {
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <?php include "inc/navbar.php"; ?>
    <div class="result-card">
        <div class="school-header">
            <img src="../logo2.png" alt="Shree School Logo">
            <div>
                <div class="school-title">Shree School</div>
                <div style="font-size:1.1rem;color:#555;">Student Result Sheet</div>
            </div>
        </div>
        <div class="student-info row">
            <div class="col-md-6"><b>Name:</b> <?= htmlspecialchars($student['fname'] . ' ' . $student['lname']) ?></div>
            <div class="col-md-3"><b>ID:</b> <?= htmlspecialchars($student['student_id']) ?></div>
            <div class="col-md-3"><b>Class:</b> <?= htmlspecialchars($student['section_name'] ?? $student['section']) ?></div>
        </div>
        <?php if (!empty($results)):
            $row = $results[0]; // Show latest or first result
        ?>
            <table class="table table-bordered result-table">

                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <th>
                                Subjects
                            </th>
                            <th>
                                Obtained Marks
                            </th>
                            <th>
                                Marks
                            </th>
                        <tr>
                            <td>Maths</td>
                            <td>100</td>
                            <td><?= htmlspecialchars($row['maths']) ?></td>
                        </tr>
                        <tr>

                            <td>Gujarati</td>
                            <td>100</td>
                            <td><?= htmlspecialchars($row['gujarati']) ?></td>
                        </tr>
                        <tr>

                            <td>English</td>
                            <td>100</td>
                            <td><?= htmlspecialchars($row['english']) ?></td>
                        </tr>

                        <tr bgcolor="#808080" style="color:#fff;">
                            <td><b>Total</b></td>
                            <td>300</td>
                            <td><?= htmlspecialchars($row['total']) ?></td>
                        </tr>
                        <tr rowspan="2">
                            <td>Percentage</td>
                            <td>Grade</td>
                            <td>Result</td>
                        </tr>
                        <tr>
                            <td><?= round($row['percentage'], 2) ?>%</td>
                            <td><?= htmlspecialchars($row['grade']) ?></td>
                            <td>
                                <?php if ($row['result'] == 'Pass'): ?>
                                    <span class="badge bg-success">Pass</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Fail</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        </tr>




                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center mt-4">No result found.</div>
        <?php endif; ?>
    </div>
</body>

</html>