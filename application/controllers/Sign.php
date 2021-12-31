<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign extends CI_Controller {

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
		$this->load->view('login');
	}
	public function in()
	{
		//login
		$uid=$this->input->post("uid");
		$upwd=md5($this->input->post("upwd"));
		$sql="select * from t_users where uid='$uid' and upwd='$upwd'";
		$usr=$this->db->query($sql)->result_array();
		if(count($usr)>0){
			if($usr[0]['uid']==$uid && $usr[0]['upwd']==$upwd){
				$this->session->set_userdata('user_data',$usr[0]);
				redirect(base_url()."welcome/home");
			}
		}
		$data["uid"]=$uid;
		$data["upwd"]=$this->input->post("upwd");
		$data["script"]="Swal.fire({icon: 'error',text: 'Wrong ID or Password'});";
		$this->load->view('login',$data);
	}
	public function out($re=0)
	{
		//logout
		session_destroy();
		$msg=$re==0?"Logged out":"Session closed, please login";
		$ico=$re==0?"success":"error";
		$data["script"]="Swal.fire({icon: '$ico',text: '$msg'});";
		$this->load->view('login',$data);
	}
	public function pwd()
	{
		$ret=array('msgs'=>'Session expired, please re-login','type'=>'error','head'=>'');
		
		//chgpwd
		$opwd=md5($this->input->post("opwd"));
		$npwd=md5($this->input->post("npwd"));
		$usr=$this->session->userdata('user_data');
		if(isset($usr)){
			$rowid=$usr['rowid'];
			$sql="update t_users set upwd='$npwd' where rowid=$rowid and upwd='$opwd'";
			$ok=$this->db->query($sql);
			if($ok){
				if($this->db->affected_rows()>0){
					$ret=array('msgs'=>'Password changed','type'=>'success','head'=>'');
				}else{
					$ret=array('msgs'=>'Invalid old password','type'=>'error','head'=>'');
				}
			}else{
				$ret=array('msgs'=>'Failed','type'=>'error','head'=>'');
			}
		}
		echo json_encode($ret);
	}
}