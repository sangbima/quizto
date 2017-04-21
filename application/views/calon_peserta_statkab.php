<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php echo $title;?>
                    <div class="btn-group pull-right">
                        <button id="w6" class="btn btn-default dropdown-toggle" title="Export data in Excel" data-toggle="dropdown" aria-expanded="false"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span></button>
                        <ul id="w7" class="dropdown-menu">                          
                            <li title="Export All Data To Excel"><a id="all-excell" class="export-full-html" href="<?php echo site_url('calonpeserta/download/xlsx/statkab') ;?>" tabindex="-1"><i class="fa fa-file-excel-o"></i> Export All</a></li>                            
                        </ul>
                    </div>
                </div>
                <table id="tbl-caper" class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN/KOTA</th>
                        <th>PENDAFTAR</th>
                        <th>LOLOS</th>
                        <th>%</th>
                    </tr>
                    <?php 
                    $xi=($page-1) * $this->config->item('number_of_rows') ;
                    foreach($statprov as $val) {
                        ++$xi;
                    ?> 
                    <tr>
                        <td><?php echo $xi;?></td>
                        <td><?php echo $val->provinsi;?></td>
                        <td><?php echo $val->kabupatenkota;?></td>
                        <td><?php echo $val->total;?></td>
                        <td><?php echo $val->lolos;?></td>
                        <td><?php echo $val->percent;?></td>
                    </tr>
                    <?php }?>
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