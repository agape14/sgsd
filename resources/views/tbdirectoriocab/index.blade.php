<x-app-layout>
  <x-slot name="header">
      <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>Sesion de Directorio</h3>
              <!--<p class="text-subtitle text-muted">Sub titulo de la sesin.</p>-->
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
              <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="/dashboard">Inicio</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Sesion de Directorio</li>
                  </ol>
              </nav>
          </div>
      </div>
  </x-slot>
  <section class="section">
      <div class="card">
          <div class="card-body">
              <section id="multiple-column-form">
                  <div class="row match-height">
                      <div class="col-12">
                          <div class="card">
                              <div class="card-header">
                                  <h4 class="card-title">Búsqueda</h4>
                              </div>
                              <div class="card-content">
                                  <div class="card-body pb-0">
                                      <form class="form" id="search-form">
                                          <div class="row">
                                              <div class="col-md-4 col-12">
                                                  <div class="form-group">
                                                      <label for="CODI_SESION">N° de Sesión de Directorio</label>
                                                      <input type="number" id="CODI_SESION" class="form-control" name="CODI_SESION">
                                                  </div>
                                              </div>
                                              <div class="col-md-4 col-12">
                                                  <div class="form-group">
                                                      <label for="FECH_PROGRAMADA">Fecha Programada</label>
                                                      <input type="date" id="FECH_PROGRAMADA" class="form-control" name="FECH_PROGRAMADA">
                                                  </div>
                                              </div>
                                              <div class="col-md-4 col-12">
                                                  <div class="form-group">
                                                      <label for="CODI_ESTADO_S">Estado de Sesión</label>
                                                      <fieldset class="form-group">
                                                          <select class="form-select" id="CODI_ESTADO_S" name="CODI_ESTADO_S">
                                                                <option value="">Todos</option>
                                                                @foreach ($listestadosesion as $estado)
                                                                    <option value="{{ $estado->CODI_ESTADO }}">{{ $estado->DESC_ESTADO }}</option>
                                                                @endforeach
                                                          </select>
                                                      </fieldset>
                                                  </div>
                                              </div>

                                              <div class="col-12 d-flex justify-content-end">
                                                  <button type="button" class="btn btn-primary me-1 mb-1" id="btnSearchSesion"><i class="bi bi-search" ></i> Buscar</button>
                                                  <button type="button" class="btn btn-secondary me-1 mb-1" id="btnClearSearchSesion"><i class="bi bi-shield-lock"></i> Limpiar</button>
                                              </div>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </section>
              
              
          </div>
      </div>
      <div class="card">
          <div class="card-body">
              <section class="section">
                  <div class="card">
                      <div class="panel-heading">
                          <div class="d-flex justify-content-end">
                                  <a href="#" class="btn btn-success me-1 mb-1" data-bs-toggle="modal" data-bs-target="#createModal"><i class="bi bi-file-earmark-plus"></i> Nueva Sesion</a>
                          </div>
                      </div>
                      <div class="card-body">
                          <table class="table table-hover table-striped border-primary table-bordered" id="tblSesionDirectorio">
                              <thead>
                                  <tr>
                                      <th>N° Sesión</th>
                                      <th>Fecha</th>
                                      <th>N° de Temas</th>
                                      <th>N° de Acuerdos</th>
                                      <th>% Avance</th>
                                      <th>Estado</th>
                                      <th width="12%"><i class="bi bi-stack"></i></th>
                                  </tr>
                              </thead>
                              <tbody></tbody>
                          </table>
                      </div>
                  </div>

              </section>
          </div>
      </div>
  </section>

  <!--NUEVA SESION form Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Crear nuevo registro</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="frmRegistraSesion" >
              @csrf
              <input type="hidden" name="_method" value="POST">
              <div class="modal-body">
                  <div class="mb-3">
                      <label for="CODI_SESION" class="form-label">Código de sesión</label>
                      <input type="text" class="form-control" id="CODI_SESION_AD" name="CODI_SESION" value="" readonly>
                  </div>
                  <div class="mb-3">
                      <input type="text" class="form-control d-none" id="CODI_PERIODO_AD" name="CODI_PERIODO" value="{{ date('Y') }}" readonly>
                  </div>
                  <div class="mb-3">
                      <label for="FECH_PROGRAMADA" class="form-label">Fecha programada</label>
                      <input type="date" class="form-control" id="FECH_PROGRAMADA_AD" name="FECH_PROGRAMADA" required>
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
          </div>
      </div>
  </div>
</div>

  <!--EDITAR SESION form Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Sesion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="frmActualizaSesion">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="CODI_SESION" class="form-label">Código de sesión</label>
                        <input type="text" class="form-control" id="CODI_SESION_ED" name="CODI_SESION" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control d-none" id="CODI_PERIODO_ED" name="CODI_PERIODO" value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="FECH_PROGRAMADA" class="form-label">Fecha programada</label>
                        <input type="date" class="form-control" id="FECH_PROGRAMADA_ED" name="FECH_PROGRAMADA" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"> Cancelar</i></button>
                    <button type="submit" class="btn btn-primary ml-2" ><i class="bi bi-save2"> Actualizar</i></button>
                </div>
              </form>
            </div>
        </div>
    </div>
  </div>


 
