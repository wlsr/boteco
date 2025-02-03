<?php 
	require_once('database/Database.php');
	$db = new Database();
	//get all items
	$sql = "SELECT *
			FROM laboratorio
			ORDER BY nombre_lab ASC";
	$items = $db->getRows($sql);
 ?>
 
 <div class="modal fade" id="modal-laboratorio" tabindex="-1" aria-labelledby="modal-laboratorio-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content col-md-8 mod-stile modal-labo">
      <form id="form-laboratorio" method="POST" action="#">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <h4 class="modal-title mx-auto" id="modal-laboratorio-title">Agregar Laboratorio</h4>
      </div>
        <div class="modal-body col-md-12">
            <div class="form-group">
                <input required type="text" class="form-control col-md-4" id="lab-name" name="lab-name" 
                       onkeyup="this.value = this.value.toUpperCase()" 
                       onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || 
                                          (event.charCode >= 97 && event.charCode <= 122) || 
                                          event.charCode === 32)" required>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-success" id="add-lab-btn">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-tipo" tabindex="-1" aria-labelledby="modal-tipo-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content col-md-8 mod-stile modal-labo">
      <form id="form-tipo" method="POST" action="#">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <h4 class="modal-title mx-auto" id="modal-tipo-title">Agregar categoria</h4>
    </div>
        <div class="modal-body col-md-12">
            <div class="form-group">
                <input required type="text" class="form-control col-md-4" id="tipo-name" name="tipo-name" 
                       onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || 
                                          (event.charCode >= 97 && event.charCode <= 122) || 
                                          event.charCode === 32)" required>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-warning" id="add-tipo-btn">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

