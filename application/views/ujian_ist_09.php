<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
       
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
                        <button type="button" class="btn btn-success" id="click-me" data-toggle="modal">START</button>
                    </div>
                </div>
            </div>

    </div>
</div>

<div  id="warning_div" style="padding:10px; position:fixed;z-index:100;display:none;width:100%;border-radius:5px;height:200px; border:1px solid #dddddd;left:4px;top:70px;background:#ffffff;">
    <center><b> <?php echo $this->lang->line('to_which_position');?></b><br><input type="text" style="width:30px" id="qposition" value=""><br><br>
    <a href="javascript:cancelmove();"   class="btn btn-danger"  style="cursor:pointer;">Cancel</a> &nbsp; &nbsp; &nbsp; &nbsp;
    <a href="javascript:movequestion();"   class="btn btn-info"  style="cursor:pointer;">Move</a>
    </center>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-me" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="vertical-alignment-helper">
      <div class="modal-dialog vertical-align-center" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="text-me" id="div1">
              <p><span class="title">BUNGA</span>: Soka -- Larat -- Flamboyan -- Yasmin -- Dahlia</p>
            </div>
            <div class="text-me" id="div2">
              <p><span class="title">PERKAKAS</span>: Wajan -- Jarum -- Kikir -- Cangkul -- Palu</p>
            </div>
            <div class="text-me" id="div3">
              <p><span class="title">BURUNG</span>: Itik -- Elang -- Walet -- Tekukur -- Nuri</p>
            </div>
            <div class="text-me" id="div4">
              <p><span class="title">KESENIAN</span>: Quintet -- Arca -- Opera -- Gamelan -- Ukiran</p>
            </div>
            <div class="text-me" id="div5">
              <p><span class="title">BINATANG</span>: Musang -- Rusa -- Beruang -- Zebra -- Harimau</p>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url('js/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/bootstrap.min.js');?>"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 --><script type="text/javascript">
  $(document).ready(function() {
    $('#click-me').click(function(){
      $('#modal-me').modal('show');

      var $divs = $("div.text-me").hide(),
      current = 0;
      var url = '<?php echo site_url('/ujian/validate_ujian_me/'.$quiz['quid']);?>';

      $divs.eq(0).show();

      function sendData() {
        $.post(url);
      }

      function showNext() {
        if (current < $divs.length - 1) {
          $divs.eq(current).delay(36000).fadeOut('fast', function() {
            current++;
            $divs.eq(current).fadeIn('fast');
            showNext();
          });
        } else {
          setInterval(function(){
            $(location).attr('href',url);
          }, 36000);
        }
      }
      showNext();
    });
  });
</script>