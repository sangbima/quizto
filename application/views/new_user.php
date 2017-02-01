<?php $logged_in=$this->session->userdata('logged_in'); ?>
<div class="container">
	<h3><?php echo $title;?></h3>
	<div class="row">
		<form method="post" action="<?php echo site_url('user/insert_user/');?>">
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-body"> 
						<?php 
							if($this->session->flashdata('message')){
						?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('message');?>
						</div>
						<?php
							}
						?>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputRegistrationNo" class="sr-only"><?php echo $this->lang->line('registration_no');?></label> 
									<input type="text" id="inputRegistrationNo" name="registration_no" class="form-control" placeholder="<?php echo $this->lang->line('registration_no');?>" required autofocus>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('email_address');?></label> 
									<input type="email" id="inputEmail" name="email" class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" required autofocus>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	  
									<label for="inputPassword" class="sr-only"><?php echo $this->lang->line('password');?></label>
									<input type="password" id="inputPassword" name="password"  class="form-control" placeholder="<?php echo $this->lang->line('password');?>" required >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputFirstname" class="sr-only"><?php echo $this->lang->line('first_name');?></label> 
									<input type="text"  id="inputFirstname" name="first_name"  class="form-control" placeholder="<?php echo $this->lang->line('first_name');?>"   autofocus>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputLastname" class="sr-only"><?php echo $this->lang->line('last_name');?></label> 
									<input type="text"  id="inputLastname" name="last_name"  class="form-control" placeholder="<?php echo $this->lang->line('last_name');?>"   autofocus>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label><?php echo $this->lang->line('select_group');?></label> 
									<select class="form-control" name="gid" id="gid" onChange="getexpiry();">
										<?php 
										foreach($group_list as $key => $val){
										?>
											<option value="<?php echo $val['gid'];?>"><?php echo $val['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $val['price'];?>)</option>
										<?php 
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">	 
									<label><?php echo $this->lang->line('account_type');?></label> 
									<select class="form-control" name="su">
										<option value="0"><?php echo $this->lang->line('user');?></option>
										<?php  
					                    if($logged_in['su']==1){
					                    ?>
										<option value="1"><?php echo $this->lang->line('administrator');?></option>
										<option value="2"><?php echo $this->lang->line('operator');?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputContactno" class="sr-only"><?php echo $this->lang->line('contact_no');?></label> 
									<input type="text" id="inputContactno" name="contact_no"  class="form-control" placeholder="<?php echo $this->lang->line('contact_no');?>"   autofocus>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="subscription_expired"  class="sr-only"><?php echo $this->lang->line('subscription_expired');?></label> 
									<input type="text" name="subscription_expired"  id="subscription_expired" class="form-control" placeholder="<?php echo $this->lang->line('subscription_expired');?>" autofocus>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	getexpiry();
</script>
<script type="text/javascript">
// When the document is ready
$(document).ready(function () {
    
    $('#subscription_expired').datepicker({
        format: "dd-mm-yyyy"
    });  

});
</script>