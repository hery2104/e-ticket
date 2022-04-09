<?php 
include 'backend.php';
$obj=new backend;
if (isset($_GET['q'])) {
	$action=$_GET['q'];
	if ($action=='loadmodul') {
		$table='modul';
		$col='parent';
		$param='>0';
		$obj->showFind($table,$col,$param);
	}elseif($action=='logout'){
		$url='index.php';
		$obj->logout($url);
	}elseif ($action=='loadkritiksaran') {
		$table='tb_kritiksaran';
		$col='status';
		$param='1';
		$filter=$_POST['filter'];
		$data=$_POST['data'];
		$page=$_POST['page'];
		$take=$_POST['take'];
		$obj->showFind($table,$col,$param);
	}elseif ($action=='loadpemesanantiket') {
		$table='tb_pemesanantiket';
		$col='status';
		$param='1';
		$filter=$_POST['filter'];
		$data=$_POST['data'];
		$page=$_POST['page'];
		$take=$_POST['take'];
		$obj->showFind($table,$col,$param);
	}elseif ($action=='loadpemesanantiketdetail') {
		$table='tb_pemesanantiketdetail';
		$col='status';
		$param=$_POST['id'];
		$obj->showFind($table,$col,$param);
	}elseif ($action=='loadarmada') {
		$table='tb_armada';
		$col='status';
		$param='0';
		$filter=$_POST['filter'];
		$data=$_POST['data'];
		$page=$_POST['page'];
		$take=$_POST['take'];
		$obj->showFind($table,$col,$param);
	}elseif ($action=='loadrute') {
		$table='tb_rute';
		$col='status';
		$param='1';
		$filter=$_POST['filter'];
		$data=$_POST['data'];
		$page=$_POST['page'];
		$take=$_POST['take'];
		$obj->showFind($table,$col,$param);
	}elseif ($action=='loadtiket') {
		$table='tb_tiket';
		$col='status';
		$param='1';
		$filter=$_POST['filter'];
		$data=$_POST['data'];
		$page=$_POST['page'];
		$take=$_POST['take'];
		$obj->showFind($table,$col,$param);
	}elseif ($action=='loadpengguna') {
		$table='tb_pengguna';
		$col='status';
		$param='1';
		$filter=$_POST['filter'];
		$data=$_POST['data'];
		$page=$_POST['page'];
		$take=$_POST['take'];
		$obj->showFind($table,$col,$param);
	}elseif ($action=='simpanbalasan') {
		$table='tb_kritiksaran';		
		$obj->storeKritikSaran($table);
	}elseif ($action=='storerute') {
		$table='rute';		
		$obj->storeRute($table);
	}elseif ($action=='updaterute') {
		$table='rute';		
		$obj->updateRute($table);
	}elseif ($action=='updatearmada') {
		$table='armada';		
		$obj->updateArmada($table);
	}elseif ($action=='storearmada') {
		$table='armada';		
		$obj->storeArmada($table);
	}elseif ($action=='storetiket') {
		$table='tiket';		
		$obj->storeTiket($table);
	}elseif ($action=='deleterute') {
		$table='rute';
		$id=$_GET['id'];
		$obj->deleteData($table,$id);
	}elseif ($action=='deletearmada') {
		$table='armada';
		$id=$_GET['id'];
		$obj->deleteData($table,$id);
	}elseif ($action=='deletetiket') {
		$table='tiket';
		$id=$_GET['id'];
		$obj->deleteData($table,$id);
	}elseif ($action=='pdfpemesanantiket') {
		$table='tb_keranjang';
		$filter=$_POST['filter'];
		$data=$_POST['data'];
		$periode=$_POST['periode'];
		$obj->pdfPemesanan($table,$filter,$data,$periode);
}else{
	$response=null;
	$obj->redirect('index.php?pages=404');
}
}else{
	$response=null;
	$obj->redirect('index.php?pages=404');
}

?>