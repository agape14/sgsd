<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tema: {{ $codigo_sesion }}</h3>
                <!--<p class="text-subtitle text-muted">Detalles de los temas.</p>-->
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('tbdirectoriocab.inicio') }}">Sesion de Directorio</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tema {{ $codigo_sesion }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>


    <section class="section">
        <div class="row">
            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Búsqueda</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" >
                                        <div class="row">
                                            <input type="hidden" id="CODI_SESION" value="{{ $codigo_sesion }}">
                                            <input type="hidden" id="CODI_PERIODO" value="{{ $periodo }}">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="NUME_SECUEN">N° de Tema</label>
                                                    <input type="number" id="NUME_SECUEN" class="form-control" name="NUME_SECUEN">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="DESC_TEMA">Descripción</label>
                                                    <input type="text" id="DESC_TEMA" class="form-control" name="DESC_TEMA">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="FECH_LIMITE">Fecha de Plazo</label>
                                                    <input type="date" id="FECH_LIMITE" class="form-control" name="FECH_LIMITE">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">Estado</label>
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="CODI_ESTADO" name="CODI_ESTADO">
                                                            <option value="">Todos</option>
                                                            @foreach ($listestados as $estado)
                                                                <option value="{{ $estado->CODI_ESTADO }}">{{ $estado->DESC_ESTADO }}</option>
                                                            @endforeach
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <button  type="button"  class="btn btn-primary me-1 mb-1" id="btnSearchTemas"><i class="bi bi-search" ></i> Buscar</button>
                                                <button type="button" class="btn btn-secondary me-1 mb-1" id="btnClearSearchTema"><i class="bi bi-shield-lock"></i> Limpiar</button>
                                            </div>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <br>
            <!--AGREGA TEMA form Modal -->
            <div class="modal fade" id="mdlNuevoTema" tabindex="-1" aria-labelledby="mdlNuevoTemaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mdlNuevoTemaLabel">Registro de nuevo tema</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="frmRegistraTema">
                            @csrf
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="CODI_SESION" value="{{ $codigo_sesion }}">
                            <input type="hidden" name="CODI_PERIODO" value="{{ $periodo }}">
                            <div class="modal-body">
                                <label>Tema: </label>
                                <div class="form-group">
                                    <textarea class="form-control" name="DESC_TEMA" id="DESC_TEMA_AD" rows="5" required></textarea>
                                </div>
                                <label>Plazo de presentación: </label>
                                <div class="form-group">
                                    <input type="date" class="form-control" name="FECH_LIMITE" id="FECH_LIMITE_AD" required>
                                </div>
                                <label>Finalidad: </label>
                                <div class="form-group">
                                    <fieldset class="form-group">
                                        <select class="form-select" name="CODI_FINALIDAD" id="CODI_FINALIDAD_AD" required>
                                            <option value="">Seleccione</option>
                                            @foreach ($listfinalidad as $finalidad)
                                                <option value="{{ $finalidad->CODI_FINALIDAD }}">{{ $finalidad->DESC_FINALIDAD }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle-fill"> Cancelar</i>
                                </button>
                                <button type="submit" class="btn btn-primary ml-2">
                                    <i class="bi bi-save2"> Registrar</i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--EDITAR TEMA form Modal -->
            <div class="modal fade" id="mdlEditaTema" tabindex="-1" aria-labelledby="mdlEditaTemaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mdlEditaTemaLabel">Editar Tema</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="frmActualizaTema">
                                @csrf
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="CODI_SESION" value="{{ $codigo_sesion }}">
                                <input type="hidden" name="CODI_PERIODO" value="{{ $periodo }}">
                                <input type="hidden" name="NUME_SECUEN" id="NUME_SECUEN_ED">
                                <div class="modal-body">
                                    <label>Tema: </label>
                                    <div class="form-group">
                                        <textarea class="form-control" name="DESC_TEMA" id="DESC_TEMA_ED" rows="5" required></textarea>
                                    </div>
                                    <label>Plazo de presentación: </label>
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="FECH_LIMITE" ID="FECH_LIMITE_ED" required>
                                    </div>
                                    <label>Finalidad: </label>
                                    <div class="form-group">
                                        <fieldset class="form-group">
                                            <select class="form-select" name="CODI_FINALIDAD" id="CODI_FINALIDAD_ED" required>
                                                <option value="">Seleccione</option>
                                                @foreach ($listfinalidad as $finalidad)
                                                    <option value="{{ $finalidad->CODI_FINALIDAD }}">{{ $finalidad->DESC_FINALIDAD }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle-fill"> Cancelar</i>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-2">
                                        <i class="bi bi-save2"> Registrar</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="card">
                    <div class="card-body">
                    <div class="panel-heading">
                      <div class="d-flex justify-content-end">
                        <button class="btn btn-success me-1 mb-1" data-bs-toggle="modal"
                        data-bs-target="#mdlNuevoTema"><i class="bi bi-file-earmark-plus"></i> Nuevo</button>
                      </div>
                    </div>
                        <table class="table table-hover table-striped border-primary table-bordered" id="tblTemas">
                            <thead>
                                <tr>
                                    <th>N° Tema</th>
                                    <th>Descripción</th>
                                    <th>Finalidad</th>
                                    <th>Fecha Plazo</th>
                                    <th>Responsables</th>
                                    <th>En proceso</th>
                                    <th>Culminados</th>
                                    <th>% de avance</th>
                                    <th>Estado</th>
                                    <th><i class="bi bi-stack"></i></i></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!--mdlResponsables size Modal -->
            <div class="modal fade" id="mdlResponsables" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-move"  role="dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Gestion de Responsables de Directorio N° <span id="txtNroSesionCab"></span> - Tema N° <span id="txtNroTemaCab"></span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                                <div class="row">
                                    <form id="frmRegistraResponsable">
                                        @csrf
                                        <input type="hidden" name="_method" value="POST">
                                        <div class="row">
                                            <input type="hidden" name="CODI_SESION" id="CODI_SESION_RESP_AD">
                                            <input type="hidden" name="CODI_PERIODO" id="CODI_PERI_RESP_AD">
                                            <input type="hidden" name="NUME_SECUEN" id="NUME_SECUEN_RESP_AD">
                                            <div class="col-md-6">
                                                <label>Area: </label>
                                                <div class="form-group">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="cbxAreaResponsable" name="CODI_AREA" required>
                                                            <option value="">Seleccione Area</option>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <br>
                                                <button type="submit" class="btn btn-primary ml-2">
                                                    <i class="bi bi-save2"> Registrar</i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-12">
                                            <table class="table table-hover table-striped border-primary table-bordered" id="tblResponsables">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>CodArea</th>
                                                        <th>Area</th>
                                                        <th>Sustento</th>
                                                        <th>Estado</th>
                                                        <th><i class="bi bi-stack"></i></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <!--mdlSustento size Modal -->
            <div class="modal fade" id="mdlSustento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg"  role="dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h4 class="modal-title" id="exampleModalLabel"><span id="tituloAreaSustento" class="text-white"></span></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                    <form id="frmRegistraSustento" style="width: 100%">
                                        @csrf
                                        <input type="hidden" name="_method" value="POST">
                                        <div class="row">
                                            <input type="hidden" name="CODI_SESION" id="CODI_SESION_DETRESP_AD">
                                            <input type="hidden" name="CODI_PERIODO" id="CODI_PERI_DETRESP_AD">
                                            <input type="hidden" name="NUME_SECUEN" id="NUME_SECUEN_DETRESP_AD">
                                            <input type="hidden" name="CODI_AREA" id="CODI_AREA_DETRESP_AD">
                                            <input type="hidden" name="CODI_DOCU_SUSTENTO" id="CODI_DOCU_SUSTENTO_DETRESP_AD">
                                            
                                            <div class="col-md-12">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="DESC_DOCUMENTO" id="DESC_DOCUMENTO_AD" placeholder="Ingrese el documento de sustento..." maxlength="250" required>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary ml-2"><i class="bi bi-save-fill"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                    <fieldset class="border rounded-3">
                                        <legend class="float-none w-auto px-3" >Documentos del SGD</legend>
                                        <div class="col-md-12 mb-1">
                                            <div class="input-group mb-3">
                                                <button class="btn btn-danger" type="button" id="btnClearSearchDocSgd"><i class="bi bi-trash-fill"></i></button>
                                                <input type="text" class="form-control" name="DO_EXPE_CODI" id="txtNroExpediente" placeholder="Ingrese el nro. Expediente"  required>
                                                <select class="browser-default form-control" name="DO_PERI" id="cbxNroExp" required>
                                                </select>
                                                <button class="btn btn-primary" type="button" id="btnConsultaExpSgd">
                                                <i class="bi bi-search"></i> Buscar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table table-hover table-striped border-secondary table-bordered" id="tblDocumentosSgd">
                                                <thead>
                                                    <tr>
                                                        <th>Tipo Doc.</th>
                                                        <th>Nro. Doc.</th>
                                                        <th>Area</th>
                                                        <th>Fecha</th>
                                                        <th><i class="bi bi-stack"></i></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <div class="col-md-12">
                                            <table class="table table-hover table-striped border-primary table-bordered" id="tblSustentos">
                                                <thead>
                                                    <tr>
                                                        <th>SESION</th>
                                                        <th>PERIODO</th>
                                                        <th>SECUENCIA</th>
                                                        <th>AREA</th>
                                                        <th>N°</th>
                                                        <th>Documento</th>
                                                        <th><i class="bi bi-stack"></i></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="module">
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $(document).ready(function() {
            var codigoSesion = $('#CODI_SESION').val();
            var periodo = $('#CODI_PERIODO').val();
            getDatosTblTemas();
            setAreasCombo();
            setAnios();
            $('#btnSearchTemas').click(function() {
                var nume_secuen = $('#NUME_SECUEN').val();
                var desc_tema = $('#DESC_TEMA').val();
                var fech_limite = $('#FECH_LIMITE').val();
                var codi_estado = $('#CODI_ESTADO').val();
                var table = $('#tblTemas').DataTable();
                table.ajax.url("{{ route('tbldirectoriodet_gettbltemas') }}?CODI_SESION=" + codigoSesion + "&CODI_PERIODO=" + periodo + "&NUME_SECUEN=" + nume_secuen+ "&DESC_TEMA=" + desc_tema+ "&FECH_LIMITE=" + fech_limite+ "&CODI_ESTADO=" + codi_estado).load();
            });
            
            $('#btnClearSearchTema').click(function() {
                $('#NUME_SECUEN').val('');
                $('#DESC_TEMA').val('');
                $('#FECH_LIMITE').val('');
                $('#CODI_ESTADO').val('');
                $('#btnSearchTemas').click();
            });

            function getDatosTblTemas(){
                $('#tblTemas').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [],
                    searching: false,
                    language: {url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'},
                    ajax: {
                        url: "{{ route('tbldirectoriodet_gettbltemas') }}",
                        data: function(d) {
                            d.CODI_SESION = codigoSesion;
                            d.CODI_PERIODO = periodo;
                        }
                    },
                    columnDefs: [
                        { targets: 9, width: '10%' }
                    ],
                    columns: [
                        {data: 'NUME_SECUEN',       name: 'NUME_SECUEN'},
                        {data: 'DESC_TEMA',         name: 'DESC_TEMA'},
                        {data: 'DESC_FINALIDAD',    name: 'DESC_FINALIDAD'},
                        {data: 'FECH_LIMITE',       name: 'FECH_LIMITE'},
                        {data: 'RESPONSABLES',      name: 'RESPONSABLES'},
                        {data: 'EN_PROCESO',        name: 'EN_PROCESO'},
                        {data: 'CULMINADOS',        name: 'CULMINADOS'},
                        {data: 'AVANCE',            name: 'AVANCE'},
                        {data: 'CODI_ESTADO',       name: 'CODI_ESTADO'},
                        {data: 'action',            name: 'action', orderable: false, searchable: false},
                    ]
                });
                $('#tblTemas').css('width', '100%');
            }

            $('#mdlNuevoTema').on('show.bs.modal', function (event) {
                $('#DESC_TEMA_AD').val('');
                $('#FECH_LIMITE_AD').val('');
                $('#CODI_FINALIDAD_AD').val('');
            });

            $('#frmRegistraTema').submit(function(event) {
                event.preventDefault();
                var url = "{{ route('tbdirectoriodet_registra') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success){
                        $('#mdlNuevoTema').modal('hide');
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
                        $('#tblTemas').DataTable().ajax.reload();
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                        'Cancelado',
                        'Existe un error al procesar',
                        'error'
                        );
                    }
                });
            });

            $('#mdlEditaTema').on('show.bs.modal', function (event) {
                $('#DESC_TEMA_ED').val('');
                $('#FECH_LIMITE_ED').val('');
                $('#CODI_FINALIDAD_ED').val('');
                $('#NUME_SECUEN_ED').val('');
                var button = $(event.relatedTarget);
                var nro = button.data('edt-id');
                var modal = $(this);
                var urledt = "{{ route('tbdirectoriodet_show', [':codi_sesion', ':periodo', ':numero']) }}";
                urledt = urledt.replace(':codi_sesion', codigoSesion);
                urledt = urledt.replace(':periodo', periodo);
                urledt = urledt.replace(':numero', nro);
                $.ajax({
                    url: urledt,
                    type: 'GET',
                    success: function(response) {
                        if(response.success){
                            $('#DESC_TEMA_ED').val(response.tbDirectorioDet.DESC_TEMA);
                            $('#FECH_LIMITE_ED').val(response.fechaLimiteFormat);
                            $('#CODI_FINALIDAD_ED').val(response.tbDirectorioDet.CODI_FINALIDAD);
                            $('#NUME_SECUEN_ED').val(response.tbDirectorioDet.NUME_SECUEN);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        Swal.fire(
                        'Cancelado',
                        'Existe un error al obtener informacion',
                        'error'
                        );
                    }
                });
            });

            $('#frmActualizaTema').submit(function(event) {
                event.preventDefault();
                var idnro = $('#NUME_SECUEN_ED').val(); // Replace with your record ID
                var url = "{{ route('tbdirectoriodet_update', ':id') }}".replace(':id', idnro);
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success){
                            $('#mdlEditaTema').modal('hide');
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
                            $('#tblTemas').DataTable().ajax.reload();
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        console.log('CLOSESSSSSSSSSSSSSSSS',error);
                        Swal.fire(
                        'Cancelado',
                        'Existe un error al actualizar',
                        'error'
                        );
                    }
                });
            });

            $(document).on('click', '#btnDeleteTema', function() {
                var nrodel = $(this).data('delete-id');
                var urldel = "{{ route('tbdirectoriodet_delete', [':codi_sesion', ':periodo', ':numero']) }}";
                urldel = urldel.replace(':codi_sesion', codigoSesion);
                urldel = urldel.replace(':periodo', periodo);
                urldel = urldel.replace(':numero', nrodel);
                Swal.fire({
                title: '¿Estás seguro de eliminar?',
                text: 'No podrás recuperar el tema '+nrodel,
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
                        url: urldel,
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
                            $('#tblTemas').DataTable().ajax.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            Swal.fire(
                            'Cancelado',
                            'Existe un error al eliminar',
                            'error'
                            );
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
                    // Aquí puedes realizar las acciones necesarias después de cancelar mdlResponsables
                }
                });        
            });
            /* Movilizar modal
            $('#mdlResponsables').modal({
                backdrop: 'static',
                keyboard: false
            });

            $('.modal-dialog').draggable({
                containment: 'selector'
            });
            */
            function setAreasCombo(){
                $.ajax({
                    url: "{{ route('tbdirectoriodet_areas') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                    $.each(data, function(key, value) {
                        $('#cbxAreaResponsable').append('<option value="' + key + '">' + value + '</option>');
                    });
                    }
                });
            }
            
            function setAnios(){
                $.ajax({
                    url: "{{ route('getanios_sgd') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        const setAnios = data;
                        const anios = Object.keys(setAnios).map(key => {
                            return { key: key, value: setAnios[key] };
                        });
                        anios.sort((a, b) => b.value - a.value );
                        $.each(anios, function(index, anio) {
                            $('#cbxNroExp').append('<option value="' + anio.key + '">' + anio.value + '</option>');
                        });
                    }
                });
            }

            $('#mdlResponsables').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                $('#CODI_SESION_RESP_AD').val("");
                $('#CODI_PERI_RESP_AD').val("");
                $('#NUME_SECUEN_RESP_AD').val("");
                $('#cbxAreaResponsable').val("");
                var nro_sec = button.data('nro-sec');
                $('#CODI_SESION_RESP_AD').val(codigoSesion);
                $('#CODI_PERI_RESP_AD').val(periodo);
                $('#NUME_SECUEN_RESP_AD').val(nro_sec);
                document.getElementById("txtNroSesionCab").innerHTML = codigoSesion;
                document.getElementById("txtNroTemaCab").innerHTML = nro_sec;
                getDatosTblResponsables()
            });
            
            $('#frmRegistraResponsable').submit(function(event) {
                event.preventDefault();
                var url = "{{ route('tbdirectorioresp_registra') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
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
                            $('#cbxAreaResponsable').val("");
                            $('#tblResponsables').DataTable().ajax.reload();
                        }else{
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'warning',
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 6000,
                                timerProgressBar: true
                            });
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                        'Cancelado',
                        'Existe un error al procesar',
                        'error'
                        );
                    }
                });
            });

            $('#mdlResponsables').on('hidden.bs.modal', function (event) {
                $('#tblResponsables').DataTable().destroy();
            });

            function getDatosTblResponsables(){
                var codiNumSec=$('#NUME_SECUEN_RESP_AD').val()
                $('#tblResponsables').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [],
                    searching: true,
                    language: {url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'},
                    ajax: {
                        url: "{{ route('tbdirectorioresp_gettblresp') }}",
                        data: function(d) {
                            d.CODI_SESION = codigoSesion;
                            d.CODI_PERIODO = periodo;
                            d.NUME_SECUEN = codiNumSec;
                        }
                    },
                    columnDefs: [
                        { targets: 1, visible: false },
                        { targets: 5, width: '9%' }
                    ],
                    columns: [
                        {data: 'CODI_DOCU_SUSTENTO',    name: 'CODI_DOCU_SUSTENTO'},
                        {data: 'CODI_AREA',             name: 'CODI_AREA'},
                        {data: 'AR_NOMB',               name: 'AR_NOMB'},
                        {data: 'DESC_DOCUMENTO',        name: 'DESC_DOCUMENTO',
                            render: function(data, type, row) {
                                if (data != null) {
                                    // Reemplazar los saltos de línea por etiquetas <br>
                                    data = data.replace(/\n/g, '<br>');
                                }
                                return data;
                            }
                        },
                        {data: 'CODI_ESTADO',           name: 'CODI_ESTADO'},
                        {data: 'action',                name: 'action', orderable: false, searchable: false},
                    ],
                    order: [
                        [1, 'desc']
                    ]
                    //,rowGroup: {dataSrc: ['CODI_AREA', 'AR_NOMB']}
                });
                $('#tblResponsables').css('width', '100%');
            }
            
            $(document).on('click', '#btnMostrarSustento', function(event) {
                $('#CODI_SESION_DETRESP_AD').val("");
                $('#CODI_PERI_DETRESP_AD').val("");
                $('#NUME_SECUEN_DETRESP_AD').val("");
                $('#CODI_AREA_DETRESP_AD').val("");
                $('#CODI_DOCU_SUSTENTO_DETRESP_AD').val("");
                $('#DESC_DOCUMENTO_AD').val("");
                var nro_sec = $(this).data('nro-sec');
                var nro_doc = $(this).data('nro-docu');
                var cod_area = $(this).data('cod-area');
                var nam_area = $(this).data('name-area');
                $('#CODI_SESION_DETRESP_AD').val(codigoSesion);
                $('#CODI_PERI_DETRESP_AD').val(periodo);
                $('#NUME_SECUEN_DETRESP_AD').val(nro_sec);
                $('#CODI_AREA_DETRESP_AD').val(cod_area);
                $('#CODI_DOCU_SUSTENTO_DETRESP_AD').val(nro_doc);
                document.getElementById("tituloAreaSustento").innerHTML = nam_area;
                getDatosTblSustentos();
                getDatosTblDocumentosSgd();
                $('#mdlSustento').modal('show');
            });
            
            function getDatosTblSustentos(){
                var codiNumSec=$('#NUME_SECUEN_DETRESP_AD').val()
                var codiArea=$('#CODI_AREA_DETRESP_AD').val()
                var codiDocSus=$('#CODI_DOCU_SUSTENTO_DETRESP_AD').val()
                $('#tblSustentos').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [],
                    searching: true,
                    language: {url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'},
                    ajax: {
                        url: "{{ route('tbdirectorioresp_gettblsustento') }}",
                        data: function(d) {
                            d.CODI_SESION           = codigoSesion;
                            d.CODI_PERIODO          = periodo;
                            d.NUME_SECUEN           = codiNumSec;
                            d.CODI_AREA             = codiArea;
                            d.CODI_DOCU_SUSTENTO    = codiDocSus;
                        }
                    },
                    columnDefs: [
                        { targets: [0,1,2,3], visible: false },
                        { targets: 6, width: '9%' }
                    ],
                    columns: [
                        {data: 'CODI_SESION',           name: 'CODI_SESION'},
                        {data: 'CODI_PERIODO',          name: 'CODI_PERIODO'},
                        {data: 'NUME_SECUEN',           name: 'NUME_SECUEN'},
                        {data: 'CODI_AREA',             name: 'CODI_AREA'},
                        {data: 'CODI_DOCU_SUSTENTO',    name: 'CODI_DOCU_SUSTENTO'},
                        {data: 'DESC_DOCUMENTO',        name: 'DESC_DOCUMENTO'},
                        {data: 'action',                name: 'action', orderable: false, searchable: false},
                    ],
                    order: [
                        [1, 'desc']
                    ]
                    //,rowGroup: {dataSrc: ['CODI_AREA', 'AR_NOMB']}
                });
                $('#tblSustentos').css('width', '100%');
            }

            $('#mdlSustento').on('hidden.bs.modal', function (event) {
                $('#DESC_DOCUMENTO_AD').val("");
                $('#txtNroExpediente').val("");
                $('#tblSustentos').DataTable().destroy();
                $('#tblDocumentosSgd').DataTable().destroy();
            });

            $('#frmRegistraSustento').submit(function(event) {
                event.preventDefault();
                var url = "{{ route('tbdirectoriorespdets_registra') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
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
                            $('#DESC_DOCUMENTO_AD').val("");
                            $('#tblSustentos').DataTable().ajax.reload();
                            $('#tblResponsables').DataTable().ajax.reload();
                        }else{
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'warning',
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 6000,
                                timerProgressBar: true
                            });
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                        'Cancelado',
                        'Existe un error al procesar',
                        'error'
                        );
                    }
                });
            });

            $(document).on('click', '#btnDelAreaResp', function() {
                var nro_secu = $(this).data('nro-sec');
                var cod_area = $(this).data('cod-area');
                var cod_sust = $(this).data('cod-sust');

                var urldel = "{{ route('tbdirectoriodetresp_delete', [':codi_sesion', ':periodo', ':nrosecu', ':codarea', ':codsust']) }}";
                urldel = urldel.replace(':codi_sesion', codigoSesion);
                urldel = urldel.replace(':periodo', periodo);
                urldel = urldel.replace(':nrosecu', nro_secu);
                urldel = urldel.replace(':codarea', cod_area);
                urldel = urldel.replace(':codsust', cod_sust);

                Swal.fire({
                title: '¿Estás seguro de eliminar?',
                text: 'No podrás recuperar el responsable '+cod_sust,
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
                        url: urldel,
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
                            $('#tblResponsables').DataTable().ajax.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            Swal.fire(
                            'Cancelado',
                            'Existe un error al eliminar',
                            'error'
                            );
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
                    // Aquí puedes realizar las acciones necesarias después de cancelar mdlResponsables
                }
                });        
            });

            $(document).on('click', '#btnDelAreaRespDet', function() {
                var nro_secu = $(this).data('nro-sec');
                var cod_area = $(this).data('cod-area');
                var cod_sust = $(this).data('cod-sust');

                var urldel = "{{ route('tbdirectoriodetrespdet_delete', [':codi_sesion', ':periodo', ':nrosecu', ':codarea', ':codsust']) }}";
                urldel = urldel.replace(':codi_sesion', codigoSesion);
                urldel = urldel.replace(':periodo', periodo);
                urldel = urldel.replace(':nrosecu', nro_secu);
                urldel = urldel.replace(':codarea', cod_area);
                urldel = urldel.replace(':codsust', cod_sust);

                Swal.fire({
                title: '¿Estás seguro de eliminar?',
                text: 'No podrás recuperar el sustento '+cod_sust,
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
                        url: urldel,
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
                            $('#tblSustentos').DataTable().ajax.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            Swal.fire(
                            'Cancelado',
                            'Existe un error al eliminar',
                            'error'
                            );
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
                    // Aquí puedes realizar las acciones necesarias después de cancelar mdlResponsables
                }
                });        
            });

            function getDatosTblDocumentosSgd(){
                var nroexpediente=$('#txtNroExpediente').val();
                var anioexpediente=$('#cbxNroExp').val();
                $('#tblDocumentosSgd').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [],
                    searching: true,
                    language: {url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'},
                    ajax: {
                        url: "{{ route('getdocumentos_for_exp_sgd') }}",
                        data: function(d) {
                            d.DO_PERI       = anioexpediente;
                        }
                    },
                    columnDefs: [{ targets: 4, width: '9%' }],
                    columns: [
                        {data: 'TD_NOMB',       name: 'TD_NOMB'},
                        {data: 'DO_NUME_STR',   name: 'DO_NUME_STR'},
                        {data: 'AR_SIGL',       name: 'AR_SIGL'},
                        {data: 'FECHA_DOC',     name: 'FECHA_DOC'},
                        {data: 'action',        name: 'action', orderable: false, searchable: false},
                    ],
                    //,rowGroup: {dataSrc: ['CODI_AREA', 'AR_NOMB']}
                });
                $('#tblDocumentosSgd').css('width', '100%');
            }
            
            $('#btnConsultaExpSgd').click(function() {
                var tnroexpediente=$('#txtNroExpediente').val();
                var tanioexpediente=$('#cbxNroExp').val();
                var tablesgd = $('#tblDocumentosSgd').DataTable();
                tablesgd.ajax.url("{{ route('getdocumentos_for_exp_sgd') }}?DO_EXPE_CODI=" + tnroexpediente + "&DO_PERI=" + tanioexpediente).load();
            });

            $('#btnClearSearchDocSgd').click(function() {
                $('#txtNroExpediente').val("");
                var tablesgd = $('#tblDocumentosSgd').DataTable();
                tablesgd.ajax.url("{{ route('getdocumentos_for_exp_sgd') }}?DO_EXPE_CODI=&DO_PERI=").load();
            });

            $(document).on('click', '#btnAddDocSgd', function() {
                var do_codi = $(this).data('do-codi');
                var docu_desc = $(this).data('docu-desc');
                var nume_secuen = $('#NUME_SECUEN_DETRESP_AD').val();
                var codi_area=$('#CODI_AREA_DETRESP_AD').val()
                var codi_det_resp=$('#CODI_DOCU_SUSTENTO_DETRESP_AD').val()
                const params_add = {
                    CODI_SESION: codigoSesion,
                    CODI_PERIODO: periodo,
                    NUME_SECUEN: nume_secuen,
                    CODI_AREA: codi_area,
                    DESC_DOCUMENTO: docu_desc,
                    CODI_DOCU_SUSTENTO: codi_det_resp,
                    CODI_DO_SGD: do_codi,
                };
                var urladdsgd = "{{ route('tbdirectoriorespdets_registrasgd') }}";
                $.ajax({
                    url: urladdsgd,
                    type: 'POST',
                    data: JSON.stringify(params_add),
                    contentType: 'application/json',
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
                            $('#tblSustentos').DataTable().ajax.reload();
                            $('#tblResponsables').DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        Swal.fire(
                        'Cancelado',
                        'Existe un error al agregar sustento del SGD',
                        'error'
                        );
                        // Maneja el error de eliminación del registro
                    }
                });
                
            });

        });
        
        

        </script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
</x-app-layout>