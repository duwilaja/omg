<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class R extends CI_Controller {
	
	//private $site="http://mp.omgdemo.website/";
	private $site="http://localhost/omg/";
	
	private $billpath="files/bp/";
	private $invpath="files/iv/";
	private $sspath="files/ss/";

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
			$rpt=base64_decode($this->input->post("r"));
			$res=$this->db->query($sql)->result_array();
			for($i=0;$i<count($res);$i++){
				//$res[$i]["attc"]=$res[$i]["attc"]==""?"":'<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.$this->path.$res[$i]["attc"].'">'.$res[$i]["attc"].'</a>';
				switch($rpt){
					case "rmp": $res[$i]=$this->rmp($res[$i]); break;
				}
				$dum=array_values($res[$i]);
				//$rowid=$res[$i]['rowid'];
				$data[]=$dum;
			}
		}
		$out=array('data'=>$data);
		echo json_encode($out);
	}
	
	private function linkkan($dat,$path){
		$r=array();
		$ar=explode(";",$dat);
		for($j=0;$j<count($ar);$j++){
			if($ar[$j]!="") $r[]='<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.$path.$ar[$j].'">'.$ar[$j].'</a>';
		}
		return implode("<br />",$r);
	}
	
	private function rmp($dat){
		$d=$dat;
		$d["invattc"]=$this->linkkan($dat["invattc"],$this->site.$this->invpath);
		$d["ssattc"]=$this->linkkan($dat["ssattc"],$this->site.$this->sspath);
		$d["billattc"]=$this->linkkan($dat["billattc"],$this->site.$this->billpath);
		return $d;
	}
	
}