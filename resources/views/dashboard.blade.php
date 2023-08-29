<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Panel de control</h3>
                <!--<p class="text-subtitle text-muted">This is the main page.</p>-->
            </div>
            <!--<div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>-->
        </div>
    </x-slot>

    
    <section class="section">
        <div class="card">
            <img src="{{ asset('images/ReunionDirectorio.png') }}" class="card-img-top h-50 w-50  mx-auto d-block" alt="ReunionDirectorio">
        </div>
    </section>
</x-app-layout>
