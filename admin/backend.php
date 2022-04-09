<?php 
/**
 * 
 */
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
class backend
{
	private $host='localhost';
	private $user='root';
	private $pass='';
	private $db='db_tiket';
	private $conn;

	function __construct()
	{
		session_start();
		try {
			$this->conn = new PDO("mysql:host=".$this->host.";port=3306;dbname=".$this->db,$this->user,$this->pass);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$error= "Connection failed : ".$e->getMessage();
			// $_SESSION['errors']=$error;
		}
	}
	public function loginapp($uname,$upass){
		try {
			$stmt=$this->conn->prepare("SELECT * FROM tb_pengguna WHERE username=:uname and password=:upass");
			$stmt->bindparam(":uname",$uname);
			$stmt->bindparam(":upass",$upass);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_BOTH);
			if($result){
				$res['success']=true;
				$res['message']='Berhasil login';
				$res['id']=$result['id'];
			}else{
				$res['success']=false;
				$res['message']='Username atau password tidak benar';
			}
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function tiketapp($id){
		try {
			$tanggal=date('Y-m-d');
			$stmt=$this->conn->prepare("SELECT tb_tiket.*,tb_armada.nopol FROM tb_tiket LEFT JOIN tb_armada ON tb_armada.id=tb_tiket.idarmada WHERE tb_tiket.status='Y' AND tb_tiket.idrute=$id");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				$res['success']=true;
				$res['message']='Berhasil ambil data tiket';
				$res['data']=$result;
			}else{
				$res['success']=false;
				$res['message']='Data tiket tidak tersedia';
			}
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function ruteapp(){
		try {
			$tanggal=date('Y-m-d');
			$stmt=$this->conn->prepare("SELECT * FROM tb_rute WHERE status='Y'");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				$res['success']=true;
				$res['message']='Berhasil ambil data rute';
				$res['data']=$result;
			}else{
				$res['success']=false;
				$res['message']='Data rute tidak tersedia';
			}
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function profileapp($userid){
		try {
			$tanggal=date('Y-m-d');
			$stmt=$this->conn->prepare("SELECT * FROM tb_pengguna WHERE id='".$userid."'");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				$res['success']=true;
				$res['message']='Berhasil ambil data pengguna';
				$res['data']=$result;
			}else{
				$res['success']=false;
				$res['message']='Data pengguna tidak tersedia';
			}
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function kritiksaranapp($userid){
		try {
			$tanggal=date('Y-m-d');
			$stmt=$this->conn->prepare("SELECT tb_kritiksaran.*,rt.rute,am.nopol FROM tb_kritiksaran left join tb_pemesanantiket as ps on ps.id=tb_kritiksaran.idpemesanan left join tb_tiket as tk on tk.id=ps.idtiket left join tb_rute as rt on rt.id=tk.idrute left join tb_armada as am on am.id=tk.idarmada WHERE tb_kritiksaran.idpengguna='".$userid."'");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				$res['success']=true;
				$res['message']='Berhasil ambil data kritik saran';
				$res['data']=$result;
			}else{
				$res['success']=false;
				$res['message']='Data kritik saran tidak tersedia';
			}
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function simpankritiksaranapp($userid,$kritiksaran,$idpemesanan){
		try {
			$sql=$this->conn->prepare("INSERT INTO tb_kritiksaran(idpengguna,kritiksaran,idpemesanan) VALUES(:idpengguna,:kritiksaran,:idpemesanan)");
			$sql->bindparam(":idpengguna",$userid);
			$sql->bindparam(":kritiksaran",$kritiksaran);
			$sql->bindparam(":idpemesanan",$idpemesanan);
			$sql->execute();
			$res['success']=true;
			$res['message']='Berhasil simpan kritik saran';
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function registrasiapp($username,$password,$namalengkap,$handphone){
		$poin=0;
		try {
			$sql=$this->conn->prepare("INSERT INTO tb_pengguna(username,nama,password,handphone,poin) VALUES(:username,:nama,:password,:handphone,:poin)");
			$sql->bindparam(":username",$username);
			$sql->bindparam(":nama",$namalengkap);
			$sql->bindparam(":password",$password);
			$sql->bindparam(":handphone",$handphone);
			$sql->bindparam(":poin",$poin);
			$sql->execute();
			$stmt3=$this->conn->prepare("SELECT * FROM tb_pengguna ORDER BY id DESC LIMIT 0,1");
			$stmt3->execute();
			while ($row=$stmt3->fetch(PDO::FETCH_ASSOC)) {
				$lastid=$row['id'];
			} 
			$res['success']=true;
			$res['id']=$lastid;
			$res['message']='Berhasil simpan akun baru';
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function transaksiapp($userid){
		try {
			$tanggal=date('Y-m-d');
			$stmt=$this->conn->prepare("SELECT * FROM tb_pemesanantiket WHERE idpengguna='".$userid."'");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				$res['success']=true;
				$res['message']='Berhasil ambil data transaksi';
				$res['data']=$result;
			}else{
				$res['success']=false;
				$res['message']='Data transaksi tidak tersedia';
			}
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function transaksidetailapp($notransaksi){
		try {
			$tanggal=date('Y-m-d');
			$stmt=$this->conn->prepare("SELECT * FROM tb_pemesanantiket LEFT JOIN tb_pemesanantiketdetail ON tb_pemesanantiketdetail.idpemesanan=tb_pemesanantiket.id WHERE tb_pemesanantiket.id='".$notransaksi."'");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				$res['success']=true;
				$res['message']='Berhasil ambil data transaksi';
				$res['data']=$result;
			}else{
				$res['success']=false;
				$res['message']='Data transaksi tidak tersedia';
			}
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function seatapp($idtiket){
		try {
			$tanggal=date('Y-m-d');
			$stmt=$this->conn->prepare("SELECT * FROM tb_tiketdetail WHERE idtiket=$idtiket ORDER BY seat ASC");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				$res['success']=true;
				$res['message']='Berhasil ambil data tiket';
				$res['data']=$result;
			}else{
				$res['success']=false;
				$res['message']='Data tiket tidak tersedia untuk jadwal ini';
			}
			return $res;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function bookseatapp($idtiket,$seat,$set,$userid){
		try {
			$subpesan=1;
			$tanggal=date('Y-m-d');
			$stmt=$this->conn->prepare("SELECT * FROM tb_tiketdetail WHERE idtiket=$idtiket AND seat=$seat");
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_BOTH);
			if($result['status']=='N'){
				if($result['idpengguna']==$userid || $result['idpengguna']==0){
					if($result['idpengguna']!=0){
						$userid=0;
						$subpesan=0;
					}
					$stmt=$this->conn->prepare("UPDATE tb_tiketdetail SET idpengguna=$userid WHERE idtiket=$idtiket AND seat=$seat");
					$stmt->execute();
					$res['success']=true;
					$res['message']='Berhasil simpan no bangku '.$set;
					$res['subpesan']=$subpesan;
				}else{
					$res['success']=false;
					$res['message']='No bangku ini sudah tidak tersedia '.$set.$userid;
				}
			}else{
				$res['message']='No bangku ini tidak tersedia '.$set;
				$res['success']=false;
			}
		} catch (PDOException $e) {
			$res['success']=false;
			$res['message']='Kesalahan server '.$e->getMessage();
		}
		return $res;
	}
	public function getData($table,$column,$param){
		$stmt=$this->conn->prepare("SELECT * FROM $table WHERE $column='$param'");
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return $result;
	}
	public function optionData($table){
		$sql = "SELECT * FROM $table";
		$q=$this->conn->prepare($sql);
		$q->execute();
		while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
			$data[]=$row;
		} 
		return $data;
	}
	public function booktiketapp($idtiket,$userid,$metodepembayaran){
		try {
			$tanggal=date('Y-m-d');
			if($metodepembayaran=="Poinku"){
				$stmtx=$this->conn->prepare("SELECT * FROM tb_tiket WHERE id=$idtiket");
				$stmtx->execute();
				$result = $stmtx->fetch(PDO::FETCH_BOTH);
				if($result){
					$idrute=$result['idrute'];
				}
				$stmty=$this->conn->prepare("SELECT * FROM tb_rute WHERE id=$idrute");
				$stmty->execute();
				$result = $stmty->fetch(PDO::FETCH_BOTH);
				if($result){
					$itempotongan=$result['potonganpoin'];
				}else{
					$itempotongan=20;
				}
				$stmt=$this->conn->prepare("SELECT * FROM tb_pengguna WHERE id=$userid");
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_BOTH);
				if($result){
					$cekpoint=$result['poin'];
				}else{
					$cekpoint=0;
				}
				$stmt2=$this->conn->prepare("SELECT COUNT(*) FROM tb_tiketdetail WHERE idtiket='$idtiket' AND idpengguna=$userid AND status='N'");
				$stmt2->execute();
				$result2 = $stmt2->fetch(PDO::FETCH_BOTH);
				$itemtiket=$result2[0];
				$potonganpoin=$itemtiket*$itempotongan;
				if ($cekpoint<$potonganpoin) {
					$res['success']=false;
					$res['message']='Poin anda tidak cukup untuk pembayaran tiket sebesar '.$potonganpoin.' poin';
					return $res;
				}else{
					$cekpoint=$cekpoint-$potonganpoin;
				}
			}
			$item=0;
			$subtotal=0;
			$status=1;
			$poin=0;
			$sql=$this->conn->prepare("INSERT INTO tb_pemesanantiket(idpengguna,idtiket,poin,subtotal,metodepembayaran,item,status) VALUES(:idpengguna,:idtiket,:poin,:subtotal,:metodepembayaran,:item,:status)");
			$sql->bindparam(":idpengguna",$userid);
			$sql->bindparam(":idtiket",$idtiket);
			$sql->bindparam(":poin",$poin);
			$sql->bindparam(":subtotal",$subtotal);
			$sql->bindparam(":metodepembayaran",$metodepembayaran);
			$sql->bindparam(":item",$item);
			$sql->bindparam(":status",$status);
			$sql->execute();
			$stmt3=$this->conn->prepare("SELECT * FROM tb_pemesanantiket ORDER BY id DESC LIMIT 0,1");
			$stmt3->execute();
			while ($row=$stmt3->fetch(PDO::FETCH_ASSOC)) {
				$lastid=$row['id'];
			} 
			$stmt=$this->conn->prepare("SELECT * FROM tb_tiketdetail WHERE idtiket='$idtiket' AND idpengguna=$userid AND status='N'");
			$stmt->execute();
			$idrute=$this->getData('tb_tiket','id',$idtiket)['idrute'];
			$tarif=$this->getData('tb_rute','id',$idrute)['tarif'];
			while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
				++$item;
				$seat=$row['seat'];
				$stmt2=$this->conn->prepare("UPDATE tb_tiketdetail SET status='Y' WHERE idtiket='$idtiket' AND idpengguna=$userid");
				$stmt2->execute();
				$stmt3=$this->conn->prepare("INSERT tb_pemesanantiketdetail (idpemesanan,seat) VALUES($lastid,$seat)");
				$stmt3->execute();
			} 
			$poin=2*$item;
			$subtotal=$item*$tarif;
			$stmt4=$this->conn->prepare("UPDATE tb_pemesanantiket SET subtotal='$subtotal',item='$item',poin='$poin' WHERE id='$lastid'");
			$stmt4->execute();
			if ($metodepembayaran=="Poinku") {
				$akumpoin=$cekpoint+$poin;
				$stmt5=$this->conn->prepare("UPDATE tb_pengguna SET poin='$akumpoin' WHERE id='$userid'");
				$stmt5->execute();
			}
			$res['message']='Berhasil simpan pemesanan tiket'.$tarif;
			$res['success']=true;
			$res['poin']=$poin;
			$res['subtotal']=$subtotal;
			$res['id']=$lastid;
		} catch (PDOException $e) {
			$res['success']=false;
			$res['message']='Kesalahan server '.$e->getMessage();
		}
		return $res;
	}
	public function login($uname,$upass){
		try {
			$stmt=$this->conn->prepare("SELECT * FROM tb_pengguna WHERE username=:uname");
			$stmt->bindparam(":uname",$uname);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_BOTH);
			if ($result['password']==$upass) {
		// die(var_dump($upass));
				$_SESSION['usersesi'] = $result['id'];
				$user=$result['name'];
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function getuser($id){
		try {
			$q=$this->conn->prepare("SELECT * FROM tb_pengguna where id=:id");
			$q->bindparam(":id",$id);
			$q->execute();
			$result=$q->fetchAll(PDO::FETCH_BOTH);
			return $result;
		} catch (PDOException $e) {
			echo "Kesalahan : ".$e->getMessage();
		}
	}
	public function showFind($table,$col,$param){
		if ($table=="modul") {
			$data=[];
			$sql = "SELECT * FROM tb_modul WHERE status=1 AND parent>0";
			$q=$this->conn->prepare($sql);
			$q->execute();
			while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
				$data[]=$row;
			} 
			echo json_encode($data);
		}elseif ($table=="tb_tiket") {
			// die(var_dump($table));
			$datafilter = $_POST['data'];
			$take = $_POST['take'];
			$page = $_POST['page'];
			$filter=$_POST['filter'];
			if ($filter=='') {
				$filter='ph.id';
			}
			if ($filter=="nama") {
				$filter="pg.nama";
			}
			$skippedData = ($page - 1) * $take;

			$data=[];
			$sql = "SELECT tk.id FROM tb_tiket as tk left join tb_rute as rt ON rt.id=tk.idrute";
			$q=$this->conn->prepare($sql);
			$q->execute();
			$totalJumlah=$q->rowCount();

			$totalPage = $totalJumlah / $take;

			$totalPage = ceil($totalPage);

			$sql = "SELECT tk.*,rt.rute FROM tb_tiket as tk left join tb_rute as rt ON rt.id=tk.idrute ORDER BY tk.id DESC LIMIT $skippedData,$take";
			$q=$this->conn->prepare($sql);
			$q->execute();
			while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
				$data[]=$row;
			} 
			echo json_encode(['data'=>$data, 'totalPage' => $totalPage , 'activePage' => $page,'totalRecord' => $totalJumlah]);
		}elseif ($table=="tb_pemesanantiket") {
			// die(var_dump($table));
			$periode=$_POST['periode'];
			// $periode='2021-01-01 2021-12-31';
			$tanggalawal=substr($periode, 0,10);
			$tanggalakhir=substr($periode, 13,10);
			$datafilter = $_POST['data'];
			$take = $_POST['take'];
			$page = $_POST['page'];
			$filter=$_POST['filter'];
			if ($filter=='') {
				$filter='pt.id';
			}
			$skippedData = ($page - 1) * $take;

			$data=[];
			$sql = "SELECT pt.id FROM tb_pemesanantiket as pt left join tb_pengguna as pg on pg.id=pt.idpengguna where LEFT(pt.created_at,10)>='".$tanggalawal."' AND LEFT(pt.created_at,10)<='".$tanggalakhir."'";
			$q=$this->conn->prepare($sql);
			$q->execute();
			$totalJumlah=$q->rowCount();

			$totalPage = $totalJumlah / $take;

			$totalPage = ceil($totalPage);

			$sql = "SELECT pt.*,pg.nama FROM tb_pemesanantiket as pt left join tb_pengguna as pg on pg.id=pt.idpengguna where LEFT(pt.created_at,10)>='".$tanggalawal."' AND LEFT(pt.created_at,10)<='".$tanggalakhir."' ORDER BY pt.id DESC LIMIT $skippedData,$take";
			$q=$this->conn->prepare($sql);
			$q->execute();
			while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
				$data[]=$row;
			} 
			echo json_encode(['data'=>$data, 'totalPage' => $totalPage , 'activePage' => $page,'totalRecord' => $totalJumlah]);

		}elseif ($table=="tb_pemesanantiketdetail") {
			$sql = "SELECT pt.*,pg.nama,pd.seat FROM tb_pemesanantiket as pt left join tb_pemesanantiketdetail as pd on pd.idpemesanan=pt.id left join tb_pengguna as pg on pg.id=pt.idpengguna where pt.id=$param ORDER BY pt.id DESC";
			$q=$this->conn->prepare($sql);
			$q->execute();
			$data=[];
			while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
				$data[]=$row;
			} 
			echo json_encode(['data'=>$data, 'param'=>$param]);

		}elseif ($table=="tb_kritiksaran") {
			// die(var_dump($table));
			$datafilter = $_POST['data'];
			$take = $_POST['take'];
			$page = $_POST['page'];
			$filter=$_POST['filter'];
			if ($filter=='') {
				$filter='ph.id';
			}
			if ($filter=="nama") {
				$filter="pg.nama";
			}
			$skippedData = ($page - 1) * $take;

			$data=[];
			$sql = "SELECT * FROM tb_kritiksaran as ks left join tb_pemesanantiket as ps on ps.id=ks.idpemesanan left join tb_tiket as tk on tk.id=ps.idtiket left join tb_pengguna as pg on pg.id=ks.idpengguna left join tb_rute as rt on rt.id=tk.idrute left join tb_armada as am on am.id=tk.idarmada ";
			$q=$this->conn->prepare($sql);
			$q->execute();
			$totalJumlah=$q->rowCount();

			$totalPage = $totalJumlah / $take;

			$totalPage = ceil($totalPage);

			$sql = "SELECT ks.*,pg.nama,pg.username,tk.idrute,rt.rute,tk.tgl_keberangkatan,am.nopol FROM tb_kritiksaran as ks left join tb_pemesanantiket as ps on ps.id=ks.idpemesanan left join tb_tiket as tk on tk.id=ps.idtiket left join tb_pengguna as pg on pg.id=ks.idpengguna left join tb_rute as rt on rt.id=tk.idrute left join tb_armada as am on am.id=tk.idarmada ORDER BY ks.id DESC LIMIT $skippedData,$take";
			$q=$this->conn->prepare($sql);
			$q->execute();
			while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
				$data[]=$row;
			} 
			echo json_encode(['data'=>$data, 'totalPage' => $totalPage , 'activePage' => $page,'totalRecord' => $totalJumlah]);
		}else{
			$datafilter = $_POST['data'];
			$take = $_POST['take'];
			$page = $_POST['page'];
			$filter=$_POST['filter'];
			if ($filter=='') {
				$filter='id';
			}
			$skippedData = ($page - 1) * $take;

			$data=[];
			$sql = "SELECT * FROM ".$table." WHERE ".$filter." LIKE '%".$datafilter."%'";
			$q=$this->conn->prepare($sql);
			$q->execute();
			$totalJumlah=$q->rowCount();

			$totalPage = $totalJumlah / $take;

			$totalPage = ceil($totalPage);

			$sql = "SELECT * FROM ".$table." WHERE ".$filter." LIKE '%".$datafilter."%' ORDER BY id DESC LIMIT $skippedData,$take";
			$q=$this->conn->prepare($sql);
			$q->execute();
			while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
				$data[]=$row;
			} 
			echo json_encode(['data'=>$data, 'totalPage' => $totalPage , 'activePage' => $page,'totalRecord' => $totalJumlah]);
		}
	}
	public function showData($table,$param,$col){
		$data=[];
		$sql="SELECT * FROM tb_".$table." WHERE ".$col." = ".$param.' ORDER BY id DESC';
		$q=$this->conn->query($sql) or die('Failed');
		while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
			$data[]=$row;
		}
		echo json_encode($data);
	}
	public function islogin(){
		if(isset($_SESSION['usersesi']))
		{
			return true;
		}
	}
	public function storeKritikSaran($table){
		try {
			$sql=$this->conn->prepare("UPDATE tb_kritiksaran SET balasan=:balasan where id=:id");
			$sql->bindparam(":balasan",$_POST['isiBalasan']);
			$sql->bindparam(":id",$_POST['id']);
			$sql->execute();


			echo json_encode(['status'=>200]);
		} catch (PDOException $e) {

			echo json_encode('Errors : '.$e->getMessage());
		}
	}
	public function storeRute($table){
		$error=[];
		foreach ($_POST as $key => $value) {
			if ($value=='') {
				$error[][$key]=$key.' dibutuhkan!';
			}
		}
		if (!empty($error)) {
			echo json_encode(['status'=>409,'response'=>$error]);
			die();
		}
		$this->conn->beginTransaction();
		try {
			$sql=$this->conn->prepare("INSERT INTO tb_rute(rute,tarif,status) VALUES(:rute,:tarif,:aktif)");
			$sql->bindparam(":rute",$_POST['Rute']);
			$sql->bindparam(":tarif",$_POST['Tarif']);
			$sql->bindparam(":aktif",$_POST['Status']);
			$sql->execute();
			$this->conn->commit();
			echo json_encode(['status'=>200]);
		} catch (PDOException $e) {
			$this->conn->rollBack();
			echo json_encode('Errors : '.$e->getMessage());
		}
	}
	public function updateRute($table){
		$error=[];
		foreach ($_POST as $key => $value) {
			if ($value=='') {
				$error[][$key]=$key.' dibutuhkan!';
			}
		}
		if (!empty($error)) {
			echo json_encode(['status'=>409,'response'=>$error]);
			die();
		}
		$this->conn->beginTransaction();
		try {
			$sql=$this->conn->prepare("UPDATE tb_rute SET rute=:rute,tarif=:tarif,status=:aktif WHERE id=:id");
			$sql->bindparam(":rute",$_POST['Rute']);
			$sql->bindparam(":tarif",$_POST['Tarif']);
			$sql->bindparam(":aktif",$_POST['Status']);
			$sql->bindparam(":id",$_POST['id']);
			$sql->execute();
			$this->conn->commit();
			echo json_encode(['status'=>200]);
		} catch (PDOException $e) {
			$this->conn->rollBack();
			echo json_encode('Errors : '.$e->getMessage());
		}
	}
	public function updateArmada($table){
		$error=[];
		foreach ($_POST as $key => $value) {
			if ($value=='') {
				$error[][$key]=$key.' dibutuhkan!';
			}
		}
		if (!empty($error)) {
			echo json_encode(['status'=>409,'response'=>$error]);
			die();
		}
		$this->conn->beginTransaction();
		try {
			$sql=$this->conn->prepare("UPDATE tb_armada SET nopol=:nopol,status=:aktif,jumlahbangku:seat WHERE id=:id");
			$sql->bindparam(":nopol",$_POST['NoPolisi']);
			$sql->bindparam(":aktif",$_POST['Status']);
			$sql->bindparam(":seat",$_POST['Seat']);
			$sql->bindparam(":id",$_POST['id']);
			$sql->execute();
			$this->conn->commit();
			echo json_encode(['status'=>200]);
		} catch (PDOException $e) {
			$this->conn->rollBack();
			echo json_encode('Errors : '.$e->getMessage());
		}
	}
	public function storeArmada($table){
		// die(var_dump("expression"));
		$error=[];
		foreach ($_POST as $key => $value) {
			if ($value=='') {
				$error[][$key]=$key.' dibutuhkan!';
			}
		}
		if (!empty($error)) {
			echo json_encode(['status'=>409,'response'=>$error]);
			die();
		}
		$this->conn->beginTransaction();
		try {
			$sql=$this->conn->prepare("INSERT INTO tb_armada(nopol,status,jumlahbangku) VALUES(:nopol,:aktif,:seat)");
			$sql->bindparam(":nopol",$_POST['NoPolisi']);
			$sql->bindparam(":aktif",$_POST['Status']);
			$sql->bindparam(":seat",$_POST['Seat']);
			$sql->execute();

			$this->conn->commit();
			echo json_encode(['status'=>200]);
		} catch (PDOException $e) {
			$this->conn->rollBack();
			echo json_encode('Errors : '.$e->getMessage());
		}
	}
	public function storeTiket($table){
		// die(var_dump("expression"));
		$error=[];
		foreach ($_POST as $key => $value) {
			if ($value=='') {
				$error[][$key]=$key.' dibutuhkan!';
			}
		}
		if (!empty($error)) {
			echo json_encode(['status'=>409,'response'=>$error]);
			die();
		}
		try {
			$sql=$this->conn->prepare("INSERT INTO tb_tiket(idarmada,idrute,status,tgl_keberangkatan) VALUES(:idarmada,:idrute,:aktif,:jadwal)");
			$sql->bindparam(":idarmada",$_POST['Armada']);
			$sql->bindparam(":idrute",$_POST['Rute']);
			$sql->bindparam(":aktif",$_POST['Status']);
			$sql->bindparam(":jadwal",$_POST['Jadwal']);
			$sql->execute();

			$stmt3=$this->conn->prepare("SELECT * FROM tb_tiket ORDER BY id DESC LIMIT 0,1");
			$stmt3->execute();
			while ($row=$stmt3->fetch(PDO::FETCH_ASSOC)) {
				$lastid=$row['id'];
			} 
			$seat=$this->getData('tb_armada','id',$_POST['Armada'])['jumlahbangku'];
			$lenseat=12;
			for ($i=0; $i <$lenseat ; $i++) { 
				if ($i==0) {
					$status='Y';
				}else{
					$status='N';
				}
				$idpengguna=0;
				$seat=$i+1;
				$booked_at='0000-00-00 00:00:00';
				$sql=$this->conn->prepare("INSERT INTO tb_tiketdetail(idtiket,idpengguna,seat,booked_at,status) VALUES(:idtiket,:idpengguna,:seat,:booked_at,:aktif)");
				$sql->bindparam(":idtiket",$lastid);
				$sql->bindparam(":idpengguna",$idpengguna);
				$sql->bindparam(":seat",$seat);
				$sql->bindparam(":booked_at",$booked_at);
				$sql->bindparam(":aktif",$status);
				$sql->execute();
			}
			echo json_encode(['status'=>200]);
		} catch (PDOException $e) {
			echo json_encode('Errors : '.$e->getMessage());
		}
	}
	public function find($table,$col,$id){
		// die(var_dump($_SESSION['dept']));
		$data=[];
		if ($table=='tb_modul') {
			$sql="SELECT * FROM ".$table." WHERE ".$col." = '$id' ORDER BY urutan ASC ";
		}elseif($table=='tb_halaman'){
			$sql="SELECT * FROM ".$table." WHERE ".$col." = '$id'";
		}elseif($table=='tb_settingweb'){
			$sql="SELECT * FROM ".$table;
		}else{
			$sql="SELECT * FROM ".$table." WHERE  ".$col." = '$id'";
		}
		$q=$this->conn->prepare($sql);
		$q->execute();
		while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
			$data[]=$row;
		} 
		return $data;

	}
	public function deleteData($table,$id){
		
		$this->conn->beginTransaction();
		try {
			$sql="DELETE FROM tb_".$table." WHERE id = '$id'";
			$del=$this->conn->query($sql) or die('Failed');
			if ($table=='tiket') {
				$sql2="DELETE FROM tb_tiketdetail WHERE idtiket = '$id'";
				$del=$this->conn->query($sql2) or die('Failed');
			}
			$this->conn->commit();
			echo json_encode(['status'=>200]);
		} catch (PDOException $e) {
			$this->conn->rollBack();
			echo json_encode('Errors : '.$e->getMessage());
		}
	}

	public function findDetail($id,$table){
		$data=[];
		$sql="SELECT * FROM tb_roomsdetail WHERE roomid = '$id'";
		$q=$this->conn->query($sql) or die('Failed');
		while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
			$data[]=$row;
		}
		return $data;

	}

	function pdfPemesanan($table,$filter,$data,$periode){
		$datafilter = $data;
		$filter=$filter;
		$periode=$periode;
		// $periode='2021-01-01 2021-12-31';
		$tanggalawal=substr($periode, 0,10);
		$tanggalakhir=substr($periode, 13,10);
		if ($filter=='') {
			$filter='a.id';
		}
		if ($filter=="nama") {
			$filter="pg.nama";
		}

		$data=[];

		$sql = "SELECT a.*,b.seat,pg.nama FROM tb_pemesanantiket a left join tb_pemesanantiketdetail b on b.idpemesanan=a.id left join tb_pengguna as pg ON pg.id=a.idpengguna WHERE ".$filter." LIKE '%".$datafilter."%' AND LEFT(a.created_at,10)>='".$tanggalawal."' AND LEFT(a.created_at,10)<='".$tanggalakhir."' ORDER BY a.id DESC ";
		$q=$this->conn->prepare($sql);
		$q->execute();
		while ($row=$q->fetch(PDO::FETCH_ASSOC)) {
			$data[]=$row;
		} 
		echo json_encode(['data'=>$data]);
	}
	public function redirect($url)
	{
		header("Location: $url");
	}
	public function logout($url)
	{
		unset($_SESSION['usersesi']);
		$this->redirect($url);
		return true;
	}
}

?>