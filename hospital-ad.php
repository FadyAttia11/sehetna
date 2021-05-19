<?php
session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($con);
    $client_name = $user_data['user_name'];
    $hospital_id = $_GET["id"];

    $hospital_query = "select * from hospitals where id = '$hospital_id'";
    $hospital = mysqli_query($con, $hospital_query);

    if($hospital && mysqli_num_rows($hospital) > 0) {
        $hospital_data = mysqli_fetch_assoc($hospital);
    }

    $hospital_reviews_query = "select * from reviews where hospital_id = '$hospital_id'";
    $hospital_reviews = mysqli_query($con, $hospital_reviews_query);
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
          <h2>Hospital: <?php echo $hospital_data['name'] ?></h2>
          <ol>
            <li><a href="index.html">Home</a></li>
            <li><?php echo $hospital_data['name'] ?></li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">
      <div class="container">

      <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center
        }

        .rating>input {
            display: none
        }

        .rating>label {
            position: relative;
            width: 1em;
            font-size: 3vw;
            color: #FFD600;
            cursor: pointer
        }

        .rating>label::before {
            content: "\2605";
            position: absolute;
            opacity: 0
        }

        .rating>label:hover:before,
        .rating>label:hover~label:before {
            opacity: 1 !important
        }

        .rating>input:checked~label:before {
            opacity: 1
        }

        .rating:hover>input:checked~label:before {
            opacity: 0.4
        }
      </style>

        <div class="portfolio-details-container">
          <h2>Hospital Image</h2>
          <img src=<?php echo "./uploads/". $hospital_data['image'] ?> class="img-fluid" alt="">            
        </div>

        

        <div class="portfolio-description">
          <h2>Hospital Info</h2>
          <p>Number of Normal Rooms: <strong><?php echo $hospital_data['num_of_rooms'] ?></strong></p>
          <p>Normal Room Price: <strong><?php echo $hospital_data['room_price'] ?></strong> L.E</p>
          <p>Number of Critical Care Rooms: <strong><?php echo $hospital_data['num_of_cares'] ?></strong></p>
          <p>Critical Care Room Price: <strong><?php echo $hospital_data['care_price'] ?></strong> L.E</p>
          <p>Specialties: <strong><?php echo $hospital_data['specialties'] ?></strong></p>
          <p>Specialty Fees: <strong><?php echo $hospital_data['specialty_fees'] ?></strong> L.E</p>
          <p>Phone: <strong>0<?php echo $hospital_data['phone'] ?></strong></p>
          <p>Address: <strong><?php echo $hospital_data['address'] ?></strong></p>
          <p>Zone: <strong><?php echo $hospital_data['zone'] ?></strong></p>
        </div>

        <?php
          $reviewed_before_query = "select * from reviews where client_name = '$client_name' and hospital_id = '$hospital_id'";
          $reviewed_before = mysqli_query($con, $reviewed_before_query);

          if($reviewed_before && mysqli_num_rows($reviewed_before) > 0) {

        ?>

        <h2>You Have Already Reviewed This Hospital before!</h2>

        <?php } else { ?>

          <h1>Rate & Review</h1>
        <form method="post">
          <div class="rating"> 
            <input type="radio" name="rating" value="5" id="5">
            <label for="5">☆</label> 

            <input type="radio" name="rating" value="4" id="4">
            <label for="4">☆</label> 

            <input type="radio" name="rating" value="3" id="3">
            <label for="3">☆</label> 

            <input type="radio" name="rating" value="2" id="2">
            <label for="2">☆</label> 

            <input type="radio" name="rating" value="1" id="1">
            <label for="1">☆</label>
          </div>

          <textarea class="form-control mb-3" rows="5" name="review" placeholder="Your Review.." required></textarea>

          <button type="submit" class="btn btn-primary">Submit Rating</button>
          <?php
            if($_SERVER['REQUEST_METHOD'] == "POST") {
              if(isset($rating)) {
                $rating = $_POST['rating'];
                $review = $_POST['review'];

                $query = "insert into reviews (hospital_id,client_name,rating,review) values ('$hospital_id','$client_name','$rating','$review')";
                $result = mysqli_query($con, $query);
  
                if($result) {
                  $new_rate_num = $hospital_data['rate_num'] + 1;
                  $gross_rate = $hospital_data['rating'] * $hospital_data['rate_num'];
                  $new_gross_rate = $gross_rate + $rating;
                  $new_rating = $new_gross_rate / $new_rate_num;
                  
                  $update_rating_query = "update hospitals set rating = '$new_rating', rate_num = '$new_rate_num' where id = '$hospital_id'";
                  $update_rating = mysqli_query($con, $update_rating_query);

                  if($update_rating) {
                    echo $client_name;
                  }
                }
              } else {
                echo "please specify a rating from the stars above!";
              }

            }
          ?>
        </form>
          
        <?php } ?>

        <div class="d-flex justify-content-center">
          <div class="content text-center">
            <h2>Place Rating</h2>
              <div class="ratings"> 
                <span class="product-rating"><?php echo $hospital_data['rating'] ?></span><span>/5</span>
                <div class="rating-text"> 
                  <span><?php echo $hospital_data['rate_num'] - 1 ?> ratings & reviews</span> 
                </div>
              </div>
          </div>
        </div>

        <style>
           .content {
                width: 420px;
                margin-top: 100px
            }

            .ratings {
                background-color: #fff;
                padding: 54px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                box-shadow: 0px 10px 10px #E0E0E0
            }

            .product-rating {
                font-size: 50px
            }

            .stars i {
                font-size: 18px;
                color: #28a745
            }

            .rating-text {
                margin-top: 10px
            }
        </style>

        <div class="portfolio-description">
          <h2>Place Reviews</h2>
          <div class="row">

            <?php
              while($row = mysqli_fetch_array($hospital_reviews)) {
            ?>
            
            <div class="card col-5 ml-2" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">Client Name: <?php echo $row['client_name'] ?></h5>
                <p class="card-text">Rating: <?php echo $row['rating'] ?> Stars</p>
                <p class="card-text">Review: <strong><?php echo $row['review'] ?></strong></p>      
              </div>
            </div>

            <?php } ?>
          </div>
        </div>


        <div class="portfolio-description mt-5">
          <h2>Book Reservation In This Hospital</h2>
          <p>(All Reservation Fees are 100 L.E per Reservation)</p>
          <form method="post">
            <div class="form-group mt-2">
              <label>What do you want to reserve?</label>
              <select class="form-control" name="category" required>
                  <option disabled selected value>Choose Category</option>
                  <option>Normal Room</option>
                  <option>Critical Care Room</option>
                  <option>Doctor Consultation</option>
              </select> 
            </div>
            <div class="form-group mt-2">
              <label>Reserve specific date:</label>
              <input type="text" placeholder="Ex: Thursday 2pm" name="time" class="form-control">
            </div>
            <div class="form-group mt-2">
              <label>Card holder's name</label>
              <input type="text" placeholder="Card holder's name" class="form-control">
            </div>
            <div class="form-group">
              <label>Card number</label>
              <input type="number" placeholder="Card number" class="form-control">
            </div>
            <div class="form-group">
              <label>Expire Date</label>
              <input type="date" placeholder="dd/mm/yy" class="form-control">
            </div>
            <div class="form-group">
                <label>CVV</label>
                <input type="text" placeholder="CVV" class="form-control">
            </div>
            <input type="submit" class="btn btn-primary" value="Book Reservation">
            <?php
              if($_SERVER['REQUEST_METHOD'] == "POST") {
                $get_money_query = "select * from users where user_role = 'admin'";
                $get_money = mysqli_query($con, $get_money_query);

                if($get_money && mysqli_num_rows($get_money) > 0) {
                  $current_money = mysqli_fetch_assoc($get_money);
                  $updated_money = $current_money['balance'] + 100;

                  $add_money_query = "update users set balance = '$updated_money' where user_role = 'admin'";
                  $add_money = mysqli_query($con, $add_money_query);

                  if($add_money) {
                    $category = $_POST['category'];
                    $time = $_POST['time'];

                    $query = "insert into reservations (hospital_id,client_name,category,time) values ('$hospital_id','$client_name','$category','$time')";
                    $result = mysqli_query($con, $query);

                    if($result) {
                      echo "successfully added your reservation";
                    } else {
                      echo "error adding your reservation";
                    }
                  } else {
                      echo "error adding money to our account";
                  }
                }
              }
            ?>
          </form>
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