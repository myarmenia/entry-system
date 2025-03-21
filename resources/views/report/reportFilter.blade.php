@extends('layouts.app')

@section("page-script")
    <script src="{{ asset('assets/js/change-status.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        th{
            font-size:12px
        }
        th{
            font-size:12px
        }
        table th {
            height: 100px;
            text-align: center
        }

        table td {
            text-align: center;
        }

        .fix_column {
            position: sticky;
            left: 0;
            background-color: #343a40;
            color: #fff
        }

    </style>
@endsection


@section('content')
@php
    use Carbon\Carbon;

    use App\Models\AttendanceSheet;
    use Illuminate\Support\Facades\DB;



    // Assuming $request->month contains "2024-10"
    $monthYear = $data['month'];

    // Parse the month-year string to get the start and end of the month
    $startOfMonth = Carbon::parse($monthYear)->startOfMonth();
    $endOfMonth = Carbon::parse($monthYear)->endOfMonth();
    // dd($startOfMonth);

@endphp



   <main id="main" class="main">


    <section class="section">
      <div class="row">



        <div class="col-lg-12">

                <div class="card">

                        <div class="card-body">
                            @if (session('create_client'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('create_client') }}
                                </div>
                            @endif

                            <div class = "d-flex justify-content-between">
                                <h5 class="card-title">
                                    <nav>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item active">Հաշվետվություն</li>
                                        </ol>
                                    </nav>
                                </h5>
                                @php
                                    $day = \Carbon\Carbon::now()->format('l'); // 'l' gives the full name of the day (e.g., Monday, Tuesday)

                                @endphp


                            </div>


                            <form  action="{{ route('reportFilter.list') }}" method="get" class="mb-3 justify-content-end" style="display: flex; gap: 8px">
                                {{-- <div class="col-2"> --}}
                                    {{-- <div class="row mb-3"> --}}

                                        <div class="col-sm-2">
                                                 <select class="form-select" aria-label="Default select example" name="department_id">
                                                    <option value="" disabled="" selected>Ընտրել ստորաբաժանումը</option>
                                                     @foreach($data['client_department'] as $department)
                                                          <option value="{{ $department->id }}"> {{ $department->name }}</option>
                                                     @endforeach

                                                 </select>
                                        </div>

                                    {{-- </div> --}}
                                {{-- </div> --}}

                                <div class="col-2">
                                    <input type="text"  class="form-select"  id="monthPicker" placeholder="Ընտրել ամիսը տարեթվով" name="month"/>
                                </div>
                                <button type="submit" class="btn btn-primary col-2 search">Հաշվետվություն</button>
                                <a href="{{ route('export-xlsx',['mounth'=>$data['month']]) }}" type="submit" class="btn btn-primary col-2 search">Արտահանել XLSX</a>
                            </form>
                            <!-- Bordered Table -->


                            <!-- End Bordered Table -->
                            <div class="demo-inline-spacing">
                                {{-- {{ $data->links() }} --}}
                            </div>
                        </div>



                </div>



        </div>

      </div>

    </section>

  </main><!-- End #main -->

@endsection


