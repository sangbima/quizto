    <?php 
    $attributes = array("name" => "register_form", "id" => "register_form","enctype"=>"multipart/form-data");   
    echo form_open('test/submit', $attributes); 
    ?>
    <div class="row">
    <div class="col-md-3">
        <div class="form-group">        
            <?php echo form_label('Surat Pernyataan<sup class="required">*</sup>', 'lampiran4'); ?>                              
            <?php echo form_input(array(
                'name' => 'lampiran4',                                         
                'id' => 'lampiran4', 
                'class' =>'form-control', 
                'placeholder' => 'Riwayat Hidup',                                          
                'type' => 'file',
                'accept' => '.jpg, .jpeg, .JPEG',
                // 'required' => 'required'
            )); ?>
            <small><?php echo form_error('lampiran4', '<div class="text-danger">', '</div>');?></small>
            <br>                                    
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">        
            <?php echo form_label('Riwayat Hidup<sup class="required">*</sup>', 'lampiran5'); ?>                              
            <?php echo form_input(array(
                'name' => 'lampiran5',                                         
                'id' => 'lampiran5', 
                'class' =>'form-control', 
                'placeholder' => 'Riwayat Hidup' ,                                          
                'type' => 'file',
                'accept' => '.doc, .docx, .pdf',
                // 'required' => 'required'
            )); ?>
            <small><?php echo form_error('lampiran5', '<div class="text-danger">', '</div>');?></small>
            <br>                                    
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">        
            <?php echo form_label('Surat Lamaran<sup class="required">*</sup>', 'lampiran6'); ?>                              
            <?php echo form_input(array(
                'name' => 'lampiran6',                                         
                'id' => 'lampiran6', 
                'class' =>'form-control', 
                'placeholder' => 'Surat Lamaran' ,                                          
                'type' => 'file',
                'accept' => '.doc, .docx, .pdf',
                // 'required' => 'required'
            )); ?>
            <small><?php echo form_error('lampiran6', '<div class="text-danger">', '</div>');?></small>
            <br>                                    
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group stepNumber">
            <?php echo form_label('IPK/NEM (Ex. 3.4)<sup class="required">*</sup>', 'nilaiIpk'); ?>
            <?php echo form_input(array(
                'name' => 'nilai_ipk', 
                'id' => 'nilaiIpk', 
                'class' =>'form-control', 
                'placeholder' => 'IPK', 
                // 'required' => 'required',
                'type' => 'number'
            )); ?>
            <small><?php echo form_error('nilai_ipk', '<div class="text-danger">', '</div>');?></small>
        </div>
    </div>
</div>
                        
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-default" type="submit" id="daftar">Daftar</button>
    </div>
</div>
<?php echo form_close(); ?>