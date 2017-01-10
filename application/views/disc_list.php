<div class="container">
    <h3><?php echo $title;?></h3>
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
                    <td><?=$key+1 ?></td>
                    <td colspan="3">
                        <table class="table table-bordered">
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
                                $no = 1; 
                                $data = $this->disc_model->disc_list_by_no($val['no_pernyataan']); 
                                foreach($data as $key => $value){
                            ?>
                            <tr>
                                <td><?php echo $value['disc_m'] ?></td>
                                <td><?php echo $value['disc_l'] ?></td>
                                <td><?php echo $value['statement'] ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>