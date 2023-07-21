	<!-- Modal -->
	<div class="modal fade" id="myModalAddRecipientAddresses" tabindex="-1" role="dialog" aria-labelledby="modal_add_address_title">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
				<h4 class="modal-title" id="modal_add_address_title"></h4>
		  		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="add_address_from_modal_shipments" name="add_address_from_modal_shipments">
			<div class="resultados_ajax_mail text-center"></div>	

            <input type="hidden" id="type_user_address" name="type_user_address">         
	

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phoneNumber1"><?php echo $lang['user_manage10'] ?></label>
                            <input type="text" class="form-control" name="address"  id="address"placeholder="<?php echo $lang['user_manage10'] ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emailAddress1"><?php echo $lang['user_manage12'] ?></label>
                            <input type="text" class="form-control" name="country"  id="country" placeholder="<?php echo $lang['user_manage12'] ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phoneNumber1"><?php echo $lang['user_manage13'] ?></label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="<?php echo $lang['user_manage13'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phoneNumber1"><?php echo $lang['user_manage14'] ?></label>
                            <input type="text" class="form-control" name="postal" id="postal" placeholder="<?php echo $lang['user_manage14'] ?>">
                        </div>
                    </div>
                </div>
		
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-success" id="save_data_address">Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>