<?php


include 'config/connect.php';


if($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT admin_id, password FROM admins WHERE username = ?";

    $run = $conn->prepare($sql);
    $run->bind_param("s", $username);
    $run->execute();

    $results = $run->get_result();

    if($results->num_rows == 1) {
        $admin = $results->fetch_assoc();

        if(password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $conn->close();
            header('location: dashboard.php');
            exit();
        } else {
            $_SESSION['error'] = "Wrong Username or Password";
            $conn->close();
            header('location: index.php');
            exit();
        }

    }   else {
        $_SESSION['error'] = "Wrong Username or Password";
        $conn->close();
        header('location: index.php');
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
    <div class="content p-1 d-flex align-items-center flex-column-fluid position-relative">
        <div class="container py-4">
            <div class="row align-items-center justify-content-center">
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
                    <div class="card card-body p-4">
                        <h4 class="text-center">Welcome Back</h4>
                        <p class="mb-4 text-muted text-center">
                            <span class="text-primary">GymFlex</span> Management System
                        </p>
                        
                        <form action="" method="POST" class="z-index-1 position-relative needs-validation" novalidate="" >
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="username" required="" id="floatingInput" placeholder="Username" />
                                <label for="floatingInput">Username</label>
                                <span class="invalid-feedback">Please enter a valid Username</span>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="password" required="" id="floatingPassword" placeholder="Password" />
                                <label for="floatingInput">Password</label>
                                <span class="invalid-feedback">Enter the Password</span>
                            </div>
                             
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="form-check">
                                    <input class="form-check-input me-1" id="terms" type="checkbox" value="" />
                                    <label class="form-check-label" for="terms">Remember Me</label>
                                </div>
    
                                <div>
                                    <a href="#" class="small text-muted">Forget Password?</a>
                                </div>
                            </div>
                            <button class="w-100 btn btn-lg btn-primary"  type="submit">
                                Sign In
                            </button>

                            <hr class="mt-4 mb-3" />
                            <p class="text-muted text-center">
                                Don’t have an account yet?
                                <a href="#" class="ms-2 text-body">Sign Up</a>
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