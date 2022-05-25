<div class="modal fade modal-xl" id="verProducto" tabindex="-1" aria-labelledby="verProductoLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                {{--  --}}
                <div class="card mb-3">
                    <div class="row g-0">
                      <div class="col-md-4">
                            <div id="mostrarImagen"></div>
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title" id="verProductoLabel"></h5>
                          <p class="card-text" id="descriptionVIEWMODAL"></p>
                          <p class="card-text" id="stockVIEWMODAL"></p>
                          <p class="card-text" id="priceVIEWMODAL"></p>
                          <p class="card-text" id="category"></p>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>
