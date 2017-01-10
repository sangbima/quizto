<div class="container">
	<h3><?php echo $title;?></h3>
	<div class="row">
		<form method="post" action="<?php echo site_url('quiz/insert_quiz/');?>">
			<div class="col-md-12">
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
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('quiz_name');?></label> 
									<input type="text"  name="quiz_name"  class="form-control" placeholder="<?php echo $this->lang->line('quiz_name');?>"  required autofocus>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
									<textarea   name="description"  class="form-control tinymce_textarea" ></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label for="start_date"><?php echo $this->lang->line('start_date');?></label>
									<input id="start_date" name="start_date"  value="<?php echo date('d-m-Y',time());?>" class="form-control datepicker" required>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="start_time"><?php echo $this->lang->line('start_time');?></label>
									<input id="start_time" name="start_time"  value="<?php echo date('H:i',time());?>" type="time" class="form-control timepicker">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label for="end_date"><?php echo $this->lang->line('end_date');?></label>
									<input id="end_date" name="end_date"  value="<?php echo date('d-m-Y',time()+(60*60*24*365));?>" class="form-control datepicker"required>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="end_time"><?php echo $this->lang->line('end_time');?></label>
									<input id="end_time" name="end_time"  value="<?php echo date('H:i',time());?>" type="time" class="form-control timepicker" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('duration');?></label> 
									<input type="text" name="duration"  value="10" class="form-control" placeholder="<?php echo $this->lang->line('duration');?>"  required  >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('maximum_attempts');?></label> 
									<input type="text" name="maximum_attempts"  value="10" class="form-control" placeholder="<?php echo $this->lang->line('maximum_attempts');?>"   required >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('pass_percentage');?></label> 
									<input type="text" name="pass_percentage" value="50" class="form-control" placeholder="<?php echo $this->lang->line('pass_percentage');?>"   required >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('correct_score');?></label> 
									<input type="text" name="correct_score"  value="1" class="form-control" placeholder="<?php echo $this->lang->line('correct_score');?>"   required >
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('incorrect_score');?></label> 
									<input type="text" name="incorrect_score"  value="0" class="form-control" placeholder="<?php echo $this->lang->line('incorrect_score');?>"  required  >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('ip_address');?></label> 
									<input type="text" name="ip_address"  value="" class="form-control" placeholder="<?php echo $this->lang->line('ip_address');?>"    >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputEmail" ><?php echo $this->lang->line('view_answer');?></label>
									<div class="radio">
										<input type="radio" id="viewYes" name="view_answer" value="1" checked > 
										<label for="viewYes"><?php echo $this->lang->line('yes');?></label>
									</div>
									<div class="radio">
										<input type="radio" id="viewNo" name="view_answer" value="0"  >
										<label for="viewNo"><?php echo $this->lang->line('no');?></label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<?php 
								if($this->config->item('webcam')==true){
									?>
									<div class="form-group">	 
										<label for="inputEmail" ><?php echo $this->lang->line('capture_photo');?></label>
										<div class="radio">
											<input type="radio" id="camYes" name="camera_req" value="1"  >
											<label for="camYes"><?php echo $this->lang->line('yes');?></label>
										</div>
										<div class="radio">
											<input type="radio" id="camNo" name="camera_req" value="0"  checked >
											<label for="camNo"><?php echo $this->lang->line('no');?></label>
										</div>
									</div>
								<?php 
								}else{
									?>
									<input type="hidden" name="camera_req" value="0">
									
									<?php 
								}
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label   ><?php echo $this->lang->line('select_group');?></label> <br>
									 <?php 
									foreach($group_list as $key => $val){
									?>
										<div class="checkbox">
										<input type="checkbox" name="gids[]" id="group<?php echo ($key+1);?>" value="<?php echo $val['gid'];?>" <?php if($key==0){ echo 'checked'; } ?> > 
										<label for="group<?php echo ($key+1);?>"><?php echo $val['group_name'];?></label>
										</div>
									<?php 
									}
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">	 
									<label for="inputEmail" ><?php echo $this->lang->line('question_selection');?></label> <br>
									<div class="radio">
										<input type="radio" id="auto" name="question_selection" value="1"  >
										<label for="auto"><?php echo $this->lang->line('automatically');?></label>
									</div>
									<div class="radio">
										<input type="radio" id="manual" name="question_selection" value="0"  checked >
										<label for="manual"><?php echo $this->lang->line('manually');?></label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">	 
									<label for="inputEmail" ><?php echo $this->lang->line('generate_certificate');?></label>
									<div class="radio">
										<input type="radio" id="genYes" name="gen_certificate" value="1"  >
										<label for="genYes"><?php echo $this->lang->line('yes');?></label>
									</div>
									<div class="radio">
										<input type="radio" id="genNo" name="gen_certificate" value="0"  checked >
										<label for="genNo"><?php echo $this->lang->line('no');?></label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('certificate_text');?></label> 
									<textarea  name="certificate_text"  class="form-control" style="height:250px;"></textarea><br>
									<?php echo $this->lang->line('tags_use');?> <?php echo htmlentities("<br>  <center></center>  <b></b>  <h1></h1>  <h2></h2>  <h3></h3>  <font></font>");?><br>
									{email}, {first_name}, {last_name}, {quiz_name}, {percentage_obtained}, {score_obtained}, {result}, {generated_date}, {result_id}, {qr_code}
								</div>
							</div>
						</div>
						
						<button class="btn btn-success" type="submit"><?php echo $this->lang->line('next');?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
// When the document is ready
$(document).ready(function () {
    
    $('#start_date').datepicker({
        format: "dd-mm-yyyy"
    });
    $('#end_date').datepicker({
        format: "dd-mm-yyyy"
    });

});
</script>