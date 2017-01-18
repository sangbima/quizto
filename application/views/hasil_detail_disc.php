<div class="container">
     <div class="row">
`            <?php 
                $logged_in=$this->session->userdata('logged_in');
            ?>
            <?php 
                if($logged_in['su']=='1'){
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
            </div>
            <div class="row">
                <div class="col-md-12">
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