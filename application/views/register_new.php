<div class="container">
    <h3><?php echo $title;?></h3>
    <?php echo form_open('register'); ?>
        
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