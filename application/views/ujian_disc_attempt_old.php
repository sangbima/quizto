<script src="<?php echo base_url('js/gen_validatorv4.js');?>"></script>
<script>
    var Timer;
    var TotalSeconds;
    function CreateTimer(TimerID, Time) {
        Timer = document.getElementById(TimerID);
        TotalSeconds = Time;
        UpdateTimer()
        window.setTimeout("Tick()", 1000);
    }

    function Tick() {
        if (TotalSeconds <= 0) {
            alert("Time's up!")
            return;
        }
        TotalSeconds -= 1;
        UpdateTimer()
        window.setTimeout("Tick()", 1000);
    }

    function UpdateTimer() {
        var Seconds = TotalSeconds;
        var Days = Math.floor(Seconds / 86400);
        Seconds -= Days * 86400;
        var Hours = Math.floor(Seconds / 3600);
        Seconds -= Hours * (3600);
        var Minutes = Math.floor(Seconds / 60);
        Seconds -= Minutes * (60);
        var TimeStr = ((Days > 0) ? Days + " days " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds)
        Timer.innerHTML = TimeStr;
    }


    function LeadingZero(Time) {
        return (Time < 10) ? "0" + Time : + Time;
    }

    //var myCountdown1 = new Countdown({time:<?php echo $seconds;?>, rangeHi:"hour", rangeLo:"second"});
    setTimeout(submitform,'<?php echo $seconds * 1000;?>');
    function submitform(){
        alert('Time Over');
        window.location="<?php echo site_url('ujian/submit_quiz_se/');?>";
    }
</script>
<script type="text/javascript">
    function TestCheckMarkQ(rownum, colnum, id)
    {
        if (colnum == 0) {
          document.getElementsByName('least'+id.toString())[rownum].checked = false;
        } else {
          document.getElementsByName('most'+id.toString())[rownum].checked = false;
        }
    }
</script>

