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
                <div class="panel-heading">Hasil TPU dan TPA</div>
                <table class="table table-condensed table-hover" id="table-hasil">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fullname</th>
                        <th>TPU</th>
                        <th>TPA</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <?php foreach ($result as $key => $value) { ?>
                <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><?php echo $value['fullname']; ?></td>
                    <td><?php echo $value['ist1'] ? $value['ist1'] : 0; ?></td>
                    <td><?php echo $value['ist2'] ? $value['ist2'] : 0; ?></td>
                    <td><?php echo ($value['ist1'] ? $value['ist1'] : 0) + ($value['ist2'] ? $value['ist2'] : 0) ?></td>
                </tr>
                <?php } ?>
            </table>
            </div>
            <?php 
                }
            ?>
        </div>
    </div>
</div>