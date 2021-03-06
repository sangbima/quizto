<div class="container">
	<h3><?php echo $title;?></h3>
	<div class="row">
		<form method="post" action="<?php echo site_url('quiz/update_quiz/'.$quiz['quid']);?>">
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
									<input type="text" name="quiz_name"  value="<?php echo $quiz['quiz_name'];?>" class="form-control" placeholder="<?php echo $this->lang->line('quiz_name');?>"  required autofocus>
								</div>
							</div>
							<div class="col-md-6">
								<label class="toggle"><input id="quiz_status" name="status" type="checkbox" <?php echo $quiz['status'] == "1" ? 'checked' : '';?>><span class="handle"></span></label> <label for="quiz_status" ><?php echo $this->lang->line('status');?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
									<textarea   name="description"  class="form-control tinymce_textarea" ><?php echo $quiz['description'];?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="start_date"><?php echo $this->lang->line('start_date');?></label>
									<input id="start_date" name="start_date"  value="<?php echo date('d-m-Y',$quiz['start_date']);?>" class="form-control datepicker" required>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label for="start_time"><?php echo $this->lang->line('start_time');?></label> 
									<input id="start_time" name="start_time"  value="<?php echo date('H:i',$quiz['start_date']);?>" type="time" class="form-control timepicker" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="end_date"><?php echo $this->lang->line('end_date');?></label>
								<input id="end_date" name="end_date"  value="<?php echo date('d-m-Y',$quiz['end_date']);?>" class="form-control datepicker" required>
							</div>
							<div class="col-md-2">
								<label for="end_time"><?php echo $this->lang->line('end_time');?></label>
								<input id="end_time" name="end_time"  value="<?php echo date('H:i',$quiz['end_date']);?>" type="time" class="form-control timepicker" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('duration');?></label> 
									<input type="text" name="duration"  value="<?php echo $quiz['duration'];?>" class="form-control" placeholder="<?php echo $this->lang->line('duration');?>"  required  >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('maximum_attempts');?></label> 
									<input type="text" name="maximum_attempts"  value="<?php echo $quiz['maximum_attempts'];?>" class="form-control" placeholder="<?php echo $this->lang->line('maximum_attempts');?>"   required >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('pass_percentage');?></label> 
									<input type="text" name="pass_percentage" value="<?php echo $quiz['pass_percentage'];?>" class="form-control" placeholder="<?php echo $this->lang->line('pass_percentage');?>"   required >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('correct_score');?></label> 
									<input type="text" name="correct_score"  value="<?php echo $quiz['correct_score'];?>" class="form-control" placeholder="<?php echo $this->lang->line('correct_score');?>"   required >
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('incorrect_score');?></label> 
									<input type="text" name="incorrect_score"  value="<?php echo $quiz['incorrect_score'];?>" class="form-control" placeholder="<?php echo $this->lang->line('incorrect_score');?>"  required  >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">	 
									<label for="inputEmail"  ><?php echo $this->lang->line('ip_address');?></label> 
									<input type="text" name="ip_address"  value="<?php echo $quiz['ip_address'];?>" class="form-control" placeholder="<?php echo $this->lang->line('ip_address');?>"    >
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label for="inputEmail" ><?php echo $this->lang->line('view_answer');?></label> <br>
									<div class="radio">
										<input type="radio" id="viewYes" name="view_answer" value="1" <?php if($quiz['view_answer']==1){ echo 'checked'; } ?>> 
										<label for="viewYes"><?php echo $this->lang->line('yes');?></label>
									</div>
									<div class="radio">
										<input type="radio" id="viewNo" name="view_answer" value="0" <?php if($quiz['view_answer']==0){ echo 'checked'; } ?>> 
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
									<label for="inputEmail" ><?php echo $this->lang->line('capture_photo');?></label> <br>
									<div class="radio">
										<input type="radio" id="camYes" name="camera_req" value="1"   <?php if($quiz['camera_req']==1){ echo 'checked'; } ?>  >
										<label for="camYes"><?php echo $this->lang->line('yes');?></label>
									</div>
									<div class="radio">
										<input type="radio" id="camNo" name="camera_req" value="0"   <?php if($quiz['camera_req']==0){ echo 'checked'; } ?>    > 
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
									<label><?php echo $this->lang->line('select_group');?></label> <br>
									<?php 
										foreach($group_list as $key => $val){
									?>
										<div class="checkbox">
											<input type="checkbox" id="group<?php echo ($key+1);?>" name="gids[]" value="<?php echo $val['gid'];?>" <?php if(in_array($val['gid'],explode(',',$quiz['gids']))){ echo 'checked'; } ?> >
											<label for="group<?php echo ($key+1);?>"><?php echo $val['group_name'];?></label>
										</div>
									<?php 
										}
									?>
								</div>
							</div>
						</div>
						<hr>
						<?php 
						if($quiz['question_selection']=='0'){

						?>
							<h4><?php echo $this->lang->line('questions_added_into_quiz');?></h4>
							<a href="<?php echo site_url('quiz/add_question/'.$quiz['quid']);?>" class="btn btn-danger"  ><?php echo $this->lang->line('add_question_into_quiz');?></a>

							<table class="table table-bordered" style="margin-top:10px;">
								<tr>
									<th>#</th>
									<th><?php echo $this->lang->line('question');?></th>
									<th><?php echo $this->lang->line('question_type');?></th>
									<th><?php echo $this->lang->line('category_name');?></th>
									<th><?php echo $this->lang->line('level_name');?></th>
									<th><?php echo $this->lang->line('action');?> </th>
								</tr>
								<?php 
									if(count($questions)==0){
								?>
								<tr>
									<td colspan="6"><?php echo $this->lang->line('no_question_added');?></td>
								</tr>
								<?php
									}
									foreach($questions as $key => $val){
								?>
								<tr>
									<td><?php echo $val['qid'];?></td>
									<td><?php echo substr(strip_tags($val['question']),0,50);?></td>
									<td><?php echo $val['question_type'];?></td>
									<td><?php echo $val['category_name'];?></td>
									<td><?php echo $val['level_name'];?></td>
									<td>
										<a class="btn btn-sm btn-danger" href="<?php echo site_url('quiz/remove_qid/'.$quiz['quid'].'/'.$val['qid']);?>" title="<?php echo $this->lang->line('remove_from_quiz');?>"><i class="fa fa-trash"></i></a>
										<?php 
										if($key==0){
										?>
										<img src="<?php echo base_url();?>images/empty.png" title="">
										<?php 
										}else{
										?>
										<a class="btn btn-sm btn-success" href="javascript:cancelmove('Up','<?php echo $quiz['quid'];?>','<?php echo $val['qid'];?>','<?php echo $key+1;?>');"><i class="fa fa-arrow-up"></i></a>
										<?php 
										}

										if($key==(count(explode(',',$quiz['qids']))-1)){ 
										?>
										<?php 
										}else{
										?>
										<a class="btn btn-sm btn-warning" href="javascript:cancelmove('Down','<?php echo $quiz['quid'];?>','<?php echo $val['qid'];?>','<?php echo $key+1;?>');"><i class="fa fa-arrow-down"></i></a>
										<?php 
										}
										?>
									</td>
								</tr>

								<?php 
								}
								?>
							</table>
						<?php
						}else{
						?>
							<h4><?php echo $this->lang->line('questions_added_into_quiz');?></h4><br> 
							<?php 
							if(count($qcl)==0){
								echo $this->lang->line('no_question_added').'<br><br>'; 
							}	
							foreach($qcl as $k => $vall){
							?>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label><?php echo $this->lang->line('select_category');?></label> 
										<select class="selecter_4" name="cid[]" >
											<option value="0"><?php echo $this->lang->line('select');?> <?php echo $this->lang->line('category_name');?></option>
											<?php 
											foreach($category_list as $key => $val){
											?>
												<option value="<?php echo $val['cid'];?>"   <?php if($val['cid']==$vall['cid']){ echo 'selected'; } ?>  ><?php echo $val['category_name'];?></option>
											<?php 
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label><?php echo $this->lang->line('select_level');?></label>
										<select class="selecter_4" name="lid[]" >
											<option value="0"><?php echo $this->lang->line('select');?> <?php echo $this->lang->line('level_name');?></option>
											<?php 
											foreach($level_list as $key => $val){
											?>
												<option value="<?php echo $val['lid'];?>"   <?php if($val['lid']==$vall['lid']){ echo 'selected'; } ?> ><?php echo $val['level_name'];?></option>
											<?php 
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label><?php echo $this->lang->line('no_questions_added');?></label>
										<select class="selecter_4" name="noq[]">
											<option value="<?php echo $vall['noq'];?>"><?php echo $vall['noq'];?></option>
											<option value="0">0</option>
										</select>
									</div>
								</div>
								<hr>
							</div>
							<?php 
								}
							?>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">	 
										<select  class="selecter_4" name="cid[]" id="cid">
											<option value="0"><?php echo $this->lang->line('select');?> <?php echo $this->lang->line('category_name');?></option>
											<?php 
											foreach($category_list as $key => $val){
											?>
												<option value="<?php echo $val['cid'];?>"   ><?php echo $val['category_name'];?></option>
											<?php 
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<select class="selecter_4" name="lid[]" onChange="no_q_available(this.value);">
											<option value="0"><?php echo $this->lang->line('select');?> <?php echo $this->lang->line('level_name');?></option>
											<?php 
											foreach($level_list as $key => $val){
											?>
												<option value="<?php echo $val['lid'];?>"   ><?php echo $val['level_name'];?></option>
											<?php 
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10">
									<div class="row">
										<div class="col-md-7">
											<label><?php echo $this->lang->line('no_questions_available');?></label>
										</div>
										<div class="col-md-2">
											<span id="no_q_available"></span>
										</div>
									</div>
								</div>
							</div>
						<?php 
						}

						?>	
						<button class="btn btn-success" type="submit"><?php echo $this->lang->line('submit');?></button>
				 
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div  id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:100%;border-radius:5px;height:200px; border:1px solid #dddddd;left:4px;top:70px;background:#ffffff;">
	<center><b> <?php echo $this->lang->line('to_which_position');?></b><br><input type="text" style="width:30px" id="qposition" value=""><br><br>
		<a href="javascript:cancelmove();"   class="btn btn-danger"  style="cursor:pointer;"><?php echo $this->lang->line('cancel');?></a> &nbsp; &nbsp; &nbsp; &nbsp;
		<a href="javascript:movequestion();"   class="btn btn-info"  style="cursor:pointer;"><?php echo $this->lang->line('move');?></a>
	</center>
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