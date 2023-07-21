<?php
// *************************************************************************
// *                                                                       *
// * DEPRIXA PRO -  Integrated Web Shipping System                         *
// * Copyright (c) JAOMWEB. All Rights Reserved                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: support@jaom.info                                              *
// * Website: http://www.jaom.info                                         *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// * If you Purchased from Codecanyon, Please read the full License from   *
// * here- http://codecanyon.net/licenses/standard                         *
// *                                                                       *
// *************************************************************************




require_once("loader.php");

$login = new User;
$core = new Core;

if ($login->cdp_loginCheck() == true){

   header("location: index.php");

}

if (isset($_POST['login'])){

    $result = $login->cdp_login($_POST['username'], $_POST['password']);


         
    if ($result){
        header("location: index.php");

    }
}


?>


<!DOCTYPE html>
    <html lang="en">

<head>
    <meta charset="utf-8" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Courier DEPRIXA-Integral Web System">
    <meta name="author" content="Jaomweb">
    <meta name="description" content="">
        <!-- favicon -->
    <title>Login | <?php echo $core->site_name ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
    <!-- Bootstrap -->
    <link href="assets/css_main_deprixa/main_deprixa/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="assets/css_main_deprixa/main_deprixa/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" /> 
    <!-- Main css --> 
    <link href="assets/css_main_deprixa/main_deprixa/css/style.css" rel="stylesheet" type="text/css" />



    </head>

<body>

        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div>
        <!-- Loader -->
        
        <!-- Navbar STart -->
        <header id="topnav" class="defaultscroll sticky">
            <div class="container">
                <!-- Logo container-->
                <div>
                   <a class="logo" href="index.php"><?php echo ($core->logo) ? '<img src="assets/'.$core->logo.'" alt="'.$core->site_name.'"  width="190" height="45"/>': $core->site_name;?></a>
                </div>                 
                <div class="buy-button">
                    <a href="sign-up.php" class="btn btn-soft-secondary"><i class="mdi mdi-account-alert ml-3 icons"></i> <?php echo $lang['left112'] ?></a>
                </div><!--end login button-->


                <div class="menu-extras">
                    <div class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </div>
                </div>
                <div id="navigation">
                    <!-- Navigation Menu-->   
                    <ul class="navigation-menu">
                        <li><a href="index.php"><?php echo $lang['left111'] ?></a></li>
                        
                        <li><a href="tracking.php"><i class="mdi mdi-package-variant-closed"></i> <?php echo $lang['left113'] ?></a></li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- Navbar End -->
        
                <!-- Hero Start -->
        <section class="bg-home">
            <div class="home-center">
                <div class="home-desc-center">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-6">
                                <div >   
                                    <img src="assets/css_main_deprixa/images/user/login.png" class="img-fluid" alt="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                <div class="login-page bg-white shadow rounded p-4">
                                    <div class="text-center">
                                        <h4 class="mb-4"><?php echo $core->site_name ?>, <?php echo $lang['left114'] ?></h4>  
                                    </div>
                                    <div id="msgholder2">
                                     <?php 
                                        if (isset($login)) {
                                            if ($login->errors) {            
                                             ?>
                                        <div class="alert alert-danger" id="success-alert">
                                            <p><span class="icon-minus-sign"></span>
                                                <i class="close icon-remove-circle"></i>
                                                <span>Error!</span>
                                                <?php 
                                                foreach ($login->errors as $error) {

                                                  echo $error;

                                                }?>
                                            </p>
                                        </div>
                                        <?php
                                            }
                                        }
                                        ?>         
                                    </div>
                                    <div id="loader" style="display:none"></div>
                                    <form class="login-form"  method="post" name="login_form" id="login-form">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left115'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-account ml-3 icons"></i>
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['left116'] ?>" name="username" id="username" required="">
                                                </div>
                                            </div>
    
                                            <div class="col-lg-12">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left117'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-key ml-3 icons"></i>
                                                    <input type="password" class="form-control pl-5" placeholder="<?php echo $lang['left118'] ?>" name="password" id="password" required="">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <p class="float-right forgot-pass"><a href="forgot-password.php" class="text-dark font-weight-bold"><?php echo $lang['left119'] ?></a></p>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                        <label class="custom-control-label" for="customCheck1"><?php echo $lang['left120'] ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-0">
                                                <button class="btn btn-primary rounded w-100"><?php echo $lang['left121'] ?></button>
                                                <input name="login" type="hidden" value="1" />
                                            </div>
                       
                                            <div class="col-12 text-center">
                                                <p class="mb-0 mt-3"><small class="text-dark mr-2"><?php echo $lang['left122'] ?></small> <a href="sign-up.php" class="text-dark font-weight-bold"><?php echo $lang['left123'] ?></a></p>
                                            </div>
                                        </div>
                                    </form>
                                </div><!---->
                            </div> <!--end col-->
                        </div><!--end row-->
                    </div> <!--end container-->
                </div>
            </div>
        </section><!--end section-->

        <footer class="text-center">
            &copy <?php echo date('Y') . ' ' . $core->site_name; ?> - <?php echo $lang['foot'] ?>
        </footer>
        <!-- Hero End -->

        <!-- Back to top -->
        <a href="#" class="back-to-top rounded text-center" id="back-to-top"> 
            <i class="mdi mdi-chevron-up d-block"> </i> 
        </a>
        <!-- Back to top -->
      

        <!-- javascript -->
        <script src="assets/css_main_deprixa/main_deprixa/js/jquery.min.js"></script>
        <script src="assets/css_main_deprixa/main_deprixa/js/bootstrap.bundle.min.js"></script>
        <script src="assets/css_main_deprixa/main_deprixa/js/jquery.easing.min.js"></script>
        <script src="assets/css_main_deprixa/main_deprixa/js/scrollspy.min.js"></script>
        <!-- Main Js -->
        <script src="assets/css_main_deprixa/main_deprixa/js/app.js"></script> 

    </body>

</html>
