<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>TMS | Package List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);
        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="banner-3">
    <div class="container">
        <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
            TMS - Package List
        </h1>
    </div>
</div>
<div class="rooms">
    <div class="container">
        <div class="room-bottom">
            <h3>Package List</h3>

            <?php
            $sql = "SELECT * FROM tbltourpackages";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $usdToInrRate = 83; 
            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
                    $packagePrice = $result->PackagePrice;
                    $currency = "₹"; // Default to INR
                    
                    if (strpos($packagePrice, 'USD') !== false) {
                        $priceInUSD = (float) filter_var($packagePrice, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                        $convertedPrice = $priceInUSD * $usdToInrRate;
                        $packagePrice = $currency . " " . number_format($convertedPrice, 2);
                    } else {
                        $packagePrice = $currency . " " . number_format($packagePrice, 2); 
                    }
                    ?>
                    <div class="rom-btm">
                        <div class="col-md-3 room-left wow fadeInLeft animated" data-wow-delay=".5s">
                            <img src="admin/packageimage/<?php echo htmlentities($result->PackageImage); ?>" class="img-responsive" alt="Package Image">
                        </div>
                        <div class="col-md-6 room-midle wow fadeInUp animated" data-wow-delay=".5s">
                            <h4>Package Name: <?php echo htmlentities($result->PackageName); ?></h4>
                            <h6>Package Type: <?php echo htmlentities($result->PackageType); ?></h6>
                            <p><b>Package Location:</b> <?php echo htmlentities($result->PackageLocation); ?></p>
                            <p><b>Features:</b> <?php echo htmlentities($result->PackageFetures); ?></p>
                        </div>
                        <div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
                            <h5><?php echo $packagePrice; ?></h5>
                            <a href="package-details.php?pkgid=<?php echo htmlentities($result->PackageId); ?>" class="view">Details</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No packages found.</p>";
            }
            ?>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
<?php include('includes/signup.php'); ?>
<?php include('includes/signin.php'); ?>
<?php include('includes/write-us.php'); ?>
</body>
</html>
