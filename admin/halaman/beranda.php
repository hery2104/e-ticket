<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">

      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="placeholder">
          
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    loadModul()
  })
  function loadModul(){
    filter='>0';
    $.ajax({
      url : 'action.php?q=loadmodul',
      type : 'post',
      data : {
        filter : filter,
      },
      beforeSend : function(){
        $('body .placeholder').append('<div class="overlay" align="center" style="padding-top:20px;"><br/><p><img src=""></p><i class="fa fa-spinner fa-spin fa-5x"></i></div>');
      },
      complete : function(){
        $('body .overlay').remove();
      },
      success : function(response){
        console.log(response)
        var contentHtml='';
        var urut=0;
        var color='';
        if (response.length>2) {
          $.each(JSON.parse(response),function(index,el){
            urut++;
            if (urut%2==0) {
              color='bg-green';
            }else{
              color='bg-aqua';
            }
            console.log(el)
            contentHtml+='<div class="col-lg-3 col-xs-6">'
            contentHtml+='<a href="index.php?pages='+el.defaultlink+'" style="color:#ffffff;"><div class="small-box bg-aqua">'
            contentHtml+='<div class="inner">'
            contentHtml+='<div class="single-package-item-txt">'
            contentHtml+='<h4>'+el.namamodul+'</h4>'
            contentHtml+='<p>'+el.namamodul+'</p>'
            contentHtml+='</div>'
            contentHtml+='<div class="icon">'
            contentHtml+='<i class="fa fa-shopping-cart"></i>'
            contentHtml+='</div>'
            contentHtml+='<a href="#" class="small-box-footer">'
            contentHtml+='More info <i class="fa fa-arrow-circle-right"></i>'
            contentHtml+='</a>'
            contentHtml+='</div></div></a></div>'
          })
          $('body .placeholder').html(contentHtml);
        }else{

          $('body .placeholder').html('<center><div style="border: #eaeaea 1px solid;min-height: 200px;"><p style="margin-top:50px;"><i class="fa fa-warning fa-4x"></i></p>Data tidak ada</div></center>');

        }

      },
      error : function(data){
        toastr['error'](data.statusText);
      }
    })
  }
</script>