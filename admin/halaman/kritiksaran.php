
<div class="box box-primary" id="box-primary">
	<div class="box-header with-border">
		<div class="row">
			<div class="col-md-4">
				<a class="btn-sm btn btn-success" id="refresh"><i class="fa fa-refresh"></i></a>
				<button class="btn btn-danger btn-sm" id="btnPdf" title="Export PDF" data-url="action.php?q=pdfpenukaranpoin"><i class="fa fa-download"></i> PDF</button>

			</div>
			<div class="col-md-8">
				<span class="col-md-4">
					<select name="filter" id="filter" class="form-control input-sm">
						<option value="">Filter Data</option>
						<option value="nama">Nama</option>
					</select>
				</span>
				<span class="col-md-8">
					<div class="input-group">
						<input class="form-control input-sm" type="text" id="data" placeholder="Ketikkan kata kunci..."></input>
						<span class="input-group-btn">
							<button class="btn-sm btn btn-default" type="button" onclick="muatData()"><i class="fa fa-search"></i></button>
						</span>
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
							Nama Pengguna
						</th>
						<th>
							Kritik Saran
						</th>
						<th>
							Tiket
						</th>
						<th>
							Rute
						</th>
						<th>
							Armada
						</th>
						<th>
							Tanggal
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
<div class="modal fade" id="modal-reply">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="idBalasan" id="idBalasan" class="form-control" required="required">
				<label>Ketikkan Balasan :</label>
				<textarea name="Balasan" id="inputBalasan" class="form-control" rows="3" required="required"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				<button type="button" id="simpanBalasan" class="btn btn-primary">Simpan Balasan</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		muatData();
		$('#refresh').click(function(){
			$('#take').val(10);
			$('#data').val('');
			$('#filter').val('');
			muatData();
		})
	});
	$("#simpanBalasan").click(function(){
		var idBalasan=$("#idBalasan").val();
		var isiBalasan=$("#inputBalasan").val();
		if(isiBalasan==''){
			alert('Silahkan isi balasan');
			return false;
		}
		$.ajax({
			url:'action.php?q=simpanbalasan',
			type : 'POST',
			data : {
				id : idBalasan,
				isiBalasan : isiBalasan
			},
			success:function(res){
				alert('Berhasil simpan balasan')
				$("#modal-reply").modal('hide');
				muatData();
			}
		})
	})
	$('#btnPdf').click(function(e){
		var link=$(this).data('url');
		var filter = $('#filter').val();
		var data = $('#data').val();
		e.preventDefault()
		$.ajax({
			url:'action.php?q=loadkritiksaran',
			type : 'POST',
			data : {
				_token : '{{csrf_token()}}',
				filter : filter,
				data : data,
				page : 1,
				take : 1000000
			},
			success:function(res){
				var bodyHtml='';
				var result=JSON.parse(res);
				var data=result.data;
				console.log(data);
				bodyHtml+='<center><h2>LAPORAN KRITIK SARAN</h2>';
				bodyHtml+='<table class="table table-condensed" border="1" width="100%">';
				bodyHtml+='<tr style="background-color:#eaeaea;"><th>No</th><th>Nama Pelanggan</th><th>Kritik Saran</th><th>Tiket</th><th>Rute</th><th>Armada</th><th>Tanggal</th></tr>';
				bodyHtml+='<tbody>';
				var urut=0;
				$.each(data, function(index, el){
					++urut;
					bodyHtml+='<tr>';
					bodyHtml += '<td>'+urut+'</td>'
					bodyHtml += '<td>'+el.nama+'</td>'
					bodyHtml += '<td>'+el.kritiksaran+'</td>'
					bodyHtml += '<td>'+el.idpemesanan+'</td>'
					bodyHtml += '<td>'+el.rute+'</td>'
					bodyHtml += '<td>'+el.nopol+'</td>'
					bodyHtml += '<td>'+el.created_at+'</td>'
					bodyHtml+='</tr>';
				});
				bodyHtml+='</tbody>';
				bodyHtml+='</table>';
				printDiv(bodyHtml)
			}
		})
	});
	function muatReply(id){
		$("#modal-reply").modal('show');
		$("#idBalasan").val(id);
	}
	function muatData(page = 1){
		var filter = $('#filter').val();
		var data = $('#data').val();
		var take = $('#take').val();
		$.ajax({
			url : 'action.php?q=loadkritiksaran',
			type : 'POST',
			data : {
				filter : filter,
				data : data,
				page : page,
				take : take
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
					console.log(result)
					totalPage=aktif.totalPage;
					totalRecord=aktif.totalRecord;
					activePage=aktif.activePage;
					var urut=0;
					var aktif;
					$.each(result, function(index, el){
						urut++;
						tbodyHtml += '<tr>'

						tbodyHtml += '<td>'+urut+'</td>'
						tbodyHtml += '<td>'+el.nama+'</td>'
						tbodyHtml += '<td>'+el.kritiksaran+'</td>'
						tbodyHtml += '<td>'+el.idpemesanan+'</td>'
						tbodyHtml += '<td>'+el.rute+'</td>'
						tbodyHtml += '<td>'+el.nopol+'</td>'
						tbodyHtml += '<td>'+el.created_at+'</td>'

						// tbodyHtml += '<td>'
						// tbodyHtml+='<a class="btn-sm btn btn-info" id="openReply" onclick="muatReply('+el.id+')"><i class="fa fa-reply"></i></a>'
						// tbodyHtml += '</td>'

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