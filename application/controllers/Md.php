<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Md extends CI_Controller {

	public function index()
	{
		$usr=$this->session->userdata('user_data');
		if(isset($usr)){
			$view=$this->input->get("p");
			$data["session"]=$usr;
			$this->load->view($view,$data);
		}else{
			redirect(base_url()."sign/out/1");
		}
	}
	
	public function datatable()
	{
		$usr=$this->session->userdata('user_data');
		$data=array();
		if(isset($usr)){
			$sql=base64_decode($this->input->post("s"));
			$res=$this->db->query($sql)->result_array();
			for($i=0;$i<count($res);$i++){
				$dum=array_values($res[$i]);
				$rowid=$res[$i]['rowid'];
				$dum[0]='<a href="#" onclick="openf('.$rowid.')">'.$dum[0].' </a>';
				$data[]=$dum;
			}
		}
		$out=array('data'=>$data);
		echo json_encode($out);
	}
	
	public function get()
	{
		$usr=$this->session->userdata('user_data');
		$data=array();$cod='500';
		if(isset($usr)){
			$c=base64_decode($this->input->post("c"));
			$c=$c==''?'*':$c;
			$sql="select $c from ".base64_decode($this->input->post("t"))." where rowid=".$this->input->post("id");
			$data=$this->db->query($sql)->result_array();
			$cod='200';
		}
		$ret=array('code'=>$cod,'data'=>$data);
		echo json_encode($ret);
	}
	
	public function gets()
	{
		$usr=$this->session->userdata('user_data');
		$data=array();
		if(isset($usr)){
			$c=base64_decode($this->input->post("c"));
			$w=base64_decode($this->input->post("w"));
			$t=base64_decode($this->input->post("t"));
			$c=$c==''?'*':$c;
			$sql="select $c from $t where $w";
			$data=$this->db->query($sql)->result_array();
		}
		$ret=array('data'=>$data);
		echo json_encode($ret);
	}
	
	public function sv()
	{
		$usr=$this->session->userdata('user_data');
		$data=array();$msgs='Failed'; $typ="error";
		if(isset($usr)){
			$this->load->model("mydb");
			$c=base64_decode($this->input->post("cols"));
			$t=base64_decode($this->input->post("table"));
			$rowid=$this->input->post("rowid");
			$flag=$this->input->post("flag");
			$where="rowid=$rowid";
			
			$data=$this->input->post(explode(",",$c));
			$data["updby"]=$usr["uid"];
			$data["lastupd"]=date('Y-m-d H:i:s');
			
			//specific user pwd
			if(isset($_POST['upwd'])){
				if($_POST['upwd']!='') $data["upwd"]=md5($this->input->post("upwd"));
			}
			
			if($rowid==0){
				$sql=$this->mydb->insert_string($t, $data);
			}else{
				$sql=$this->mydb->update_string($t, $data, $where);
				if($flag=='DEL') $sql="delete from $t where $where";
			}
			
			$this->db->query($sql);
			if($this->db->affected_rows()>0) {
				$msgs='Success'; $typ="success";
			}else{
				$msgs=$this->mydb->error($this->db->error());
			}
			
		}else{
			$msgs="Session closed, please login";
		}
		$ret=array('msgs'=>$msgs,'type'=>$typ);
		echo json_encode($ret);
	}
}
