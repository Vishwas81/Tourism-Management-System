<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_POST['submit2'])) {
    $pid = intval($_GET['pkgid']);
    $useremail = $_SESSION['login'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $comment = $_POST['comment'];
    $status = 0;

    $sql = "INSERT INTO tblbooking(PackageId, UserEmail, FromDate, ToDate, Comment, status) 
            VALUES (:pid, :useremail, :fromdate, :todate, :comment, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_STR);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query->bindParam(':comment', $comment, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();

    $lastInsertId = $dbh->lastInsertId();
    if ($lastInsertId) {
        $msg = "Booked Successfully";
    } else {
        $error = "Something went wrong. Please try again";
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>TMS | Package Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/jquery-ui.css" rel="stylesheet" />
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script>
        new WOW().init();
        $(function () {
            $("#datepicker, #datepicker1").datepicker();
        });
    </script>
    <style>
        .errorWrap {
            padding: 10px;
            margin: 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
        }
        .succWrap {
            padding: 10px;
            margin: 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
        }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="banner-3">
    <div class="container">
        <h1 class="wow zoomIn animated" data-wow-delay=".5s">TMS - Package Details</h1>
    </div>
</div>
<div class="selectroom">
    <div class="container">
        <?php if ($error) { ?>
            <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
        <?php } elseif ($msg) { ?>
            <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
        <?php } ?>

        <?php
        $pid = intval($_GET['pkgid']);
        $sql = "SELECT * FROM tbltourpackages WHERE PackageId = :pid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pid', $pid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
                <form name="book" method="post">
                    <div class="selectroom_top">
                        <div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
                            <img src="admin/packageimage/<?php echo htmlentities($result->PackageImage); ?>" class="img-responsive" alt="Package Image">
                        </div>
                        <div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
                            <h2><?php echo htmlentities($result->PackageName); ?></h2>
                            <p class="dow">#PKG-<?php echo htmlentities($result->PackageId); ?></p>
                            <p><b>Package Type:</b> <?php echo htmlentities($result->PackageType); ?></p>
                            <p><b>Package Location:</b> <?php echo htmlentities($result->PackageLocation); ?></p>
                            <p><b>Features:</b> <?php echo htmlentities($result->PackageFetures); ?></p>
                            <div class="ban-bottom">
                                <div class="bnr-right">
                                    <label class="inputLabel">From</label>
                                    <input class="date" id="datepicker" type="text" placeholder="dd-mm-yyyy" name="fromdate" required>
                                </div>
                                <div class="bnr-right">
                                    <label class="inputLabel">To</label>
                                    <input class="date" id="datepicker1" type="text" placeholder="dd-mm-yyyy" name="todate" required>
                                </div>
                            </div>
                            <div class="grand">
                                <p>Grand Total</p>
                                <!-- Display Price in INR (converted from USD) -->
                                <h3>₹ <?php echo htmlentities($result->PackagePrice * 83); ?></h3>
                            </div>
                        </div>
                        <h3>Package Details</h3>
                        <p><?php echo htmlentities($result->PackageDetails); ?></p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="selectroom_top">
                        <h2>Travels</h2>
                        <div class="selectroom-info">
                            <ul>
                                <li class="spe">
                                    <label class="inputLabel">Comment</label>
                                    <input class="special" type="text" name="comment" required>
                                </li>
                                <?php if ($_SESSION['login']) { ?>
                                    <li class="spe" align="center">
                                        <button type="submit" name="submit2" class="btn-primary btn">Book</button>
                                    </li>
                                <?php } else { ?>
                                    <li class="sigi" align="center" style="margin-top: 1%">
                                        <a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn">Book</a>
                                    </li>
                                <?php } ?>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                    </div>
                </form>
            <?php }
        } ?>
    </div>
</div>
<?php include('includes/footer.php'); ?>
<?php include('includes/signup.php'); ?>
<?php include('includes/signin.php'); ?>
<?php include('includes/write-us.php'); ?>
</body>
</html>
