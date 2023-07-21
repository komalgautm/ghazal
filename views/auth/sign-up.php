<?php


?>
<!DOCTYPE html>
    <html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $lang['langs_010112'] ?> | <?php echo $core->site_name;?></title>
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
                   <a class="logo" href="index.php"><?php echo ($core->logo) ? '<img src="assets/'.$core->logo.'" alt="'.$core->site_name.'" width="190" height="45"/>': $core->site_name;?></a>
                </div>                 

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
                        <li><a href="index.php"><?php echo $lang['left134'] ?></a></li>
                        
                        <li><a href="tracking.php"><i class="mdi mdi-package-variant-closed"></i> <?php echo $lang['left135'] ?></a></li>
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
                            <div class="col-lg-7 col-md-5">
                                <div class="mr-lg-6">   
                                    <img src="assets/css_main_deprixa/images/user/signup.png" class="img-fluid" alt="">
                                </div>
                            </div>
								
                            <div class="col-lg-5 col-md-7 mt-4 mt-sm-5 pt-2 pt-sm-3">
								<?php if(!$core->reg_allowed):?>

                                    <div class="alert alert-warning" id="success-alert">
                                        <p><span class="icon-exclamation-sign"></span><i class="close icon-remove-circle"></i>
                                            
                                               <?php echo $lang['langs_010133'];?>
                                        </p>
                                    </div>     
								
							
								<?php else:?>
                                <div class="login_page bg-white shadow rounded p-4">
                                    <div class="text-center">
                                        <h4 class="mb-4"><?php echo $lang['left136'] ?></h4>
										<p><?php echo $lang['left137'] ?></p>										
                                    </div>
									<div id="resultados_ajax"></div>
									<br><br>	
                                    <form class="login-form" id="new_register" name="new_register" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">                                               
                                                    <label><?php echo $lang['left138'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-account ml-3 icons"></i>
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['left139'] ?>" name="fname" id="fname">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">                                                
                                                    <label><?php echo $lang['left140'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-account ml-3 icons"></i>
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['left141'] ?>" name="lname" id="lname">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left142'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-mail-ru ml-3 icons"></i>
                                                    <input type="email" class="form-control pl-5" placeholder="<?php echo $lang['left143'] ?>" name="email" id="email" >
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group position-relative">                                                
                                                    <label><?php echo $lang['user_manage12'] ?> <span class="text-danger">*</span></label>
                                                   
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['user_manage12'] ?>" name="country" id="country" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group position-relative">                                                
                                                    <label><?php echo $lang['user_manage13'] ?> <span class="text-danger">*</span></label>
                                                   
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['user_manage13'] ?>" name="city" id="city" required>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group position-relative">                                                
                                                    <label><?php echo $lang['user_manage14'] ?> <span class="text-danger">*</span></label>
                                                   
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['user_manage14'] ?>" name="postal" id="postal" required>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group position-relative">                                                
                                                    <label><?php echo $lang['user_manage10'] ?> <span class="text-danger">*</span></label>
                                                   
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['user_manage10'] ?>" name="address" id="address" required>
                                                </div>
                                            </div>


                                           
											<div class="col-md-12">
                                                <div class="form-group position-relative">                                               
                                                    <label><?php echo $lang['left144'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-account ml-3 icons"></i>
                                                    <input type="text" class="form-control pl-5" placeholder="<?php echo $lang['left145'] ?>" name="username" id="username">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left146'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-key ml-3 icons"></i>
                                                    <input type="password" class="form-control pl-5" placeholder="<?php echo $lang['left147'] ?>" name="pass" id="pass">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group position-relative">
                                                    <label><?php echo $lang['left148'] ?> <span class="text-danger">*</span></label>
                                                    <i class="mdi mdi-key ml-3 icons"></i>
                                                    <input type="password" class="form-control pl-5" name="pass2" id="pass2" placeholder="<?php echo $lang['left149'] ?>">
                                                </div>
                                            </div>

											
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="terms" name="terms" value="yes">
                                                        <label class="custom-control-label" for="terms"><?php echo $lang['left164'] ?> <a href="#" class="text-primary"> <?php echo $lang['left165'] ?></a></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn btn-primary rounded w-100" name="dosubmit"><?php echo $lang['left166'] ?></button>
												<input name="locker" type="hidden"id="locker" value="<?php echo cdp_generarCodigo(6); ?>" />
												
                                            </div>
                                            <div class="col-lg-12 mt-4 text-center">
                                                
                                            </div>
                                            <div class="mx-auto">
                                                <p class="mb-0 mt-3"><small class="text-dark mr-2"><?php echo $lang['left167'] ?> </small> <a href="index.php" class="text-dark font-weight-bold"><?php echo $lang['left168'] ?></a></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
								
							<?php endif;?>
                            </div> <!--end col-->	

                        </div><!--end row-->

                    </div> <!--end container-->

                </div>
            </div>
            <br><br><br>
            <footer class="text-center">
                &copy <?php echo date('Y') . ' ' . $core->site_name; ?> - <?php echo $lang['foot'] ?>
            </footer>
        </section><!--end section-->

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

        <script src="dataJs/sign-up.js"></script> 

    </body>

</html>