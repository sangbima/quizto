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
        window.location="<?php echo site_url('ujian/submit_quiz_tpu/');?>";
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
            <form method="post" action="<?php echo site_url('ujian/submit_quiz_tpu()/'.$quiz['rid']);?>" id="form" name="form">
                <input type="hidden" name="rid" value="<?php echo $quiz['rid'];?>">
                <input type="hidden" name="noq" value="<?php echo $quiz['noq'];?>">
                <input type="hidden" name="individual_time"  id="individual_time" value="<?php echo $quiz['individual_time'];?>">
                 
                <?php 
                $abc=array(
                    '0'=>'A',
                    '1'=>'B',
                    '2'=>'C',
                    '3'=>'D',
                    '4'=>'E',
                    '6'=>'F',
                    '7'=>'G',
                    '8'=>'H',
                    '9'=>'I',
                    '10'=>'J',
                    '11'=>'K'
                );
                foreach($questions as $qk => $question){
                ?>
                    <div id="q<?php echo $qk;?>" class="question_div">
                        <div class="question_container" >
                             <?php echo $this->lang->line('question');?> <?php echo $qk+1;?>)<br>
                             <?php echo $question['question'];?>
                        </div><!-- end question_container -->
                        <div class="option_container" >
                            <?php 
                            // multiple single choice
                            if($question['question_type']==$this->lang->line('multiple_choice_single_answer')){
                                $save_ans=array();
                                foreach($saved_answers as $svk => $saved_answer){
                                    if($question['qid']==$saved_answer['qid']){
                                        $save_ans[]=$saved_answer['q_option'];
                                    }
                                }
                            ?>
                                <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="1">
                            <ol type="A" class="option_answers">
                            <?php
                                $i=0;
                                foreach($options as $ok => $option){
                                    if($option['qid']==$question['qid']){
                            ?>
                                 <li><div class="radio">
                                    <input type="radio" name="answer[<?php echo $qk;?>][]"  id="answer_value<?php echo $qk.'-'.$i;?>" value="<?php echo $option['oid'];?>"   <?php if(in_array($option['oid'],$save_ans)){ echo 'checked'; } ?>>
                                    <label for="answer_value<?php echo $qk.'-'.$i;?>"><?php echo strip_tags($option['q_option'], '<img>');?></label>
                                    </div>
                                 </li>
                            <?php 
                                        $i+=1;
                                    }else{
                                        $i=0;   
                                    }
                                }
                            }
                            ?>
                            </ol>
                            <!-- End multiple single choice -->
                            
                            <?php
                            // multiple_choice_multiple_answer
                            if($question['question_type']==$this->lang->line('multiple_choice_multiple_answer')){
                                $save_ans=array();
                                foreach($saved_answers as $svk => $saved_answer){
                                    if($question['qid']==$saved_answer['qid']){
                                        $save_ans[]=$saved_answer['q_option'];
                                    }
                                }
                            ?>
                                <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="2">
                                <ul class="option_answers_multi">
                            <?php
                                $i=0;
                                foreach($options as $ok => $option){
                                    if($option['qid']==$question['qid']){
                            ?>
                                <li>
                                    <div class="checkbox">
                                        <input type="checkbox" name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk.'-'.$i;?>"   value="<?php echo $option['oid'];?>"  <?php if(in_array($option['oid'],$save_ans)){ echo 'checked'; } ?> >
                                        <label for="answer_value<?php echo $qk.'-'.$i;?>"><?php echo strip_tags($option['q_option'], '<img>');?></label>
                                    </div>
                                </li>
                            <?php 
                                        $i+=1;
                                    }else{
                                        $i=0;
                                    }
                                }
                            }
                            ?>
                            </ul>
                            <!-- End multiple_choice_multiple_answer-->

                            <?php
                            // short answer 
                            if($question['question_type']==$this->lang->line('short_answer')){
                                $save_ans="";
                                foreach($saved_answers as $svk => $saved_answer){
                                    if($question['qid']==$saved_answer['qid']){
                                        $save_ans=$saved_answer['q_option'];
                                    }
                                }
                            ?>
                                <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="3" >
                                <div class="op"> 
                                <?php echo $this->lang->line('answer');?> 
                                <input type="text" name="answer[<?php echo $qk;?>][]" value="<?php echo $save_ans;?>" id="answer_value<?php echo $qk;?>"   >  
                                </div>
                            <?php
                            }
                            // End short answer
                            ?>
                            
                            <!-- Start DISC questions -->
                            <?php 
                            if($question['question_type']==$this->lang->line('disc_question')){
                                $save_ans=array();
                                foreach($saved_answers as $svk => $saved_answer){
                                    if($question['qid']==$saved_answer['qid']){
                                        $save_ans[]=$saved_answer['q_option'];
                                    }
                                }
                            ?>
                                <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="6">
                            
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
                                    $i=0;
                                    foreach($options as $ok => $option){
                                        if($option['qid']==$question['qid']){
                                            $opt = strip_tags($option['q_option'], '<img>');
                                            $exp_opt = explode('||', $opt);
                                ?>
                                <script type="text/javascript">
                                    function TestCheckMarkQ(rownum, colnum)
                                    {
                                        if (colnum == 0) document.form.answer['least']
                                            [rownum].checked = false;
                                        else  document.form.answer['most']
                                            [rownum].checked = false;
                                    }
                                </script>
                                <tr>
                                    <td>
                                        <div class="radio">
                                            <input type="radio" name="answer['most'][<?php echo $qk;?>][]" value="<?php echo $exp_opt[0] ?>" onclick="TestCheckMarkQ(<?php echo $i?>, 0)" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio">
                                            <input type="radio" name="answer['least'][<?php echo $qk;?>][]" value="<?php echo $exp_opt[1] ?>" onclick="TestCheckMarkQ(<?php echo $i?>, 1)" />
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $exp_opt[2];?>
                                    </td>
                                </tr>
                                    <script  type="text/javascript">
                                        var frmvalidator = new Validator("form");
                                        frmvalidator.addValidation("answer['most']","selone");
                                        frmvalidator.addValidation("answer['least']","selone");
                                    </script>
                                <?php 
                                        $i+=1;
                                    }else{
                                        $i=0;   
                                    }
                                }
                            }
                            ?>
                            </table>
                            <!-- End DISC questions -->
                            
                            <?php
                            // long answer  
                            if($question['question_type']==$this->lang->line('long_answer')){
                                $save_ans="";
                                foreach($saved_answers as $svk => $saved_answer){
                                    if($question['qid']==$saved_answer['qid']){
                                        $save_ans=$saved_answer['q_option'];
                                    }
                                }
                                ?>
                                <input type="hidden"  name="question_type[]" id="q_type<?php echo $qk;?>" value="4">
                                <div class="op"> 
                                <?php echo $this->lang->line('answer');?> <br>
                                <?php echo $this->lang->line('word_counts');?> <span id="char_count<?php echo $qk;?>">0</span>
                                <textarea name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk;?>" style="width:100%;height:100%;" onKeyup="count_char(this.value,'char_count<?php echo $qk;?>');"><?php echo $save_ans;?></textarea>
                                </div>
                            <?php
                            }
                            // End long answer       
                            
                            // matching 
                            if($question['question_type']==$this->lang->line('match_the_column')){
                                $save_ans=array();
                                foreach($saved_answers as $svk => $saved_answer){
                                    if($question['qid']==$saved_answer['qid']){
                                        // $exp_match=explode('__',$saved_answer['q_option_match']);
                                        $save_ans[]=$saved_answer['q_option'];
                                    }
                                }
                            ?>
                                    <input type="hidden" name="question_type[]" id="q_type<?php echo $qk;?>" value="5">
                            <?php
                                    $i=0;
                                    $match_1=array();
                                    $match_2=array();
                                    foreach($options as $ok => $option){
                                        if($option['qid']==$question['qid']){
                                            $match_1[]=$option['q_option'];
                                            $match_2[]=$option['q_option_match'];
                                            $i+=1;
                                        }else{
                                            $i=0;
                                        }
                                    }
                            ?>
                                    <div class="op">
                                        <table>
                            <?php 
                                        shuffle($match_1);
                                        shuffle($match_2);
                                        foreach($match_1 as $mk1 =>$mval){
                            ?>
                                            <tr>
                                                <td><?php echo $abc[$mk1];?>)  <?php echo $mval;?></td>
                                                <td>
                                                    <select class="form-control" name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk.'-'.$mk1;?>"  >
                                                    <option value="0"><?php echo $this->lang->line('select');?></option>
                            <?php 
                                                    foreach($match_2 as $mk2 =>$mval2){
                                                        ?>
                                                        <option value="<?php echo $mval.'___'.$mval2;?>"  <?php $m1=$mval.'___'.$mval2; if(in_array($m1,$save_ans)){ echo 'selected'; } ?> ><?php echo $mval2;?></option>
                                                        <?php 
                                                    }
                            ?>
                                                    </select>
                                                </td>
                                            </tr>
                            <?php 
                                        }
                            ?>
                                    </table>
                                    </div><!-- End op -->
                            <?php
                            }
                            // End matching
                            ?>
                        </div> <!-- End option_container -->
                 </div>
                <?php
                }
                ?>
            </form>
        </div><!-- End col-md-8 -->
        <?php if($this->config->item('show_timelapse_right')==true) {?>
        <div class="col-md-2" style="padding-bottom:80px;">
            <div class="text-center" style="font-size: 40px; font-weight: bold;">

                Time left: <br>
                <center><span id="timer" style="color: red;"><script type="text/javascript">window.onload = CreateTimer("timer", <?php echo $seconds;?>);</script></span></center>

            </div>
        </div><!-- End col-md-2 -->
        <?php } else { ?>
        <div class="col-md-2" style="padding-bottom:80px;">
            <b><?php echo $this->lang->line('questions');?></b>
            <div>
                <?php 
                for($j=0; $j < $quiz['noq']; $j++ ){
                ?>
                    <div class="qbtn" onClick="javascript:show_question('<?php echo $j;?>');" id="qbtn<?php echo $j;?>" ><?php echo ($j+1);?></div>
                <?php 
                }
                ?>
                <div style="clear:both;"></div>
            </div>
            <br>
            <hr>
            <br>
            <div>
                <table>
                    <tr><td style="font-size:12px;"><div class="qbtn" style="background:#449d44;">&nbsp;</div><span class="labelqbtn"><?php echo $this->lang->line('Answered');?></span></td></tr>
                    <tr><td style="font-size:12px;"><div class="qbtn" style="background:#c9302c;">&nbsp;</div><span class="labelqbtn"><?php echo $this->lang->line('UnAnswered');?></span></td></tr>
                    <tr><td style="font-size:12px;"><div class="qbtn" style="background:#ec971f;">&nbsp;</div><span class="labelqbtn"><?php echo $this->lang->line('Review-Later');?></span></td></tr>
                    <tr><td style="font-size:12px;"><div class="qbtn" style="background:#212121;">&nbsp;</div><span class="labelqbtn"><?php echo $this->lang->line('Not-visited');?></span></td></tr>
                </table>
                <div style="clear:both;"></div>
            </div>
        </div><!-- End col-md-4 -->
        <?php } ?>
    </div><!-- End row -->
