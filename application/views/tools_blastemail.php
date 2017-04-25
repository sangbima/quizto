<div class="container">
    <h3><?php echo $title;?></h3>
    <?php 
    $attributes = array("name" => "tools_form", "id" => "tools_form");   
    echo form_open('tools/sendemail', $attributes); 
    ?>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Kirim Email</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">     
                                    <?php echo form_label('Jumla email<sup class="required">*</sup>', 'jmlemail'); ?>
                                    <?php
                                        $option = array(
                                            '' => '-- Jumlah Email --',
                                            '5' => '5',
                                            '10' => '10',
                                            '15' => '15',
                                            '20' => '20',
                                            '25' => '25',
                                            '30' => '30',
                                            '35' => '35',
                                            '40' => '40',
                                            '45' => '45',
                                            '50' => '50'
                                        );

                                        echo form_dropdown('jml_email', $option, '', array(
                                            'id' => 'jmlemail',
                                            'class' => 'form-control',
                                            'data-selecter-options' => '{"cover":"true"}',
                                            'required' => 'required'
                                        ));
                                    ?>
                                    <small><?php echo form_error('jml_email', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-default" type="submit" id="kirim">Kirim</button>
    <?php echo form_close(); ?>
    <hr/>
    <div class="row">
        <div class="col-md-12">
           <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php echo $title;?>
                </div>
                <table id="tbl-caper" class="table table-bordered">
                    <tr>
                        <th>NO. REGISTRASI</th>
                        <th>NAMA</th>
                        <th>EMAIL</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN/KOTA</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                    <?php
                    foreach($result as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $value->registration_no;?></td>
                        <td><?php echo $value->fullname;?></td>
                        <td><?php echo $value->email;?></td>
                        <td><?php echo $value->provinsi;?></td>
                        <td><?php echo $value->kabkota;?></td>
                        <td>
                            <?php 
                                if($value->status == '0') {
                                    echo '<span class="label label-danger"><i class="fa fa-times"></i></span>';
                                } elseif($value->status == '10') {
                                    echo '<span class="label label-success"><i class="fa fa-check"></i></span>';
                                } else {
                                    echo '<span class="label label-info"><i class="fa fa-ban"></i></span>';
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                $status_send = anchor(site_url('#'), '<i class="fa fa-envelope"></i>', array('class' => 'btn btn-sm btn-success changestatus disabled', 'data-id' => $value->id));
                                // $status_send = anchor(site_url('#'), '<i class="fa fa-envelope"></i>', array('class' => 'btn btn-sm btn-info changestatus', 'data-id' => $value->id));
                                $status_unsend = anchor(site_url('#'), '<i class="fa fa-envelope"></i>', array('class' => 'btn btn-sm btn-info changestatus', 'data-id' => $value->id));
                                
                                echo $value->status == '10' ? $status_send : $status_unsend;
                            ?>
                            <!-- <a href="/tools/sendsingleemail/3" class="btn btn-sm btn-success changestatus"><i class="fa fa-envelope"></i></a> -->
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
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
            url: '/tools/sendsingleemail',
            data: {caper_id: caper_id},
            success: function(response) {
                if(response == 'success') {
                    alert('Email Berhasil Dikirim');
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