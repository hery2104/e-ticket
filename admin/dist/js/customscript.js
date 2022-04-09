const formatter = new Intl.NumberFormat(['ban', 'id'], {
      // style: 'currency',
      // currency: 'IDR',
      // minimumFractionDigits: 2
  })
function loadPagination(targetClass, totalPage, activePage, totalRecord){
	// alert(totalRecord)
	totalRecord = parseInt(totalRecord);
	totalPage  	= parseInt(totalPage);
	activePage  = parseInt(activePage);
	var listPageHtml = '';
	
	if(activePage == 1){
		listPageHtml += '<li class="disabled"><a id="no-session">First</a></li>'
		listPageHtml += '<li class="disabled"><a id="no-session">Previous</a></li>'
	}else{
		listPageHtml += '<li><a id="no-session" href="javascript:muatData(1)">First</a></li>'
		listPageHtml += '<li><a id="no-session" href="javascript:muatData('+(activePage - 1)+')">Previous</a></li>'
	}
	if(activePage - 3 <= 0){
		if(totalPage >= 7){
			var y = 7;
		}else{
			y = totalPage;
		}
		for(var x = 1 ; x <= y ; x++){
			if(x == activePage){
				listPageHtml += '<li class="active"><a id="no-session" class="nomor">'+x+'</a></li>'
			}
			else{
				listPageHtml += '<li ><a id="no-session" href="javascript:muatData('+x+')" class="nomor">'+x+'</a></li>'
			}
		}
	}
	else if(activePage + 3 >= totalPage){
		for(var x = totalPage - 6 ; x <= totalPage ; x++){

			if(x > 0){
				if(x == activePage){
					listPageHtml += '<li class="active"><a id="no-session" class="nomor">'+x+'</a></li>'
				}
				else{
					listPageHtml += '<li ><a id="no-session" href="javascript:muatData('+x+')" class="nomor">'+x+'</a></li>'
				}
			}
		}
	}
	else{
		if(activePage+3 <= totalPage ){
			var y = activePage + 3;
		}else{
			var y = totalPage;
		}
		for(var x = activePage - 3 ; x <= y; x++){
			if(x > 0){
				if(x == activePage){
					listPageHtml += '<li class="active"><a id="no-session" class="nomor">'+x+'</a></li>'
				}
				else{
					listPageHtml += '<li ><a id="no-session" href="javascript:muatData('+x+')" class="nomor">'+x+'</a></li>'
				}
			}
		}
	}



	if(activePage == totalPage){
		listPageHtml += '<li class="disabled"><a id="no-session">Next</a></li>'
		listPageHtml += '<li class="disabled"><a id="no-session">Last</a></li>'
	}else{
		listPageHtml += '<li><a id="no-session" href="javascript:muatData('+(parseInt(activePage + 1))+')">Next</a></li>'
		listPageHtml += '<li><a id="no-session" href="javascript:muatData('+totalPage+')">Last</a></li>'
	}
	$('body .'+targetClass).html(listPageHtml);
	$('body #totalRecord').html(totalRecord);
}
function konfirmasi(message = '', title = '', button, onOk, obj , allow = 'primary', dismiss = 'default', nextaction = 'next'){
	
	objek = obj;
	console.log(objek.data('id'));
	$('#modal-box .modal-body').html(message);
	$('#modal-box .modal-title').html(title);
	var buttonHtml = '';
	$.each(button,function(index,el){
		if(index == dismiss)
			buttonHtml += '<button type="button" class="btn btn-'+index+'" data-dismiss="modal">'+el+'</button>';
		else if(index == allow){
			buttonHtml += '<a id="no-session" type="button" class="btn btn-'+index+'" onclick="'+onOk+'();$(\'#modal-box\').modal(\'hide\');">'+el+'</a>';
		}
	})
	$('#modal-box .modal-footer').html(buttonHtml);

	$('#modal-box').modal('show');
}

var simpan = {primary :'<i class="fa fa-check"></i> Ya',default :'<i class="fa fa-check"></i> No'};