<div class="container" >
    <div class="save_answer_signal" id="save_answer_signal2"></div>
    <div class="save_answer_signal" id="save_answer_signal1"></div>
    <?php if($this->config->item('show_timelapse_right')==false) {?>
    <div style="float:right;width:150px; margin-right:10px;" >
        Time left: <span id='timer' >
        <script type="text/javascript">window.onload = CreateTimer("timer", <?php echo $seconds;?>);</script>
        </span>
    </div>
    <?php } ?>
    <div style="float:left;" >
        <h4><?php echo $title;?></h4>
    </div>
    <div style="clear:both;"></div>
    <!-- Category button -->

    <div class="row"  >
        <div class="col-md-12">
            <?php 
            $categories=explode(',',$quiz['categories']);
            $category_range=explode(',',$quiz['category_range']);
             
            function getfirstqn($cat_keys='0',$category_range){
                if($cat_keys==0){
                    return 0;
                }else{
                    $r=0;
                    for($g=0; $g < $cat_keys; $g++){
                        $r+=$category_range[$g];    
                    }
                    return $r;
                }
                
                
            }

            if(count($categories) > 1 ){
                $jct=0;
                foreach($categories as $cat_key => $category){
            ?>
                    <a href="javascript:switch_category('cat_<?php echo $cat_key;?>');"   class="btn btn-info"  style="cursor:pointer;"><?php echo $category;?></a>
                    <input type="hidden" id="cat_<?php echo $cat_key;?>" value="<?php echo getfirstqn($cat_key,$category_range);?>">
            <?php 
                }
            }
            ?>
        </div> <!-- End col-md-12 -->
    </div> <!-- End row -->
    <div class="row"  style="margin-top:5px;">
        <div class="col-md-10">

            <form method="post" action="<?php echo site_url('ujian/submit_quiz_disc()/'.$quiz['rid']);?>" id="form" name="form">
                <input type="hidden" name="rid" value="<?php echo $quiz['rid'];?>">
                <input type="hidden" name="noq" value="<?php echo $quiz['noq'];?>">
                <input type="hidden" name="individual_time"  id="individual_time" value="<?php echo $quiz['individual_time'];?>">
                
                <table class="table table-bordered">
                    <?php
                        $disc=array(
                            'D'=>'1',
                            'I'=>'2',
                            'S'=>'3',
                            'C'=>'4',
                            '*'=>'5',
                        );
                        if(count($question)==0){
                    ?>
                    <tr>
                    <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
                    </tr>
                     <?php
                        }
                        foreach($question as $key => $val){
                    ?>
                    <tr>
                        <td><?=$key+1 ?></td>
                        <td colspan="3">
                            <table class="table table-bordered">
                                <tr>
                                    <th>M</th>
                                    <th>L</th>
                                    <th>
                                        <?php echo $this->lang->line('statement');?>
                                    </th>
                                </tr>
                                <?php 
                                    $no = 1; 
                                    $data = $this->disc_model->disc_list_by_no($val['no_pernyataan']); 
                                    foreach($data as $k => $value){
                                ?>
                                <tr>
                                    <td>
                                        <div class="radio">
                                            <input type="radio" name="most<?php echo $key ?>" value="<?php echo $disc[$value['disc_m']] ?>" onclick="TestCheckMarkQ(<?php echo $k ?>, 0, <?php echo $key ?>)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio">
                                            <input type="radio" name="least<?php echo $key ?>" value="<?php echo $disc[$value['disc_l']] ?>" onclick="TestCheckMarkQ(<?php echo $k ?>, 1, <?php echo $key ?>)">
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $value['statement'] ?>
                                    </td>
                                </tr>
                                <?php } ?> 
                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </form>

        </div><!-- End col-md-8 -->
        <div class="col-md-2" style="padding-bottom:80px;">
            <div class="text-center" style="font-size: 40px; font-weight: bold;">

                Time left: <br>
                <center><span id="timer" style="color: red;"><script type="text/javascript">window.onload = CreateTimer("timer", <?php echo $seconds;?>);</script></span></center>

            </div>
        </div><!-- End col-md-2 -->
    </div><!-- End row -->
</div>

<div class="footer_buttons">
    <button class="btn btn-danger"  onClick="javascript:cancelmove();" style="margin-top:2px;" ><?php echo $this->lang->line('submit_quiz');?></button>
</div>



<script>
    var ctime=0;
    var ind_time=new Array();
    <?php 
    $ind_time=explode(',',$quiz['individual_time']);

    for($ct=0; $ct < $quiz['noq']; $ct++){
    ?>
        ind_time[<?php echo $ct;?>]=<?php echo $ind_time[$ct];?>;
    <?php 
    }
    ?>
    noq="<?php echo $quiz['noq'];?>";
    show_question('0');


    function increasectime(){
        ctime+=1;
    }
    setInterval(increasectime,1000);
    setInterval(setIndividual_time_ist,30000);
</script>

<div  id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:100%;border-radius:5px;height:200px; border:1px solid #dddddd;left:4px;top:70px;background:#ffffff;">
    <center><b> <?php echo $this->lang->line('really_Want_to_submit');?></b> <br><br>
        <span id="processing"></span>
        <a href="javascript:cancelmove();"   class="btn btn-danger"  style="cursor:pointer;"><?php echo $this->lang->line('cancel');?></a> &nbsp; &nbsp; &nbsp; &nbsp;
        <a href="javascript:submit_ujian_disc();"   class="btn btn-info"  style="cursor:pointer;"><?php echo $this->lang->line('submit_quiz');?></a>
    </center>
</div>

<script  type="text/javascript">
    var frmvalidator = new Validator("form");
    <?php foreach ($question as $m => $value) { ?>    
        frmvalidator.addValidation("most<?php echo $m?>","selone");
        frmvalidator.addValidation("least<?php echo $m?>","selone");
    <?php } ?>
</script>

<script src="<?php echo base_url('js/jquery.js');?>"></script>