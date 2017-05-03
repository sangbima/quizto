<div class="container">
    <h3><?php echo $title;?></h3>
    <?php 
    $attributes = array("name" => "berkas_form", "id" => "berkas_form","enctype"=>"multipart/form-data");	
    echo form_open('berkas/submit', $attributes); 
    ?>		
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lampiran Dokumen</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                           <?php 
        				        $lname=array('SKCK',
								             'SKSJ',
											 'SKSR',
											 'SKBN',
											 'BPJS',
											 'KIS'											 
											 );
                                $br = false;
        				        for ($xi=0;$xi<count($lname);++$xi) 
        				           {
        					         $lid='berkas' . $xi;   
                                     if ($this->berkas_model->if_berkas_exist($lname[$xi],$registration_no)){
                                         $br = true;
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
                                        'accept' => '.jpeg, .jpg'
                                    )); ?>
                                    <small><?php echo form_error($lid, '<div class="text-danger">', '</div>');?></small>
                                    <br>									
                                </div>
                            </div>													
                                <?php }}?>
                           
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box bg-danger" style="padding: 0 5px 0 5px;">
                                <p>Keterangan:</p>
                                <ul>
                                    <li>Semua file harus berbentuk gambar (.jpeg, .jpg)</li>
                                    <li>Ukuran per file max. 200 Kb</li>
                                    <li>SKCK: Surat Keterangan Catatan Kepolisian</li>
                                    <li>SKSJ: Surat Keterangan Sehat Jasmani</li>									
                                    <li>SKSR: Surat Keterangan Sehat Rohani</li>																		
                                    <li>SKBN: Surat Keterangan Bebas Narkoba</li>
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
		<?php if($br) { ?>	
            <button class="btn btn-default" type="submit" id="daftar">Upload</button>
        <?php } ?>
    <?php echo form_close(); ?>
</div>

<div id="spinner"></div>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script type="text/javascript">
// When the document is ready


$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
    ajaxStop: function() { $body.removeClass("loading"); }    
});

$('form#berkas_form').submit(function(){
    var myFormData=new FormData($(this)[0]);
    $.ajax({
        url: "<?php echo site_url('berkas/submit'); ?>",
        type: 'POST',
		data: myFormData,		        
        contentType: false, 
        processData: false,		
        success: function(msg) {
            if(msg == 'YES') {
                alert('Upload Dokumen Berhasil');
                window.location.replace("<?php echo site_url('berkas/success'); ?>");
            } else if (msg == 'NO') {
                alert('Upload Dokumen Gagal ' + msg);
            } else {
                alert(msg);
            }
        }
    });
    return false;
});

</script>