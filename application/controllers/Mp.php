<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mp extends CI_Controller {

	private $path='./files/mp/';
	
	public function index()
	{
		$usr=$this->session->userdata('user_data');
		if(isset($usr)){
			$data["session"]=$usr;
			$data["which"]=$this->input->get("w");
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
			$sql=base64_decode($this->input->post("s")).base64_decode($this->input->post("w"));
			$res=$this->db->query($sql)->result_array();
			for($i=0;$i<count($res);$i++){
				$dum=array_values($res[$i]);
				$rowid=$res[$i]['rowid'];
				$mpn=base64_encode($res[$i]['mpnumber']);
				$camp=base64_encode($res[$i]['campaign']);
				$approver=$res[$i]['approver'];
				$stts=$res[$i]['stts'];
				$dum[0]='<a href="#" onclick="openf('.$rowid.')">'.$dum[0].' </a>';
				$dum[count($dum)-2]='<button type="button" class="btn btn-info" onclick="attach(\''.$mpn.'\',\''.$camp.'\');"><i class="fas fa-paperclip"></i></button>';
				$dum[count($dum)-1]='';
				if($usr["uid"]==$approver && $stts=="Pending Approval") $dum[count($dum)-1]='<button type="button" class="btn btn-success" onclick="apprup('.$rowid.');">Approve/Reject</button>';
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
			$w=base64_decode($this->input->post("w"));
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
	
	private function getNR(){
		$data=$this->db->query("select max(nr) as mnr from t_mediaplans")->result_array();
		$nr=1;
		if(count($data)>0){
			$mnr=$data[0]['mnr'];
			$nr=is_numeric($mnr)?$mnr+1:$nr;
		}
		return  $nr;
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
			
			if($flag=='SNDA'||$rowid==0) {$data["stts"]="Pending Approval"; $data["approver"]=$this->input->post("approver");}
			if($flag=='REJE') {$data["stts"]="Rejected";}
			if($flag=='APPR') {$data["stts"]="Approved"; $data["approved"]=date('Y-m-d H:i:s');}
			
			if($rowid==0){
				$subm=$data['submitdt'];
				$camp=str_ireplace(" ","_",strtoupper($data['campaign']));
				$nr=$this->getNR();
				$data['nr']=$nr;
				$data['mpnumber']=$nr.'/'.substr($subm,5,3).substr($subm,2,2).'/'.$camp.'/'.$data['placement'];
				$data['creator']=$usr["uid"];
				$sql=$this->mydb->insert_string($t, $data);
			}else{
				$sql=$this->mydb->update_string($t, $data, $where);
				if($flag=='DEL') $sql="delete from $t where $where";
			}
			
			$this->db->query($sql);
			if($this->db->affected_rows()>0) {
				$msgs='Success'; $typ="success";
				//if($rowid==0)	$msgs.=$this->mydb->ctask("create_mp",$data);
				//if($flag=='SNDA') $msgs=$this->mydb->notify(array("assignedto"=>$data["approver"],"taskname"=>"Mediaplan Approval"));
				if($rowid==0||$flag=='SNDA') {
					$m="This is a reminder that there are outstanding tasks in ODS that require your attention.<br />Please log into ODS to review and approve the outstanding.<br />";
					$m.="Mediaplan#: ".$data['mpnumber']."<br />Campaign: ".$data['campaign']."<br />Client: ".$data['client'];
					$msgs=$this->mydb->notify(array("assignedto"=>$data["approver"],"taskname"=>"Mediaplan Approval","msgs"=>$m));
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
