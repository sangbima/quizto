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
                                    <?php echo form_label('Nama Depan<sup class="required">*</sup>', 'inputFirstName'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'first_name', 
                                        'id' => 'inputFirstName', 
                                        'class' =>'form-control',
                                        // 'value' => set_value('first_name'),
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
                                    <?php echo form_label('Tempat Lahir<sup class="required">*</sup>', 'inputTempatLahir'); ?>
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
                                    <?php echo form_label('Tanggal Lahir<sup class="required">*</sup>', 'inputTanggalLahir'); ?>
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
                                    <?php echo form_label('Alamat Email<sup class="required">*</sup>', 'inputEmail'); ?>
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
                                    <?php echo form_label('Password<sup class="required">*</sup>', 'inputPassword'); ?>
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
                                    <?php echo form_label('Ulangi Password<sup class="required">*</sup>', 'inputRepeatPassword'); ?>
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
                                    <?php echo form_label('NIK<sup class="required">*</sup>', 'inputNik'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'nik', 
                                        'id' => 'inputNik', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Nomor Induk Kependudukan',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('nik', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo form_label('Alamat (Sesuai KTP)<sup class="required">*</sup>', 'inputAlamat'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'alamat', 
                                        'id' => 'inputAlamat', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Alamat',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('alamat', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="selectProvinsi">
                                    <?php echo form_label('Provinsi<sup class="required">*</sup>', 'inputprovinsi'); ?>
                                    
                                    <?php 
                                        $noselect = array('#' => '-- Pilih Provinsi --');
                                        $options = array_merge($noselect, $provinsi);
                                        echo form_dropdown('provinsi', $options, '#', array(
                                            'id' => 'inputprovinsi',
                                            'class' => 'form-control',
                                            'data-selecter-options' => '{"cover":"true"}',
                                            'required' => 'required'
                                        )); 
                                    ?>

                                    <small><?php echo form_error('provinsi', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="selectKabkota">
                                    <?php echo form_label('Kabupaten/Kota<sup class="required">*</sup>', 'inputkabupaten'); ?>
                                    <?php 
                                        $options = array('#' => '-- Pilih Kabupaten/Kota --');
                                        echo form_dropdown('kabupatenkota', $options, '#', array(
                                            'id' => 'inputkabupaten',
                                            'class' => 'form-control',
                                            'data-selecter-options' => '{"cover":"true"}',
                                            'required' => 'required'
                                        )); 
                                    ?>

                                    <small><?php echo form_error('kabupatenkota', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Kecamatan<sup class="required">*</sup>', 'inputKecamatan'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'kecamatan', 
                                        'id' => 'inputKecamatan', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Kecamatan',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('kecamatan', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label('Desa/Kelurahan<sup class="required">*</sup>', 'inputDesa'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'desakelurahan', 
                                        'id' => 'inputDesa', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Desa/Kelurahan',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('desakelurahan', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">     
                                    <?php echo form_label('Nomor Telepon<sup class="required">*</sup>', 'contactNo'); ?>
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
                                    <?php echo form_label('Tingkat Pendidikan<sup class="required">*</sup>', 'inputPendidikan'); ?>
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
                                            'class' => 'form-control',
                                            'data-selecter-options' => '{"cover":"true"}',
                                            'required' => 'required'
                                        ));
                                    ?>
                                    <small><?php echo form_error('pendidikan', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label('Institusi Pendidikan<sup class="required">*</sup>', 'institusiPendidikan'); ?>
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
                                    <?php echo form_label('Fakultas/Jurusan<sup class="required">*</sup>', 'fakultas'); ?>
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
                                    <?php echo form_label('No. Ijazah<sup class="required">*</sup>', 'noIjazah'); ?>
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
                                    <?php echo form_label('IPK/NEM (Ex. 3.4)<sup class="required">*</sup>', 'nilaiIpk'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'nilai_ipk', 
                                        'id' => 'nilaiIpk', 
                                        'class' =>'form-control', 
                                        'placeholder' => $this->lang->line('nilai_ipk'), 
                                        'required' => 'required',
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
        				        $lname=array('Foto (Ukuran 4x6)<sup class="required">*</sup>','Ijazah<sup class="required">*</sup>','KTP<sup class="required">*</sup>','Surat Pernyataan<sup class="required">*</sup>');
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
                                        'required' => 'required',
                                        // 'onchange' => "checkName(this, 'fname', 'daftar')"
                                    )); ?>
                                    <small><?php echo form_error($lid, '<div class="text-danger">', '</div>');?></small>
                                    <br>									
                                </div>
                            </div>													
						   <?php }?>
                           <div class="col-md-4">
                                <div class="form-group">        
                                    <?php echo form_label('Transkrip Nilai<sup class="required">*</sup>', 'lampiran4'); ?>                              
                                    <?php echo form_input(array(
                                        'name' => 'lampiran4',                                         
                                        'id' => 'lampiran4', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Transkrip Nilai' ,                                          
                                        'type' => 'file',
                                        'accept' => '.pdf',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('lampiran4', '<div class="text-danger">', '</div>');?></small>
                                    <br>                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">        
                                    <?php echo form_label('Riwayat Hidup<sup class="required">*</sup>', 'lampiran5'); ?>                              
                                    <?php echo form_input(array(
                                        'name' => 'lampiran5',                                         
                                        'id' => 'lampiran5', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Riwayat Hidup' ,                                          
                                        'type' => 'file',
                                        'accept' => '.jpeg, .jpg',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('lampiran5', '<div class="text-danger">', '</div>');?></small>
                                    <br>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">        
                                    <?php echo form_label('Surat Lamaran<sup class="required">*</sup>', 'lampiran6'); ?>                              
                                    <?php echo form_input(array(
                                        'name' => 'lampiran6',                                         
                                        'id' => 'lampiran6', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Surat Lamaran' ,                                          
                                        'type' => 'file',
                                        'accept' => '.jpeg, .jpg',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('lampiran6', '<div class="text-danger">', '</div>');?></small>
                                    <br>                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">        
                                    <?php echo form_label('SKCK<sup class="required">*</sup>', 'lampiran7'); ?>                              
                                    <?php echo form_input(array(
                                        'name' => 'lampiran7',                                         
                                        'id' => 'lampiran7', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'SKCK' ,                                          
                                        'type' => 'file',
                                        'accept' => '.jpeg, .jpg',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('lampiran7', '<div class="text-danger">', '</div>');?></small>
                                    <br>                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">        
                                    <?php echo form_label('SKSJ<sup class="required">*</sup>', 'lampiran8'); ?>                              
                                    <?php echo form_input(array(
                                        'name' => 'lampiran8',                                         
                                        'id' => 'lampiran8', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'SKSJ' ,                                          
                                        'type' => 'file',
                                        'accept' => '.jpeg, .jpg',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('lampiran8', '<div class="text-danger">', '</div>');?></small>
                                    <br>                                    
                                </div>
                            </div>								
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">        
                                    <?php echo form_label('BPJS/KIS<sup class="required">*</sup>', 'lampiran9'); ?>                              
                                    <?php echo form_input(array(
                                        'name' => 'lampiran9',                                         
                                        'id' => 'lampiran9', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'BPJS/KIS' ,                                          
                                        'type' => 'file',
                                        'accept' => '.jpeg, .jpg',
                                        'required' => 'required'
                                    )); ?>
                                    <small><?php echo form_error('lampiran9', '<div class="text-danger">', '</div>');?></small>
                                    <br>                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box bg-danger" style="padding: 0 5px 0 5px;">
                                <p>Keterangan:</p>
                                <ul>
                                    <li><sup class="required">*</sup> Wajib diisi</li>
                                    <li>Semua file harus berbentuk gambar (.jpeg, .jpg)</li>
                                    <li>Ukuran per file max. 200 Kb</li>
                                    <li>Khusus <b>Transkrip Nilai</b> harus berupa dokumen pdf (.pdf)</li>
                                    <li>SKCK: Surat Keterangan Catatan Kepolisian</li>
                                    <li>SKSJ: Surat Keterangan Sehat Jasmani</li>									
                                    <li>BPJS yang masih aktif</li>                                    
                                    <li>KIS: Kartu Indonesia Sehat</li>
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

    $("#inputprovinsi").change(function(){
        $("#inputkabupaten > option").remove();
        var provinsi_name = $('#inputprovinsi').val();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "<?php echo site_url('register/getkotabyprovinsi') . '/'; ?>"+escape(provinsi_name),
            success: function(data)
            {
                $.each(data, function(key, value){
                    var opt = $('<option />');
                    opt.val(key);
                    opt.text(value);
                    $('#inputkabupaten').append(opt);
                });
            }
        });
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

// var ar_ext = ['jpg', 'jpeg'];
// var doc_ext = ['doc', 'docx', 'pdf'];

// function checkName(el, sbm) {
//     // - coursesweb.net
//     // get the file name and split it to separe the extension
//     var name = el.value;
//     var ar_name = name.split('.');

//     // for IE - separe dir paths (\) from name
//     var ar_nm = ar_name[0].split('\\');
//     for(var i=0; i<ar_nm.length; i++) var nm = ar_nm[i];

//     // add the name in 'to'
//     // document.getElementById(to).value = nm;

//     // check the file extension
//     var re = 0;
//     for(var i=0; i<ar_ext.length; i++) {
//         if(ar_ext[i] == ar_name[1]) {
//             re = 1;
//             break;
//         }
//     }

//     // if re is 1, the extension is in the allowed list
//     if(re==1) {
//         // enable submit
//         document.getElementById(sbm).disabled = false;
//     } else {
//         // delete the file name, disable Submit, Alert message
//         el.value = '';
//         document.getElementById(sbm).disabled = true;
//         alert('".'+ ar_name[1]+ '" is not an file type allowed for upload');
//     }
// }

</script>