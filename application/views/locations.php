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
                <table id="tbl-locations" class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>PROVINSI</th>
                        <th>KOTA/KABUPATEN</th>
                        <th>STATUS</th>
                    </tr>
                    <?php 
					$xi=($page-1) * $this->config->item('number_of_rows') ;
                    foreach($result as $key => $value) {
						++$xi;
                    ?> 
                    <tr>
                        <td><?php echo $xi;?></td>
                        <td><?php echo $value->provinsi; ?></td>
                        <td><?php echo $value->kotakabupaten; ?></td>
                        <td>
                            <?php
                                // $segments = array('calonpeserta', 'status', $value->id);
                                $status_ok = anchor(site_url('#'), '<i class="fa fa-check"></i>', array('class' => 'btn btn-sm btn-success changestatus', 'data-id' => $value->id));
                                $status_gagal = anchor(site_url('#'), '<i class="fa fa-remove"></i>', array('class' => 'btn btn-sm btn-danger changestatus', 'data-id' => $value->id));
                                
                                echo $value->status == 1 ? $status_ok : $status_gagal;
                            ?>
                        </td>
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

<script type="text/javascript">
    $('.changestatus').click(function(e){
        e.preventDefault();
        var caper_id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: '/locations/status',
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

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>