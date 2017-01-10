<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
        <form method="post" id="quiz_detail" action="<?php echo site_url('/ujian/validate_ujian_wa/'.$quiz['quid']);?>">
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
                        <table class="table table-bordered">
                            <tr>
                                <td><?php echo $this->lang->line('quiz_name');?></td>
                                <td><?php echo $quiz['quiz_name'];?></td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <?php echo $this->lang->line('description');?><br>
                                    <?php echo $quiz['description'];?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('start_date');?></td>
                                <td><?php echo date('d-m-Y H:i:s',$quiz['start_date']);?></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('end_date');?></td>
                                <td><?php echo date('d-m-Y H:i:s',$quiz['end_date']);?></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('duration');?></td>
                                <td><?php echo $quiz['duration'];?></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('maximum_attempts');?></td>
                                <td><?php echo $quiz['maximum_attempts'];?></td>
                            </tr>
                            <?php if($this->config->item('pass_percentage')==true) {?>
                            <tr>
                                <td><?php echo $this->lang->line('pass_percentage');?></td>
                                <td><?php echo $quiz['pass_percentage'];?></td>
                            </tr>
                            <?php } ?>
                        </table>
                        <button class="btn btn-success" type="submit">START</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div  id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:100%;border-radius:5px;height:200px; border:1px solid #dddddd;left:4px;top:70px;background:#ffffff;">
    <center><b> <?php echo $this->lang->line('to_which_position');?></b><br><input type="text" style="width:30px" id="qposition" value=""><br><br>
    <a href="javascript:cancelmove();"   class="btn btn-danger"  style="cursor:pointer;">Cancel</a> &nbsp; &nbsp; &nbsp; &nbsp;
    <a href="javascript:movequestion();"   class="btn btn-info"  style="cursor:pointer;">Move</a>
    </center>
</div>