</div>

<div class="footer_buttons">
    <?php if($this->config->item('show_btn_back_prev')==true) { ?>
    <button class="btn btn-warning"   onClick="javascript:review_later();" style="margin-top:2px;" ><?php echo $this->lang->line('review_later');?></button>
    <?php } ?>
    <?php if($this->config->item('show_btn_clear')==true) { ?>
    <button class="btn btn-info"  onClick="javascript:clear_response();"  style="margin-top:2px;"  ><?php echo $this->lang->line('clear');?></button>
    <?php } ?>
    <?php if($this->config->item('show_btn_back_prev')==true) { ?>
    <button class="btn btn-success"  id="backbtn" style="visibility:hidden;" onClick="javascript:show_back_question();"  style="margin-top:2px;" ><?php echo $this->lang->line('back');?></button>
    <?php } ?>
    <button class="btn btn-success" id="nextbtn" onClick="javascript:show_next_question();" style="margin-top:2px;" ><?php echo $this->lang->line('save_next');?></button>
    
    <button id="submitbtnsave" class="btn btn-danger is-hide"  onClick="javascript:submit_ujian_tpu();" style="margin-top:2px;" ><?php echo $this->lang->line('next_quiz');?></button>
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
        <a href="javascript:submit_ujian_tpu();"   class="btn btn-info"  style="cursor:pointer;"><?php echo $this->lang->line('submit_quiz');?></a>
    </center>
</div>
<script src="<?php echo base_url('js/jquery.js');?>"></script>