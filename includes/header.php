<header class="navbar py-lg-0 navbar-expand-lg navbar-light navbar-horizontal fixed-top start-0 top-0 w-100 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-semibold text-secondary fs-2" href="dashboard.php">
        <span class="material-symbols-rounded align-middle opacity-100 fs-1 me-2">fitness_center</span>
    </a>
    <div class="d-flex order-lg-last">
      <div class="order-lg-last ms-auto">
        <ul class="navbar-nav navbar-icon flex-row ms-auto d-flex align-items-center">

          <li class="nav-item d-flex align-items-center justify-content-center flex-column h-100 me-2">
            <label class="dark-mode-checkbox size-40 d-flex align-items-center justify-content-center nav-link p-0" for="ChangeTheme">
              <input type="checkbox" id="ChangeTheme" />
              <span class="slide"></span>
            </label>
          </li>

          <li class="nav-item dropdown py-lg-3">
            <a href="#" class="nav-link dropdown-toggle rounded-pill p-1 lh-1 pe-1 d-flex align-items-center justify-content-center" aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
              <div class="d-flex align-items-center">
                <!-- Avatar with status -->
                <div class="avatar-status status-online avatar sm">
                  <img src="assets/media/avatars/01.jpg" class="rounded-circle img-fluid" alt="" />
                </div>
              </div>
            </a>
            <div class="dropdown-menu mt-0 pt-0 dropdown-menu-end overflow-hidden">
              <!-- User meta -->
              <div class="position-relative overflow-hidden p-3 mb-3 border-bottom">
                <h5 class="mb-1">Noah Pierre</h5>
                <p class="text-muted small mb-0 lh-1">Full stack developer</p>
              </div>
              <a href="#!.html" class="dropdown-item">
                <span class="material-symbols-rounded align-middle opacity-75 fs-4 me-2">account_circle</span>
                Profile
              </a>
              <a href="#!.html" class="dropdown-item">
                <span class="material-symbols-rounded align-middle opacity-75 fs-4 me-2">settings</span>
                Settings
              </a>
              <a href="#!.html" class="dropdown-item">
                <span class="material-symbols-rounded align-middle opacity-75 fs-4 me-2">task</span>
                Tasks
                </a>
                <hr class="mt-3 mb-1" />
                <a href="config/logout.php" class="dropdown-item d-flex align-items-center">
                  <span class="material-symbols-rounded align-middle opacity-75 fs-4 me-2">logout</span>
                  Sign out
                </a>
              </div>
            </li>
          </ul>

        </div>

        <!-- Navbar collapse items -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-lg-5">
            <li class="nav-item py-lg-3">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item dropdown py-lg-3 me-lg-2">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Gym System</a>
              <ul class="dropdown-menu mt-0" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="trainers.php">Trainers</a>
                </li>
                <li>
                  <a class="dropdown-item" href="members.php">Members</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </header>
