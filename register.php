<?php


require_once 'config/connect.php';


if($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $confirmPassword = $_POST['confirmPassword'];

    $hash_password =  password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO `admins` (`username`, `first_name`, `last_name`, `email`, `password`)
    VALUES (?, ?, ?, ?, ?)";

    $run = $conn->prepare($sql);
    $run->bind_param("sssss", $username, $first_name, $last_name,  $email, $hash_password);
    $run->execute();

    if($password === $confirmPassword) {
        $_SESSION['success-message'] = "Awesome! Now Sign In";
        header('location:index.php');
        exit();
        } else {
            $_SESSION['error'] = "Something went wrong, check you credentials";
            $conn->close();
            header('location:register.php');    
            exit();
    }
} 





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/head.php'; ?>
</head>

<body>

<!-- Theme Switcher/start -->
<div class="position-absolute end-0 top-0 size-40 me-2 mt-2 z-index-fixed">
    <label class="dark-mode-checkbox size-40 d-flex align-items-center justify-content-center nav-link p-0" for="ChangeTheme">
        <input type="checkbox" id="ChangeTheme"/> <span class="slide"></span>
    </label>
</div>
<!-- Theme Switcher/end -->

<!-- Login System/start -->
<div class="d-flex flex-column flex-root">
<div class="page d-flex flex-row flex-column-fluid">
<main class="page-content overflow-hidden ms-0 d-flex flex-column flex-row-fluid">
          <!--//content//-->
          <div class="content p-1 d-flex flex-column-fluid position-relative">
                        <div class="container py-4">
                            <div class="row h-100 align-items-center justify-content-center">
                                <div class="col-md-8 col-lg-5 col-xl-4">
                                <?php 
                                if (isset($_SESSION['error'])) {
                                       echo '
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                                            <span class="material-symbols-rounded align-middle me-2">error</span>
                                            <div>' .$_SESSION['error']. '</div>
                                        </div>
                                        ';
                                    unset($_SESSION['error']);
                                }
                                ?>
                                    <!--Card-->
                                    <div class="card card-body p-4">
                                        <h4 class="text-center">GymFlex Management System</h4>
                                        <p class="mb-4 text-center text-muted">
                                            To get started, Please signup with details...
                                        </p>
                                        <form action="#" method="POST" class="z-index-1 position-relative needs-validation" novalidate="">
                                            
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control text-capitalize"
                                                    id="floatingInputFirstName" name="first_name" placeholder="Ministrator">
                                                <label for="floatingInputFirstName">First Name</label>
                                                <span class="invalid-feedback">Please enter your First name</span>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control text-capitalize"
                                                    id="floatingInputLastName" name="last_name" placeholder="Ministrator">
                                                <label for="floatingInputLastName">Last name</label>
                                                <span class="invalid-feedback">Please enter your Last name</span>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control text-lowercase"
                                                    id="floatingInputUsername" name="username" placeholder="Ministrator">
                                                <label for="floatingInputUsername">Username</label>
                                                <span class="invalid-feedback">Please enter your username</span>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" required=""
                                                    id="floatingInputEmail" name="email" placeholder="adam@ministrator.com">
                                                <label for="floatingInputEmail">Email address</label>
                                                <span class="invalid-feedback">Please enter a valid email address</span>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="password" required="" class="form-control"
                                                    id="floatingPassword" name="password" placeholder="Password">
                                                <label for="floatingPassword">Password</label>
                                                <span class="invalid-feedback">Enter the password</span>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="password" required="" class="form-control"
                                                    id="floatingPassword2" name="confirmPassword" placeholder="Password">
                                                <label for="floatingPassword2">Confirm Password</label>
                                                <span class="invalid-feedback">Enter the same password as above</span>
                                            </div>
                                            <div class="d-flex align-items-strech justify-content-between mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input me-1" required id="terms"
                                                        type="checkbox" value="">
                                                    <label class="form-check-label" for="terms">Agree to our <a
                                                            href="#">Terms & conditions</a></label>
                                                    <span class="invalid-feedback">You must be agree to terms &
                                                        conditions</span>
                                                </div>
                                            </div>
                                            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign Up</button>
                                            <hr class="mt-4">
                                            <p class="text-muted text-center">
                                                Alread have an account? 
                                                <a href="index.php" class="ms-2 text-body">Sign In</a>

                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


          <footer class="pb-3 pb-lg-5 px-3 px-lg-6">
            <div class="container-fluid px-0">
              <span class="d-block lh-sm small text-muted text-end"
                >&copy;
                <script>
                  document.write(new Date().getFullYear());
                </script>
                . <a href="https://vmd.rs" target="_blank">vmdev</a>
              </span>
            </div>
          </footer>

</main>
</div>
</div>
<!-- Login System/end -->
   
<!-- Scripts/start -->
<?php include 'includes/scripts.php'; ?>
<!-- Scripts/end -->
</body>
</html>