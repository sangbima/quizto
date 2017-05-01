
<div class="container">
  <div class="row">

<div class="panel panel-default">   
    <div class="panel-heading">
	   <?php
	   echo $list['0']['fullname'] ;	   
		?>
	</div>
    <table class="table table-condensed table-hover" id="table-hasil">
                <thead>
                    <tr>
					    <th> # </th>
					    <th>Category</th>
						
                    </tr>					
				</thead>	


<?php 
   foreach ($list as $key => $value) {
      echo "<tr>";          
	  echo "  <td>" . ($key+1) . "</td>";	   	   
	  echo "  <td><a href=\"" . site_url('nhasil/quiz_list_by_time/' . $value['uid'] . "/" .$value['cid'] ) . "\">" . $value['category_name'] . "</a></td>";
	   echo "</tr>"; 
   } 
   
   
   
?>

   </table>
</div> 
</div>
</div>