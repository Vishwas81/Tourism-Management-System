<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if(isset($_POST['submit'])) {
        $pname = $_POST['packagename'];
        $ptype = $_POST['packagetype'];
        $plocation = $_POST['packagelocation'];
        $pprice = $_POST['packageprice'];
        $pfeatures = $_POST['packagefeatures'];
        $pdetails = $_POST['packagedetails'];
        $pimage = $_FILES["packageimage"]["name"];

        // Move the uploaded file to the desired directory
        move_uploaded_file($_FILES["packageimage"]["tmp_name"], "packageimages/" . $_FILES["packageimage"]["name"]);

        // Prepare SQL query to insert the data into the database
        $sql = "INSERT INTO tbltourpackages(PackageName, PackageType, PackageLocation, PackagePrice, PackageFetures, PackageDetails, PackageImage) 
                VALUES(:pname, :ptype, :plocation, :pprice, :pfeatures, :pdetails, :pimage)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':pname', $pname, PDO::PARAM_STR);
        $query->bindParam(':ptype', $ptype, PDO::PARAM_STR);
        $query->bindParam(':plocation', $plocation, PDO::PARAM_STR);
        $query->bindParam(':pprice', $pprice, PDO::PARAM_STR);
        $query->bindParam(':pfeatures', $pfeatures, PDO::PARAM_STR);
        $query->bindParam(':pdetails', $pdetails, PDO::PARAM_STR);
        $query->bindParam(':pimage', $pimage, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if($lastInsertId) {
            $msg = "Package Created Successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>TMS | Admin Package Creation</title>

    <script type="application/x-javascript"> 
        addEventListener("load", function() { 
            setTimeout(hideURLbar, 0); 
        }, false); 
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>

    <!-- CSS files -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/morris.css" type="text/css"/>
    <link href="css/font-awesome.css" rel="stylesheet"> 
    <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
    <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />

    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head> 
<body>
    <div class="page-container">
        <!-- Content inner -->
        <div class="left-content">
            <div class="mother-grid-inner">
                <!-- Header -->
                <?php include('includes/header.php'); ?>
                <div class="clearfix"> </div>
            </div>

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>Create Package</li>
            </ol>

            <!-- Grid form -->
            <div class="grid-form">
                <div class="grid-form1">
                    <h3>Create Package</h3>

                    <?php if($error){?>
                        <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                    <?php } else if($msg){?>
                        <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                    <?php }?>

                    <form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="packagename" class="col-sm-2 control-label">Package Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="packagename" id="packagename" placeholder="Create Package" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="packagetype" class="col-sm-2 control-label">Package Type</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="packagetype" id="packagetype" placeholder="Package Type (e.g., Family, Couple)" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="packagelocation" class="col-sm-2 control-label">Package Location</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="packagelocation" id="packagelocation" placeholder="Package Location" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="packageprice" class="col-sm-2 control-label">Package Price (USD)</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="packageprice" id="packageprice" placeholder="Package Price in USD" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="packagefeatures" class="col-sm-2 control-label">Package Features</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="packagefeatures" id="packagefeatures" placeholder="Package Features (e.g., Free Pickup-Drop)" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="packagedetails" class="col-sm-2 control-label">Package Details</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" rows="5" name="packagedetails" id="packagedetails" placeholder="Package Details" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="packageimage" class="col-sm-2 control-label">Package Image</label>
                            <div class="col-sm-8">
                                <input type="file" name="packageimage" id="packageimage" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <button type="submit" name="submit" class="btn-primary btn">Create</button>
                                <button type="reset" class="btn-inverse btn">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include('includes/footer.php'); ?>

        <!-- Sidebar Menu -->
        <?php include('includes/sidebarmenu.php'); ?>
        <div class="clearfix"></div>
    </div>

    <!-- JavaScript files -->
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>

    <script>
        var toggle = true;
        $(".sidebar-icon").click(function() {
            if (toggle) {
                $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                $("#menu span").css({"position": "absolute"});
            } else {
                $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                setTimeout(function() {
                    $("#menu span").css({"position": "relative"});
                }, 400);
            }
            toggle = !toggle;
        });
    </script>
</body>
</html>
<?php } ?>
