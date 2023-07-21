

<?php

require_once 'config/connect.php';

if(!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = 'Enter Username and Password to continue!';
    $conn->close();
    header('location: index.php');
    exit();
} 

$admin_id = $_SESSION['admin_id'];

$sql = "SELECT username, first_name, last_name, email FROM `admins` WHERE admin_id = $admin_id";
$run = $conn->query($sql);
$results = $run->fetch_all(MYSQLI_ASSOC);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
</head>
<body class="layout-horizontal">

<div class="d-flex flex-column flex-root">
    <?php include 'includes/header.php' ?>
    <div class="page d-flex flex-row flex-column-fluid">
        <main class="page-content pt-10 ps-0 ms-0 d-flex flex-column flex-row-fluid">
        <div class="toolbar pt-10 pb-5 px-3">
            <div class="position-relative container">
              <div class="row align-items-center position-relative">
                <div class="col-md-7 mb-2 mb-md-0">
                  <?php  foreach($results as $result) : ?>
                  <h3 class="mb-0">Welcome back, <span class="text-capitalize"><?php echo $result['first_name'] ?>!</span></h3>
                  <?php endforeach; ?>
                </div>
                <div class="col-md-5">
                  <nav aria-label="breadcrumb" class="d-md-flex justify-content-md-end">
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item">
                        <a href="#!" class="">Dashboard</a>
                      </li>
                      <!-- <li class="breadcrumb-item active">Dashboard</li>
                      <li class="breadcrumb-item active">Analytics</li> -->
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

        <div class="content d-flex flex-column-fluid position-relative">
            <div class="container">
                <div class="row">

                <div class="col-lg-12 col-md-7 mb-3 mb-lg-5">
                    <?php 
                        if (isset($_SESSION['success_message'])) {
                               echo '
                                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                                    <span class="material-symbols-rounded align-middle me-2">check_circle</span>
                                    <strong class="me-2">Awesome! </strong> ' .$_SESSION['success_message']. '
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                ';
                            unset($_SESSION['success_message']);
                        }
                    ?>
                </div>

                <div class="col-lg-9 col-md-7 mb-3 mb-lg-5">
                  <div class="card table-card table-nowrap">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">List</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTrainer">
                            Add Trainer to Member
                        </button>
                    </div>

                    <div class="modal fade" id="addTrainer" tabindex="-1" aria-labelledby="addTrainerLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addTrainerLabel">GymFlex Management System
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="add_trainer_to_member.php" method="POST">
                                    <h6>Select Member</h6>
                                    <select class="form-select mb-5" name="member" aria-label="Member Select">
                                        <option selected value="" disabled>Members</option>
                                       <?php  
                                        $sql = "SELECT * FROM `members`";
                                        $run = $conn->query($sql);
                                        $results = $run->fetch_all(MYSQLI_ASSOC);
                                        foreach($results as $result) : ?>
                                        <option value="<?php echo $result['member_id']; ?>">
                                            <?php echo $result['first_name'] . " " . $result['last_name'] ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                    <h6>Select Trainer</h6>
                                    <select class="form-select" name="trainer" aria-label="Trainer Select">
                                        <option selected disabled value="">Trainers</option>
                                       <?php  
                                        $sql = "SELECT * FROM `trainers`";
                                        $run = $conn->query($sql);
                                        $results = $run->fetch_all(MYSQLI_ASSOC);

                                        foreach($results as $result) : ?>
                                        <option value="<?php echo $result['trainer_id']; ?>">
                                            <?php echo $result['first'] . " " . $result['last_name'] ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                      <table class="align-middle mb-0 table">
                        <thead class="small bg-body text-uppercase text-muted">
                          <tr>
                            <th>Member</th>
                            <th>Trainer</th>
                            <th>Training Plan</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php  
                                $sql = "SELECT members.*,
                                training_plans.name AS training_plan_name,
                                trainers.first_name AS trainer_first_name,
                                trainers.last_name AS trainer_last_name
                                FROM `members`
                                LEFT JOIN `training_plans` ON members.training_plan_id = training_plans.plan_id
                                LEFT JOIN `trainers` ON members.trainer_id = trainers.trainer_id";
                   
                                $run = $conn->query($sql);
                                $results = $run->fetch_all(MYSQLI_ASSOC);
                   
                                foreach ($results as $result) : ?>
                                    <tr>
                                        <td><?php echo $result['first_name'] . " " . $result['last_name']; ?></td>
                                        <td><small class="text-muted">Coach</small>: 
                                            <?php
                                            if ($result['trainer_first_name']) {
                                                echo $result['trainer_first_name'] . " " . $result['trainer_last_name'];
                                            } else {
                                                echo "Not Found";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($result['training_plan_name']) {
                                                echo $result['training_plan_name'];
                                            } else {
                                                echo "Not Found";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>  
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                
                <div class="col-xl-3 col-lg-4">
                  <!--::begin card-->
                  <div class="card overflow-hidden mb-3 mb-lg-5">
                    <div class="card-body d-flex align-items-center">
                      <!--Card text-->
                      <div class="flex-grow-1">
                        <div class="h3 mb-2">
                        <?php
                        $sql = "SELECT SUM(tp.price) AS total_price 
                        FROM members m
                        LEFT JOIN training_plans tp ON m.training_plan_id = tp.plan_id
                        WHERE m.training_plan_id IS NOT NULL";

                        $run = $conn->query($sql);
                        $result = $run->fetch_assoc();

                        if ($result['total_price']) {
                            echo "$" . $result['total_price']; 
                        } else {
                            echo "Total Price not available.";
                        }
                        ?>
                        </div>
                        <span class="text-reset">Total Earnings <small class="text-muted" >(Training Plans)</small></span>
                      </div>
                      <div class="flex-shrink-0 text-end">
                        <span class="material-symbols-rounded text-info">
                        sell
                        </span>
                      </div>
                    </div>
                  </div>
                  <!--::/end card-->
                  <!--::begin card-->
                  <div class="card overflow-hidden mb-3 mb-lg-5">
                    <div class="card-body d-flex align-items-center">
                      <!--Card text-->
                      <div class="flex-grow-1">
                        <div class="h3 mb-2">
                        <?php                       
                        $sql = "SELECT COUNT(member_id) AS total_members FROM members";
                        $run = $conn->query($sql);
                        $result = $run->fetch_assoc();
                        
                        if ($result) {
                            $total_members = $result['total_members'];
                            echo $total_members;
                        } else {
                            echo "Error fetching total members.";
                        }
                        ?>
                        </div>
                        <span>Total Members <small class="text-muted" >(GymFlex Members)</small></span>
                      </div>
                      <div class="flex-shrink-0 text-end">
                        <span class="material-symbols-rounded text-warning">
                        person
                        </span>
                      </div>
                    </div>
                  </div>
                  <!--::/end card-->
                  <!--::begin card-->
                  <div class="card overflow-hidden mb-3 mb-lg-5">
                    <div class="card-body d-flex align-items-center">
                      <!--Card text-->
                      <div class="flex-grow-1">
                        <div class="h3 mb-2">
                        <?php                       
                        $sql = "SELECT COUNT(trainer_id) AS total_trainers FROM trainers";
                        $run = $conn->query($sql);
                        $result = $run->fetch_assoc();
                        
                        if ($result) {
                            $total_trainers = $result['total_trainers'];
                            echo $total_trainers;
                        } else {
                            echo "Error fetching total trainers.";
                        }
                        ?>
                        </div>
                        <span>Total Trainers <small class="text-muted" >(GymFlex Trainers)</small></span>
                      </div>
                      <div class="flex-shrink-0 text-end">
                        <span class="material-symbols-rounded text-danger">
                        badge
                        </span>
                      </div>
                    </div>
                  </div>
                  <!--::/end card-->
                </div>
                </div>
            </div>
        </div>
               



        </main>
    </div>

</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>