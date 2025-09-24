<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/message.php";
       $messages = getAllMessages($conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Messages</title>
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
        .message-card {
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
        .accordion-button {
            font-weight: 600;
            color: #2563eb;
            background: #f1f5ff;
        }
        .accordion-button:not(.collapsed) {
            background: #2563eb;
            color: #fff;
        }
        .accordion-body {
            background: #f8fafc;
        }
        .alert-info {
            background: #e0e7ff;
            color: #2563eb;
            border: none;
        }
        @media (max-width: 900px) {
            .message-card {
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
    <div class="message-card">
        <div class="school-header">
            <img src="../logo2.png" alt="Shree School Logo">
            <div>
                <div class="school-title">Shree School</div>
                <div style="font-size:1.1rem;color:#555;">Inbox</div>
            </div>
        </div>
        <?php if ($messages != 0) { ?>
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <?php foreach ($messages as $message) { ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading_<?=$message['message_id']?>">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_<?=$message['message_id']?>" aria-expanded="false" aria-controls="flush-collapse_<?=$message['message_id']?>">
                <i class="fa fa-user"></i> <?=$message['sender_full_name']?> 
              </button>
            </h2>
            <div id="flush-collapse_<?=$message['message_id']?>" class="accordion-collapse collapse" aria-labelledby="flush-heading_<?=$message['message_id']?>" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                <div class="mb-2" style="font-size:1.1rem;"><?= nl2br(htmlspecialchars($message['message'])) ?></div>
                <div class="d-flex mb-3">
                    <div class="p-2"><i class="fa fa-envelope"></i> <b><?=$message['sender_email']?></b></div>
                    <div class="ms-auto p-2"><i class="fa fa-calendar"></i> <?=$message['date_time']?></div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php } else { ?>
            <div class="alert alert-info w-100 m-5 text-center" role="alert">
                Empty!
            </div>
        <?php } ?>
    </div>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks .nav-link").removeClass("active");
             $("#navLinks .nav-link[href='message.php']").addClass('active');
        });
    </script>
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