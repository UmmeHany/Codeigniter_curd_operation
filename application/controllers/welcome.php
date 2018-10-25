<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		//$data["t1"]="bula";
		//$data["t2"]="parvez";
         $this->load->model('main_model');
		$data["fetch_data"]=$this->main_model->fetch_data();

		$this->load->view('main_views',$data);

		//$this->load->model('main_model');

	}

	public function myindex()
	{
		echo "test";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */