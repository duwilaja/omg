<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bp extends CI_Controller {
	
	private $path="./files/bp/";

	public function index()
	{
		$usr=$this->session->userdata('user_data');
		if(isset($usr)){
			$data["session"]=$usr;
			$this->load->view("bp",$data);
		}else{
			redirect(base_url()."sign/out/1");
		}
	}
	
	public function datatable()
	{
		$usr=$this->session->userdata('user_data');
		$data=array();
		if(isset($usr)){
			$sql=base64_decode($this->input->post("s")).base64_decode($this->input->post("w"));
			$sql.=$this->input->post("df")==''?'':" and bdt>='".$this->input->post("df")."'";
			$sql.=$this->input->post("dt")==''?'':" and bdt<='".$this->input->post("dt")."'";
			$res=$this->db->query($sql)->result_array();
			for($i=0;$i<count($res);$i++){
				$res[$i]["attc"]=$res[$i]["attc"]==""?"":'<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.$this->path.$res[$i]["attc"].'">'.$res[$i]["attc"].'</a>';
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
	
	public function lov()
	{
		$usr=$this->session->userdata('user_data');
		$data=array();
		if(isset($usr)){
			$c=base64_decode($this->input->post("c"));
			$w=base64_decode($this->input->post("w"));
			$t=base64_decode($this->input->post("t"));
			$onclick=base64_decode($this->input->post("o"));
			$sql="select $c from $t where $w";
			$data=$this->db->query($sql)->result_array();
			for($i=0;$i<count($res);$i++){
				$dum=array_values($res[$i]);
				$dum[0]='<input type="radio" name="pilih" onclick="'.$onclick.'" value="'.$dum[0].'"> '.$dum[0];
				$data[]=$dum;
			}
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
			if($rowid==0) $data['attc']='';
			
			$config['upload_path'] = $this->path;
			$config['allowed_types'] = '*';
			$config['file_ext_tolower'] = true;
			$config['overwrite'] = true;
			$this->load->library('upload',$config);
			if ( $this->upload->do_upload('uploadedfile')){
				$data['attc']= $this->upload->data('file_name');
				//$fn=$data['attc'];
			}else{
				//$fn=$this->upload->display_errors();
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
