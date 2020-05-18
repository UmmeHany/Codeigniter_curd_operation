<?php  

  defined('BASEPATH') OR exit('No direct script access allowed');  

  class Crud extends CI_Controller {  
   
    function index(){  
      $data["title"] = "Codeigniter Project";  
      $this->load->view('crud_view', $data);  
    } 


    function fetch_user(){  
      $this->load->model("crud_model");  
      $fetch_data = $this->crud_model->make_datatables();  
      echo json_encode($fetch_data);  
    }  


    function addItem(){

      $this->load->model("crud_model");

      $result = $this->crud_model->addItem();
      $msg['success'] = false;
      $msg['type'] = 'add';

        if($result){
          $msg['success'] = true;
        }
      echo json_encode($msg);
    }

    function deleteItem(){
      $this->load->model("crud_model"); 

      $result = $this->crud_model->deleteItem();
      $msg['success'] = false;

        if($result){
          $msg['success'] = true;
        }
      echo json_encode($msg);
    }
  
  }

?> 
