<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
        <form id="form" name="form" method="post" action="<?php echo site_url('qbank/new_question_6/'.$nop);?>">
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
											<option value="<?php echo $val['cid'];?>"><?php echo $val['category_name'];?></option>
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
                            <tr>
                                <td>
                                    <select name="disc_m_1">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="disc_l_1">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" placeholder="<?php echo $this->lang->line('statement');?>" name="statement_1" required autofocus></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="disc_m_2">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="disc_l_2">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" placeholder="<?php echo $this->lang->line('statement');?>" name="statement_2" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="disc_m_3">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="disc_l_3">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" placeholder="<?php echo $this->lang->line('statement');?>" name="statement_3" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="disc_m_4">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="disc_l_4">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" placeholder="<?php echo $this->lang->line('statement');?>" name="statement_4" required></td>
                            </tr>
                        </table>
                        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
                    </div>
                </div>
            </div>
        </form>
    </div> 
</div>