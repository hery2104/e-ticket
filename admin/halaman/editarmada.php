<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit armada</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form action="action.php?q=updatearmada" method="POST" role="form" id="formeditarmada">

         <?php 
         $id=$_GET['id'];
         ?>
          <div class="row">
           <div class="col-md-8">
             <div class="form-group" id="groupNoPolisi">
              <label>
                Nama Armada :
              </label>
              <input class="form-control input-sm" name="NoPolisi" type="text" id="NoPolisi" value="<?php echo $db->getData('tb_armada','id',$id)['nopol']; ?>" />
              <input class="form-control input-sm" name="id" type="hidden" id="id" value="<?php echo $db->getData('tb_armada','id',$id)['id']; ?>" />
            </div>
             <div class="form-group" id="groupSeat">
              <label>
                Jumlah Kursi :
              </label>
              <input class="form-control input-sm" name="Seat" type="text" id="Seat" value="<?php echo $db->getData('tb_armada','id',$id)['jumlahbangku']; ?>" />
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-group" id="groupStatus">
              <label>
                Status Aktif :
              </label>
              <select name="Status" id="Status" class="form-control input-sm" required="required">
                <option value="Y" <?php if($db->getData('tb_armada','id',$id)['status']=='Y'){
                  echo "selected";
                } ?>>Aktif</option>
                <option value="N" <?php if($db->getData('tb_armada','id',$id)['status']=='N'){
                  echo "selected";
                } ?>>Tidak Aktif</option>
              </select>
            </div>
          </div>
        </div>
      <div class="box-footer">
        <a type="button" href="index.php?pages=armada" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
        <button type="submit" id="simpanarmada" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
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
  var param='armada';
  $('#formeditarmada').submit(function(e){
    e.preventDefault();
    console.log(this);
    $.ajax({
      url:"action.php?q=updatearmada",
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
