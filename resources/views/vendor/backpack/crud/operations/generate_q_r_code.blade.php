@extends(backpack_view('blank'))

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none">
        <h2>
            <span class="text-capitalize mb-0">Generate QR Code</span>
        </h2>
    </section>
@endsection


@section('content')
    <div class="container-fluid animated fadeIn">
        <div class="row table-content">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('room.generate', ['roomId' => $roomId]) }}" class="btn btn-info">Generate QR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
