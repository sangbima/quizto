<div class="container">
    <?php 
        $logged_in=$this->session->userdata('logged_in');
    ?>
    <h3><?php echo $title;?></h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>Nama Test</th>
                    <th>Jumlah Soal</th>
                    <th>Durasi (menit)</th>
                </tr>
                <?php
                    foreach ($result as $key => $value) {
                ?>
                <tr>
                    <td><?php echo $key+1?></td>
                    <td><?php echo $value['quiz_name']?></td>
                    <td><?php echo $value['noq']?></td>
                    <td><?php echo $value['duration']?></td>
                </tr>
                <?php 
                    }                     
                    $url_submit = site_url('ujian/'.$quiz_current['short_name'].'/');                                            
                ?>
            </table>
            <?php
               if ($masih_ada_kesempatan)
               {
                    // $url_submit = site_url('ujian/tpu/');



                    // echo $value['quid'];
            ?>
            <form name="preujian" method="post" action="<?php echo $url_submit;?>">
                <button class="btn btn-success" type="submit" name="submit"><?php echo $this->lang->line('start_quiz');?></button>
            </form>
            <?php } else { ?>
                <!-- <h3>Kesempatan Sudah Habis</h3> -->
                <h3>Selamat, Anda sudah selesai mengerjakan Ujian Online. Silahkan Logout!</h3>
            <?php } ?>
        </div>
    </div>
</div>