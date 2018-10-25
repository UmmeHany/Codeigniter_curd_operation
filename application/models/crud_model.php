<?php
 class Crud_model extends CI_Model  
 {  
      
      var $select_column = array("name","b_name","m_name","item_id","date_added");  

       var $select_column1 = array("brand_id","model_id");  
       
      function make_query()  
      {  
          

          $this->db->select($this->select_column);

$this->db->from('items');

$this->db->join('brands','items.brand_id = brands.brand_id');
$this->db->join('models','models.brand_id = brands.brand_id');

            
            
            
      } 


      function make_datatables(){  
           $this->make_query();  
           
           $query = $this->db->get(); 
         //  $query->result_array();
          // print_r($query->result_array()); 
           //
           return $query->result();  
      }  



      function deleteItem(){
        $id = $this->input->get('id');

        $this->db->select($this->select_column1);
$this->db->from("items");
$this->db->where('item_id',$id);
$query1 = $this->db->get();
    
    

   
    



$b_id="";
$m_id="";
foreach ($query1->result() as $row)
{
  $b_id=$row->brand_id;
$m_id=$row->model_id;
   
}




$this->db->where('brand_id', $b_id);
    $this->db->delete('brands');

    $this->db->where('model_id', $m_id);
    $this->db->delete('models');

    $this->db->where('item_id', $id);
    $this->db->delete('items');

    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }


  public function addItem(){
    $field = array(
      'item_id'=>$this->input->post('txtItemID'),
      'name'=>$this->input->post('txtItemName'),
      'brand_id'=>$this->input->post('txtBrandID'),
      
      'model_id'=>$this->input->post('txtModelID')
      
      
      );

    $field1=array(
     'brand_id'=>$this->input->post('txtBrandID'),
    'b_name'=>$this->input->post('txtBrandName')
    
  );

    $field2=array(
     'brand_id'=>$this->input->post('txtBrandID'),
    'model_id'=>$this->input->post('txtModelID'),
    'm_name'=>$this->input->post('txtModelName')
    
  );


    


    $this->db->insert('items', $field);
    $this->db->insert('brands', $field1);
    $this->db->insert('models', $field2);

    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }


     
function insert_crud($insert_data,$insertb_data,$insertm_data)  
      {  
           $this->db->insert('items',$insert_data);  
           $this->db->insert('brands',$insertb_data);  
           $this->db->insert('models',$insertm_data);  
      }  

      


 }

 ?> 
