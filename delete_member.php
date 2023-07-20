

<?php

require_once 'config/connect.php';

if(!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = 'Enter Username and Password to continue!';
    header('location: index.php');
    exit();
} 

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $member_id = $_POST['member_id'];

    //Select files from db
    $sql = "SELECT access_card_pdf_path, photo_path FROM `members` WHERE member_id = ?";
    $run = $conn->prepare($sql);
    $run->bind_param("i", $member_id);
    $run->execute();

    $result = $run->get_result();
    $row = $result->fetch_assoc();

    //Delete the files from local storage (server)
    $access_card_path = $row['access_card_pdf_path'];
    $photo_path = $row['photo_path'];

    if (file_exists($access_card_path)) {
        unlink($access_card_path);
    }

    if (file_exists($photo_path)) {
        unlink($photo_path);
    }


    // Delete the Member
    $sql_delete = "DELETE FROM members WHERE member_id = ?";
    $run_delete = $conn->prepare($sql_delete);
    $run_delete->bind_param("i", $member_id);
    $message = "";

    if($run_delete->execute()) {
        echo $message = "The Member and associated files have been deleted";
    } else {
        echo $message = "Failed to delete the Member or some associated files";
    }

    $_SESSION['success_message'] = $message;
    header("location: members.php");
    exit();
}

?>