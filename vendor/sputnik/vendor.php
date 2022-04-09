<?php $json = file_get_contents('php://input');
$post = json_decode($json, TRUE);
require '../../admin/backend.php';
$obj=new backend;
if (isset($_GET['q'])) {
	$q=$_GET['q'];
	if ($q=='login') {
		$username=$post['username'];
		$password=$post['password'];
		
		$response=$obj->loginapp($username,$password);
		$res=json_encode($response);
		echo $res;
	}elseif ($q=='registrasi') {
		$username=$post['nama'];
		$password=$post['password'];
		$namalengkap=$post['fullname'];
		$handphone=$post['handphone'];
		
		$response=$obj->registrasiapp($username,$password,$namalengkap,$handphone);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='tiket'){
		$id=$post['idrute'];
		$response=$obj->tiketapp($id);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='seat'){
		$id=$post['id'];
		$response=$obj->seatapp($id);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='bookseat'){
		$id=$post['id'];
		$seat=$post['seat'];
		$status=$post['status'];
		$userid=$post['userid'];
		$response=$obj->bookseatapp($id,$seat,$status,$userid);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='booktiket'){
		$userid=$post['userid'];
		$id=$post['id'];
		$metodepembayaran=$post['metodepembayaran'];
		$response=$obj->booktiketapp($id,$userid,$metodepembayaran);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='transaksi'){
		$userid=$post['userid'];
		$response=$obj->transaksiapp($userid);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='kritiksaran'){
		$userid=$post['userid'];
		$response=$obj->kritiksaranapp($userid);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='profile'){
		$userid=$post['userid'];
		$response=$obj->profileapp($userid);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='simpankritiksaran'){
		$userid=$post['userid'];
		$kritiksaran=$post['kritiksaran'];
		$notransaksi=$post['notransaksi'];
		$response=$obj->simpankritiksaranapp($userid,$kritiksaran,$notransaksi);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='transaksidetail'){
		$notransaksi=$post['notransaksi'];
		$response=$obj->transaksidetailapp($notransaksi);
		$res=json_encode($response);
		echo $res;
	}elseif($q=='rute'){
		$response=$obj->ruteapp();
		$res=json_encode($response);
		echo $res;
	}
}else{
	$res['success']=false;
	$res['message']='Not Found';
	echo json_encode($json);
}

?>