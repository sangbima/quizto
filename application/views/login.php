<div class="jumbotron hero">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-push-7 phone-preview item">
                <div class="login-card"><img src="../images/logo.png" class="profile-img-card">
                    <p class="profile-name-card"> </p>
                    <form class="form-signin" method="post" action="<?php echo site_url('login/verifylogin');?>">
                    	<span class="reauth-email"> </span>
                    	<?php 
						if($this->session->flashdata('message')){
						?>
							<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('message'); ?>
                            </div>
						<?php	
						}
						?>
                        <input class="form-control" type="text" name="registration_no" required="" placeholder="<?php echo $this->lang->line('registration_no');?>" autofocus="" id="inputRegistrationNo">
                        <input class="form-control" type="password" name="password" required="" placeholder="<?php echo $this->lang->line('password');?>" id="inputPassword">
                        <div class="checkbox"></div>
                        <button class="btn btn-primary btn-block btn-lg btn-signin" type="submit"><?php echo $this->lang->line('login');?></button>
                        <a class="btn btn-primary btn-block btn-lg btn-reg" href="register">Daftar Ujian</a>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-md-pull-3 get-it">
                <h1>CAT KEMENDIKBUD</h1>
                <p>Ujian CAT Online untuk Pegawai Non PNS</p>
            </div>
        </div>
    </div>
</div>