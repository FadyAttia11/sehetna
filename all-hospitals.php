<?php
session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);
    $zone = $_GET["zone"];

    if($zone == 'All') {
        $all_hospitals_query = "select * from hospitals";
        $all_hospitals = mysqli_query($con, $all_hospitals_query);
    } else {
        $all_hospitals_query = "select * from hospitals where zone = '$zone'";
        $all_hospitals = mysqli_query($con, $all_hospitals_query);
    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>صحتنا</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <i class="icofont-clock-time"></i> Sunday - Thursday, 9AM to 6PM
      </div>
      <div class="d-flex align-items-center">
        <i class="icofont-phone"></i> Call us now 0100 255 5622
      </div>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <a href="index.php" class="logo mr-auto">صحتنا</a>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <h1 class="logo mr-auto"><a href="index.html">Medicio</a></h1> -->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="new-hospital.php">Add New Hospital</a></li>
          <li><a href="view-reservations.php">View Reservations</a></li>
          <li class="active"><a href="all-hospitals.php?zone=All">All Hospitals</a></li>
          <li><a href="#">Balance <?php echo $user_data['balance'] ?> L.E</a></li>
          <li><a href="#">Admin</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <a href="logout.php" class="appointment-btn scrollto">Logout</a>

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Choose Zone: <a href="all-hospitals.php?zone=All">All</a> - <a href="all-hospitals.php?zone=Maadi">Maadi</a> - <a href="all-hospitals.php?zone=The 5th Settlement">The 5th Settlement</a> - <a href="all-hospitals.php?zone=Downtown">Downtown</a></h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>All Hospitals</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">
      <div class="container">
        <div class="portfolio-description">
        <h3>All Hospitals</h3>
            <div class="row">
                <?php
                    while($row = mysqli_fetch_array($all_hospitals)) {
                ?>

                <div class="col-6">
                    <a href=<?php echo "hospital-ad.php?id=". $row['id'] ?>><img src=<?php echo "./uploads/".$row['image'] ?> alt="" style="width: 50%; border: 1px solid #cda45e;"></a>
                    <h5>Name: <?php echo $row['name'] ?></h5>
                </div>

                <?php } ?>
            </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->


  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>