<?php 
include 'backend.php';
$db=new backend;
// session_start();
if(!$db->islogin())
{
  $db->redirect('../index.php');
}
$usersesi=$_SESSION['usersesi'];
foreach ($db->getuser($usersesi) as $user) {
  $uname= $user['nama'];
  $ufoto='./img/akun/admin1.png';
  
} 
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Administrator | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="/ckfinder/userfiles/images/favicon.png">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Bootstrap 3.3.6 -->
  <!-- <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css"> -->
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/jquery-confirm.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- jQuery 2.2.3 -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="dist/js/jquery-confirm.js"></script>
    <script src="dist/js/jquery.PrintArea.js"></script>
    <script src="dist/js/highcharts.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- CK Editor -->
    <script src="plugins/ckeditor/ckeditor.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>
  <script src="bootcomplete/js/jquery.bootcomplete.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type = "text/css">
      @media screen {
         p.bodyText {font-family:verdana, arial, sans-serif;}
      }

      @media print {
         p.bodyText {font-family:georgia, times, serif;}
         table{
          border-width: 2px;
          border:1px solid;
         }
      }
      @media screen, print {
         p.bodyText {font-size:10pt}
      }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed skin-green" style="padding-right: 0px !important;">
  <div class="wrapper">


    <?php
    include 'halaman/header.php';
    include 'halaman/aside.php';
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?php 
          if (isset($_GET['pages'])) {
            $x=$_GET['pages'];
            echo ucwords(str_replace("_", " ", $x));

          }else{
            echo "Beranda";
          }
          ?>
        </h1>
        <!--  -->
      </section>

      <!-- Main content -->
      <section class="content">
        <?php
        $pages_dir = 'halaman';
        if(!empty($_GET['pages'])){
          $pages = scandir($pages_dir, 0);
          unset($pages[0], $pages[1]);

          $p = $_GET['pages'];
          if(in_array($p.'.php', $pages)){
            include($pages_dir.'/'.$p.'.php');

          } else
          echo '<div class="alert alert-info" role="alert">Halaman tidak ditemukan! :( </div>';
        }
        else
        {
          include("halaman/beranda.php");
        }
        ?>
      </section>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
      </div>
      <strong>Copyright &copy; 2020 <a href="./">Web Admin</a>.</strong>
    </footer>


  </div>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script> -->
  <script src="plugins/daterangepicker/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
  <!-- SlimScroll 1.3.0 -->
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- iCheck 1.0.1 -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <!-- FastClick -->
  <script src="plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script src="dist/js/customscript.js"></script>
  <div class="modal fade" id="modalkonfirmasi">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Konfirmasi</h4>
        </div>
        <div class="modal-body">
          Simpan data ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="button" id="simpandata" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modaldelete">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modal title</h4>
        </div>
        <div class="modal-body">
          Hapus Data Ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="hapusdata">Hapus</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalnotif">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Konfirmasi</h4>
        </div>
        <div class="modal-body" id="kontennotif">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /#wrapper -->
  <div class="modal fade" id="modal-box">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function(){
      var jlhimage=1;
      $('body').on('click','#hapusData',function(e){
        e.preventDefault();
        konfirmasi('Hapus data ini?','Konfirmasi Hapus', hapus ,'confirmDelete' , $(this),'danger');
      })
      $('body').on('change','#checkAll',function(e){
        e.preventDefault();
        $('tbody #checkRow').not(this).prop('checked', this.checked);
      });
      $('body').on('click','#hapusCheckedkData',function(e){
        e.preventDefault();
        konfirmasi('Hapus data dipilih?','Konfirmasi hapus pilih',hapusDipilih,'confirmDeleteAll' , $(this),'danger');
      })

    })
    var simpan = {primary :'Simpan',default :'Batal'};
    var hapus = {danger :'Hapus',default :'Batal'};
    var logout = {danger :'Ya',default :'Batal'};
    var hapusDipilih = {danger : 'Hapus semua data dipilih?', default : 'Batal'};
var globalLink = '';

  </script>

  <script type="text/javascript">

