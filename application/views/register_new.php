<div class="container">
    <h3><?php echo $title;?></h3>
    <?php 
    $attributes = array("name" => "register_form", "id" => "register_form","enctype"=>"multipart/form-data");	
    echo form_open('register/submit', $attributes); 
    ?>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informasi Umum (Semua wajib diisi)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('first_name'), 'inputFirstName'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'first_name', 
                                        'id' => 'inputFirstName', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('first_name'), 
                                        'required' => 'required', 
                                        'autofocus' => 'autofocus'
                                    )); ?>
                                    <small><?php echo form_error('first_name', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('last_name'), 'inputLastName'); ?> 
                                    <?php echo form_input(array(
                                        'name' => 'last_name', 
                                        'id' => 'inputLastName', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('last_name'), 
                                    )); ?>
                                    <small><?php echo form_error('last_name', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('tempat_lahir'), 'inputTempatLahir'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'tempat_lahir', 
                                        'id' => 'inputTempatLahir', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('tempat_lahir'), 
                                        'required' => 'required', 
                                    )); ?>
                                    <small><?php echo form_error('tempat_lahir', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('tanggal_lahir'), 'inputTanggalLahir'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'tanggal_lahir', 
                                        'id' => 'inputTanggalLahir', 
                                        'class' =>'form-control datepicker', 
                                        'placeholder' => $this->lang->line('tanggal_lahir'), 
                                        'required' => 'required', 
                                    )); ?>
                                    <small><?php echo form_error('tanggal_lahir', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('email_address'), 'inputEmail'); ?>
                                    <?php echo form_input(array(
                                        'type' => 'email',
                                        'name' => 'email', 
                                        'id' => 'inputEmail', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('email_address'), 
                                        'required' => 'required', 
                                    )); ?>
                                    <small><?php echo form_error('email', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">      
                                    <?php echo form_label($this->lang->line('password'), 'inputPassword'); ?>
                                    <?php echo form_password(array(
                                        'name' => 'password', 
                                        'id' => 'inputPassword', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('password'), 
                                        'required' => 'required', 
                                    )); ?>
                                    <small><?php echo form_error('password', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">      
                                    <?php echo form_label($this->lang->line('password_repeat'), 'inputRepeatPassword'); ?>
                                    <?php echo form_password(array(
                                        'name' => 'passconf', 
                                        'id' => 'inputRepeatPassword', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('password_repeat'), 
                                        'required' => 'required', 
                                    )); ?>
                                    <small><?php echo form_error('passconf', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Alamat', 'inputAlamat'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'alamat', 
                                        'id' => 'inputAlamat', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Alamat'
                                    )); ?>
                                    <small><?php echo form_error('alamat', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Desa/Kelurahan', 'inputDesa'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'desakelurahan', 
                                        'id' => 'inputDesa', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Desa/Kelurahan'
                                    )); ?>
                                    <small><?php echo form_error('desakelurahan', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Kecamatan', 'inputKecamatan'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'kecamatan', 
                                        'id' => 'inputKecamatan', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Kecamatan'
                                    )); ?>
                                    <small><?php echo form_error('kecamatan', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Kabupaten/Kota', 'inputKabupaten'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'kabupatenkota', 
                                        'id' => 'inputKabupaten', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Kabupaten/Kota'
                                    )); ?>
                                    <small><?php echo form_error('kabupatenkota', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Provinsi', 'inputProvinsi'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'provinsi', 
                                        'id' => 'inputProvinsi', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Provinsi'
                                    )); ?>
                                    <small><?php echo form_error('provinsi', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">     
                                    <?php echo form_label($this->lang->line('contact_no'), 'contactNo'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'contact_no', 
                                        'id' => 'contactNo', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('contact_no'), 
                                        'required' => 'required', 
                                    )); ?>
                                    <small><?php echo form_error('contact_no', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Pekerjaan Terakhir (Tidak wajib diisi)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('instansi_name'), 'inputInstansi'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'instansi_name', 
                                        'id' => 'inputInstansi', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('instansi_name')
                                    )); ?>
                                    <small><?php echo form_error('instansi_name', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('bagian'), 'inputDepartemen'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'bagian', 
                                        'id' => 'inputDepartemen', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('bagian')
                                    )); ?>
                                    <small><?php echo form_error('bagian', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('alamat_instansi'), 'inputAlamatInstansi'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'alamat_instansi', 
                                        'id' => 'inputAlamatInstansi', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('alamat_instansi')
                                    )); ?>
                                    <small><?php echo form_error('alamat_instansi', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Jabatan', 'inputJabatan'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'jabatan', 
                                        'id' => 'inputJabatan', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Jabatan'
                                    )); ?>
                                    <small><?php echo form_error('jabatan', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group stepNumber">
                                    <?php echo form_label('Masa Kerja (Thn)', 'inputTahunPengabdian'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'thn_mengabdi', 
                                        'id' => 'inputTahunPengabdian', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Masa Kerja',
                                        'type' => 'number'
                                    )); ?>
                                    <small><?php echo form_error('thn_mengabdi', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_label('Deskripsi Pekerjaan', 'inputJobDesk'); ?>
                                <?php echo form_textarea(array(
                                    'name' => 'jobdesk',
                                    'id' => 'inputJobDesk',
                                    'class' => 'form-control',
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informasi Pendidikan (Semua wajib diisi)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">     
                                    <?php echo form_label($this->lang->line('pendidikan'), 'inputPendidikan'); ?>
                                    <?php
                                        $option = array(
                                            '' => '--'.$this->lang->line('pendidikan').'--',
                                            'SD' => 'Sekolah Dasar',
                                            'SMP' => 'Sekolah Menengah Pertama',
                                            'SMA' => 'Sekolah Menengah Atas',
                                            'DIPLOMA' => 'Diploma',
                                            'S1' => 'Sarjana',
                                            'S2' => 'Megister',
                                        );

                                        echo form_dropdown('pendidikan', $option, '', array(
                                            'id' => 'inputPendidikan',
                                            'class' => 'selecter_3',
                                            'data-selecter-options' => '{"cover":"true"}',
                                            'required' => 'required'
                                        ));
                                    ?>
                                    <small><?php echo form_error('pendidikan', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('institusi_pendidikan'), 'institusiPendidikan'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'institusi_pendidikan', 
                                        'id' => 'institusiPendidikan', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('institusi_pendidikan'), 
                                        'required' => 'required', 
                                    )); ?>
                                    <small><?php echo form_error('institusi_pendidikan', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('fakultas'), 'fakultas'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'fakultas', 
                                        'id' => 'fakultas', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('fakultas'), 
                                        'required' => 'required', 
                                    )); ?>
                                    <small><?php echo form_error('fakultas', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('no_ijazah'), 'noIjazah'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'no_ijazah', 
                                        'id' => 'noIjazah', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('no_ijazah'), 
                                        'required' => 'required', 
                                    )); ?>
                                    <small><?php echo form_error('no_ijazah', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group stepNumber">
                                    <?php echo form_label($this->lang->line('nilai_ipk'), 'nilaiIpk'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'nilai_ipk', 
                                        'id' => 'nilaiIpk', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('nilai_ipk'), 
                                        'required' => 'required',
                                        'type' => 'number'
                                    )); ?>
                                    <small><?php echo form_error('nilai_ipk', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lampiran Dokumen (Semua wajib diisi)</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                           <?php 
        				        $lname=array('Foto','Ijazah','Transkrip Nilai','KTP','SKCK','SKBN','SKS','BPJS');
        				        for ($xi=0;$xi<count($lname);++$xi) 
        				           {
        					         $lid='lampiran' . $xi;                             						 					    
        				   ?>					                            
                            <div class="col-md-4">
                                <div class="form-group">        
                                    <?php echo form_label($lname[$xi], $lid  ); ?>								
                                    <?php echo form_input(array(
                                        'name' => $lid, 										
                                        'id' => $lid, 
                                        'class' =>'form-control', 
                                        'placeholder' => $lid ,                                          
										'type' => 'file',
                                        'accept' => '.jpeg, .jpg',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error($lid, '<div class="text-danger">', '</div>');?></small>
                                    <br>									
                                </div>
                            </div>													
						   <?php }?>
                           <div class="col-md-4">
                                <div class="form-group">        
                                    <?php echo form_label('Riwayat Hidup', 'riwayathidup'); ?>                              
                                    <?php echo form_input(array(
                                        'name' => 'lampiran8',                                         
                                        'id' => 'lampiran8', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Riwayat Hidup' ,                                          
                                        'type' => 'file',
                                        'accept' => '.doc, .docx, .pdf',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error($lid, '<div class="text-danger">', '</div>');?></small>
                                    <br>                                    
                                </div>
                           </div>
                           
                        </div>
                        <div class="row">										
                            <div class="col-md-6">
                                <div class="box bg-danger" style="padding: 0 5px 0 5px;">
                                <p>Keterangan:</p>
                                <ul>
                                    <li>Semua file harus berbentuk gambar (.jpeg, .jpg)</li>
                                    <li>Ukuran per file max. 200 Kb</li>
                                    <li>KTP: Kartu Tanda Penduduk</li>
                                    <li>SKCK: Surat Keterangan Catatan Kepolisian</li>
                                    <li>SKBN: Surat Keterangan Bebas Narkoba</li>
                                    <li>SKS: Surat Keterangan Sehat</li>
                                    <li>BPJS yang masih aktif</li>
                                    <li>Khusus Riwayat Hidup berupa dokumen (.docx, doc, atau .pdf)</li>
                                </ul>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>		
				
        <button class="btn btn-default" type="submit" id="daftar">Daftar</button>
    <?php echo form_close(); ?>
</div>

<div id="spinner"></div>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script type="text/javascript">
// When the document is ready
$(document).ready(function () {    
    $('#inputTanggalLahir').datepicker({
        format: "dd-mm-yyyy"
    });

});

$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
    ajaxStop: function() { $body.removeClass("loading"); }    
});

$('form#register_form').submit(function(){
    var myFormData=new FormData($(this)[0]);
    $.ajax({
        url: "<?php echo site_url('register/submit'); ?>",
        type: 'POST',
		data: myFormData,		        
        contentType: false, 
        processData: false,		
        success: function(msg) {
            if(msg == 'YES') {
                alert('Pendaftaran Berhasil');
                window.location.replace("<?php echo site_url('register/success'); ?>");
            } else if (msg == 'NO') {
                alert('Pendaftaran Gagal ' + msg);
            } else {
                alert(msg);
            }
        }
    });
    return false;
});
</script>