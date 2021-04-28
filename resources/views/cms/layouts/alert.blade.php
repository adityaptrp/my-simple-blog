
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible -mt-5 -mb-20" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="d-flex">
            <i class="far fa-calendar-check text-lg mr-2"></i>
            {{ session()->get('success') }}
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible -mt-5 -mb-20" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="d-flex">
            <i class="fas fa-exclamation-circle text-lg mr-2"></i>
            {{ session()->get('success') }}
        </div>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible -mt-5 -mb-20" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="d-flex">
            <i class="fas fa-exclamation-circle text-lg mr-2"></i>
            {{ session()->get('success') }}
        </div>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible -mt-5 -mb-20" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="d-flex">
            <i class="fas fa-info-circle text-lg mr-2"></i>
            {{ session()->get('success') }}
        </div>
    </div>
@endif
