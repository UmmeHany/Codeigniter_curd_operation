<?php  

class Main_model extends CI_Model{

function test_main(){



	echo "this is model function";
}


function fetch_data(){

$query= $this->db->get("user");
//select * from user table
return $query;
}




}






?>