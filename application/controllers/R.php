<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class R extends CI_Controller {
	
	private $path="./files/bp/";

	public function index()
	{
		$usr=$this->session->userdata('user_data');
		if(isset($usr)){
			$data["session"]=$usr;
			$this->load->view($this->input->get('v'),$data);
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
				//$res[$i]["attc"]=$res[$i]["attc"]==""?"":'<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.$this->path.$res[$i]["attc"].'">'.$res[$i]["attc"].'</a>';
				$dum=array_values($res[$i]);
				//$rowid=$res[$i]['rowid'];
				$data[]=$dum;
			}
		}
		$out=array('data'=>$data);
		echo json_encode($out);
	}
	
}