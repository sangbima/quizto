<html lang="en">
    <head>
        <title><?php echo $title;?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php echo base_url('bootstrap-datepicker/css/bootstrap-datepicker.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('bootflat/css/site.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('fontawesome/css/font-awesome.min.css');?>">

        <link rel="stylesheet" href="<?php echo base_url('css/style.css');?>">

        <script>
            var base_url="<?php echo base_url();?>";
        </script>

        <script type="text/javascript" src="<?php echo base_url('bootflat/js/site.min.js');?>"></script>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
        <script src="bootflat/js/html5shiv.js"></script>
        <script src="bootflat/js/respond.min.js"></script>
        <![endif]-->
        <!-- custom javascript -->
        <script src="<?php echo base_url('js/basic.js');?>"></script>
        <script src="<?php echo base_url('js/gen_validatorv4.js');?>" type="text/javascript"></script>
        
    </head>
<body>
  	
	<?php 
		if($this->session->userdata('logged_in')){
			if($this->uri->segment(2)!='attempt'){
			$logged_in=$this->session->userdata('logged_in');
	?>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url();?>"><?php echo $this->lang->line('title');?></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right">
                    <?php  
                    if($logged_in['su']==1){
                    ?>

                    <li <?php if($this->uri->segment(1)=='dashboard'){ echo "class='active'"; } ?> ><a href="<?php echo site_url('dashboard');?>"><?php echo $this->lang->line('dashboard');?></a></li>
                    <li class="dropdown" <?php if($this->uri->segment(1)=='user'){ echo "class='active'"; } ?> >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->lang->line('users');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('user/new_user');?>"><?php echo $this->lang->line('add_new');?></a></li>
                            <li><a href="<?php echo site_url('user');?>"><?php echo $this->lang->line('user_list');?></a></li>

                        </ul>
                    </li>
                    <li class="dropdown" <?php if($this->uri->segment(1)=='qbank'){ echo "class='active'"; } ?> >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->lang->line('qbank');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('qbank/pre_new_question');?>"><?php echo $this->lang->line('add_new');?></a></li>
                            <li><a href="<?php echo site_url('qbank');?>"><?php echo $this->lang->line('question_list');?></a></li>
                        </ul>
                    </li>
                    <?php 
                    }else{
                    ?>
                    <li><a href="<?php echo site_url('user/edit_user/'.$logged_in['uid']);?>"><?php echo $this->lang->line('myaccount');?></a></li>
                    <?php 
                    }
                    ?>
                    <?php  
                        if($logged_in['su']==1){
                        ?> 
                    <li class="dropdown" <?php if($this->uri->segment(1)=='qbank'){ echo "class='active'"; } ?> >
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->lang->line('quiz');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                                
                            <!-- <li><a href="<?php //echo site_url('quiz/add_new');?>"><?php //echo $this->lang->line('add_new');?></a></li> -->
                            				 
                            <li><a href="<?php echo site_url('quiz');?>"><?php echo $this->lang->line('quiz_list');?></a></li>
                        </ul>
                        <?php 
                            }
                        ?>
                    </li>
                    <?php  
                    if($logged_in['su']==1){
                    ?>
                    <!-- <li><a href="<?php // echo site_url('hasil');?>"><?php // echo $this->lang->line('result');?></a></li> -->
                    <!-- Star Menu Hasil -->
                    <li class="dropdown" <?php if($this->uri->segment(1)=='result'){ echo "class='active'"; } ?> >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->lang->line('result');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('hasil/');?>"><?php echo $this->lang->line('result_all');?></a></li>
                            <!-- <li><a href="<?php //echo site_url('#');?>"><?php //echo $this->lang->line('result_tpa');?></a></li> -->
                            <li><a href="<?php echo site_url('hasil/tpu_tpa');?>"><?php echo $this->lang->line('result_tpu_tpa');?></a></li>
                            <li><a href="<?php echo site_url('hasil/ist');?>"><?php echo $this->lang->line('result_ist');?></a></li>
                            <!-- <li><a href="<?php // echo site_url('hasil/disc');?>"><?php // echo $this->lang->line('result_disc');?></a></li> -->
                        </ul>
                    </li>
                    <!-- End Menu Hasil -->
                    <li class="dropdown" <?php if($this->uri->segment(1)=='user_group'){ echo "class='active'"; } ?> >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->lang->line('setting');?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">

                        <li><a href="<?php echo site_url('user/group_list');?>"><?php echo $this->lang->line('group_list');?></a></li>
                        <li><a href="<?php echo site_url('qbank/category_list');?>"><?php echo $this->lang->line('category_list');?></a></li>
                        <li><a href="<?php echo site_url('qbank/level_list');?>"><?php echo $this->lang->line('level_list');?></a></li>
                        <!-- <li><a href="<?php //echo site_url('dashboard/config');?>"><?php //echo $this->lang->line('config');?></a></li> -->
                        <!-- <li><a href="<?php //echo site_url('dashboard/css');?>"><?php //echo $this->lang->line('custom_css');?></a></li> -->
                        </ul>
                    </li>
                    <?php 
                    }
                    ?>
                    <li><a href="<?php echo site_url('user/logout');?>"><?php echo $this->lang->line('logout');?></a></li>
                    <!--
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>

                    </ul>
                    </li>
                    -->
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

	<?php 
			}
		}
	?>
	
