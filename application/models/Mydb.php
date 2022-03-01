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
	
	public function notify($dt){
		$rs=$this->db->query("select umail,uname from t_users where uid='".$dt["assignedto"]."'")->result_array();
		if(count($rs)>0){
			$to = trim($rs[0]['umail']);
			if($to!=""){
				$br="<br />";
				$sub= "[MdS Notification] : ".$dt["taskname"];
				$msg= "Dear ".$rs[0]["uname"]."$br $br";
				$msg.=$dt["msgs"];
				$msg.=" $br $br Regards, $br MdS Admin";
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
			'smtp_host' => 'ssl://mail.omgdemo.website',
			'smtp_port' => 465,
			'smtp_user' => 'omg@omgdemo.website',
			'smtp_pass' => '0mGbanget',
			'smtp_timeout' => 15,
			'mailtype'  => 'html', 
			'charset'   => 'utf-8'
		);
		$this->load->library('email', $config);
		
		$this->email->from($config['smtp_user'], 'MdS Admin');
		$this->email->to($to);
		$this->email->subject($sub);
		$this->email->message($msg);
		
		return $this->email->send();
	}
	public function debugmail($to,$sub,$msg){
		$debug = '';
		require_once(APPPATH."third_party/phpmailer/PHPMailerAutoload.php");
        $mail = new PHPMailer;
		$mail->SMTPDebug = 2;
		$mail->Debugoutput = function($str, $level) {
								$GLOBALS['debug'] .= "$level: $str <br />";
							};
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = 'smtp.yandex.com';
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = 'omg.demo.app@yandex.com';
		$mail->Password = 'dknhlkohqftrcbki';
		$mail->setFrom('omg.demo.app@yandex.com', 'MdS Admin');
		$mail->addAddress($to);
		$mail->Subject = $sub;
		$mail->Body = $msg;
		$mail->send();
		
		return $debug;
	}
	
	public function gettot($usr){
		$where=$usr["uaccess"]=="ADM"?"":" where creator='".$usr["uid"]."' or approver='".$usr["uid"]."'";
		$sql="select stts,count(*) as cnt from t_mediaplans $where group by stts";
		$rs=$this->db->query($sql)->result_array();
		return $rs;
	}
	public function getlist($usr,$stts=""){
		$where=$usr["uaccess"]=="ADM"?"":" and (creator='".$usr["uid"]."' or approver='".$usr["uid"]."')";
		$sql="select mpnumber,client,product,stts,approver from t_mediaplans where stts='$stts' $where order by lastupd";
		$rs=$this->db->query($sql)->result_array();
		return array_slice($rs,0,5);
	}
	
	public function getsstot($usr,$g,$w){
		$where=$usr["uaccess"]=="ADM"?"":" and ss='".$usr["uid"]."'";
		$sql="select $g  as stts,count(*) as cnt from t_invoices where $w $where";
		$rs=$this->db->query($sql)->result_array();
		return $rs;
	}
}
