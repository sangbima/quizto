<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th><?php echo $this->lang->line('_d');?></th>
                    <th><?php echo $this->lang->line('value_d');?></th>
                    <th><?php echo $this->lang->line('_i');?></th>
                    <th><?php echo $this->lang->line('value_i');?></th>
                    <th><?php echo $this->lang->line('_s');?></th>
                    <th><?php echo $this->lang->line('value_s');?></th>
                    <th><?php echo $this->lang->line('_c');?></th>
                    <th><?php echo $this->lang->line('value_c');?></th>
                </tr>
                <?php 
                    if(count($result)==0){
                ?>
                <tr>
                    <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
                </tr>   
                <?php
                    }
                    foreach($result as $key => $val){
                ?>
                <tr>
                    <td><?php echo $val['least_d'];?></td>
                    <td><?php echo $val['value_d'];?></td>
                    <td><?php echo $val['least_i'];?></td>
                    <td><?php echo $val['value_i'];?></td>
                    <td><?php echo $val['least_s'];?></td>
                    <td><?php echo $val['value_s'];?></td>
                    <td><?php echo $val['least_c'];?></td>
                    <td><?php echo $val['value_c'];?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>      