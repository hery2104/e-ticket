<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Tiket Baru</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form action="action.php?q=storetiket" method="POST" role="form" id="formaddtiket">

         <div class="row">
           <div class="col-md-8">
             <div class="form-group" id="groupArmada">
              <label>
                Armada :
              </label>
              <select name="Armada" id="Armada" class="form-control input-sm" required="required">
                <?php 
                foreach ($db->optionData('tb_armada') as $key => $value) { ?>
                  <option value="<?php echo $value['id'] ?>"><?php echo $value['nopol']; ?></option>
                <?php }
                 ?>
              </select>
            </div>
             <div class="form-group" id="groupRute">
              <label>
                Rute :
              </label>
              <select name="Rute" id="Rute" class="form-control input-sm" required="required">
                <?php 
                foreach ($db->optionData('tb_rute') as $key => $value) { ?>
                  <option value="<?php echo $value['id'] ?>"><?php echo $value['rute']; ?></option>
                <?php }
                 ?>
              </select>
            </div>


          </div>
          <div class="col-lg-4">
            <div class="form-group" id="groupStatus">
              <label>
                Status Aktif :
              </label>
              <select name="Status" id="Status" class="form-control input-sm" required="required">
                <option value="Y">Aktif</option>
                <option value="N">Tidak Aktif</option>
              </select>
            </div>
            <div class="form-group" id="groupJadwal">
              <label>
                Jadwal :
              </label>
              <select name="Jadwal" id="Jadwal" class="form-control input-sm" required="required">
                <option value="05:00">05:00</option>
                <option value="06:00">06:00</option>
                <option value="07:00">07:00</option>
                <option value="08:00">08:00</option>
                <option value="09:00">09:00</option>
                <option value="10:00">10:00</option>
                <option value="11:00">11:00</option>
                <option value="12:00">12:00</option>
                <option value="13:00">13:00</option>
                <option value="14:00">14:00</option>
                <option value="15:00">15:00</option>
                <option value="16:00">16:00</option>
                <option value="17:00">17:00</option>
                <option value="18:00">18:00</option>
                <option value="19:00">19:00</option>
                <option value="20:00">20:00</option>
                <option value="21:00">21:00</option>
              </select>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a type="button" href="index.php?pages=tiket" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
          <button type="submit" id="simpantiket" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
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


  var param='tiket';
  $('#formaddtiket').submit(function(e){
    e.preventDefault();
    console.log(this);
    $.ajax({
      url:"action.php?q=storetiket",
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
