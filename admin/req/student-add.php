<?php
session_start();
if (
    isset($_SESSION['admin_id']) &&
    isset($_SESSION['role'])
) {

    if ($_SESSION['role'] == 'Admin') {

        if (
            isset($_POST['fname']) &&
            isset($_POST['lname']) &&
            isset($_POST['username']) &&
            isset($_POST['pass'])     &&
            isset($_POST['address'])  &&
            isset($_POST['gender'])   &&
            isset($_POST['email_address']) &&            
            isset($_POST['date_of_birth']) &&
            isset($_POST['parent_fname'])  &&
            isset($_POST['parent_lname'])  &&
            isset($_POST['parent_phone_number']) &&
            isset($_POST['section']) &&
            isset($_POST['roll_no']) // <-- Add this line
        ) {

            include '../../DB_connection.php';
            include "../data/student.php";

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $uname = $_POST['username'];
            $pass = $_POST['pass'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $email_address = $_POST['email_address'];
            $date_of_birth = $_POST['date_of_birth'];
            $parent_fname = $_POST['parent_fname'];
            $parent_lname = $_POST['parent_lname'];
            $parent_phone_number = $_POST['parent_phone_number'];
            $section = $_POST['section'];
            $caste = $_POST['caste'];
            $mobile_number = $_POST['mobile_number'];
            $roll_no = $_POST['roll_no']; // <-- Add this line

            $data = 'uname=' . $uname . '&fname=' . $fname . '&lname=' . $lname . '&address=' . $address . '&gender=' . $email_address . '&pfn=' . $parent_fname . '&pln=' . $parent_lname . '&ppn=' . $parent_phone_number . '&roll_no=' . $roll_no;

            if (empty($fname)) {
                $em  = "First name is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($lname)) {
                $em  = "Last name is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($uname)) {
                $em  = "Username is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (!unameIsUnique($uname, $conn)) {
                $em  = "Username is taken! try another";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($pass)) {
                $em  = "Password is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($address)) {
                $em  = "Address is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($gender)) {
                $em  = "Gender is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($email_address)) {
                $em  = "Email address is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($date_of_birth)) {
                $em  = "Date of birth is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($parent_fname)) {
                $em  = "Parent first name is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($parent_lname)) {
                $em  = "Parent last name is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($parent_phone_number)) {
                $em  = "Parent phone number is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($section)) {
                $em  = "Section is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else if (empty($roll_no)) {
                $em  = "Roll number is required";
                header("Location: ../student-add.php?error=$em&$data");
                exit;
            } else {
                // Check if roll_no is unique in the section
                $stmt = $conn->prepare("SELECT * FROM students WHERE roll_no = ? AND section = ?");
                $stmt->execute([$roll_no, $section]);
                if ($stmt->rowCount() > 0) {
                    $em = "Roll number already exists in this section!";
                    header("Location: ../student-add.php?error=$em&$data");
                    exit;
                }

                $sql = "INSERT INTO students (roll_no, username, password, fname, lname, section, address, gender, caste, mobile_number, email_address, date_of_birth, parent_fname, parent_lname, parent_phone_number)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$roll_no, $uname, $pass, $fname, $lname, $section, $address, $gender, $caste, $mobile_number, $email_address, $date_of_birth, $parent_fname, $parent_lname, $parent_phone_number]);
                $sm = "New student registered successfully";
                header("Location: ../student-add.php?success=$sm");
                exit;
            }
        } else {
            $em = "An error occurred";
            header("Location: ../student-add.php?error=$em");
            exit;
        }
    } else {
        header("Location: ../../logout.php");
        exit;
    }
} else {
    header("Location: ../../logout.php");
    exit;
}
