<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php 
                if($this->session->flashdata('message')){
            ?>
                    <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
            <?php
                }
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Registrasi Anda Berhasil</h3>
                </div>
                <div class="panel-body">
                    <p>Silahkan cek email Anda untuk mendapatkan Username dan Password.</p>
                    <p>
                        Info lengkap silahkan hubungi: <a href="mailto:cat.kemendikbud@gmail.com">Panitia Ujian</a><br/><br/>
                        <a href="/" class="btn btn-primary">Kembali</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>