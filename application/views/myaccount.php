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
							<?=$this->session->flashdata('message');?>
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
									<label for="inputRegistrationNo"><?php echo $this->lang->line('registration_no');?></label> 
									<input type="text" id="inputRegistrationNo" name="registration_no" value="<?php echo $result['registration_no'];?>" readonly=readonly class="form-control" placeholder="<?php echo $this->lang->line('registration_no');?>" required autofocus>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputEmail"><?php echo $this->lang->line('email_address');?></label> 
									<input type="email" id="inputEmail" name="email" value="<?php echo $result['email'];?>" readonly=readonly class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" required autofocus>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	  
									<label for="inputPassword"><?php echo $this->lang->line('password');?></label>
									<input type="password" id="inputPassword" name="password"   value=""  class="form-control" placeholder="<?php echo $this->lang->line('password');?>"   >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputEmail"><?php echo $this->lang->line('first_name');?></label> 
									<input type="text"  name="first_name"  class="form-control"  value="<?php echo $result['first_name'];?>"  placeholder="<?php echo $this->lang->line('first_name');?>"   autofocus>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputEmail"><?php echo $this->lang->line('last_name');?></label> 
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
									<label for="inputEmail"><?php echo $this->lang->line('contact_no');?></label> 
									<input type="text" name="contact_no"  class="form-control"  value="<?php echo $result['contact_no'];?>"  placeholder="<?php echo $this->lang->line('contact_no');?>"   autofocus>
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
	<?php if($this->config->item('show_payment_history')==true) {?>
	<div class="row">
		<div class="col-md-8">
			<h3><?php echo $this->lang->line('payment_history');?></h3>
			<table class="table table-bordered">
				<tr>
					<th><?php echo $this->lang->line('payment_gateway');?></th>
					<th><?php echo $this->lang->line('paid_date');?> </th>
					<th><?php echo $this->lang->line('amount');?></th>
					<th><?php echo $this->lang->line('transaction_id');?> </th>
					<th><?php echo $this->lang->line('status');?> </th>
				</tr>
				<?php 
				if(count($payment_history)==0){
				?>
				<tr>
					<td colspan="5"><?php echo $this->lang->line('no_record_found');?></td>
				</tr>
				<?php
				}
				foreach($payment_history as $key => $val){
				?>
				<tr>
					<td><?php echo $val['payment_gateway'];?></td>
					<td><?php echo date('d-m-Y H:i:s',$val['paid_date']);?></td>
					<td><?php echo $val['amount'];?></td>
					<td><?php echo $val['transaction_id'];?></td>
					<td><?php echo $val['payment_status'];?></td>
				</tr>
				<?php 
				}
				?>
			</table>
		</div>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
// When the document is ready
$(document).ready(function () {
    
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