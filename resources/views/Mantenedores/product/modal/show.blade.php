
<style>
  .pildora{
    background:rgb(0, 76, 255);
    border-radius: 100px;
    padding: 5px 20px;
    color: #FFF;
    font-size: 1.2rem;
  }

  .cantidad{
    background:rgb(197, 116, 34);
    border-radius: 100px;
    padding: 5px 20px;
    color: #FFF;
    font-size: 1.2rem;
  }
</style>
<div class="modal fade " id="verProducto" tabindex="-1" aria-labelledby="verProductoLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
              <h3 class="card-title mb-0" id="verProductoLabel"></h3>
              
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                {{--  --}}
           
                  {{--  --}}
                  <div class="card">
                      
                    <div id="mostrarImagen"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center px-2">
                       <h6 class="pildora"  id="category"></h6>
                       <h5 class="cantidad" id="stockVIEWMODAL"></h5>
                        <p class="" style="color: rgb(1, 112, 1); font-size: 2rem;" id="priceVIEWMODAL"></p>
                     </div>
                     <hr>
                      <h5 class="px-2" id="descriptionVIEWMODAL">
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>
