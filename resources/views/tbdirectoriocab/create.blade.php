<form action="{{ route('tbdirectoriocab.store') }}" method="POST" >
  @csrf
  <div class="modal-body">
      <div class="mb-3">
          <label for="CODI_SESION" class="form-label">Código de sesión</label>
          <input type="text" class="form-control" id="CODI_SESION" name="CODI_SESION" value="{{ $lastCodiSesion }}" readonly>
      </div>
      <div class="mb-3">
          <input type="text" class="form-control d-none" id="CODI_PERIODO" name="CODI_PERIODO" value="{{ date('Y') }}" readonly>
      </div>
      <div class="mb-3">
          <label for="FECH_PROGRAMADA" class="form-label">Fecha programada</label>
          <input type="date" class="form-control" id="FECH_PROGRAMADA" name="FECH_PROGRAMADA" required>
      </div>
  </div>
  <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
        <i class="bi bi-x-circle-fill"> Cancelar</i>
    </button>
    <button type="submit" class="btn btn-primary ml-2" >
        <i class="bi bi-save2"> Registrar</i>
    </button>
  </div>
</form>
