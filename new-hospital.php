<?php
session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);

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
          <li class="active"><a href="new-hospital.php">Add New Hospital</a></li>
          <li><a href="view-reservations.php">View Reservations</a></li>
          <li><a href="all-hospitals.php?zone=All">All Hospitals</a></li>
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
          <h2>Add New Hospital</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>Add New Hospital</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->

    <section>
        <div class="container mt-3" style="max-width: 700px;">
            <h3>Add New Hospital</h3>
            
            <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row mb-3">
                <div class="col">
                <input type="text" class="form-control" placeholder="Hospital Name" name="name" required>                </div>
                <div class="col">
                    <select class="form-control" name="zone" required>
                        <option disabled selected value>Hospital Zone</option>
                        <option>Maadi</option>
                        <option>The 5th Settlement</option>
                        <option>Downtown</option>
                    </select> 
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input type="number" class="form-control" placeholder="Hospital Phone" name="phone" required>
                </div>
                <div class="col">
                  <input type="number" class="form-control" placeholder="Specialty Fees" name="specialty_fees" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input type="number" class="form-control" placeholder="Number of Normal Rooms" name="num_of_rooms" required>
                </div>
                <div class="col">
                    <input type="number" class="form-control" placeholder="Normal Room Price" name="room_price" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input type="number" class="form-control" placeholder="Number of Critical Care Rooms" name="num_of_cares" required>
                </div>
                <div class="col">
                    <input type="number" class="form-control" placeholder="Critical Care Room Price" name="care_price" required>
                </div>
            </div>

            <textarea class="form-control mb-4" rows="5" name="specialties" placeholder="Specialties (Ex: Neurology Ophthalmology psychotherapy)" required></textarea>

            <textarea class="form-control mb-4" rows="5" name="address" placeholder="Hospital Address.." required></textarea>

            <label>Hospital Image (Required):</label>
            <input type="file" class="form-control file_height" name="fileToUpload" required>

            <button type="submit" class="btn btn-primary mt-3">Add New Hospital</button>
            <?php 
                if($_SERVER['REQUEST_METHOD'] == "POST") {
                    $image = '';
                    $name = $_POST['name'];
                    $zone = $_POST['zone'];
                    $phone = $_POST['phone'];
                    $address = $_POST['address'];
                    $num_of_rooms = $_POST['num_of_rooms'];
                    $room_price = $_POST['room_price'];
                    $num_of_cares = $_POST['num_of_cares'];
                    $care_price = $_POST['care_price'];
                    $specialties = $_POST['specialties'];
                    $specialty_fees = $_POST['specialty_fees'];

                    $target_dir = "uploads/";
                    $target_file = $target_dir . time() . basename($_FILES["fileToUpload"]["name"]);

                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $image = time() . basename($_FILES["fileToUpload"]["name"]);
                    } else {
                        $error_msg = "Sorry, there was an error uploading your file.";
                    }

                    $query = "insert into hospitals (name,zone,phone,address,num_of_rooms,room_price,num_of_cares,care_price,specialties,specialty_fees,image,rating,rate_num) values ('$name','$zone','$phone','$address','$num_of_rooms','$room_price','$num_of_cares','$care_price','$specialties','$specialty_fees','$image',5,1)";
                    $result = mysqli_query($con, $query);

                    if($result) {
                        echo "Successfully added your hospital.";
                    } else {
                        echo "Error adding your hospital, try again later!";
                    }
                }
            ?>
            </form>
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