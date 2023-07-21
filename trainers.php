

<?php

require_once 'config/connect.php';


if(!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = 'Enter Username and Password to continue!';
    header('location: index.php');
    exit();
} 

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO `trainers` (`first_name`, `last_name`, `email`, `phone_number` ) 
    VALUES (?, ?, ?, ?, ?)";

    $run = $conn->prepare($sql);
    $run->bind_param("sssss", $first_name, $last_name, $email, $phone);
    $run->execute();

    $conn->close();


    $_SESSION['success_message'] = "GymFlex Trainer Successfully Added!";
    header("location: trainers.php");
    exit();


}


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
        <main class="page-content pt-7 ps-0 ms-0 d-flex flex-column flex-row-fluid">

            <div class="toolbar pt-10 pb-5 px-3">
                <div class="position-relative container">
                    <div class="row align-items-center position-relative">

                    <div class="col-md-7 mb-2 mb-md-0">
                      <h3 class="mb-0">Members</h3>
                    </div>

                    <div class="col-md-5">
                      <nav aria-label="breadcrumb" class="d-md-flex justify-content-md-end">
                        <ol class="breadcrumb mb-0">
                          <li class="breadcrumb-item">
                            <a href="dashboard.php" class="">Dashboard</a>
                          </li>
                          <li class="breadcrumb-item active">Trainers</li>
                        </ol>
                      </nav>
                    </div>
                  </div>
                </div>
            </div>


            <div class="content d-flex flex-column-fluid position-relative">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 mb-3 mb-lg-5">
                            <div class="card overflow-hidden">
                                <div class="card-header d-flex align-items-center">
                                <div class="col-md-6">
                                        <h4 class="mb-2">Trainers List</h4>
                                    </div>

                                    <div class="col-md-6 text-end">
                                    <a href="export.php?what=trainers" type="button" class="btn btn-success mb-2 me-2 fw-bold">
                                       Download CSV
                                    </a>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                <!-- Lists of members -->
                                    <div class="table-responsive">
                                        <table class="table mt-0 table-striped table-card table-nowrap">
                                            <thead class="text-uppercase small text-muted">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Created at</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $sql = "SELECT * FROM `trainers`";
                                                $run = $conn->query($sql);
                                                $results = $run->fetch_all(MYSQLI_ASSOC);
                                                foreach($results as $result) : ?>
                                                 
                                                <tr class="align-middle">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="h6 mb-0 lh-1"><?php echo $result['first_name'] . " " . $result['last_name'] ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $result['email'] ?></td>
                                                    <td><?php echo $result['phone_number'] ?></td>
                                                    <td>
                                                    <?php 
                                                        $originalDate = $result['date'];

                                                        $dateObject = new DateTime($originalDate);

                                                        $formatDate = $dateObject->format('d.m.Y');

                                                        echo $formatDate;
                                                    ?>
                                                    </td>
                                                    
                                                    <td class="text-end">
                                                        <div class="drodown">
                                                            <a data-bs-toggle="dropdown" href="#" class="btn p-1">
                                                              <span class="material-symbols-rounded align-middle">
                                                                more_vert
                                                              </span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                              <form action="delete_trainer.php" method="POST">
                                                                <input type="hidden" name="trainer_id" value="<?php echo $result['trainer_id']; ?>">
                                                                <button class="dropdown-item" type="submit">Delete</button>
                                                              </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                 

                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 mb-3 mb-lg-5">
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
                            <div class="card overflow-hidden">
                                <div class="card-header d-flex align-items-center">
                                    <div class="pe-3 flex-grow-1">
                                        <div class="d-flex align-items-center">
                                            <h4 class="mb-2">Add Trainer</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body p-5">
                                <!-- Lists of members -->
                                    <form action="" method="POST" class="row g-3" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <label for="inputFirstName" class="form-label">First name</label>
                                            <input type="text" name="first_name" class="form-control" id="inputFirstName">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputLastName" class="form-label">Last name</label>
                                            <input type="text" name="last_name" class="form-control" id="inputLastName">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputEmail" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="inputEmail">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputPhone" class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control" id="inputPhone maskPhone" data-inputmask='"mask": "(999)-999-9999"'>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Add Trainer</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>

</div>
<?php $conn->close(); ?>
<?php include 'includes/scripts.php'; ?>
<script>
Inputmask().mask(document.querySelectorAll("[data-inputmask]"));
</script>

</body>
</html>