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
                        <div class="panel-heading"><i class="fa fa-user"></i> Detail Peserta <a href="<?php echo site_url('hasil/download/default_detail/'. $user['uid']);?>" title="Export ke Excel" class="btn btn-primary pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a></div>
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
                            <!-- <tr>
                                <th>TPU</th>
                                <td><?php //echo $tputpa; ?></td>
                            </tr>
                            <tr>
                                <th>TPA</th>
                                <td><?php //echo $tputpa; ?></td>
                            </tr> -->
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading"><i class="fa fa-bar-chart"></i> TPU/TPA</div>
                        <table class="table table-bordered table-condensed">
                            <tr>
                                <th>TPU</th>
                                <td><?php echo $result['ist1'] ? $result['ist1'] : 0; ?></td>
                            </tr>
                            <tr>
                                <th>TPA</th>
                                <td><?php echo $result['ist2'] ? $result['ist2'] : 0; ?></td>
                            </tr>
                        </table>
                    </div>
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
                                                $total_i = $this->norma_model->norma_iq_score($total);
                                            ?>
                                        </th>
                                        <th>
                                            <?php echo $this->norma_model->norma_iq($total)?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading"><i class="fa fa-bar-chart"></i> D I S C Profile</div>
                        <div class="panel-body">
                            <table class="table table-hover table-condensed" id="table-detail-disc">
                                <thead>
                                   <tr>
                                        <th></th>
                                        <th align="center">D</th>
                                        <th align="center">I</th>
                                        <th align="center">S</th>
                                        <th align="center">C</th>
                                        <th align="center">X</th>
                                        <th align="center">SUM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>MOST</th>
                                        <td align="center"><?php echo $disc_m['d'] ?></td>
                                        <td align="center"><?php echo $disc_m['i'] ?></td>
                                        <td align="center"><?php echo $disc_m['s'] ?></td>
                                        <td align="center"><?php echo $disc_m['c'] ?></td>
                                        <td align="center"><?php echo $disc_m['x'] ?></td>
                                        <td align="center"><?php echo $disc_m['t'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>LEAST</th>
                                        <td align="center"><?php echo $disc_l['d'] ?></td>
                                        <td align="center"><?php echo $disc_l['i'] ?></td>
                                        <td align="center"><?php echo $disc_l['s'] ?></td>
                                        <td align="center"><?php echo $disc_l['c'] ?></td>
                                        <td align="center"><?php echo $disc_l['x'] ?></td>
                                        <td align="center"><?php echo $disc_l['t'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>CHANGE</th>
                                        <td align="center"><?php echo $disc_m['d'] - $disc_l['d'] ?></td>
                                        <td align="center"><?php echo $disc_m['i'] - $disc_l['i'] ?></td>
                                        <td align="center"><?php echo $disc_m['s'] - $disc_l['s'] ?></td>
                                        <td align="center"><?php echo $disc_m['c'] - $disc_l['c'] ?></td>
                                        <td align="center"><?php echo $disc_m['x'] - $disc_l['x'] ?></td>
                                        <td align="center"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading"><i class="fa fa-bar-chart"></i> Most Graph</div>
                                        <div class="panel-body">
                                            <canvas id="mostGraph" width="300" height="200"></canvas>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#mostModal">Norma</button>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading"><i class="fa fa-bar-chart"></i> Least Graph</div>
                                        <div class="panel-body">
                                            <canvas id="leastGraph" width="300" height="200"></canvas>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#leastModal">Norma</button>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading"><i class="fa fa-bar-chart"></i> Change Graph</div>
                                        <div class="panel-body">
                                            <canvas id="changeGraph" width="300" height="200"></canvas>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#changeModal">Norma</button>
                                </div>
                            </div>
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

<!-- Most Modal -->
<div class="modal fade" id="mostModal" tabindex="-1" role="dialog" aria-labelledby="mostModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <?php echo $mscale['norma']?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Least Modal -->
<div class="modal fade" id="leastModal" tabindex="-1" role="dialog" aria-labelledby="leastModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <?php echo $lscale['norma']?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Change Modal -->
<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <?php echo $cscale['norma']?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url('js/chart.bundle.min.js');?>"></script>
<script>
const MCHART = document.getElementById("mostGraph");
const LCHART = document.getElementById("leastGraph");
const GCHART = document.getElementById("changeGraph");

let mlineChart = new Chart(MCHART, {
    type: 'line',
    data: {
        labels: <?php print_r (json_encode($mscale['label']))?>,
        datasets: [
            {
                label: "<?php echo $mscale['value']?>",
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10,
                data: <?php print_r (json_encode($mscale['data']))?>,
                spanGaps: false,
            }
        ]
    }
})
let llineChart = new Chart(LCHART, {
    type: 'line',
    data: {
        labels: <?php print_r (json_encode($lscale['label']))?>,
        datasets: [
            {
                label: "<?php echo $lscale['value']?>",
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10,
                data: <?php print_r (json_encode($lscale['data']))?>,
                spanGaps: false,
            }
        ]
    }
})
let glineChart = new Chart(GCHART, {
    type: 'line',
    data: {
        labels: <?php print_r (json_encode($cscale['label']))?>,
        datasets: [
            {
                label: "<?php echo $cscale['value']?>",
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 3,
                pointHitRadius: 10,
                data: <?php print_r (json_encode($cscale['data']))?>,
                spanGaps: false,
            }
        ]
    }
})
</script>