<?php 
	require_once('database/Database.php');
	$db = new Database();
	//get all items
	$sql = "SELECT *
			FROM laboratorio
			ORDER BY nombre_lab ASC";
	$items = $db->getRows($sql);
 ?>
<div class="modal fade" id="modal-stock">
  <div class="modal-dialog">
    <div class="modal-content col-sm-9">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <!-- FORM -->
        <form class="form-horizontal" role="form" id="form-stock">
          <div class="form-group row">
            <label class="control-label col-sm-3 font-weight-bold" for="">Producto:</label>
            <div class="col-sm-6">
              <select class="btn btn-success" id="item-id">
                <?php foreach($items as $i): ?>
                  <option value="<?= $i['lab_id']; ?>"><?= ucwords($i['nombre_lab'] ); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 font-weight-bold" for="">Cantidad:</label>
            <div class="col-sm-3"> 
              <input type="number" min="1" class="form-control" id="qty" required="">
            </div>
          </div>

          <!-- anulado temporalmente  -->
          <div class="form-group row">
            <label class="control-label col-sm-3 font-weight-bold" for="">Vence:</label>
            <div class="col-sm-6"> 
              <input type="date" class="form-control" id="xDate" required="">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 font-weight-bold" for="">Fabricado:</label>
            <div class="col-sm-6"> 
              <input type="date" class="form-control" id="manu" required="">
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 font-weight-bold" for="">Comprado:</label>
            <div class="col-sm-6"> 
              <input type="date" class="form-control" id="purc" required="">
            </div>
          </div>

          <div class="form-group row"> 
            <div class="col-sm-offset-3 col-sm-9">
              <button type="submit" class="btn btn-warning">Guardar datos
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
              </button>
            </div>
          </div>
        </form>
        <!-- END FORM -->
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
