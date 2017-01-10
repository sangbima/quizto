<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
        <form method="post" action="<?php echo site_url('disc/insert_disc');?>">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php 
                            if($this->session->flashdata('message')){
                        ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('message');?>
                        </div>
                        <?php
                            }
                        ?>
                        <div class="col-md-2" style="margin-bottom: 5px;">
                            <div class="form-group">     
                                <label for="no_statement"><?php echo $this->lang->line('no_statement');?></label> 
                                <select name="no_pernyataan" class="form-control" id="no_statement">
                                    <?php for($i=1; $i<=24; $i++) { ?>
                                        <option value="<?php echo $i?>"><?=$i?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <table class="table">
                            <tr>
                                <th>
                                    <?php echo $this->lang->line('most');?>
                                </th>
                                <th>
                                    <?php echo $this->lang->line('least');?>
                                </th>
                                <th>
                                    <?php echo $this->lang->line('statement');?>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="disc_m_1">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="disc_l_1">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" placeholder="<?php echo $this->lang->line('statement');?>" name="statement_1" required autofocus></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="disc_m_2">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="disc_l_2">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" placeholder="<?php echo $this->lang->line('statement');?>" name="statement_2" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="disc_m_3">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="disc_l_3">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" placeholder="<?php echo $this->lang->line('statement');?>" name="statement_3" required></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="disc_m_4">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="disc_l_4">
                                        <option value="D">D</option>
                                        <option value="I">I</option>
                                        <option value="S">S</option>
                                        <option value="C">C</option>
                                        <option value="*">*</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" placeholder="<?php echo $this->lang->line('statement');?>" name="statement_4" required></td>
                            </tr>
                        </table>
                        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
                    </div>
                </div>
            </div>
        </form>
    </div> 
</div>