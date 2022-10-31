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
			
			$data["tot"]=$this->gettot($usr);
			$data['pending']=$this->getlist($usr,"pending");//usr,creatorstat,apprstat/ adm all;
			$data['ongoing']=$this->getlist($usr,"ongoing");
			
			$sspending=$this->getsstot($usr,"'ss_pending'","ssattc=''");
			$sscomplet=$this->getsstot($usr,"'ss_completed'","ssattc<>''");
			$data['totss']=array_merge($sspending,$sscomplet);
			$this->load->view('home',$data);
		}else{
			redirect(base_url()."sign/out/1");
		}
	}
	
	public function gettot($usr){
		$where=$usr["uaccess"]=="ADM"?"":" where creator='".$usr["uid"]."' or approver='".$usr["uid"]."'";
		$sql="select creator,stts,count(rowid) as cnt from t_mediaplans $where group by creator,stts";
		$rs=$this->db->query($sql)->result_array();
		$tot=array("ongoing"=>0,"pending"=>0,"completed"=>0);
		foreach($rs as $row){
			if($row["stts"]=="Approved"){ $tot["completed"]+=$row["cnt"]; }
			if($usr["uaccess"]=="ADM"){
				switch($row["stts"]){
					case "Pending Approval": $tot["pending"]+=$row["cnt"]; break;
					case "Rejected": $tot["ongoing"]+=$row["cnt"]; break;
					case "Changed": $tot["ongoing"]+=$row["cnt"]; break;
				}
			}else{
				if($usr["uid"]==$row["creator"]){
					switch($row["stts"]){
						case "Pending Approval": $tot["ongoing"]+=$row["cnt"]; break;
						case "Rejected": $tot["pending"]+=$row["cnt"]; break;
						case "Changed": $tot["pending"]+=$row["cnt"]; break;
					}
				}else{
					switch($row["stts"]){
						case "Pending Approval": $tot["pending"]+=$row["cnt"]; break;
						case "Rejected": $tot["ongoing"]+=$row["cnt"]; break;
						case "Changed": $tot["ongoing"]+=$row["cnt"]; break;
					}
				}
			}
		}
		
		return $tot;
	}
	public function getlist($usr,$which=""){
		if($usr["uaccess"]=="ADM"){
			$where=$which=="ongoing"?"stts in ('Rejected','Changed')":" stts in ('Pending Approval')";
		}else{
			if($which=="pending"){
				$where=" (creator='".$usr["uid"]."' and stts in ('Rejected','Changed')) or (approver='".$usr["uid"]."' and stts in ('Pending Approval'))";
			}else{
				$where=" (approver='".$usr["uid"]."' and stts in ('Rejected','Changed')) or (creator='".$usr["uid"]."' and stts in ('Pending Approval'))";
			}
		}
		$sql="select mpnumber,client,product,stts,approver from t_mediaplans where $where order by lastupd";
		$rs=$this->db->query($sql)->result_array();
		return array_slice($rs,0,5);
	}
	
	public function getsstot($usr,$g,$w){
		$where=$usr["uaccess"]=="ADM"?"":" and ss='".$usr["uid"]."'";
		$sql="select $g  as stts,count(rowid) as cnt from t_invoices where $w $where";
		$rs=$this->db->query($sql)->result_array();
		return $rs;
	}
	
	public function debugmail(){
		$this->load->model("mydb");
		$data['msg']=$this->mydb->debugmail('smart.mgmt.mmt@gmail.com','Test Mail','This is the content.');
		$this->load->view("debugmail",$data);
	}
}
