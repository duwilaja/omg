<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bgjob extends CI_Controller {
	
	public function index()
	{
	}
	public function sch_notif()
	{
		if(is_cli()){
		
		$this->load->model("mydb");
		$sql="select approver as u, count(approver) as c  from t_mediaplans where stts='Pending Approval' group by approver";
		$lst=$this->db->query($sql)->result_array();
		for($i=0;$i<count($lst);$i++){
			$br="<br />";
			$d=$lst[$i];
			$be=$d["c"]=="1"?"is":"are";
			$task=$d["c"]=="1"?"task":"tasks";
			$m="This is a reminder that there $be ".$d["c"]." outstanding $task in MdS that require your attention.$br 
			Please log into MdS to review and approve the outstanding.$br";
			//echo $m;
			$msgs=$this->mydb->notify(array("assignedto"=>$d["u"],"taskname"=>"Mediaplan Approval","msgs"=>$m));
		}
		$sql="select ss as u, count(ss) as c  from t_invoices where ssattc='' or ssattc is null group by ss";
		$lst=$this->db->query($sql)->result_array();
		for($i=0;$i<count($lst);$i++){
			$br="<br />";
			$d=$lst[$i];
			$be=$d["c"]=="1"?"is":"are";
			$task=$d["c"]=="1"?"task":"tasks";
			$m="This is a reminder that there $be ".$d["c"]." outstanding $task in MdS that require your attention.$br 
			Please log into MdS to complete the outstanding.$br";
			//echo $m;
			$msgs=$this->mydb->notify(array("assignedto"=>$d["u"],"taskname"=>"Screenshot Upload","msgs"=>$m));
		}
		
		}//end if is_cli
	}
	
}