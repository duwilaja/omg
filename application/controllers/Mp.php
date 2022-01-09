<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mp extends CI_Controller {

	private $path='./files/mp/';
	
	public function index()
	{
		$usr=$this->session->userdata('user_data');
		if(isset($usr)){
			$data["session"]=$usr;
			$this->load->view("mp",$data);
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
				$mpn=$res[$i]['mpnumber'];
				$dum[0]='<a href="#" onclick="openf('.$rowid.')">'.$dum[0].' </a>';
				$dum[count($dum)-1]='<button type="button" class="btn btn-info" onclick="attach(\''.$mpn.'\');"><i class="fas fa-paperclip"></i></button>';
				$data[]=$dum;
			}
		}
		$out=array('data'=>$data);
		echo json_encode($out);
	}
	public function attachments()
	{
		$usr=$this->session->userdata('user_data');
		$data=array();
		if(isset($usr)){
			$sql=base64_decode($this->input->post("s"));
			$w=($this->input->post("w"));
			$sql.=" where mp='$w'";
			$res=$this->db->query($sql)->result_array();
			for($i=0;$i<count($res);$i++){
				$dum=array_values($res[$i]);
				$rowid=$res[$i]['rowid'];
				$dum[0]='<a href="#" onclick="openfa('.$rowid.')">'.$dum[0].' </a>';
				$dum[2]='<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.$this->path.$dum[2].'">'.$dum[2].' </a>';
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
						
			if($rowid==0){
				$data['mpnumber']=time();
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
	
	public function sva()
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
			$config['allowed_types'] = 'gif|jpg|png|pdf';
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
