<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iv extends CI_Controller {
	
	private $path="./files/iv/";
	private $sspath="./files/ss/";

	public function index()
	{
		$usr=$this->session->userdata('user_data');
		if(isset($usr)){
			$data["session"]=$usr;
			$data["which"]=$this->input->get("w");
			$this->load->view("iv",$data);
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
			$sql.=$this->input->post("df")==''?'':" and idt>='".$this->input->post("df")."'";
			$sql.=$this->input->post("dt")==''?'':" and idt<='".$this->input->post("dt")."'";
			$res=$this->db->query($sql)->result_array();
			for($i=0;$i<count($res);$i++){
				$res[$i]["attc"]=$res[$i]["attc"]==""?"":'<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.$this->path.$res[$i]["attc"].'">'.$res[$i]["attc"].'</a>';
				$res[$i]["ssattc"]=$this->linkkan($res[$i],$usr);
				$dum=array_values($res[$i]);
				$rowid=$res[$i]['rowid'];
				$dum[0]=$res[$i]["creator"]==$usr['uid']?'<a href="#" onclick="openf('.$rowid.')">'.$dum[0].' </a>':$dum[0];
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
	
	private function uplots($fld){
		$ret=array();
		// Count total files
        $countfiles = count($_FILES[$fld]['name']);
		// Looping all files
        for($i=0;$i<$countfiles;$i++){
			if(!empty($_FILES[$fld]['name'][$i])){
				// Define new $_FILES array - $_FILES['file']
				  $_FILES['file']['name'] = $_FILES[$fld]['name'][$i];
				  $_FILES['file']['type'] = $_FILES[$fld]['type'][$i];
				  $_FILES['file']['tmp_name'] = $_FILES[$fld]['tmp_name'][$i];
				  $_FILES['file']['error'] = $_FILES[$fld]['error'][$i];
				  $_FILES['file']['size'] = $_FILES[$fld]['size'][$i];
				
				if ( $this->upload->do_upload('file')){
						$ret[]= $this->upload->data('file_name');
					}
			}
		}
		
		return implode(";",$ret);
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
			$config['upload_path'] = $this->sspath;
			$this->upload->initialize($config);
			$ssfs=$this->uplots('ssuploadedfile');
			if($ssfs!='') $data['ssattc']=$ssfs;
			
			if($rowid==0){
				$data['creator']=$usr["uid"];
				$sql=$this->mydb->insert_string($t, $data);
			}else{
				$sql=$this->mydb->update_string($t, $data, $where);
				if($flag=='DEL') $sql="delete from $t where $where";
			}
			
			$this->db->query($sql);
			if($this->db->affected_rows()>0) {
				$msgs='Success'; $typ="success";
				if($rowid==0||$flag=='SNDN') {
					$msgs="Data Saved. ";
					$br="<br />";
					$m="This is a reminder that there are outstanding tasks in MdS that require your attention.$br Please log into MdS to complete the outstanding.$br";
					$m.="Invoice#: ".$data['invno'].$br."Supplier: ".$data['supplier'].$br."Client: ".$data['client'];
					$msgs.=$this->mydb->notify(array("assignedto"=>$data["ss"],"taskname"=>"Screenshot Upload","msgs"=>$m));
				}
			}else{
				$msgs=$this->mydb->error($this->db->error());
			}
			
		}else{
			$msgs="Session closed, please login";
		}
		$ret=array('msgs'=>$msgs,'type'=>$typ);
		echo json_encode($ret);
	}
	
	private function linkkan($dat,$usr){
		$r=array();
		$ar=explode(";",$dat["ssattc"]);
		for($j=0;$j<count($ar);$j++){
			if($ar[$j]!="") $r[]='<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.$this->sspath.$ar[$j].'">'.$ar[$j].'</a>';
		}
		if(count($r)==0 && $dat["ss"]==$usr["uid"]) $r[]='<button type="button" class="btn btn-secondary" onclick="openfa('.$dat["rowid"].');"><i class="fas fa-paperclip"></i></button>';
		return implode("<br />",$r);
	}
}
