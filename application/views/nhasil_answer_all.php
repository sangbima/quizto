<div class="container">
  <div class="row">

<div class="panel panel-default">   
   <div class="panel-heading">
	   <?php
	    echo "<a href=\"" .  site_url('nhasil/answer/'.$list[0]['uid']) . "\">" . $list['0']['fullname'] . "</a> >> " .           
		    " <a href=\"" . site_url('nhasil/quiz/' . $list[0]['uid'] . "/" . $list[0]['cid'] ) . "\">" . $list[0]['category_name'] . "</a>" .			
		    " >> " .
		    $list['0']['qid'];
		?>
	</div>
    <table class="table table-condensed table-hover" id="table-hasil">
                <thead>
                    <tr>
					    <th> # </th>
					    <th>aid</th>
					    <th>score_u</th>						
						<th>start_time</th>
                        <th>individual_time</th>						
                    </tr>					
				</thead>	
<?php 
   foreach ($list as $key => $value) {
	   
	  echo "<tr>";          
	  echo "  <td>" . $key . "</td>";
	  echo "   <td>" . $value['aid'] . "</td>" ;
	  echo "   <td>" . $value['score_u']. "</td>" ;
	  echo "   <td>" . $value['start_time']. "</td>" ;	
	  echo "   <td>" . $value['individual_time']. "</td>" ;		  
	  echo "</tr>";
   } 
      
?>
   </table>
</div> 
</div>
</div>

