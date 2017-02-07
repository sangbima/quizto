<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
        <div class="col-lg-6">
            <form method="post" action="<?php echo site_url('user/index/');?>">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
                    </span>
                </div><!-- /input-group -->
            </form>
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-md-12">
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

            <table class="table table-bordered">
                <tr>
                    <th><?php echo $this->lang->line('email');?></th>
                    <th><?php echo $this->lang->line('registration_no');?></th>
                    <th><?php echo $this->lang->line('full_name');?></th>
                    <th><?php echo $this->lang->line('action');?> </th>
                    <!-- <th><?php //echo $this->lang->line('reset');?></th> -->
                </tr>
                <?php 
                    if(count($result)==0){
                ?>
                <tr>
                    <td colspan="4"><?php echo $this->lang->line('no_record_found');?></td>
                </tr>	


                <?php
                    }
                    foreach($result as $key => $val){
                ?>
                <tr>
                    <td><?php echo $val['email'];?></td>
                    <td><?php echo $val['registration_no'];?></td>
                    <td><?php echo $val['first_name'];?> <?php echo $val['last_name'];?></td>
                    <td>
                        <a class="btn btn-primary" href="<?php echo site_url('user/edit_user/'.$val['uid']);?>"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger" href="javascript:remove_entry('user/remove_user/<?php echo $val['uid'];?>');"><i class="fa fa-trash"></i></a>
                        <a class="btn btn-info" href="javascript:reset_entry('user/reset/<?php echo $val['uid'];?>');"><i class="fa fa-refresh"></i></a>
                    </td>
                    <!-- <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><i class="fa fa-refresh"></i> <span class="caret"></span></button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:reset_entry('user/reset/<?php //echo $val['uid'];?>');">ALL</a></li>
                            <?php //foreach($quiz as $k => $v) {?>
                            <li><a href="javascript:reset_entry('user/reset_quiz/<?php //echo $v['quid']?>/<?php //echo $val['uid'];?>');"><?php //echo $v['quiz_name']?></a></li>
                            <?php //}?>
                          </ul>
                        </div>
                    </td> -->
                </tr>

                <?php 
                    }
                ?>
            </table>
        </div>

    </div>


    <?php
    if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

    <a href="<?php echo site_url('user/index/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
    &nbsp;&nbsp;
    <?php
    $next=$limit+($this->config->item('number_of_rows'));  ?>

    <a href="<?php echo site_url('user/index/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>

    <br><br><br><br>
    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open('user/import',array('enctype'=>'multipart/form-data')); ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4><?php echo $this->lang->line('import_user');?></h4>
                    </div>
                </div>              
				
                <div class="row">
					<div class="col-md-6">
						<select name="gid" class="selecter_4">
							<option value=""><?php echo $this->lang->line('select_group');?></option>
                            <?php 
								foreach($group_list as $key => $val){
							?>
									<option value="<?php echo $val['gid'];?>"><?php echo $val['group_name'];?></option>
							<?php 
								}
							?>
						</select>
					</div>
				</div>				
                <div class="row">
                    <div class="col-md-2">
                        <input type="hidden" name="size" value="3500000">
                        <input type="file" name="xlsfile">
                    </div>
                    <div class="col-md-10">
                        <?php echo $this->lang->line('upload_excel');?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div style="clear:both;"></div>
                        <input type="submit" value="Import" style="margin-top:5px;" class="btn btn-default">
                        <a href="<?php echo base_url();?>sample/sample_users.xls" target="new">Click here</a> <?php echo $this->lang->line('upload_excel_info');?> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>