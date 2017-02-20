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
                    <h3 class="panel-title">Data Anda</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed">
                        <tr>
                            <td class="col-md-2">Username:</td>
                            <td class="col-md-10">20178990</td>
                        </tr>
                        <tr>
                            <td class="col-md-2">Password:</td>
                            <td class="col-md-10">inipasswordku</td>
                        </tr>
                        <tr>
                            <td class="col-md-2">Nama</td>
                            <td class="col-md-10">Khairil</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>