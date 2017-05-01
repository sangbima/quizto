<div class="container">
  <div class="row">

<div class="panel panel-default">   
 <div class="panel-heading">
	   <?php
	   echo  "<a href=\"" .  site_url('nhasil/answer/'.$list[0]['uid']) . "\">" . $list[0]['fullname'] . "</a> >> " . 
	        "<a href=\"" . site_url('nhasil/quiz_list_by_time/' . $list[0]['uid'] . "/" .$list[0]['cid'] ) . "\">" . $list[0]['category_name'] . "</a> >> " .
			 $list['0']['start_time'];
		?>
	</div>
    <table class="table table-condensed table-hover"  id="table-hasil">
                <thead>
                    <tr>
					    <th> # </th>
					    <th>qid</th>						
						<th>Mulai</th>
						<th>Selesai</th>						
						<th>Waktu</th>
						<th>Nilai</th>
						<th>Pertanyaan</th>						
						<th>Status</th>
                    </tr>					
				</thead>	
				<tbody>
<?php 
   $time_in_secs=explode(",",$list[0]['individual_time']);
   $total_score=0;
   $i_time=0;
   
   $t_failed=0;
   $t_success=0;
   foreach ($list as $key => $value) {
	  $individual_start = $value['start_time'] + $i_time; 
	  $individual_submit = $individual_start + $time_in_secs[$key];
	   	  
	  $i_time+=$time_in_secs[$key];
	  $t_count= count($time_in_secs);
	  
	 	  
	  
	  if ($value['status']=="error") {
           $tb_class=" class=\"bg-warning text-info\"";	
           ++$t_failed;   		   
	  } else {
		   ++$t_success;
		   $tb_class="";		 
	  } 	  
	  
	  
	  echo "<tr" . $tb_class .">";          
	  echo "  <td>" . ($key +1). "</td>";
	  echo "   <td>" . $value['qid'] . "</td>" ;
	  echo "   <td>" . date("d/m/Y \(H:i:s\)", $individual_start). "</td>" ;
	  echo "   <td>" . date("d/m/Y \(H:i:s\)", $individual_submit) . "</td>" ;	  
	  echo "   <td>" . $time_in_secs[$key] . "</td>";
      echo "   <td>" . $value['score_u'] . "</td>";	  	  
	  echo "   <td>" . $value['question']. "</td>" ;
	  echo "   <td>".  $value['status']. "</td>" ;
	  echo "</tr>";
	  
	  if ($value['score_u'] == 1) {
		  ++$total_score;
	  }	  
   } 	  
?>
     </tbody>
   </table>
</div> 

<div class="panel panel-default">
     <div class="panel-body">
	     Total Pertanyaan  : <?php echo $t_count;?></br>
		 Total Berhasil    : <?php echo $t_success; ?></br>
		 Total Gagal       : <?php echo $t_failed;?><br>
	     Total Waktu       : <?php echo $i_time; ?> secs</br>
	     Total Nilai       : <?php echo $total_score;?></br>
		 
	 </div>
</div>
</div>
</div>