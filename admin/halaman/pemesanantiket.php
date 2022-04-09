
<div class="box box-primary" id="box-primary">
  <div class="box-header with-border">
    <div class="row">
      <div class="col-md-2">
        <a class="btn-sm btn btn-success" id="refresh"><i class="fa fa-refresh"></i></a><button class="btn btn-danger btn-sm" id="btnPdf" title="Export PDF" data-url="action.php?q=pdfpemesanantiket"><i class="fa fa-download"></i> PDF</button>

      </div>
      <div class="col-md-10">
        <span class="col-md-4">
          <select name="filter" id="filter" class="form-control input-sm">
            <option value="">Filter Data</option>
            <option value="pt.idtiket">No Tiket</option>
            <option value="pg.nama">Nama Pemesan</option>
          </select>
        </span>
        <span class="col-md-5">
          <div class="input-group">
            <input class="form-control input-sm" type="text" id="data" placeholder="Ketikkan kata kunci..."></input>
            <span class="input-group-btn">
              <button class="btn-sm btn btn-default" type="button" onclick="muatData()"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </span>
        <span class="col-md-3">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" readonly class="form-control input-sm pull-right" id="periode"> <span class="input-group-btn">
                <button class="btn-sm btn btn-default" type="button" onclick="muatData()"><i class="fa fa-search"></i></button>
              </span>
            </div>
            <!-- /.input group -->
          </div>
        </span>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="box table-responsive" id="box-table" class="col-md-12">
      <table class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>

            <th width="2%">
              No
            </th>
            <th>
              ID Pemesanan
            </th>
            <th>
              Nama Pelanggan
            </th>
            <th width="10%">
              No Tiket
            </th>
            <th width="10%">
              Metode Pembayaran
            </th>
            <th width="5%">
              Jumlah Kursi
            </th>
            <th width="10%">
              Subtotal
            </th>
            <th width="10%">
              Poin Transaksi
            </th>
            <th width="7%">
              Status
            </th>
            <th width="10%">
              Tanggal
            </th>
            <th width="7%">
              Action
            </th>

          </tr>
        </thead>
        <tbody id="data">

        </tbody>
      </table>
    </div>
  </div>
  <div class="box-footer">
    <div class="col-md-4">
      <table width="100%">
        <tr>
          <td width="40%">
            <!-- {{Lang::get('globals.labelJumlahTampil')}}:  -->
          </td>
          <td width="20%">
            <select id="take" class="form-control input-sm" onchange="muatData()">
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </td>
          <td>
            &nbsp; Total : <span id="totalRecord"></span> Data
          </td>
        </tr>
      </table>
    </div>
    <div class="col-md-8">
      <div class="pull-right">
        <ul class="pagination" style="margin: 0px">
        </ul>
      </div>  
    </div>
  </div>
</div>

