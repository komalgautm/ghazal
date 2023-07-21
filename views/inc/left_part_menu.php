	<div class=" left-sidebar">
		<!-- <div class="scroll-sidebar"> -->
		<div class="left-part">
			<a class="ti-menu ti-close btn btn-success show-left-part d-block d-md-none" href="javascript:void(0)"></a>
			<div class="scrollable" style="height:100%;">
				<div class="p-15">
					<a id="compose_mail" class="waves-effect waves-light btn btn-danger d-block" href=""><?php echo $lang['apis04'] ?></a>
				</div>
				<div class="divider"></div>
				<?php if ($userData->userlevel == 9) { ?>
					<nav class="sidebar-nav">
						<ul class="list-group" id="sidebarnav">

							<li>
								<small class="p-15 grey-text text-lighten-1 db"></small>
							</li>
							<li class="list-group-item">
								<a href="tools.php?list=config_general" class="list-group-item-action"><i class="mdi mdi-settings-box"></i> <?php echo $lang['left601'] ?></a>
							</li>
							<li class="list-group-item">
								<a href="tools.php?list=config" class="list-group-item-action"><i class="mdi mdi-briefcase-check"></i> <?php echo $lang['setcompany'] ?></a>
							</li>
							<li class="list-group-item">
								<a href="tools.php?list=config_email" class="list-group-item-action"><i class="mdi mdi-email"></i> <?php echo $lang['leftemail'] ?></a>
							</li>

							<li class="list-group-item sidebar-item"><a class="list-group-item-action has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="mdi mdi-playlist-plus"></i> <span class="hide-menu"> <?php echo $lang['template'] ?></span></a>
								<ul aria-expanded="false" class="collapse  first-level">
									<li class="list-group-item sidebar-item"><a href="templates_email.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['emailtemplate'] ?></span></a></li>
								</ul>
							</li>



							<li class="list-group-item sidebar-item"><a class="list-group-item-action has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="mdi mdi-playlist-plus"></i> <span class="hide-menu"><?php echo $lang['apis01'] ?></span></a>
								<ul aria-expanded="false" class="collapse  first-level">

									<li class="list-group-item sidebar-item"><a href="activate_payment_gateways.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"><?php echo $lang['apis02'] ?></span></a></li>

									<li class="list-group-item sidebar-item"><a href="config_paypal.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu">Config Paypal</span></a></li>

									<li class="list-group-item sidebar-item"><a href="config_stripe.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu">Config Stripe</span></a></li>

									<li class="list-group-item sidebar-item"><a href="config_paystack.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu">Config Paystack</span></a></li>



								</ul>
							</li>


							<li class="list-group-item sidebar-item"><a class="list-group-item-action has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="mdi mdi-playlist-plus"></i> <span class="hide-menu"><?php echo $lang['apis03'] ?></span></a>
								<ul aria-expanded="false" class="collapse  first-level">

									<li class="list-group-item sidebar-item"><a href="activate_whatsapp.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu">Activate Twilio Whatssap</span></a></li>


									<li class="list-group-item sidebar-item"><a href="config_twilio.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu">Config Twilio Whatssap</span></a></li>

								</ul>
							</li>

							<li class="list-group-item">
								<a href="backup.php" class="list-group-item-action"> <i class="mdi mdi-backup-restore"></i> <?php echo $lang['restorbackup'] ?> </a>
							</li>
							<li class="list-group-item">
								<hr>
							</li>

						</ul>
					</nav>
				<?php } else if ($userData->userlevel == 2) { ?>
					<nav class="sidebar-nav">
						<ul class="list-group" id="sidebarnav">
							<li>
								<small class="p-15 grey-text text-lighten-1 db"></small>
							</li>
							<li class="list-group-item sidebar-item"><a class="list-group-item-action has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="mdi mdi-playlist-plus"></i> <span class="hide-menu"> <?php echo $lang['left606'] ?></span></a>
								<ul aria-expanded="false" class="collapse  first-level">
									<li class="list-group-item sidebar-item"><a href="offices_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['officegroup'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="branchoffices_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['left30'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="courier_company_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['left31'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="delivery_time_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['left609'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="shipping_mode_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['shipmode'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="status_courier_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['stylestatus'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="payment_method_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['paymode'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="packaging_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['packatype'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="category_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['itemcategory'] ?></span></a></li>
								</ul>
							</li>
							<li class="list-group-item sidebar-item"><a class="list-group-item-action has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="mdi mdi-playlist-plus"></i> <span class="hide-menu"> <?php echo $lang['left602'] ?></span></a>
								<ul aria-expanded="false" class="collapse  first-level">
									<li class="list-group-item sidebar-item"><a href="tools.php?list=config_payment" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['left603'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="tools.php?list=config_api_google" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['left604'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="tools.php?list=config_sms" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['left34'] ?></span></a></li>
								</ul>
							</li>
							<li class="list-group-item sidebar-item"><a class="list-group-item-action has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="mdi mdi-playlist-plus"></i> <span class="hide-menu"> <?php echo $lang['left607'] ?></span></a>
								<ul aria-expanded="false" class="collapse  first-level">
									<li class="list-group-item sidebar-item"><a href="shipline_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['shipline'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="incoterms_list.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['incoterms'] ?></span></a></li>
								</ul>
							</li>
							<li class="list-group-item sidebar-item"><a class="list-group-item-action has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="mdi mdi-playlist-plus"></i> <span class="hide-menu"> <?php echo $lang['template'] ?></span></a>
								<ul aria-expanded="false" class="collapse  first-level">
									<li class="list-group-item sidebar-item"><a href="templates_email.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['emailtemplate'] ?></span></a></li>
									<li class="list-group-item sidebar-item"><a href="templatesms.php" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['smstemplate'] ?></span></a></li>
								</ul>
							</li>
							<li class="list-group-item">
								<hr>
							</li>
							<li class="list-group-item sidebar-item"><a class="list-group-item-action has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"> <i class="mdi mdi-playlist-plus"></i> <span class="hide-menu"> <?php echo $lang['left28'] ?></span></a>
								<ul aria-expanded="false" class="collapse  first-level">
									<li class="list-group-item sidebar-item"><a href="users_edit.php?user=<?php echo $user->uid; ?>" class="sidebar-link"><i class="mdi mdi-check"></i><span class="hide-menu"> <?php echo $lang['profiles'] ?></span></a></li>
								</ul>
							</li>
						</ul>
					</nav>
				<?php } ?>
			</div>
		</div>
	</div>