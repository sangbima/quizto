<div class="container">
     <div class="row">
        <div class="col-lg-12">
            <?php 
                $logged_in=$this->session->userdata('logged_in');
            ?>
            <?php 
                if($logged_in['su']=='1'){
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
				   Hasil Test DISC
                    <div class="btn-group pull-right">
                        <button id="w6" class="btn btn-default dropdown-toggle" title="Export data in Excel" data-toggle="dropdown" aria-expanded="false"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span></button>
                        <ul id="w7" class="dropdown-menu">
                            <li title="Export All Data To Excel"><a id="all-excell" class="export-full-html" href="<?php echo site_url('hasil/download/disc/'. $limit . '/1');?>" tabindex="-1"><i class="fa fa-file-excel-o"></i> Export All</a></li>
                            <li title="Export Per Page To Excel"><a id="page-excell" class="export-full-html" href="<?php echo site_url('hasil/download/disc/'. $limit . '/0');?>" tabindex="-1"><i class="fa fa-file-excel-o"></i> Export Per Page</a></li>
                        </ul>
                    </div>
				</div>
                <table class="table table-condensed table-hover" id="table-hasil">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fullname</th>
                        <th>MOST</th>
                        <th>LEAST</th>
                        <th>CHANGE</th>
                        <th>DETAIL</th>
                    </tr>
                </thead>
                <?php 
				$mkey=$limit;
				foreach ($result as $key => $value) { 				
				?>
                <tr>
                    <td><?php echo $mkey+1 ;?></td>
                    <td><?php echo $value['fullname']; ?></td>
                    <td><?php echo $value['mscale']['value']; ?></td>
                    <td><?php echo $value['lscale']['value']; ?></td>
                    <td><?php echo $value['cscale']['value']; ?></td>
                    <td><a href="<?php echo site_url('hasil/detaildisc/'.$value['uid']);?>"><i class="fa fa-eye"></i></a></td>
                </tr>
                <?php ++$mkey;} ?>
            </table>
            </div>
            <?php 
                }
            ?>
			
    <?php
    if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

    <a href="<?php echo site_url('hasil/disc/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
    &nbsp;&nbsp;
    <?php
    $next=$limit+($this->config->item('number_of_rows'));  ?>

    <a href="<?php echo site_url('hasil/disc/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>				
        </div>
    </div>
</div>