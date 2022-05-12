<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$data['t_users'] = $this->db->query("select * from t_users")->result_array();
		//$this->load->view('welcome_message',$data);
		$this->load->view('login');
	}
	
	public function home()
	{
		$usr=$this->session->userdata('user_data');
		if(isset($usr)){
			$data["session"]=$usr;
			$this->load->model("mydb");
			$data["tot"]=$this->mydb->gettot($usr);
			//$data["pie1"]=$this->mydb->getpie1();
			//$data["line1"]=$this->mydb->getline1();
			$data['pending']=$this->mydb->getlist($usr,'Pending Approval');
			$data['ongoing']=$this->mydb->getlist($usr,'Rejected');
			$sspending=$this->mydb->getsstot($usr,"'ss_pending'","ssattc=''");
			$sscomplet=$this->mydb->getsstot($usr,"'ss_completed'","ssattc<>''");
			$data['totss']=array_merge($sspending,$sscomplet);
			$this->load->view('home',$data);
		}else{
			redirect(base_url()."sign/out/1");
		}
	}
	
	public function debugmail(){
		$this->load->model("mydb");
		$data['msg']=$this->mydb->debugmail('smart.mgmt.mmt@gmail.com','Test Mail','This is the content.');
		$this->load->view("debugmail",$data);
	}
}
