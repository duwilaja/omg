<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bgjob extends CI_Controller {
	//private $link="http://mp.omgdemo.website";
	private $link="http://10.22.194.61";
	
	public function index()
	{
	}
	private function notif($s,$u,$l,$h){
		$br="<br />";
		$task=count($l)==1?"task":"tasks";
		$m="This is a reminder that the following outstanding $task in MdS require your attention.$br $h : $br".implode($br,$l)."
		$br $br Please <a href='".$this->link."'>click here</a> to log into MdS to review and approve the outstanding.$br";
		//echo $m;
		return $this->mydb->notify(array("assignedto"=>$u,"taskname"=>$t,"msgs"=>$m));
	}
	public function sch_notif()
	{
		if(is_cli()){
			
			$this->load->model("mydb");
			$sql="select approver as u, count(approver) as c  from t_mediaplans where stts='Pending Approval' group by approver";
			$sql="select approver as u, mpnumber as n from t_mediaplans where stts='Pending Approval' order by approver, submitdt";
			$lst=$this->db->query($sql)->result_array();
			$mpn=array(); $u="";
			for($i=0;$i<count($lst);$i++){
				$d=$lst[$i];
				if($u!=$d['u']){
					if($u!=''){
						$msgs=$this->notif("Mediaplan Approval",$u,$mpn,"MP#");
						$mpn=array();
					}
					$u=$d["u"];
				}
				$mpn[]=$d["n"];
			}
			if($u!="" && count($mpn)>0) $msgs=$this->notif("Mediaplan Approval",$u,$mpn,"MP#");
			
			$sql="select ss as u, count(ss) as c  from t_invoices where ssattc='' or ssattc is null group by ss";
			$sql="select ss as u, invno as v  from t_invoices where ssattc='' or ssattc is null order by ss,lastupd";
			$lst=$this->db->query($sql)->result_array();
			$ivn=array();$u="";
			for($i=0;$i<count($lst);$i++){
				$d=$lst[$i];
				if($u!=$d['u']){
					if($u!=''){
						$msgs=$this->notif("Screenshot Upload",$u,$ivn,"Vendor Invoice#");
						$ivn=array();
					}
					$u=$d["u"];
				}
				$ivn[]=$d["v"];
			}
			if($u!="" && count($ivn)>0) $msgs=$this->notif("Screenshot Upload",$u,$ivn,"Vendor Invoice#");
			
		}//end if is_cli
	}
	
}