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
                    <div class="row">
                        <div class="card-body">
                          <div class="row p-2">
                            <div class="col d-flex justify-content-center">
                              <div id="mostrarImagen"></div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col d-flex justify-content-center">
                              <h5 class="card-title" id="verProductoLabel"></h5>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col d-flex justify-content-center">
                              <p class="card-text" id="descriptionVIEWMODAL"></p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col d-flex justify-content-center">
                              <p class="card-text" id="stockVIEWMODAL"></p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col d-flex justify-content-center">
                              <p class="card-text" id="priceVIEWMODAL"></p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col d-flex justify-content-center">
                              <p class="card-text" id="category"></p>
                              </div>
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
