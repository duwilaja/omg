<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mydb extends CI_Model {
	
	public function esc($str){
		return str_replace("'","''",$str);
	}
	
	public function error($err){
		$msgs=$msgs='Error '.$err['code'].': '.$err['message'];
		if($err['code']==23000) $msgs='Error '.$err['code'].': Duplicate ID';//$err['message'];
		
		return $msgs;
	}
	
	public function insert_string($tab,$data)
	{
		$flds=array();
		$vals=array();
		foreach($data as $key=>$value){
			$flds[]=$key;
			$vals[]="'".$this->esc($value)."'";
		}
		$sql="INSERT INTO $tab (".implode(",",$flds).") VALUES (".implode(",",$vals).")";
		return $sql;
	}

	public function update_string($tab,$data,$where)
	{
		$where=$where==''?'1=0':$where;
		$upd=array();
		foreach($data as $key=>$value){
			$upd[]=$key."='".$this->esc($value)."'";
		}
		$sql="UPDATE $tab SET ".implode(",",$upd)." WHERE $where";
		return $sql;
	}
	
	public function rowid($t,$f,$v){
		$rs=$this->db->query("select rowid from $t where $f='$v'")->result_array();
		if(count($rs)>0){
			return $rs[0]['rowid'];
		}else{
			return "0";
		}
	}
	
	public function ctask($id,$dt){
		$sql=""; $msg="Task ID: $id not found";
		switch($id){
			case "create_mp": //create mp
					$data = array("taskid"=>$id,"taskname"=>"Create Media Plan", "dtm"=>$dt["lastupd"], "assignedby"=>"system", 
					"assignedto"=>$dt["updby"], "objname"=>"Media Plan", "objid"=>$dt["mpnumber"], "tname"=>"t_mediaplans",
					"trowid"=>$this->rowid('t_mediaplans','mpnumber',$dt["mpnumber"]),
					"lastupd"=>$dt["lastupd"], "updby"=>"system", "stts"=>"Ongoing", "nexttask"=>"approve_mp");
					$sql = $this->insert_string("t_tasks",$data);
					break;
			case "approve_mp": //approve mp
					$data = array("taskid"=>$id,"taskname"=>"Approve Media Plan", "dtm"=>$dt["lastupd"], "assignedby"=>$dt["updby"], 
					"assignedto"=>$dt["assignedto"], "objname"=>"Media Plan", "objid"=>$dt["objid"], "tname"=>"t_mediaplans",
					"trowid"=>$this->rowid('t_mediaplans','mpnumber',$dt["objid"]),
					"lastupd"=>$dt["lastupd"], "updby"=>"system", "stts"=>"Ongoing", "nexttask"=>"");
					$sql = $this->insert_string("t_tasks",$data);
					break;
		}
		if($sql!=""){
			$this->db->query($sql);
			if($this->db->affected_rows()>0) {
				$msg=". Task created.";
				$msg.=$this->notify($data);
			}else{
				$msg=". Failed creating task ".$data["taskname"];
			}
		}else{
			if($dt['nexttask']=="") $msg="";
		}
		return $msg;
	}
	private function notify($dt){
		$rs=$this->db->query("select umail,uname from t_users where uid='".$dt["assignedto"]."'")->result_array();
		if(count($rs)>0){
			$to = trim($rs[0]['umail']);
			if($to!=""){
				$br="<br />";
				$sub= "[ODS Notification] : ".$dt["taskname"];
				$msg= "Dear ".$rs[0]["uname"]."$br $br";
				$msg.="A task '".$dt["taskname"]."' has been created and assigned to your account. $br Kindly need your response as soon as possible. $br $br";
				$msg.="Regards, $br ODS Admin";
				$sent=$this->sendmail($to,$sub,$msg);
				if($sent){
					return "Notification sent to $to";
				}else{
					return "Failed sending mail to $to";
				}
			}else{
				return "User ".$dt["assignedto"]." doesn't have mail address";
			}
		}else{
			return "User ".$dt["assignedto"]." not found";
		}
	}
	public function sendmail($to,$sub,$msg){
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'smart.mgmt.mmt@gmail.com',
			'smtp_pass' => 'Smart@solo2k21',
			'smtp_timeout' => 15,
			'mailtype'  => 'html', 
			'charset'   => 'utf-8'
		);
		$this->load->library('email', $config);
		
		$this->email->from($config['smtp_user'], 'ODS Admin');
		$this->email->to($to);
		$this->email->subject($sub);
		$this->email->message($msg);
		
		return $this->email->send();
	}
}