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
                            <li title="Export All Data To Excel"><a id="all-excell" class="export-full-html" href="#" tabindex="-1"><i class="fa fa-file-excel-o"></i> Export All</a></li>
                            <!-- <li title="Export Per Page To Excel"><a id="page-excell" class="export-full-html" href="#" tabindex="-1"><i class="fa fa-file-excel-o"></i> Export Per Page</a></li> -->
                        </ul>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>EMAIL</th>
                        <th>NO. REGISTRASI</th>
                        <th>NAMA</th>
                        <th>NO. TELP</th>
                        <th>AKSI</th>
                    </tr>
                    <?php 
                    foreach($result as $key => $value) {
                    ?> 
                    <tr>
                        <td>#</td>
                        <td><?php echo $value->email; ?></td>
                        <td><?php echo $value->registration_no; ?></td>
                        <td><?php echo $value->first_name .' '.$value->last_name; ?></td>
                        <td><?php echo $value->contact_no ?></td>
                        <td><i class="fa fa-download"></i></td>
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