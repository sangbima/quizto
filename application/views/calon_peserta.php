<div class="container">
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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php echo $title;?>
                    <div class="btn-group pull-right">
                        <button id="w6" class="btn btn-default dropdown-toggle" title="Export data in Excel" data-toggle="dropdown" aria-expanded="false"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span></button>
                        <ul id="w7" class="dropdown-menu">                          
                            <li title="Export All Data To Excel"><a id="all-excell" class="export-full-html" href="<?php echo site_url('calonpeserta/download/xlsx/allcapers') ;?>" tabindex="-1"><i class="fa fa-file-excel-o"></i> Export All</a></li>							
                            <li title="Export Per Page To Excel"><a id="page-excell" class="export-full-html" href="<?php echo site_url('calonpeserta/download/xlsx/capers/' . $page) ;?>" tabindex="-1"><i class="fa fa-file-excel-o"></i> Export Per Page</a></li>
                            <li title="Download Lampiran"><a id="lampiran" class="export-full-html" href="<?php echo site_url('calonpeserta/download/zipall') ;?>" tabindex="-1"><i class="fa fa-file-zip-o"></i> Download Lampiran</a></li>
                        </ul>
                    </div>
                </div>
                <table id="tbl-caper" class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>NO. REGISTRASI</th>
                        <th>NAMA</th>
                        <th>IJAZAH</th>
                        <th>TRANSKRIP</th>
                        <th>KTP</th>
                        <th>SP</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                    <?php 
					$xi=($page-1) * $this->config->item('number_of_rows') ;
                    foreach($result as $key => $value) {
						++$xi;
                    ?> 
                    <tr <?= $value->nilai_ipk < 2.75 ? 'class="danger"' : ''?>>
                        <td><?php echo $xi;?></td>
                        <td><?php echo $value->registration_no; ?></td>
                        <td><?php echo $value->first_name .' '.$value->last_name; ?></td>
                        <td>
                            <?php
                                $ijazahfull="calonpeserta/download/full/ijazah/" . $value->registration_no;
                                echo anchor('#myModal', '<i class="fa fa-eye"></i>', 
                                    array(
                                        'title' => 'Lihat Ijazah', 
                                        'data-toggle' => 'modal',
                                        'class' => 'image-floating',
                                        'data-img-url' => site_url($ijazahfull)
                                    ));
                            ?>
                        </td>
                        <td>
                            <?php
                                $transfull="calonpeserta/download/full/transkrip_nilai/" . $value->registration_no;
                                echo anchor('#myModal', '<i class="fa fa-eye"></i>', 
                                    array(
                                        'title' => 'Lihat Transkrip Nilai',
                                        'class' => 'image-floating',
                                        'data-toggle' => 'modal',
                                        'data-img-url' => site_url($transfull)
                                    ));
                            ?>
                        </td>
                        <td>
                            <?php
                                $ktpfull="calonpeserta/download/full/ktp/" . $value->registration_no;
                                echo anchor('#myModal', '<i class="fa fa-eye"></i>', 
                                    array(
                                        'title' => 'Lihat KTP', 
                                        'data-toggle' => 'modal',
                                        'class' => 'image-floating',
                                        'data-img-url' => site_url($ktpfull)
                                    ));
                            ?>
                        </td>
                        <td>
                            <?php
                                $spfull="calonpeserta/download/full/surat_pernyataan/" . $value->registration_no;
                                echo anchor('#myModal', '<i class="fa fa-eye"></i>', 
                                    array(
                                        'title' => 'Lihat Surat Pernyataan', 
                                        'data-toggle' => 'modal',
                                        'class' => 'image-floating',
                                        'data-img-url' => site_url($spfull)
                                    ));
                            ?>
                        </td>
                        <td>
                            <?php
                                // $segments = array('calonpeserta', 'status', $value->id);
                                $status_ok = anchor(site_url('#'), '<i class="fa fa-check"></i>', array('class' => 'btn btn-sm btn-success changestatus', 'data-id' => $value->id));
                                $status_gagal = anchor(site_url('#'), '<i class="fa fa-remove"></i>', array('class' => 'btn btn-sm btn-danger changestatus', 'data-id' => $value->id));
                                
                                echo $value->status == 'OK' ? $status_ok : $status_gagal;
                            ?>
                        </td>
                        <td><a href="<?php echo site_url('calonpeserta/download/zip/detail/'. $value->registration_no) ;?>"><i class="fa fa-download"></i></a></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <div class="row example-pagination">
        <div class="col-md-12">
            <ul class="pagination">
                <?php foreach ($links as $link) { ?>
                <li><?php echo $link ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="image-gallery-title"></h4>
            </div>
            <div class="modal-body text-center">
                <img class="img-responsive" src="#"/>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.image-floating').click(function(e){
        $('#myModal img').attr('src', $(this).attr('data-img-url'));
    });

    $('.changestatus').click(function(e){
        e.preventDefault();
        var caper_id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: '/calonpeserta/status',
            data: {caper_id: caper_id},
            success: function(response) {
                // alert(response);
                if(response == 'success') {
                    location.reload();
                } else {
                    alert('Ada masalah di server');
                }
            }
        });
    });
</script>