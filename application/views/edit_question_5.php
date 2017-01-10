<div class="container">
	<h3><?php echo $title;?></h3>
	<div class="row">
		<div class="col-md-8">
			<form method="post" action="<?php echo site_url('qbank/edit_question_5/'.$question['qid']);?>">
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
									<?php echo $this->lang->line('long_answer');?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label><?php echo $this->lang->line('select_category');?></label> 
									<select class="form-control" name="cid">
										<?php 
											foreach($category_list as $key => $val){
										?>
												<option value="<?php echo $val['cid'];?>"  <?php if($question['cid']==$val['cid']){ echo 'selected'; } ?> ><?php echo $val['category_name'];?></option>
										<?php 
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">	 
									<label   ><?php echo $this->lang->line('select_level');?></label> 
									<select class="form-control" name="lid">
										<?php 
											foreach($level_list as $key => $val){
										?>
												<option value="<?php echo $val['lid'];?>" <?php if($question['lid']==$val['lid']){ echo 'selected'; } ?> ><?php echo $val['level_name'];?></option>
										<?php 
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">	 
								<label for="inputEmail"  ><?php echo $this->lang->line('question');?></label> 
								<textarea  name="question"  class="form-control"   ><?php echo $question['question'];?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">	 
								<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
								<textarea  name="description"  class="form-control"><?php echo $question['description'];?></textarea>
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
			</form>
		</div>
		<div class="col-md-3">
			<div class="form-group">	 
				<table class="table table-bordered">
					<tr><td><?php echo $this->lang->line('no_times_corrected');?></td><td><?php echo $question['no_time_corrected'];?></td></tr>
					<tr><td><?php echo $this->lang->line('no_times_incorrected');?></td><td><?php echo $question['no_time_incorrected'];?></td></tr>
					<tr><td><?php echo $this->lang->line('no_times_unattempted');?></td><td><?php echo $question['no_time_unattempted'];?></td></tr>
				</table>
			</div>
		</div>
	</div>
</div>