<script type="module">
  $(document).ready(function() {
    getDatosTable();
    $('#btnSearchSesion').click(function() {
      var codi_sesion = $('#CODI_SESION').val();
      var fech_programada = $('#FECH_PROGRAMADA').val();
      var codi_estado = $('#CODI_ESTADO_S').val();
      var table = $('#tblSesionDirectorio').DataTable();
      table.ajax.url("{{ route('tbdirectoriocab.index') }}?CODI_SESION=" + codi_sesion + "&FECH_PROGRAMADA=" + fech_programada + "&CODI_ESTADO=" + codi_estado).load();
    });

    $(document).on('click', '#btnDeleteSesion', function() {
        var id = $(this).data('delete-id');
        var url = "{{ route('tbdirectoriocab_delete', ':id') }}".replace(':id', id);
        Swal.fire({
          title: '¿Estás seguro de eliminar?',
          text: 'No podrás recuperar la sesion '+id,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, estoy seguro',
          cancelButtonText: 'No, cancelar',
          closeOnConfirm: false,
          closeOnCancel: false
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if(response.success){
                      Swal.fire({
                          title: 'Es conforme!',
                          text: response.message,
                          icon: 'success',
                          toast: true,
                          position: 'bottom-end',
                          showConfirmButton: false,
                          timer: 3000,
                          timerProgressBar: true
                      });
                      $('#tblSesionDirectorio').DataTable().ajax.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    // Maneja el error de eliminación del registro
                }
            });
            // Aquí puedes realizar las acciones necesarias después de confirmar
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
              'Cancelado',
              'Tu registro está a salvo',
              'error'
            );
            // Aquí puedes realizar las acciones necesarias después de cancelar
          }
        });        
    });

    $('#frmActualizaSesion').submit(function(event) {
        event.preventDefault();
        var idsesion = $('#CODI_SESION_ED').val(); // Replace with your record ID
        var url = "{{ route('tbdirectoriocab_update', ':id') }}".replace(':id', idsesion);
        $.ajax({
            url: url,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success){
                  $('#editModal').modal('hide');
                  Swal.fire({
                      title: 'Es conforme!',
                      text: response.message,
                      icon: 'success',
                      toast: true,
                      position: 'bottom-end',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: true
                  });
                  $('#tblSesionDirectorio').DataTable().ajax.reload();
                }
                
            },
            error: function(xhr, status, error) {
                console.log('CLOSESSSSSSSSSSSSSSSS',error);
            }
        });
    });

    $('#frmRegistraSesion').submit(function(event) {
        event.preventDefault();
        var url = "{{ route('tbdirectorio_registra') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success){
                  $('#createModal').modal('hide');
                  Swal.fire({
                      title: 'Es conforme!',
                      text: response.message,
                      icon: 'success',
                      toast: true,
                      position: 'bottom-end',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: true
                  });
                  $('#tblSesionDirectorio').DataTable().ajax.reload();
                }
                
            },
            error: function(xhr, status, error) {
                console.log('CLOSESSSSSSSSSSSSSSSS',error);
                Swal.fire(
                  'Cancelado',
                  'Existe un error al procesar',
                  'error'
                );
            }
        });
    });

    $('#btnClearSearchSesion').click(function() {
      $('#CODI_SESION').val('');
      $('#FECH_PROGRAMADA').val('');
      $('#CODI_ESTADO_S').val('');
      $('#btnSearchSesion').click();
    });


    function getDatosTable(){
      $('#tblSesionDirectorio').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        searching: false,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'},
        ajax: {
        url: "{{ route('tbdirectoriocab.index') }}",
        data: function(d) {
            d.CODI_SESION = $('#CODI_SESION').val();
            d.FECH_PROGRAMADA = $('#FECH_PROGRAMADA').val();
            d.CODI_ESTADO = $('#CODI_ESTADO_S').val();
        }
      },
          columns: [
              {data: 'CODI_SESION',     name: 'CODI_SESION'},
              {data: 'FECH_PROGRAMADA', name: 'FECH_PROGRAMADA'},
              {data: 'TOTAL_TEMAS',     name: 'TOTAL_TEMAS'},
              {data: 'TOTAL_ACUERDOS',  name: 'TOTAL_ACUERDOS'},
              {data: 'TOTAL_AVANCE',  name: 'TOTAL_AVANCE'},
              {data: 'CODI_ESTADO',     name: 'CODI_ESTADO'},
              {data: 'action',          name: 'action', orderable: false, searchable: false},
          ]
      });
    }
    

    $('#createModal').on('show.bs.modal', function (event) {
      $('#CODI_SESION_AD').val('');
      $('#FECH_PROGRAMADA_AD').val('');
      //var modal = $(this);modal.find('.modal-body').load('tbdirectorio_datos');
      var url_get = "{{ route('tbdirectoriocab_get') }}";
      $.ajax({
          url: url_get,
          type: 'GET',
          success: function(response) {
            if(response.success){
              $('#CODI_SESION_AD').val(response.lastCodiSesion);
            }
          },
          error: function(xhr, status, error) {
              console.log(xhr.responseText);
          }
      });
    });
    
    $('#editModal').on('show.bs.modal', function (event) {
      $('#CODI_SESION_ED').val('');
      $('#FECH_PROGRAMADA_ED').val('');
      var button = $(event.relatedTarget);
      var id = button.data('bs-id');
      var modal = $(this);
      var url = "{{ route('tbdirectoriocab_show', ':id') }}".replace(':id', id);
      $.ajax({
          url: url,
          type: 'GET',
          success: function(response) {
            if(response.success){
              $('#CODI_SESION_ED').val(response.tbDirectorioCab.CODI_SESION);
              $('#CODI_PERIODO_ED').val(response.tbDirectorioCab.CODI_PERIODO);
              $('#FECH_PROGRAMADA_ED').val(response.formattedDate);
            }
          },
          error: function(xhr, status, error) {
              console.log(xhr.responseText);
          }
      });
    });

    $('.show_confirm').click(function(event) {
        var form =  $(this).closest("form");
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro de eliminar?',
            text: 'No podrás recuperar este registro!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'No, cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
              }
        });
    });

    

});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

</x-app-layout>



