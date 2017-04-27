<div class="container">
     <div class="row">
        <div class="col-lg-12">
            <?php 
                $logged_in=$this->session->userdata('logged_in');
            ?>
            <?php 
                if($logged_in['su']=='1' || $logged_in['su']=='2'){
                  if($logged_in['su']=='1') {
            ?>
			
           <!-- Filter -->
            <div class="panel-group panel-group-lists" id="accordion2">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
                      Filter
                    </a>
                  </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                  <div class="panel-body">
                    <form class="form-inline" method="post" action="<?php echo site_url('hasil/ist/');?>">
                      <div class="form-group">
                        <label class="sr-only" for="operatorid">Operator</label>
                        <select name="operator" id="operatorid" class="form-control">
                            <option value="">-- Pilih Operator --</option>
                            <?php foreach($operators as $operator) {?>
                            <option value="<?php echo $operator['uid']?>"><?php echo $operator['first_name'] . ' ' .$operator['last_name']?></option>
                            <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="sr-only" for="groupid">Group</label>
                        <select name="group" id="groupid" class="form-control">
                            <option value="">-- Pilih Group --</option>
                            <?php foreach($groups as $group) {?>
                            <option value="<?php echo $group['gid']?>"><?php echo $group['group_name']?></option>
                            <?php } ?>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-default"><?php echo $this->lang->line('search');?></button>
                    </form>           
                  </div>
                </div>
              </div>
            </div>			
			       <!-- Filter -->
			       <?php } ?>
            <div class="panel panel-primary">
			    <div class="panel-heading">
				    Hasil Test IST
            <div class="btn-group pull-right">
                <button id="w6" class="btn btn-default dropdown-toggle" title="Export data in Excel" data-toggle="dropdown" aria-expanded="false"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span></button>
                <ul id="w7" class="dropdown-menu">
                    <li title="Export All Data To Excel"><a id="all-excell" class="export-full-html" href="<?php echo site_url('hasil/download/ist/'. $limit . '/1/'  . $search['gid'].'/' . $search['created_by']);?>" tabindex="-1"><i class="fa fa-file-excel-o"></i> Export All</a></li>
                    <li title="Export Per Page To Excel"><a id="page-excell" class="export-full-html" href="<?php echo site_url('hasil/download/ist/'. $limit . '/0/' . $search['gid'].'/' . $search['created_by']);?>" tabindex="-1"><i class="fa fa-file-excel-o"></i> Export Per Page</a></li>
                </ul>
            </div>
				</div>	                  					
                     <table class="table table-condensed table-hover" id="table-hasil">
                           <thead>
                                <tr>
                                   <th>#</th>
                                   <th>Fullname</th>
                                   <th>SE</th>
                                   <th>WA</th>
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
								 $mkey=$limit; 
							     foreach ($result as $key => $value) { ?>
                                <tr>
                                   <td><?php echo $mkey+1; ?></td>
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
                                   <td>
                                      <?php 
                                        $total = $value['ist1']+$value['ist2']+$value['ist3']+$value['ist4']+$value['ist5']+$value['ist6']+$value['ist7']+$value['ist8']+$value['ist9']; 
                                        echo $total;
                                      ?>
                                    </td>
                                   <td><a href="<?php echo site_url('hasil/detailist/'.$value['uid']);?>"><i class="fa fa-eye"></i></a></td>
                                 </tr>
                            <?php ++$mkey;} ?>
                      </table>					  						   						                				
            </div>				
            <?php 
                }											
            ?>
                      <?php
                           if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>
                           <a href="<?php echo site_url('hasil/ist/'.$back .'/' . $search['gid'].'/' . $search['created_by']);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
                           &nbsp;&nbsp;
                           <?php
                            $next=$limit+($this->config->item('number_of_rows'));  ?>
                           <a href="<?php echo site_url('hasil/ist/'.$next .'/' . $search['gid'].'/' . $search['created_by']);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>			
        </div>		
    </div>		
</div>