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
					    <th>qid</th>
						<th>question</th>
                    </tr>					
				</thead>	
<?php 
   foreach ($list as $key => $value) {
	   
	  echo "<tr>";          
	  echo "  <td>" . $key . "</td>";
	  echo "   <td><a href=\"" . site_url('nhasil/quiz_all/' . $value['uid'] . "/" .$value['cid']  . "/" . $value['qid']) . "\">" . $value['qid'] . "</a></td>" ;
	  echo "   <td>" . $value['question']. "</td>" ;	  	        
	  echo "</tr>";
   } 
      
?>
   </table>
</div> 
</div>
</div>