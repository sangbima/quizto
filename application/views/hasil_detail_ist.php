<div class="container">
     <div class="row">
`            <?php 
                $logged_in=$this->session->userdata('logged_in');
            ?>
            <?php 
                if($logged_in['su']=='1' || $logged_in['su']=='2'){
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading"><i class="fa fa-user"></i> Detail Peserta</div>
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th>No. Peserta</th>
                                <td><?php echo $user['registration_no']; ?></td>
                            </tr>
                            <tr>
                                <th>Fullname</th>
                                <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $user['email']; ?></td>
                            </tr>
                            <tr>
                                <th>Telephone</th>
                                <td><?php echo $user['contact_no']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div>
				   <a href="<?php echo site_url('hasil/download/ist_detail/'. $user['uid']);?>" title="Export ke Excel" class="btn btn-default pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
				</div>				
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading"><i class="fa fa-bar-chart"></i> I S T (INTELLIGENCY)</div>
                        <div class="panel-body">
                            <table class="table table-hover table-condensed" id="table-detail-ist">
                                <thead>
                                    <tr>
                                        <th rowspan="2">SUB TEST</th>
                                        <th rowspan="2">ASPECT</th>
                                        <th colspan="2">SCORE</th>
                                        <th rowspan="2">NORMA</th>
                                    </tr>
                                    <tr>
                                        <th>RS</th>
                                        <th>WS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>SE</th>
                                        <td>Decision Making</td>
                                        <td align="center"><?php echo $result['ist3']; ?></td>
                                        <td align="center">
                                            <?php 
                                                $ist1 = $this->norma_model->norma_convert('ist1', $result['ist3']);
                                                echo $ist1['ws'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $this->norma_model->norma_flag($ist1['flag'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>WE</th>
                                        <td>Verbal Reasoning</td>
                                        <td align="center"><?php echo $result['ist4']; ?></td>
                                        <td align="center">
                                            <?php 
                                                $ist2 = $this->norma_model->norma_convert('ist2', $result['ist4']);
                                                echo $ist2['ws'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $this->norma_model->norma_flag($ist2['flag'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>AN</th>
                                        <td>Creativity</td>
                                        <td align="center"><?php echo $result['ist5']; ?></td>
                                        <td align="center">
                                            <?php 
                                                $ist3 = $this->norma_model->norma_convert('ist3', $result['ist5']);
                                                echo $ist3['ws'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $this->norma_model->norma_flag($ist3['flag'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>GE</th>
                                        <td>Abstract Reasoning</td>
                                        <td align="center"><?php echo $result['ist6']; ?></td>
                                        <td align="center">
                                            <?php 
                                                $ist4 = $this->norma_model->norma_convert('ist4', $result['ist6']);
                                                echo $ist4['ws'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $this->norma_model->norma_flag($ist4['flag'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>RA</th>
                                        <td>Numerical Reasoning</td>
                                        <td align="center"><?php echo $result['ist7']; ?></td>
                                        <td align="center">
                                            <?php 
                                                $ist5 = $this->norma_model->norma_convert('ist5', $result['ist7']);
                                                echo $ist5['ws'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $this->norma_model->norma_flag($ist5['flag'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ZR</th>
                                        <td>Analogical Thinking</td>
                                        <td align="center"><?php echo $result['ist8']; ?></td>
                                        <td align="center">
                                            <?php 
                                                $ist6 = $this->norma_model->norma_convert('ist6', $result['ist8']);
                                                echo $ist6['ws'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $this->norma_model->norma_flag($ist6['flag'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>FA</th>
                                        <td>Synthetical Thinking</td>
                                        <td align="center"><?php echo $result['ist9']; ?></td>
                                        <td align="center">
                                            <?php 
                                                $ist7 = $this->norma_model->norma_convert('ist7', $result['ist9']);
                                                echo $ist7['ws'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $this->norma_model->norma_flag($ist7['flag'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>WU</th>
                                        <td>Analithical Thinking</td>
                                        <td align="center"><?php echo $result['ist10']; ?></td>
                                        <td align="center">
                                            <?php 
                                                $ist8 = $this->norma_model->norma_convert('ist8', $result['ist10']);
                                                echo $ist8['ws'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $this->norma_model->norma_flag($ist8['flag'])?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ME</th>
                                        <td>Memorical Reasoning</td>
                                        <td align="center"><?php echo $result['ist11']; ?></td>
                                        <td align="center">
                                            <?php 
                                                $ist9 = $this->norma_model->norma_convert('ist9', $result['ist11']);
                                                echo $ist9['ws'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $this->norma_model->norma_flag($ist9['flag'])?>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>JUMLAH</th>
                                        <th>IQ</th>
                                        <th align="center">
                                            <?php
                                                $total =  $result['ist3'] + $result['ist4'] + $result['ist5'] + $result['ist6'] + $result['ist7'] + $result['ist8'] + $result['ist9'] + $result['ist10'] + $result['ist11'];
                                                echo $total;												
                                            ?>
                                        </th>
                                        <th align="center">
                                            <?php
                                                $total =  $result['ist3'] + $result['ist4'] + $result['ist5'] + $result['ist6'] + $result['ist7'] + $result['ist8'] + $result['ist9'] + $result['ist10'] + $result['ist11'];
												//$total_i=$this->norma_model->norma_iq_score($total);
                                                if ($total_i=$this->norma_model->norma_iq_score($total)) {
													echo $total_i;
												} else {
													echo "?";
                                                }													
													
												
                                            ?>
                                        </th>
                                        <th>
                                            <?php 
											 //echo $result['total'] . "|";
											 //echo $this->norma_model->norma_iq_score($result['total']) . "|"; 
											 //echo $this->norma_model->norma_iq($result['total']);
											 echo $this->norma_model->norma_iq($total);?>
											
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                }
            ?>
        </div>
    </div>
</div>