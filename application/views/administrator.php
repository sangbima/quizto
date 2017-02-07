<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
        <div class="col-lg-6">
            <form method="post" action="<?php echo site_url('user/administrator/');?>">
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
                    </td>
                </tr>

                <?php 
                    }
                ?>
            </table>
        </div>

    </div>


    <?php
    if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

    <a href="<?php echo site_url('user/administrator/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
    &nbsp;&nbsp;
    <?php
    $next=$limit+($this->config->item('number_of_rows'));  ?>

    <a href="<?php echo site_url('user/administrator/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>
</div>