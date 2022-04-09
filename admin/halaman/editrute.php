<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Rute</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form action="action.php?q=updaterute" method="POST" role="form" id="formeditrute">

         <?php 
         $id=$_GET['id'];
         ?>
          <div class="row">
           <div class="col-md-8">
             <div class="form-group" id="groupRute">
              <label>
                Nama Rute :
              </label>
              <input class="form-control input-sm" name="Rute" type="text" id="Rute" value="<?php echo $db->getData('tb_rute','id',$id)['rute']; ?>" />
              <input class="form-control input-sm" name="id" type="hidden" id="id" value="<?php echo $db->getData('tb_rute','id',$id)['id']; ?>" />
            </div>
            <div class="form-group" id="groupTarif">
              <label>
                Tarif :
              </label>
              <input class="form-control input-sm" name="Tarif" type="number" id="Tarif" value="<?php echo $db->getData('tb_rute','id',$id)['tarif']; ?>"/>
            </div>


          </div>
          <div class="col-lg-4">
            <div class="form-group" id="groupStatus">
              <label>
                Status Aktif :
              </label>
              <select name="Status" id="Status" class="form-control input-sm" required="required">
                <option value="Y" <?php if($db->getData('tb_rute','id',$id)['status']=='Y'){
                  echo "selected";
                } ?>>Aktif</option>
                <option value="N" <?php if($db->getData('tb_rute','id',$id)['status']=='N'){
                  echo "selected";
                } ?>>Tidak Aktif</option>
              </select>
            </div>
          </div>
        </div>
      <div class="box-footer">
        <a type="button" href="index.php?pages=rute" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
        <button type="submit" id="simpanrute" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </form>

  </div>
</div>
</div>
</div>

<script> 
 function nextAction(data){
  $('form')[0].reset();
}
$(document).ready(function(){
  var param='rute';
  $('#formeditrute').submit(function(e){
    e.preventDefault();
    console.log(this);
    $.ajax({
      url:"action.php?q=updaterute",
      method:"POST",
      data:new FormData(this),
      dataType:'JSON',
      contentType: false,
      cache: false,
      processData: false,
      beforeSend : function(){
        removeError();
        callOverlay('box-primary');
      },
      complete : function(){
        removeOverlay();
      },
      error : function(data){

        toastr['error'](data.responseText);
      },
      success : function(data){
        console.log(data)
        toastr['success']('Data berhasil simpan');
        nextAction(data);
      }
    })

  })


})
</script>
