	</div>
	<footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-10">
                    <h5>Copyright © <?php echo date('Y'); ?> Kementerian Pendidikan dan Kebudayaan, Republik Indonesia, All Rights Reserved.</h5></div>
                <div class="col-sm-2 social-icons"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
            </div>
        </div>
    </footer>
<?php 
if($this->config->item('tinymce')){
	if($this->uri->segment(2)!='attempt'){
		if($this->uri->segment(2)!='view_result'){
			if($this->uri->segment(2)!='config'){
				if($this->uri->segment(2)!='css'){
?>
	<script type="text/javascript" src="<?php echo base_url();?>editor/tiny_mce.js"></script>
	<script type="text/javascript">
 <?php 
 if($this->uri->segment(2)=='edit_quiz' || $this->uri->segment(2)=='add_new' ){
?>
			tinyMCE.init({
	
    mode : "textareas",
	editor_selector : "tinymce_textarea",
	theme : "advanced",
		relative_urls:"false",
	 plugins: "jbimages",
	  
	
  // ===========================================
  // PUT PLUGIN'S BUTTON on the toolbar
  // ===========================================
	
 
	
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "jbimages,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		
		
	});

<?php 
 }else{
?>

			tinyMCE.init({
	
    mode : "textareas",
		theme : "advanced",
		relative_urls:"false",
	 plugins: "jbimages",
	  
	
  // ===========================================
  // PUT PLUGIN'S BUTTON on the toolbar
  // ===========================================
	
 
	
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "jbimages,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		
		
	});
	
<?php 
 }
 ?>
 
</script>

	
	<?php 
						}
					}
			}
		}
	}
?>
<script type="text/javascript" src="<?php echo base_url();?>bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
</body>
</html>