function printDiv(data) {
  var content = data;
  var mywindow = window.open('', 'Print', 'height=600,width=800');

  mywindow.document.write('<html><head><title>Cetak Laporan</title>');
  mywindow.document.write('</head><body >');
  mywindow.document.write(content);
  mywindow.document.write('</body></html>');

  mywindow.document.close();
  mywindow.moveTo(0, 0);
  mywindow.resizeTo(screen.width, screen.height);
  setTimeout(function() {
    mywindow.focus()
    mywindow.print();
    mywindow.close();
  }, 250);
  return true;
}
    var confirm = false;
    // CKEDITOR.replace( 'Description' );
    // function konfirmasi(message = '', title = '', button, onOk, obj , allow = 'primary', dismiss = 'default', nextaction = 'next'){
    //   console.log(onOk);
    //   objek = obj;
    //   console.log(objek.data('id'));
    //   $('#modal-box .modal-body').html(message);
    //   $('#modal-box .modal-title').html(title);
    //   var buttonHtml = '';
    //   $.each(button,function(index,el){
    //     if(index == dismiss)
    //       buttonHtml += '<button type="button" class="btn btn-'+index+'" data-dismiss="modal">'+el+'</button>';
    //     else if(index == allow){
    //       buttonHtml += '<a id="no-session" type="button" class="btn btn-'+index+'" onclick="'+onOk+'();$(\'#modal-box\').modal(\'hide\');">'+el+'</a>';
    //     }
    //   })
    //   $('#modal-box .modal-footer').html(buttonHtml);

    //   $('#modal-box').modal('show');
    // }
    function confirmSubmit(){
      $.ajax({
        url : objek.attr('action'),
        type : 'POST',
        data : objek.serialize(),
        beforeSend : function(){
          removeError();
          callOverlay('box-primary');
          $('body .box').append('<div class="overlay" align="center" style="padding-top:20px;"><br/><p><img src=""></p><i class="fa fa-spinner fa-spin fa-5x"></i></div>');
        },
        complete : function(){
          removeOverlay();
          $('body .overlay').remove();
        },
        error : function(data){
          if(data.status == 409){
            toastr['error'](data.responseText);
          }
          else{
            showError(data.responseJSON);
          }
        },
        success : function(data){
        // console.log(data)
        var res=JSON.parse(data);
        console.log(res.status)
        if(res.status == 200){
          toastr['success']('Data berhasil simpan!');
          nextAction(data);
        }else if(res.status==409){

          toastr['error']('Isian dibutuhkan!');

          showError(res.response);
        }else if(res.status==500){

          toastr['error']('Wrong password!');

        }
        else{
          showError(data.responseJSON);
        }
        
      }
    })
    }
    function confirmDelete(){
      var page = objek.data('page');
      var id = objek.data('id');
      var to = objek.data('url'); 
      $.ajax({
        url : to,
        type:'post',
        data:{
          id:id
        },
        success : function(response){
      // nextAction();
      muatData()
      toastr['success']('Data berhasil dihapus')
    },
    error : function(response){
      toastr['error'](response.responseText);
    }
  })
    }

function readSession(){
  if(globalLink == ""){
    globalLink = window.location.href;
  }
  var url = globalLink;
  alert(url)
  globalLink = "";
  url = url.split('=');
}
function createSession(modul,page,take,filter,data){
  var id = "";
  var objek = {};
  objek.page = page;
  objek.take = take;
  objek.filter = filter;
  objek.data = data;
  var session = JSON.stringify(objek);
  session = btoa(session);
  history.pushState(data.konten, data.title, modul+"?session="+session);
  $('body a:not(#no-session)').each(function(index,el){
    var kelas = $(this).attr('class');
    var ada = false;
    if(kelas){
      kelas = kelas.split(' ');
      $.each(kelas,function(index,el){
        if(el == 'no-session'){
          ada = true;
        }
      })
    }
    if(ada == false){
      $(this).attr('href',$(this).attr('href') + "?session="+session)
    }
  })  
}
    function confirmDeleteAll(){
      var to = objek.data('url');
      var page = 1;
      var id = [];
      $('#checkRow:checked').each(function(index,el){
        $.ajax({
          url : to,
          type:'post',
          data:{
            id:$(this).data('id')
          },
          success : function(response){
            toastr['success']('Data berhasil dihapus');
            if(index == $('#checkRow:checked').length -1){
              muatData(page)
            }
          },
          error : function(response){
            toastr['error'](response.responseText);
          }
        })

      });
    }
    function callOverlay(targetId = 'box'){
      $('#' + targetId).append('<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>');
    }
    function removeOverlay(){
      $('body .overlay').remove();
    }

    function removeError(){
      $('body .has-error').removeClass('has-error');
      $('body .with-errors').remove();
    }
    function showError(responseJSON){
    // console.log(responseJSON)
    $.each(responseJSON, function(index, el){
      $.each(el,function(index2,el2){
        console.log('#group'+index2)
        $('body #group'+index2).addClass('has-error');
        $('body #group'+index2).append('<span class="help-block with-errors">'+el2+'</span>');
      })

    })
  } 
  $('body #btnImage').click(function(){
    alert()
  })
    function confirmLogout(){
      var link='action.php?q=logout';
    window.location.replace(link);
    }
  $("#btn-logout").click(function(e){
    e.preventDefault();
    e.preventDefault();
        konfirmasi('Anda akan logout?','Konfirmasi', logout ,'confirmLogout' , $(this),'danger');
    
  })
</script>

<div class="modal fade" id="modal-box">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  
const formatter = new Intl.NumberFormat(['ban', 'id'], {
      // style: 'currency',
      // currency: 'IDR',
      // minimumFractionDigits: 2
  })
</script>
</body>

</html>
