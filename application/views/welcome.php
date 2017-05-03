<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <div class="container">
                    <h3>Selamat Datang...</h3>
                    <p>Pada tahap ini, Anda akan diminta untuk melengkapi dokumen penunjang sebagai pelengkap administrasi Anda.</p>
                    <p>Jika pada satu kesempatan Anda belum bisa mengunggah semua berkas, Anda dapat kembali ke laman ini untuk melengkapinya.</p>
                    <p>
                        Berkas penunjang dapat Anda lengkapi dari tanggal <span class="label label-danger"><?php echo tgl_indo_timestamp(strtotime($this->config->item('awal_berkas_2'))); ?> WIB</span> sampai dengan tanggal <span class="label label-danger"><?php echo tgl_indo_timestamp(strtotime($this->config->item('akhir_berkas_2'))); ?> WIB</span>. 
                    </p>
                    <p><a class="btn btn-primary btn-lg" href="/berkas" role="button">Upload Berkas</a></p>
                </div>
            </div>
        </div>
    </div>
</div>