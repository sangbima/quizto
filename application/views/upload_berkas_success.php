<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php 
                if($this->session->flashdata('message')){
            ?>
                    <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
            <?php
                }
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Upload Dokumen Anda Berhasil</h3>
                </div>
            </div>
        </div>
    </div>
</div>