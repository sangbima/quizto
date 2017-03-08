<div class="container">
    <h3><?php echo $title;?></h3>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user"></i> Informasi Umum</h3>
                    </div>
                      <table class="table table-bordered table-condensed">
                            <tr>
                                <th>Nama </th>
								<td><?php echo $caper['first_name'] . " " . $caper['last_name'] ;?></td>
                            </tr>            
                            <tr>							
                                <th>Tempat Lahir</th>
                                <td><?php echo $caper['tempat_lahir'] ;?></td>
                            </tr>
                            <tr>							
                                <th>Tanggal Lahir</th>
                                <td><?php echo $caper['tanggal_lahir'] ;?></td>
                            </tr>							
                            <tr>
								<th>Email Address</th>
								<td><?php echo $caper['tempat_lahir'] ;?></td>
                             </tr>
							 <tr>
								<th>No Telepon</th>
                                <td><?php echo $caper['contact_no'] ;?></td>
							</tr>	
                       </table>                                 
                </div>
            </div>
                <div>
				   <a href="<?php echo site_url('calonpeserta/download/zip/detail/'. $caper['registration_no']);?>" title="Export ke ZIP" class="btn btn-default pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
				</div>			
		</div>	
        <div class="row">			
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user"></i> Pekerjaan Terakhir</h3>
                    </div>
                      <table class="table table-bordered table-condensed">
                            <tr>
                                <th>Nama Instansi</th>
								<td><?php echo $caper['instansi_name'];?></td>
                            </tr>            
                            <tr>							
                                <th>Bagian</th>
                                <td><?php echo $caper['bagian'] ;?></td>
                            </tr>
                            <tr>							
                                <th>Alamat Instansi</th>
                                <td><?php echo $caper['alamat_instansi'] ;?></td>
                            </tr>							
                            <tr>
								<th>Jabatan</th>
								<td><?php echo $caper['jabatan'] ;?></td>
                             </tr>
							 <tr>
								<th>Masa Kerja</th>
                                <td><?php echo $caper['thn_mengabdi'] ;?></td>
							  </tr>	
							  <tr>
								<th>Deskripsi Pekerjaan</th>
                                <td><?php echo $caper['jobdesk'] ;?></td>
							  </tr>	
                       </table>                                 																				
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user"></i> Informasi Pendidikan</h3>
                    </div>
					<table class="table table-bordered table-condensed">
                            <tr>
                                <th>Tingkat Pendidikan</th>
                                 <td>
                                    <?php
                                        $pddk = array(                                            
                                            'SD' => 'Sekolah Dasar',
                                            'SMP' => 'Sekolah Menengah Pertama',
                                            'SMA' => 'Sekolah Menengah Atas',
                                            'DIPLOMA' => 'Diploma',
                                            'S1' => 'Sarjana',
                                            'S2' => 'Megister');
                                      echo $caper['pendidikan'] . "(" . $pddk[$caper['pendidikan']] . ")";
                                    ?>								 
								 </td>
                            </tr>
                            <tr>                                							
                                 <th>Institusi Pendidikan</th>                                    
                                 <td><?php echo $caper['institusi_pendidikan'] ;?></td>
                            </tr>
                            <tr>
								 <th>Fakultas/Jurusan</th>
                                 <td><?php echo $caper['fakultas'] ;?></td>
                            </tr>
                            <tr>
                                 <th>No. Ijazah</th>
                                 <td><?php echo $caper['no_ijazah'] ;?></td>
                            </tr>
                            <tr>
                                 <th>Nilai IPK</th>
                                 <td><?php echo $caper['nilai_ipk'] ;?></td>
                            </tr>
					</table>	
				</div>
            </div>
        </div>
		
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-user"></i> Lampiran Dokumen</h3>
                    </div>
                    <div class="panel-body">		
					
                   <?php 
				        $lname=array('Foto','Ijazah','Transkrip Nilai','KTP','SKCK','SKBN','SKS');
				        for ($xi=0;$xi<7;++$xi) 
				           {
					         $lid='lampiran' . $xi;    
                             $imgfull="calonpeserta/download/full/" .
                                     str_replace(' ','_',strtolower($lname[$xi])) . "/" .							 
									 $caper['registration_no'];					
                             $imgthumb="calonpeserta/download/thumb/" .
                                     str_replace(' ','_',strtolower($lname[$xi])) . "/" .
									 $caper['registration_no'] ;							 		 
				   ?>		  <div class="panel col-md-2">	
									 <div class="panel-body">									     
                                        <a href="<?php echo site_url($imgfull) ;?>">
                                         <img src="<?php echo site_url($imgthumb) ;?>"><br>
										   <?php echo $lname[$xi];?>
										</a>   
                                     </div>									  
							  </div>		     							           
						   <?php }?>	
                       										
                    </div>
                </div>
            </div>
        </div>						       
</div>

<div id="spinner"></div>

