

<!DOCTYPE html>
    <html lang="en">

<head>
        <meta charset="utf-8" />
        <title><?php echo $lang['langs_010106'] ?> | <?php echo $core->site_name;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="Courier DEPRIXA-Integral Web System">
        <meta name="author" content="Jaomweb">
        <meta name="description" content="">
        <!-- favicon -->
        <link rel="icon" type="image/png" sizes="16x16" href="assets/<?php echo $core->favicon ?>">
        <!-- Bootstrap -->
        <link href="assets/css_main_deprixa/main_deprixa/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons -->
        <link href="assets/css_main_deprixa/main_deprixa/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" /> 
        <!-- Main css --> 
        <link href="assets/css_main_deprixa/main_deprixa/css/style.css" rel="stylesheet" type="text/css" />
        <!-- Main js --> 
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/jquery-ui.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.js"></script>
        <script src="assets/js/jquery.wysiwyg.js"></script>
        <script src="assets/js/global.js"></script>
        <script src="assets/js/custom.js"></script>
        <script src="assets/js/checkbox.js"></script>

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
                    <a href="sign-up.php" class="btn btn-soft-secondary"><i class="mdi mdi-account-alert ml-3 icons"></i> <?php echo $lang['left169'] ?></a>
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
                        <li><a href="index.php"><?php echo $lang['left170'] ?></a></li>
                        
                        <li><a href="tracking.php"><i class="mdi mdi-package-variant-closed"></i> <?php echo $lang['left171'] ?></a></li>
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
                                <div class="mr-lg-5">   
                                    <img src="assets/css_main_deprixa/images/user/recovery.png" class="img-fluid" alt="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                                <div class="login_page bg-white shadow rounded p-4">
                                    <div class="text-center">
                                        <h4 class="mb-4"><?php echo $lang['left172'] ?></h4>  
                                    </div>
                                    
                                        <div id="resultados_ajax"></div>
                                        <div id="loader" style="display:none"></div>
                                    <div id="msgholder2">
                                        <?php 
                                        // print Filter::$showMsg;?>
                                            
                                        </div>
        
                                    <form class="login-form" name="forgotPassword" id="forgotPassword" method="post">
                                        <div class="row">
                                   
                                            <div class="col-lg-12">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left175'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-mail-ru ml-3 icons"></i>
                                                    <input type="email" class="form-control pl-5" placeholder="<?php echo $lang['left176'] ?>" id="email" name="email" required="">
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-lg-12">
                                                <button type="submit" name="dosubmit"  class="btn btn-primary rounded w-100"><?php echo $lang['langs_010108'] ?></button>
                                            </div>
                                        </div>
                                    </form>
                                  
                                    <br><br>    
                                    <p>
                                        <?php echo $lang['langs_010109'] ?> </br><?php if($core->reg_allowed):?><a href="sign-up.php" class="text-primary"><?php echo $lang['langs_010110'] ?></a><?php endif;?> | <a href="index.php" class="text-primary"><?php echo $lang['langs_010111'] ?></a>
                                    </p>
                                </div>
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

        <script src="dataJs/forgot_password.js"></script> 


    </body>

</html>