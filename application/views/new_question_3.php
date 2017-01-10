<div class="container">
	<h3><?php echo $title;?></h3>
	<div class="row">
		<form method="post" action="<?php echo site_url('qbank/new_question_3/'.$nop);?>">
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
									<?php echo $this->lang->line('match_the_column');?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">	 
									<label   ><?php echo $this->lang->line('select_category');?></label> 
									<select class="form-control selecter_4" name="cid">
										<?php 
											foreach($category_list as $key => $val){
										?>
												<option value="<?php echo $val['cid'];?>"><?php echo $val['category_name'];?></option>
										<?php 
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">	 
									<label   ><?php echo $this->lang->line('select_level');?></label> 
									<select class="form-control selecter_4" name="lid">
										<?php 
											foreach($level_list as $key => $val){
										?>
												<option value="<?php echo $val['lid'];?>"><?php echo $val['level_name'];?></option>
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
									<textarea  name="question"  class="form-control"   ></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">	 
								<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
								<textarea  name="description"  class="form-control"></textarea>
								</div>
							</div>
						</div>
						<?php 
							for($i=1; $i<=$nop; $i++){
						?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="inputEmail"  ><?php echo $this->lang->line('options');?> <?php echo $i;?>)</label> <br>
									<div class="col-md-5">
										<input class="form-control" type="text" name="option[]" value=""  >
									</div>
									<div class="col-md-2">
										<p class="text-center">=</p>
									</div>
									<div class="col-md-5">
										<input class="form-control" type="text" name="option2[]" value=""  > 
									</div>
								</div>
							</div>
						</div>
						<?php 
							}
						?>
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