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
				     Hasil Test <a href="<?php echo site_url('hasil/export_hasil/'. $limit);?>" title="Export ke Excel" class="btn btn-default pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a><br><br>					 					 
				</div>	
                <div class="panel-body">  						
                     <table class="table table-condensed table-hover table-bordered" id="table-hasil">
                           <thead>
                                <tr>
                                   <th>ID</th>
                                   <th>Fullname</th>
                                   <th>WA</th>
                                   <th>SE</th>
                                   <th>AN</th>
                                   <th>GE</th>
                                   <th>RA</th>
                                   <th>ZR</th>
                                   <th>FA</th>
                                   <th>WU</th>
                                   <th>ME</th>
                                   <th>TOTAL</th>
                                   <th>DETAIL</th>
                                </tr>
                            </thead>
                            <?php 
                                if(count($result)==0){
                            ?>
                                <tr>
                                     <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
                                </tr>															
                            <?php
								} 							
							     foreach ($result as $key => $value) { ?>
                                <tr>
                                   <td><?php echo $value['uid'] ?></td>
                                   <td><?php echo $value['fullname']; ?></td>
                                   <td><?php echo $value['ist1'] ? $value['ist1'] : 0; ?></td>
                                   <td><?php echo $value['ist2'] ? $value['ist2'] : 0; ?></td>
                                   <td><?php echo $value['ist3'] ? $value['ist3'] : 0; ?></td>
                                   <td><?php echo $value['ist4'] ? $value['ist4'] : 0; ?></td>
                                   <td><?php echo $value['ist5'] ? $value['ist5'] : 0; ?></td>
                                   <td><?php echo $value['ist6'] ? $value['ist6'] : 0; ?></td>
                                   <td><?php echo $value['ist7'] ? $value['ist7'] : 0; ?></td>
                                   <td><?php echo $value['ist8'] ? $value['ist8'] : 0; ?></td>
                                   <td><?php echo $value['ist9'] ? $value['ist9'] : 0; ?></td>
                                   <td><?php echo $value['total']; ?></td>
                                   <td><a href="<?php echo site_url('hasil/detailist/'.$value['uid']);?>"><i class="fa fa-eye"></i></a></td>
                                 </tr>
                            <?php } ?>
                      </table>
                      <?php
                           if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>
                           <a href="<?php echo site_url('hasil/ist/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
                           &nbsp;&nbsp;
                           <?php
                            $next=$limit+($this->config->item('number_of_rows'));  ?>
                           <a href="<?php echo site_url('hasil/ist/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>					  						   						   
                </div>
				
            </div>				
            <?php 
                }											
            ?>
        </div>
    </div>


	
	
	
</div>