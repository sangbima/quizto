<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
        <form method="post" id="quiz_detail" action="<?php echo site_url('quiz/validate_quiz/'.$quiz['quid']);?>">
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
                        <?php 
                        if($quiz['camera_req']==1 && $this->config->item('webcam')==true){
                        ?>
                            <div style="color:#ff0000;"><?php echo $this->lang->line('camera_instructions');?></div>
                            <div id="my_photo" style="width:500px;height:500px;background:#212121;padding:2px;border:1px solid #666666;color:red"></div>
                            <br><br>
                            <script type="text/javascript" src="<?php echo base_url();?>js/webcamjs/webcam.js"></script>
                            <script language="JavaScript">
                                Webcam.set({
                                	width: 500,
                                	height: 500,
                                	image_format: 'jpeg',
                                	jpeg_quality: 90
                                });
                                Webcam.attach( '#my_photo' );
                                function take_snapshot() {
                                    Webcam.snap( function(data_uri) {
                                        document.getElementById('my_photo').innerHTML = '<img src="'+data_uri+'"/>';
                                    } );
                                }
                                function upload_photo(){
                                    Webcam.snap( function(data_uri) {
                                        Webcam.upload( data_uri, '<?php echo site_url('quiz/upload_photo');?>',function(code, text) {
                                            // Upload complete!
                                            // 'code' will be the HTTP response code from the server, e.g. 200
                                            // 'text' will be the raw response content
                                            document.getElementById('quiz_detail').submit();
                                        });
                                    });
                                }
                                function capturephoto(){
                                    void(take_snapshot());upload_photo(); 
                                }
                            </script>
                            <button class="btn btn-success" type="button" onClick="javascript:capturephoto();"><?php echo $this->lang->line('capture_start_quiz');?></button>
                        <?php 
                        }else{
                        ?>	
                            <button class="btn btn-success" type="submit"><?php echo $this->lang->line('start_quiz');?></button>
                        <?php 
                        }
                        ?>
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