<?php $logged_in=$this->session->userdata('logged_in'); ?>
<div class="container">
	<h3><?php echo $title;?></h3>
	<div class="row">
		<form method="post" action="<?php echo site_url('user/update_user/'.$uid);?>">
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
							<div class="col-md-12">
								<div class="form-group">	 
									<?php echo $this->lang->line('group_name');?>: <?php echo $result['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $result['price'];?>)
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputRegistrationNo" class="sr-only"><?php echo $this->lang->line('registration_no');?></label> 
									<input type="text" id="inputRegistrationNo" name="registration_no" value="<?php echo $result['registration_no'];?>" class="form-control" placeholder="<?php echo $this->lang->line('registration_no');?>" required autofocus>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('email_address');?></label> 
									<input type="email" id="inputEmail" name="email" value="<?php echo $result['email'];?>" class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" required autofocus>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	  
									<label for="inputPassword" class="sr-only"><?php echo $this->lang->line('password');?></label>
									<input type="password" id="inputPassword" name="password"   value=""  class="form-control" placeholder="<?php echo $this->lang->line('password');?>"   >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('first_name');?></label> 
									<input type="text"  name="first_name"  class="form-control"  value="<?php echo $result['first_name'];?>"  placeholder="<?php echo $this->lang->line('first_name');?>"   autofocus>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('last_name');?></label> 
									<input type="text"   name="last_name"  class="form-control"  value="<?php echo $result['last_name'];?>"  placeholder="<?php echo $this->lang->line('last_name');?>"   autofocus>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group" id="selectProvinsi">
                                    <?php echo form_label('Provinsi<sup class="required">*</sup>', 'inputprovinsi'); ?>
                                    
                                    <?php 
                                        $noselect = array('#' => '-- Pilih Provinsi --');
                                        $options = array_merge($noselect, $provinsi);
                                        echo form_dropdown('provinsi', $options, $result['provinsi'], array(
                                            'id' => 'inputprovinsi',
                                            'class' => 'form-control',
                                            'data-selecter-options' => '{"cover":"true"}',
                                            'required' => 'required'
                                        )); 
                                        //echo $result['provinsi'];
                                    ?>
                                    <small><?php echo form_error('provinsi', '<div class="text-danger">', '</div>');?></small>
                                </div>
							</div>
							<div class="col-md-6">
								<div class="form-group" id="selectKabkota">
                                    <?php echo form_label('Kabupaten/Kota<sup class="required">*</sup>', 'inputkabupaten'); ?>
                                    <?php 
                                        echo form_dropdown('kabupatenkota', $kabupatenkota, $result['kabupatenkota'], array(
                                            'id' => 'inputkabupaten',
                                            'class' => 'form-control',
                                            'data-selecter-options' => '{"cover":"true"}',
                                            'required' => 'required'
                                        )); 
                                    ?>

                                    <small><?php echo form_error('kabupatenkota', '<div class="text-danger">', '</div>');?></small>
                                </div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label   ><?php echo $this->lang->line('select_group');?></label> 
									<select class="form-control" name="gid"  onChange="getexpiry();" id="gid">
										<?php 
										foreach($group_list as $key => $val){
										?>
											<option value="<?php echo $val['gid'];?>" <?php if($result['gid']==$val['gid']){ echo 'selected';}?> ><?php echo $val['group_name'];?> (<?php echo $this->lang->line('price_');?>: <?php echo $val['price'];?>)</option>
										<?php 
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">	 
									<label   ><?php echo $this->lang->line('account_type');?></label> 
									<select class="form-control" name="su">
										<option value="0" <?php if($result['su']==0){ echo 'selected';}?>><?php echo $this->lang->line('user');?></option>
										<?php  
					                    if($logged_in['su']==1){
					                    ?>
										<option value="1" <?php if($result['su']==1){ echo 'selected';}?>><?php echo $this->lang->line('administrator');?></option>
										<option value="2" <?php if($result['su']==2){ echo 'selected';}?>><?php echo $this->lang->line('operator');?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('contact_no');?></label> 
									<input type="text" name="contact_no"  class="form-control"  value="<?php echo $result['contact_no'];?>"  placeholder="<?php echo $this->lang->line('contact_no');?>"   autofocus>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputEmail"  class="sr-only"><?php echo $this->lang->line('subscription_expired');?></label> 
									<input type="text" name="subscription_expired"  id="subscription_expired" class="form-control" value="<?php if($result['subscription_expired']!='0'){ echo date('d-m-Y',$result['subscription_expired']); }else{ echo '0';} ?>" placeholder="<?php echo $this->lang->line('subscription_expired');?>"  value=""  autofocus>
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
<script type="text/javascript">
// When the document is ready
$(document).ready(function () {
    
    $('#subscription_expired').datepicker({
        format: "dd-mm-yyyy"
    });

    $("#inputprovinsi").change(function(){
        $("#inputkabupaten > option").remove();
        var provinsi_name = $('#inputprovinsi').val();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "<?php echo site_url('user/getkotabyprovinsi') . '/'; ?>"+escape(provinsi_name),
            success: function(data)
            {
                $.each(data, function(key, value){
                    var opt = $('<option />');
                    opt.val(key);
                    opt.text(value);
                    $('#inputkabupaten').append(opt);
                });
            }
        });
    });

});
</script>