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
                <div class="panel-heading">Hasil Test DISC</div>
                <table class="table table-condensed table-hover" id="table-hasil">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fullname</th>
                        <th>MOST</th>
                        <th>LEAST</th>
                        <th>CHANGE</th>
                        <th>DETAIL</th>
                    </tr>
                </thead>
                <?php foreach ($result as $key => $value) { ?>
                <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><?php echo $value['fullname']; ?></td>
                    <td>MOST</td>
                    <td>LEAST</td>
                    <td>CHANGE</td>
                    <td><a href="<?php echo site_url('hasil/detaildisc/'.$value['uid']);?>"><i class="fa fa-eye"></i></a></td>
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