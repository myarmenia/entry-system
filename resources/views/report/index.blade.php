@extends('layouts.app')

@section("page-script")
    <script src="{{ asset('assets/js/change-status.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



@endsection

@section('content')



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


                            </div>

                            <form  action="{{ route('report') }}" method="get" class="mb-3 justify-content-end" style="display: flex; gap: 8px">

                                {{-- <div class="col-2">
                                    <input type="text"  class="form-select" id="yearPicker" placeholder="Select year" name="year" />
                                </div> --}}
                                <div class="col-2">
                                    <input type="text"  class="form-select"  id="monthPicker" placeholder="Ընտրել ամիսը տարեթվով" name="mounth"/>
                                </div>
                                <button type="submit" class="btn btn-primary col-2 search">Հաշվետվություն</button>
                            </form>
                            <!-- Bordered Table -->

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Հ/Հ</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Անուն</th>
                                    <th scope="col">Ազգանուն</th>
                                    <th scope="col">Հեռախոսահամար</th>

                                    <th scope="col">Ամիս</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $item)

                                        <tr class="parent">
                                            <td>{{ $item->id }}</td>
                                            <td scope="row">{{ $item->id }}</td>

                                            <td class="personName">
                                                {{ $item->people->name ?? null }}

                                            </td>
                                            <td class="personSurname" >
                                                {{ $item->people->surname ?? null }}

                                            </td >
                                            <td class="personPhone">
                                                {{ $item->people->phone ?? null }}
                                            </td>
                                            <td>



                                                        {{-- <div class="statusSection" ><span class="badge {{$entry_code->status==1 ? 'bg-success' : 'bg-danger'  }} px-2">{{ $entry_code->status==1 ? "Գործող" : "Կասեցված" }}</span></div>


                                                    <div class="activationSection" ><span class="badge {{$entry_code->activation==1 ? 'bg-success' : 'bg-danger'  }} px-2">{{ $entry_code->activation==1 ? "Ակտիվ" : "Պասիվ" }}</span></div> --}}


                                            </td>

                                        </tr>

                                    @endforeach


                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Հ/Հ</th>
                                        <th scope="col">Անուն</th>
                                        <th scope="col">Ազգանուն</th>
                                        <th scope="col">Հեռախոսահամար</th>

                                        <th scope="col">nojember</th>
                                    </tr>


                                </thead>
                                @foreach ($data as $item)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </table>
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
  <script>
//     flatpickr("#yearPicker", {
//       dateFormat: "Y", // Year only
//       defaultDate: new Date().getFullYear().toString() // Optional default
//     });

//     flatpickr("#monthPicker", {
//     plugins: [
//       new flatpickr.monthSelectPlugin({
//         shorthand: true, // Display short month names
//         dateFormat: "Y-m", // Format as YYYY-MM
//       })
//     ]
//   });
</script>

@endsection


