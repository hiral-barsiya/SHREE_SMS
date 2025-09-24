<?php
session_start();
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../login.php");
    exit;
}
include '../DB_connection.php';

// Fetch all sections/classes
$sections = $conn->query("SELECT * FROM section")->fetchAll(PDO::FETCH_ASSOC);

// Filter by section/class if selected
$selected_section = isset($_GET['section_id']) ? $_GET['section_id'] : 'all';

$sql = "SELECT r.*, s.roll_no, s.fname, s.lname, sec.section 
        FROM result r 
        JOIN students s ON r.student_id = s.student_id 
        JOIN section sec ON s.section = sec.section_id";
$params = [];
if ($selected_section != 'all') {
    $sql .= " WHERE s.section = ?";
    $params[] = $selected_section;
}
$sql .= " ORDER BY r.result_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Results</title>
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
        .result-card {
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
        .btn-primary, .btn-success {
            font-weight: 600;
        }
        .center-btns {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 24px;
        }
        .filter-form {
            max-width: 350px;
            margin: 0 auto 18px auto;
        }
        @media (max-width: 900px) {
            .result-card {
                padding: 18px 2vw;
                max-width: 99vw;
            }
            .school-title {
                font-size: 1.2rem;
            }
            .center-btns {
                flex-direction: column;
                gap: 10px;
            }
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
            <div style="font-size:1.1rem;color:#555 ; ">All Students Results</div>
        </div>
    </div>
    <div class="center-btns">
        <a href="result-add.php" class="btn btn-success"><i class="fa fa-plus"></i> Add Result</a>
    </div>
    <!-- Class/Section Filter -->
    <form method="get" class="filter-form">
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
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    <div class="table-responsive">
    <table class="table table-bordered result-table mx-auto">
        <thead>
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th>Class</th>
                <th>Maths</th>
                <th>Gujarati</th>
                <th>English</th>
                <th>Total</th>
                <th>Percentage</th>
                <th>Grade</th>
                <th>Result</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['roll_no']) ?></td>
                <td><?= htmlspecialchars($row['fname'].' '.$row['lname']) ?></td>
                <td><?= htmlspecialchars($row['section']) ?></td>
                <td><?= htmlspecialchars($row['maths']) ?></td>
                <td><?= htmlspecialchars($row['gujarati']) ?></td>
                <td><?= htmlspecialchars($row['english']) ?></td>
                <td><?= htmlspecialchars($row['total']) ?></td>
                <td><?= round($row['percentage'],2) ?>%</td>
                <td><?= htmlspecialchars($row['grade']) ?></td>
                <td>
                    <?php if ($row['result'] == 'Pass'): ?>
                        <span class="badge bg-success">Pass</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Fail</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="result-edit.php?id=<?= $row['result_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>