<div class="container">
    <h3><?php echo $title;?></h3>
    <?php echo form_open('register'); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informasi Umum</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('first_name'), 'for="inputFirstName"'); ?>
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
                                    <?php echo form_label($this->lang->line('last_name'), 'for="inputLastName"'); ?> 
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
                                    <?php echo form_label($this->lang->line('tempat_lahir'), 'for="inputTempatLahir"'); ?>
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
                                    <?php echo form_label($this->lang->line('tanggal_lahir'), 'for="inputTanggalLahir"'); ?>
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
                                    <?php echo form_label($this->lang->line('email_address'), 'for="inputEmail"'); ?>
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
                                    <?php echo form_label($this->lang->line('password'), 'for="inputPassword"'); ?>
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
                                    <?php echo form_label($this->lang->line('password_repeat'), 'for="inputRepeatPassword"'); ?>
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
                            <div class="col-md-6">
                                <div class="form-group">     
                                    <?php echo form_label($this->lang->line('contact_no'), 'for="contactNo"'); ?>
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
                        <h3 class="panel-title">Pekerjaan Terakhir</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('instansi_name'), 'for="inputInstansi"'); ?>
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
                                    <?php echo form_label($this->lang->line('bagian'), 'for="inputDepartemen"'); ?>
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
                                    <?php echo form_label($this->lang->line('alamat_instansi'), 'for="inputAlamatInstansi"'); ?>
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
                                    <?php echo form_label('Jabatan', 'for="inputJabatan"'); ?>
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
                                <div class="form-group">
                                    <?php echo form_label('Masa Kerja (Thn)', 'for="inputTahunPengabdian"'); ?>
                                    <?php echo form_input(array(
                                        'name' => 'thn_mengabdi', 
                                        'id' => 'inputTahunPengabdian', 
                                        'class' =>'form-control', 
                                        'placeholder' => 'Masa Kerja'
                                    )); ?>
                                    <small><?php echo form_error('thn_mengabdi', '<div class="text-danger">', '</div>');?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_label('Deskripsi Pekerjaan', 'for="inputJobDesk"'); ?>
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
                        <h3 class="panel-title">Informasi Pendidikan</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">     
                                    <?php echo form_label($this->lang->line('pendidikan'), 'for="inputPendidikan"'); ?>
                                    <?php
                                        $option = [
                                            '' => '--'.$this->lang->line('pendidikan').'--',
                                            'SD' => 'Sekolah Dasar',
                                            'SMP' => 'Sekolah Menengah Pertama',
                                            'SMA' => 'Sekolah Menengah Atas',
                                            'DIPLOMA' => 'Diploma',
                                            'S1' => 'Sarjana',
                                            'S2' => 'Megister',
                                        ];

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
                                    <?php echo form_label($this->lang->line('institusi_pendidikan'), 'for="institusiPendidikan"'); ?>
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
                                    <?php echo form_label($this->lang->line('fakultas'), 'for="fakultas"'); ?>
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
                                    <?php echo form_label($this->lang->line('no_ijazah'), 'for="noIjazah"'); ?>
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
                                <div class="form-group">
                                    <?php echo form_label($this->lang->line('nilai_ipk'), 'for="nilaiIpk"'); ?>
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
        <button class="btn btn-default" type="submit">Daftar</button>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
// When the document is ready
$(document).ready(function () {
    
    $('#inputTanggalLahir').datepicker({
        format: "dd-mm-yyyy"
    });

});
</script>