<div class="modal fade" id="modal-detail">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Detail Pemesanan Tiket</h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>

              <th width="2%">
                No
              </th>
              <th>
                ID Pemesanan
              </th>
              <th>
                Nama Pelanggan
              </th>
              <th width="10%">
                No Tiket
              </th>
              <th width="5%">
                No Kursi
              </th>
            </tr>
          </thead>
          <tbody id="dataDetail">

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
   $('#periode').daterangepicker({
    locale: {
      format: 'YYYY-MM-DD'
    }
  });
   muatData();
   $('#refresh').click(function(){
    $('#take').val(10);
    $('#data').val('');
    $('#filter').val('');
    muatData();
  })
 });
  $('#btnPdf').click(function(e){
    var link=$(this).data('url');
    var filter = $('#filter').val();
    var data = $('#data').val();
    var periode = $('#periode').val();
    e.preventDefault()
    $.ajax({
      url:link,
      type : 'POST',
      data : {
        periode:periode,
        filter : filter,
        data : data,
      },
      success:function(res){
        var bodyHtml='';
        var result=JSON.parse(res);
        var data=result.data;
        console.log(data);
        bodyHtml+='<center><h2>LAPORAN TRANSAKSI PEMESANAN TIKET</h2>';
        bodyHtml+='<p>Periode : '+periode+'</p></center>';
        bodyHtml+='<table class="table table-condensed" border="1" width="100%">';
        bodyHtml+='<tr style="background-color:#eaeaea;"><th>No</th><th>ID Pemesanan</th><th>Nama</th><th>ID Tiket</th><th>Item</th><th>Poin</th><th>No Kursi</th><th>Subtotal</th><th>Tanggal</th></tr>';
        bodyHtml+='<tbody>';
        var urut=0;
        $.each(data, function(index, el){
          ++urut;
          bodyHtml+='<tr>';
          bodyHtml+='<td>'+urut+'</td>';
          bodyHtml+='<td>#'+el.id+'</td>';
          bodyHtml+='<td>'+el.nama+'</td>';
          bodyHtml+='<td>'+el.item+'</td>';
          bodyHtml+='<td>'+el.idtiket+'</td>';
          bodyHtml+='<td>'+el.poin+'</td>';
          bodyHtml+='<td>'+el.seat+'</td>';
          bodyHtml+='<td>'+formatter.format(el.subtotal)+'</td>';
          bodyHtml+='<td>'+el.created_at+'</td>';
          bodyHtml+='</tr>';
        });
        bodyHtml+='</tbody>';
        bodyHtml+='</table>';
        printDiv(bodyHtml)
      }
    })
  });
  function openModal(id){
    $("#modal-detail").modal('show');
    muatDetail(id)
  }
  function muatDetail(id){
    $.ajax({
      url : 'action.php?q=loadpemesanantiketdetail',
      type : 'POST',
      data : {
        id:id
      },
      beforeSend : function(){
        $('body .box').append('<div class="overlay" align="center" style="padding-top:20px;"><br/><p><img src=""></p><i class="fa fa-spinner fa-spin fa-5x"></i></div>');
      },
      complete : function(){
        $('body .overlay').remove();
      },
      success : function(response){
        console.log(response)
        var urut=0;
        var aktif;
        var detailBody='';
        var res=JSON.parse(response);
          res=res.data;
        $.each(res, function(index, el){
          urut++;
          detailBody += '<tr>'

          detailBody += '<td>'+urut+'</td>'
          detailBody += '<td>'+el.id+'</td>'
          detailBody += '<td>'+el.nama+'</td>'
          detailBody += '<td>'+el.idtiket+'</td>'
          detailBody += '<td>'+el.seat+'</td>'


          detailBody += '</tr>'
        })
        $("#dataDetail").append(detailBody);
      },
      error : function(data){
        toastr['error'](data.statusText);
      }
    })
  }
  function muatData(page = 1){
    var filter = $('#filter').val();
    var data = $('#data').val();
    var take = $('#take').val();
    var periode = $('#periode').val();
    $.ajax({
      url : 'action.php?q=loadpemesanantiket',
      type : 'POST',
      data : {
        filter : filter,
        data : data,
        page : page,
        take : take,
        periode:periode
      },
      beforeSend : function(){
        $('body .box').append('<div class="overlay" align="center" style="padding-top:20px;"><br/><p><img src=""></p><i class="fa fa-spinner fa-spin fa-5x"></i></div>');
      },
      complete : function(){
        $('body .overlay').remove();
      },
      success : function(response){
        var activePage;
        var totalPage;
        var totalRecord;

        var tbodyHtml = '';
        if (response.length==4) {
          toastr['error'](response+' Error parameter');
        }else{
          var aktif=JSON.parse(response);
          result=aktif.data;
          totalPage=aktif.totalPage;
          totalRecord=aktif.totalRecord;
          activePage=aktif.activePage;
          var urut=0;
          var aktif;
          $.each(result, function(index, el){
            urut++;
            aktif=el.status;
            if (aktif=='Y') {
              aktif='<span class="label label-success">Aktif</span>';
            }else{
              aktif='<span class="label label-danger">Tidak Aktif</span>';
            }
            tbodyHtml += '<tr>'

            tbodyHtml += '<td>'+urut+'</td>'
            tbodyHtml += '<td>'+el.id+'</td>'
            tbodyHtml += '<td>'+el.nama+'</td>'
            tbodyHtml += '<td>'+el.idtiket+'</td>'
            tbodyHtml += '<td>'+el.metodepembayaran+'</td>'
            tbodyHtml += '<td>'+el.item+'</td>'
            tbodyHtml += '<td>'+formatter.format(el.subtotal)+'</td>'
            tbodyHtml += '<td>'+el.poin+'</td>'
            tbodyHtml += '<td>'+aktif+'</td>'
            tbodyHtml += '<td>'+el.created_at+'</td>'

            tbodyHtml += '<td>'
            tbodyHtml += '<button class="btn-sm btn btn-info btn-sm" onclick="openModal('+el.id+')" id="detailData"><i class="fa fa-eye"></i></button>'

            tbodyHtml += '</td>'

            tbodyHtml += '</tr>'
          })
          loadPagination('pagination',totalPage, activePage, totalRecord)
          $('body #data').html(tbodyHtml);
          if(totalRecord == 0){
            $('.box-body table #data').html('<tr><td colspan="8" align="center"><div><p></p>Data tidak ada</div></td></tr>');
          }
        // createSession('slider',page,take,filter,data);
      }
    },
    error : function(data){
      toastr['error'](data.statusText);
    }
  })
  }
</script>