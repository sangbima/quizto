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
                <div class="panel-heading">Hasil Test IST</div>
                <table class="table table-condensed table-hover" id="table-hasil">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fullname</th>
                        <th>TPU</th>
                        <th>TPA</th>
                        <th>WA</th>
                        <th>SE</th>
                        <th>AN</th>
                        <th>GE</th>
                        <th>RA</th>
                        <th>ZR</th>
                        <th>FA</th>
                        <th>WU</th>
                        <th>ME</th>
                        <th>DETAIL</th>
                    </tr>
                </thead>
                <?php foreach ($result as $key => $value) { ?>
                <tr>
                    <td><?php echo $key+1 ?></td>
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
                    <td><?php echo $value['ist9'] ? $value['ist10'] : 0; ?></td>
                    <td><?php echo $value['ist9'] ? $value['ist11'] : 0; ?></td>
                    <td><a href="<?php echo site_url('hasil/detail/'.$value['uid']);?>"><i class="fa fa-eye"></i></a></td>
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