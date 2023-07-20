<?php


require_once 'config/connect.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $member_id = $_POST['member'];
    $trainer_id = $_POST['trainer'];

    $sql = "UPDATE members SET trainer_id = ? WHERE member_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $trainer_id, $member_id);

    $stmt->execute();

    $_SESSION['success_message'] = "Trainer successfully added to member.";
    header("location:dashboard.php");
    exit();
}