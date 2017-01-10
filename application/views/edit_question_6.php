<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
        <form id="form" name="form" method="post" action="<?php echo site_url('qbank/edit_question_6/'.$question['qid']);?>">
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
							<div class="col-md-6">
								<div class="form-group">	 
								<label><?php echo $this->lang->line('select_category');?></label> 
									<select class="form-control selecter_4" name="cid">
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
									<label><?php echo $this->lang->line('select_level');?></label> 
									<select class="form-control selecter_4" name="lid">
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
                        <table class="table">
                            <tr>
                                <th>
                                    <?php echo $this->lang->line('most');?>
                                </th>
                                <th>
                                    <?php echo $this->lang->line('least');?>
                                </th>
                                <th>
                                    <?php echo $this->lang->line('statement');?>
                                </th>
                            </tr>

                            <?php 
                                foreach($options as $key => $val){
                                    $value = explode('||', $val['q_option']);
                                    // var_dump($value);die();
                            ?>
                                <tr>
                                    <td>
                                        <select name="disc_m_<?=$key+1 ?>">
                                            <option value="D" <?php if($value[0] == "D") echo "selected" ;?> >D</option>
                                            <option value="I" <?php if($value[0] == "I") echo "selected" ;?>>I</option>
                                            <option value="S" <?php if($value[0] == "S") echo "selected" ;?>>S</option>
                                            <option value="C" <?php if($value[0] == "C") echo "selected" ;?>>C</option>
                                            <option value="*" <?php if($value[0] == "*") echo "selected" ;?>>*</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="disc_l_<?=$key+1 ?>">
                                            <option value="D" <?php if($value[1] == "D") echo "selected" ;?>>D</option>
                                            <option value="I" <?php if($value[1] == "I") echo "selected" ;?>>I</option>
                                            <option value="S" <?php if($value[1] == "S") echo "selected" ;?>>S</option>
                                            <option value="C" <?php if($value[1] == "C") echo "selected" ;?>>C</option>
                                            <option value="*" <?php if($value[1] == "*") echo "selected" ;?>>*</option>
                                        </select>
                                    </td>
                                    <td><input class="form-control" type="text" value="<?=$value[2]?>" placeholder="<?php echo $this->lang->line('statement');?>" name="statement_<?=$key+1 ?>" required autofocus></td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tr>
                        </table>
                        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
                    </div>
                </div>
            </div>
        </form>
    </div> 
</div>