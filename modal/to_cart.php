<div class="modal fade" id="modal-to-cart" tabindex="-1" aria-labelledby="modalToCartLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center w-100" id="modalToCartLabel"><b>Cantidad</b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-toCart" class="row g-3">
          <input type="hidden" id="item-id">
          <input type="hidden" id="stock-id">
          <input type="hidden" id="item-qty">
          
          <div class="col-12 text-center">
            <input type="number" min="1" class="form-control d-inline-block w-75" id="cart-qty" value="1" required>
          </div>

          <div class="col-12 text-center">
            <button type="submit" class="btn btn-success btn-sm mt-3" id="addToCartButton">OK</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
