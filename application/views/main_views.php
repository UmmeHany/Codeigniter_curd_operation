<!DOCTYPE html>
<html>
<head>
	<title>My view</title>
</head>
<body>
             <h1>welcomr to my viewpage</h1>>

             <br />
             
             <br /> 
             
             <br /> 
             

<div  class="table-responsive">
	<table class="table table-bordered">
		
       <tr>
       	<th>ID</th>
       	<th>Name</th>





       </tr>>



	</table>

<?php  

if($fetch_data->num_rows()>0){

	foreach ($fetch_data->result() as  $row) {
?>
		<tr>

         <td><?php  echo $row->ID  ?>   </td>
         <td><?php  echo $row->Name  ?>   </td>


		</tr>

<?php
		
	}
}

?>






</div>





</body>
</html>>