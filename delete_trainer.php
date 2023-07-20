

<?php

require_once 'config/connect.php';

if(!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = 'Enter Username and Password to continue!';
    header('location: index.php');
    exit();
} 

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $trainer_id = $_POST['trainer_id'];

    $sql = "DELETE FROM trainers WHERE trainer_id = ?";
    $run = $conn->prepare($sql);
    $run->bind_param("i", $trainer_id);
    $message = "";

    if($run->execute()) {
        echo $message = "The Trainer has been deleted";
    } else {
        echo $message = "The Trainer has not been deleted";
    }

    $_SESSION['success_message'] = $message;
    header("location: trainers.php");
    exit();
}

?>