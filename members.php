

<?php

require_once 'config/connect.php';
require_once 'fpdf/fpdf.php';

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
    $training_plan_id = $_POST['training_plan_id'];
    $photo_path = $_POST['photo_path'];
    $trainer_id = "0";
    $access_card_pdf_path = "";

    $sql = "INSERT INTO `members` (`first_name`, `last_name`, `email`, `phone_number`, `photo_path`, `training_plan_id`, `trainer_id`, `access_card_pdf_path` ) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $run = $conn->prepare($sql);
    $run->bind_param("sssssiis", $first_name, $last_name, $email, $phone, $photo_path, $training_plan_id, $trainer_id, $access_card_pdf_path);
    $run->execute();

    $fullname = $_POST['first_name'] . " " . $_POST['last_name'];

    $member_id = $conn->insert_id;    

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(40, 10, 'Access Card', 1, 1, 'C');
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Member ID: ' . $member_id);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Name: ' . $first_name . " " . $last_name);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Email: ' . $email);
    $pdf->Ln();
    
    $filename = 'access_cards/access_card_' . $member_id . '_' . $fullname . '.pdf';
    $pdf->Output('F', $filename);

    $sql = "UPDATE members SET access_card_pdf_path = '$filename' WHERE member_id = $member_id";
    $conn->query($sql);
    $conn->close();


    $_SESSION['success_message'] = "GymFlex Member Successfully Added!";
    header("location: members.php");
    exit();


}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
                          <li class="breadcrumb-item active">Members</li>
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

                                <div class="card-header row d-flex align-items-center">
                                    
                                    <div class="col-md-6">
                                        <h4 class="mb-2">Member List</h4>
                                    </div>

                                    <div class="col-md-6 text-end">
                                    <a href="export.php?what=members" type="button" class="btn btn-success mb-2 me-2 fw-bold">
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
                                                    <th>Trainer</th>
                                                    <th>Training Plan</th>
                                                    <th>Access Card</th>
                                                    <th class="text-end">Action</th>
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
                                               

                                                foreach($results as $result) : ?>
                                                 
                                                <tr class="align-middle">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?php echo $result['photo_path'] ?>" class="avatar sm rounded-pill me-3 flex-shrink-0" alt="Member">
                                                            <div>
                                                                <div class="h6 mb-0 lh-1"><?php echo $result['first_name'] . " " . $result['last_name'] ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $result['email'] ?></td>
                                                    <td><?php echo $result['phone_number'] ?></td>
                                                    <td>
                                                        <?php 
                                                        if($result['trainer_first_name']) {
                                                        echo $result['trainer_first_name'] . " " . $result['trainer_last_name'] ;
                                                        }  else {
                                                            echo "Not Found";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if($result['training_plan_name']) {
                                                        echo $result['training_plan_name'];
                                                        }  else {
                                                            echo "Not Found";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><a href="<?php echo $result['access_card_pdf_path'] ?>" target="_blank">Access Card</a></td>
                                                    <td class="text-end">
                                                        <div class="drodown">
                                                            <a data-bs-toggle="dropdown" href="#" class="btn p-1">
                                                              <span class="material-symbols-rounded align-middle">
                                                                more_vert
                                                              </span>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                              <form action="delete_member.php" method="POST">
                                                                <input type="hidden" name="member_id" value="<?php echo $result['member_id']; ?>">
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
                                            <h4 class="mb-2">Add Member</h4>
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
                                            <input type="text" name="phone" class="form-control" id="inputPhone">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputTraining" class="form-label">Training Plan</label>
                                            <select id="inputTraining" class="form-select" name="training_plan_id">
                                                <option value="" selected disabled>Choose...</option>
                                                <?php

                                                    $sql = "SELECT * FROM training_plans";
                                                    $run = $conn->query($sql);
                                                    $results = $run->fetch_all(MYSQLI_ASSOC);

                                                    foreach($results as $result) {
                                                        echo "<option value='" . $result['plan_id']  . "'>" . $result['name'] . "</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-12">  
                                            <label for="photoPathInput" class="form-label">Select/Drop Image</label>
                                            <input name="photo_path" type="hidden" id="photoPathInput">
                                            <div class="dropzone border bg-body rounded-3 bg-opacity-25 d-flex justify-content-center align-items-center" id="dropzone-upload"></div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Add member</button>
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
    Dropzone.options.dropzoneUpload = {
        url: "upload_photo.php",
        paramName: "photo",
        maxFilesize: 20, //MB
        acceptedFiles: "image/*",
        init: function () {
            this.on("success", function (file, response) {
                const jsonResponse = JSON.parse(response);

                if (jsonResponse.success) {
                    document.getElementById('photoPathInput').value = jsonResponse.photo_path;
                } else {
                    console.error(jsonResponse.error);
                }
            })
        }
    }
</script>
</body>
</html>