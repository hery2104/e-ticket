
<div class="box box-primary" id="box-primary">
	<div class="box-header with-border">
		<div class="row">
			<div class="col-md-4">
				<a class="btn-sm btn btn-success" id="refresh"><i class="fa fa-refresh"></i></a>

				<a class="btn-sm btn btn-primary" id="ajaxlink" href="index.php?pages=addarmada"><i class="fa fa-plus"></i></a>

			</div>
			<div class="col-md-8">
				<span class="col-md-4">
					<select name="filter" id="filter" class="form-control input-sm">
						<option value="">Filter Data</option>
						<option value="armada">armada</option>
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
						<th width="10%">
							ID
						</th>
						<th>
							No Polisi
						</th>
						<th width="12%">
							Jumlah Kursi
						</th>
						<th width="7%">
							Status
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
	function muatData(page = 1){
		var filter = $('#filter').val();
		var data = $('#data').val();
		var take = $('#take').val();
		$.ajax({
			url : 'action.php?q=loadarmada',
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
						tbodyHtml += '<td>'+el.nopol+'</td>'
						tbodyHtml += '<td>'+el.jumlahbangku+'</td>'
						tbodyHtml += '<td>'+aktif+'</td>'

						tbodyHtml += '<td>'
						tbodyHtml += '<a class="btn-sm btn btn-warning btn-sm" href="index.php?pages=editarmada&id='+el.id+'" data-id="'+el.id+'" data-page="'+page+'" id="editData"><i class="fa fa-pencil"></i></a>'
						tbodyHtml += '<button class="btn-sm btn btn-danger btn-sm" data-url="action.php?q=deletearmada&id='+el.id+'" data-id="'+el.id+'" data-page="'+page+'" id="hapusData"><i class="fa fa-trash"></i></button>'

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