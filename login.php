<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | CodeFest 2023</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <link href="assets/css/theme.css" rel="stylesheet" />

    <style>
       
        .signin-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
  
        .signin-image {
            width: 50%;
            padding-right: 30px;
        }
  
        .signin-form {
            width: 50%;
            padding-left: 30px;
        }

        main#top {
            margin-top: 0;
            padding-top: 0;
        }

        .signin-content {
            margin-top: 0px;
            margin-bottom: 0px;
        }
    </style>
</head>
<body>
    
<main class="main" id="top">
        <nav
          class="navbar navbar-expand-lg navbar-light sticky-top"
          data-navbar-on-scroll="data-navbar-on-scroll"
        >
          <div class="container">
            <a class="navbar-brand" href="index.html">
              <img src="../CodeFest/images/codefest.jpg" height="20" alt="" />
            </a>
  
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"> </span>
            </button>
            <div
              class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0"
              id="navbarSupportedContent"
            >
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.html#feature">Bootcamp</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.html#marketing">Competition</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.html#validation">Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="voting.php">Voting</a>
            </li>
            </ul>

              <div class="d-flex ms-lg-4">
                <a class="btn btn-secondary-outline" href="login.php">Log In</a
                ><a class="btn btn-warning ms-3" href="register.html">Sign Up</a>
              </div>
            </div>
          </div>
        </nav>

    <!-- Sign in Form -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="images/signin-image.jpg" alt="sign up image"></figure>
                    <p class="loginhere">Belum punya akun? <a href="register.html" class="loginhere-link">Buat Akun</a></p>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">Login <br> CodeFest 2023</h2>
                    <form method="POST" class="register-form" id="login-form" action="proses_login.php">
                        <div class="form-group">
                            <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="username" id="username" placeholder="Username"/>
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="pass" id="pass" placeholder="Password"/>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="Masuk"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

        <?php
        // Periksa apakah ada parameter URL success yang mengandung pesan sukses
        if (isset($_GET['success'])) {
            // Tampilkan pesan sukses
            $success_message = $_GET['success'];
            echo "<script>alert('$success_message');</script>";
        }
        ?>

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
