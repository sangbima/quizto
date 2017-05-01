<div class="container">
  <div class="row">

<div class="panel panel-default">   
 <div class="panel-heading">
	   <?php
	   echo  "<a href=\"" .  site_url('nhasil/answer/'.$list[0]['uid']) . "\">" . $list['0']['fullname'] . "</a> >> " . $list['0']['category_name'];
		?>
	</div>
    <table class="table table-condensed table-hover" id="table-hasil">
                <thead>
                    <tr>
					    <th> # </th>
					    <th>Mulai</th>
						<th>Kategori</th>
                    </tr>					
				</thead>	
				<tbody>
<?php 
   
   foreach ($list as $key => $value) {
	   
	  echo "<tr>";          
	  echo "  <td>" . ($key+1) . "</td>";
	  echo "   <td><a href=\"" . site_url('nhasil/quiz_answer_disc_all_by_time/' . $value['uid'] . "/" .$value['cid']  . "/" . $value['start_time']) . "\">" .date("d/m/Y \(H:i:s\)", $value['start_time']) . "</a></td>" ;	    	  
	  echo "   <td>" . $value['category_name']. "</td>" ;	  	        
	  echo "</tr>";
   } 
      
?>
     </tbody>
   </table>
   
   
</div> 
</div>
</div>