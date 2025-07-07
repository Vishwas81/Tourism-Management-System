<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>TMS | Tourism Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="application/x-javascript"> 
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel="stylesheet" type="text/css">
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel="stylesheet" type="text/css">
    <link href='//fonts.googleapis.com/css?family=Oswald' rel="stylesheet" type="text/css">
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Custom Theme files -->
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!--animate-->
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <!--//end-animate-->
    <style>
        .banner {
            background-image: url('images/home.webp');
            background-size: cover;
            background-position: center;
            height: 400px;
            position: relative;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .banner h1 {
            font-size: 3em;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>

<div class="banner">
    <h1>Welcome to India</h1>
</div>

<div class="container">
    <div class="holiday">
        <h3>Package List</h3>
        <?php 
        $sql = "SELECT * FROM tbltourpackages ORDER BY RAND() LIMIT 4";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {   
        ?>
        <div class="rom-btm">
            <div class="col-md-3 room-left wow fadeInLeft animated" data-wow-delay=".5s">
                <img src="<?php echo file_exists('admin/packageimage/'.htmlentities($result->PackageImage)) 
                    ? 'admin/packageimage/'.htmlentities($result->PackageImage) 
                    : 'images/default.jpg'; ?>" 
                    class="img-responsive" alt="Package Image">
            </div>
            <div class="col-md-6 room-midle wow fadeInUp animated" data-wow-delay=".5s">
                <h4>Package Name: <?php echo htmlentities($result->PackageName); ?></h4>
                <h6>Package Type: <?php echo htmlentities($result->PackageType); ?></h6>
                <p><b>Package Location:</b> <?php echo htmlentities($result->PackageLocation); ?></p>
                <p><b>Features:</b> <?php echo htmlentities($result->PackageFetures); ?></p>
            </div>
            <div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
                <h5>₹ <?php echo htmlentities($result->PackagePrice); ?></h5>
                <a href="package-details.php?pkgid=<?php echo htmlentities($result->PackageId); ?>" class="view">Details</a>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php 
            }
        } 
        ?>
        <div><a href="package-list.php" class="view">View More Packages</a></div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="routes">
    <div class="container">
        <div class="col-md-4 routes-left wow fadeInRight animated" data-wow-delay=".5s">
            <div class="rou-left">
                <a href="#"><i class="glyphicon glyphicon-list-alt"></i></a>
            </div>
            <div class="rou-rgt wow fadeInDown animated" data-wow-delay=".5s">
                <h3>80000</h3>
                <p>Enquiries</p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-4 routes-left">
            <div class="rou-left">
                <a href="#"><i class="fa fa-user"></i></a>
            </div>
            <div class="rou-rgt">
                <h3>1900</h3>
                <p>Registered users</p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-4 routes-left wow fadeInRight animated" data-wow-delay=".5s">
            <div class="rou-left">
                <a href="#"><i class="fa fa-ticket"></i></a>
            </div>
            <div class="rou-rgt">
                <h3>7000+</h3>
                <p>Booking</p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<?php include('includes/signup.php'); ?>            
<?php include('includes/signin.php'); ?>            
<?php include('includes/write-us.php'); ?>            
</body>
</html>
