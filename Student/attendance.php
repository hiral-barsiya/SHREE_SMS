<?php
session_start();
if (!isset($_SESSION['student_id']) || $_SESSION['role'] != 'Student') {
    header("Location: ../login.php");
    exit;
}
include '../DB_connection.php';

$student_id = $_SESSION['student_id'];
$total = $present = $absent = 0;

// Fetch all attendance records for the student
$stmt = $conn->prepare("SELECT date, status FROM attendance WHERE student_id=? ORDER BY date DESC");
$stmt->execute([$student_id]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($records as $rec) {
    $total++;
    if ($rec['status'] == 'Present')
        $present++;
    else
        $absent++;
}

$present_percent = $total ? round(($present / $total) * 100, 1) : 0;
$absent_percent = $total ? round(($absent / $total) * 100, 1) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: url('../img/back.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .attendance-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 32px 24px 24px 24px;
            max-width: 700px;
            margin: 40px auto 0 auto;
        }

        .attendance-title {
            font-size: 1.7rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 18px;
            text-align: center;
        }

        .attendance-table th {
            background: #2563eb;
            color: #fff;
            text-align: center;
        }

        .attendance-table td,
        .attendance-table th {
            text-align: center;
            vertical-align: middle;
        }

        .attendance-table tr td.status-present {
            color: #22c55e;
            font-weight: 600;
        }

        .attendance-table tr td.status-absent {
            color: #ef4444;
            font-weight: 600;
        }

        .attendance-summary {
            margin-top: 18px;
            text-align: center;
        }

        .attendance-chart-container {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
        }

        #attendanceChart {
            max-width: 160px !important;
            max-height: 160px !important;
        }

        @media (max-width: 800px) {
            .attendance-card {
                padding: 12px 2vw;
                max-width: 99vw;
            }

            .attendance-title {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <?php include "inc/navbar.php"; ?>
    <div class="attendance-card">
        <div class="attendance-title">My Attendance</div>
        <div class="attendance-chart-container">
            <canvas id="attendanceChart" width="160" height="160"></canvas>
        </div>
        <div class="attendance-summary">
            <b>Total Days:</b> <?= $total ?> &nbsp; | &nbsp;
            <b>Present:</b> <?= $present ?> &nbsp; | &nbsp;
            <b>Absent:</b> <?= $absent ?>
        </div>
        <?php if ($total > 0): ?>
            <div class="table-responsive mt-4">
                <table class="table table-bordered attendance-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($records as $rec): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d-M-Y', strtotime($rec['date'])) ?></td>
                                <td class="status-<?= strtolower($rec['status']) ?>">
                                    <?= $rec['status'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-4 text-center">No attendance records found.</div>
        <?php endif; ?>
    </div>
    <script>
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Present (<?= $present_percent ?>%)', 'Absent (<?= $absent_percent ?>%)'],
                datasets: [{
                    data: [<?= $present ?>, <?= $absent ?>],
                    backgroundColor: ['#22c55e', '#ef4444']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            font: { size: 13 }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>