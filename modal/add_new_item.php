<?php 
require_once('database/Database.php');
$db = new Database();
$sql = "SELECT *
		FROM item_type
		ORDER BY item_type_desc ASC";
$types = $db->getRows($sql);
$sql2 = "SELECT *
		FROM laboratorio
		ORDER BY nombre_lab ASC";
$types2 = $db->getRows($sql2);
// echo '<pre>';
// 	print_r($types);
// echo '</pre>';
 ?>
<div class="modal fade" id="modal-item" tabindex="-1" aria-labelledby="modalItemLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Encabezado del modal -->
      <div class="modal-header first-row">
        <h5 class="modal-title text-center" id="modalItemLabel">Modal Title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Cuerpo del modal -->
      <div class="modal-body">
        <form class="needs-validation" id="form-item" novalidate>
          <input type="hidden" id="item-id">
          
          <!-- Producto -->
          <div class="mb-3 row">
            <label for="item-name" class="col-sm-3 col-form-label fw-bold">Producto:</label>
            <div class="col-sm-9">
              <input type="text" maxlength="50" class="form-control" id="item-name" placeholder="Ingresa el nombre genérico" required autofocus>
            </div>
          </div>
          
          <!-- Código -->
          <div class="mb-3 row">
            <label for="code" class="col-sm-3 col-form-label fw-bold">Código:</label>
            <div class="col-sm-9">
              <input type="text" maxlength="50" class="form-control w-75" id="code" placeholder="Código" required>
            </div>
          </div>
          
          <!-- Precio -->
          <div class="mb-3 row">
            <label for="item-price" class="col-sm-3 col-form-label fw-bold">Precio:</label>
            <div class="col-sm-9">
              <input type="number" min="0.1" step="any" class="form-control w-50" id="item-price" placeholder="Bs." required>
            </div>
          </div>
          
          <!-- Gramos -->
          <div class="mb-3 row">
            <label for="grams" class="col-sm-3 col-form-label fw-bold">Gramos:</label>
            <div class="col-sm-9">
              <input type="number" min="0" step="any" class="form-control w-50" id="grams" placeholder="Gr" required>
            </div>
          </div>
          
          <!-- Tipo -->
          <div class="mb-3 row">
            <label for="item-type" class="col-sm-3 col-form-label fw-bold">Tipo:</label>
            <div class="col-sm-9">
              <select id="item-type" class="form-select form-select-sm w-50">
                <?php foreach ($types as $t): ?>
                  <option value="<?= $t['item_type_id']; ?>"><?= ucwords($t['item_type_desc']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          
          <!-- Laboratorio -->
          <div class="mb-3 row">
            <label for="brand" class="col-sm-3 col-form-label fw-bold">Laboratorio:</label>
            <div class="col-sm-9">
              <select id="brand" class="form-select w-75">
                <?php foreach ($types2 as $t2): ?>
                  <option value="<?= $t2['lab_id']; ?>"><?= ucwords($t2['nombre_lab']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          
          <!-- Botón Guardar -->
          <div class="text-center mt-4">
            <button type="submit" id="submit-item" value="add" class="btn btn-success">
              Guardar datos <i class="bi bi-save"></i>
            </button>
          </div>
        </form>
      </div>
      <!-- Pie del modal -->
      <div class="modal-footer first-row text-center">
        <small class="small-texto">F&nbsp;a&nbsp;r&nbsp;m&nbsp;a&nbsp;c&nbsp;i&nbsp;a&nbsp;&nbsp;B&nbsp;o&nbsp;t&nbsp;i&nbsp;m&nbsp;a&nbsp;r&nbsp;k&nbsp;e&nbsp;t&nbsp;&nbsp;
          <img src="img/logo.png" alt="Descripción de la imagen" width="42" height="42">
        </small>
      </div>
    </div>
  </div>
</div>


<?php 
$db->Disconnect();
 ?>