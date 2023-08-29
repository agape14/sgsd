<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Session de Directorio</h3>
                <!--<p class="text-subtitle text-muted">Sub titulo de la sesin.</p>-->
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
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
                                        <form class="form">
                                            <div class="row">
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-column">N° de Sesión de
                                                            Directorio</label>
                                                        <input type="number" id="first-name-column"
                                                            class="form-control" name="ddirec-column">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="last-name-column">Fecha Programada</label>
                                                        <input type="date" id="last-name-column" class="form-control"
                                                            name="dfecha-column">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="city-column">Estado de Sesión</label>
                                                        <fieldset class="form-group">
                                                            <select class="form-select" id="basicSelect">
                                                                <option>Todos</option>
                                                                <option>Completado</option>
                                                                <option>En proceso</option>
                                                                <option>En Registro</option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="col-1 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary me-1 mb-1"><i
                                                            class="bi bi-search"></i> Buscar</button>
                                                </div>
                                                <div class="col-1 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-secondary me-1 mb-1"><i
                                                            class="bi bi-shield-lock"></i> Limpiar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!--login form Modal -->
                <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">Registro de nueva sesión</h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <form action="#">
                                <div class="modal-body">
                                    <label>Sesión: </label>
                                    <div class="form-group">
                                        <input type="number" class="form-control">
                                    </div>
                                    <label>Fecha Programada de Sesión: </label>
                                    <div class="form-group">
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle-fill"> Cancelar</i>
                                    </button>
                                    <button type="button" class="btn btn-primary ml-2" data-bs-dismiss="modal">
                                        <i class="bi bi-save2"> Registrar</i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <section class="section">
                    <div class="card">
                        <div class="panel-heading">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-1 mb-1" data-bs-toggle="modal"
                                    data-bs-target="#inlineForm"><i class="bi bi-file-earmark-plus"></i> Nuevo</button>
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <table class="table table-hover table-striped border-primary table-bordered" id="table1">
                                <thead>
                                    <tr>
                                        <th>N° Sesión</th>
                                        <th>Fecha</th>
                                        <th>N° de Temas</th>
                                        <th>N° de Acuerdos</th>
                                        <th>% Avance</th>
                                        <th>Estado</th>
                                        <th><i class="bi bi-stack"></i></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10</td>
                                        <td>18/07/2023</td>
                                        <td>5</td>
                                        <td>8</td>
                                        <td>100%</td>
                                        <td>
                                            <span class="badge bg-success">Completado</span>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-warning btn-sm"><i
                                                    class="bi bi-pencil-fill" data-bs-toggle="tooltip"
                                                    data-bs-placement="Top" title="Editar"></i></button>
                                            <a href="{{ route('temas') }}">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-journal-text" data-bs-toggle="tooltip"
                                                        data-bs-placement="Top" title="Agenda"></i>
                                                </button>
                                            </a>
                                            <button type="submit" class="btn btn-success btn-sm"><i
                                                    class="bi bi-hand-thumbs-up" data-bs-toggle="tooltip"
                                                    data-bs-placement="Top" title="Acuerdos"></i></button>
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="bi bi-trash-fill" data-bs-toggle="tooltip"
                                                    data-bs-placement="Top" title="Eliminar"></i></button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </section>
</x-app-layout>
