@extends('layouts.app')

@section("page-script")
    <script src="{{ asset('assets/js/change-status.js') }}"></script>
@endsection

@section('content')


{{-- commentel em heto karox e petq gal  --}}
   {{-- @include("navbar") --}}




   <main id="main" class="main">


    <section class="section">
      <div class="row">



        <div class="col-lg-8">


                <div class="card">




                        <div class="card-body">
                            <div class = "d-flex justify-content-between">
                                <h5 class="card-title">
                                    <nav>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item active">Նույնականացման կոդերի ցանկ</li>
                                        </ol>
                                    </nav>
                                </h5>
                                <div class="pull-right d-flex justify-content-end m-3" >
                                    <a class="btn btn-primary  mb-2" href="{{ route('entry-codes-create') }}"><i class="fa fa-plus"></i> Ստեղծել նույնականացման կոդ</a>
                                </div>

                            </div>
                            <!-- Bordered Table -->

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Հ/Հ</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Գործատու</th>
                                    <th scope="col">Թոքեն</th>
                                    {{-- <th scope="col">Էլ. հասցեն</th>
                                    <th scope="col">Հասցե</th> --}}
                                    <th scope="col">Կարգավիճակ</th>
                                    <th scope="col">Գործողություն</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $entry_code)
                                    {{-- {{ dump($entry_code->active_person->people->name) }} --}}

                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <th scope="row">{{ $entry_code->id }}</th>

                                            {{-- <td>
                                                <img src = "{{ $entry_code->image ? route('get-file',['path' => $entry_code->image ]) : null }}" style="width:80px">
                                            </td> --}}
                                            <td>
                                                {{ $entry_code->client->name ?? null }}

                                            </td>
                                            <td>
                                                {{ $entry_code->token ?? null }}

                                            </td>
                                            {{-- <td>
                                                {{ $entry_code->client->email ?? null }}

                                            </td>
                                            <td>
                                                {{ $entry_code->client->address ?? null }}
                                            </td> --}}
                                            <td class="{{ auth()->user()->hasRole('super_admin') ? 'status' : 'activation' }}" >



                                                        <div class="statusSection" ><span class="badge {{$entry_code->status==1 ? 'bg-success' : 'bg-danger'  }} px-2">{{ $entry_code->status==1 ? "Գործող" : "Կասեցված" }}</span></div>


                                                    <div class="activationSection" ><span class="badge {{$entry_code->activation==1 ? 'bg-success' : 'bg-danger'  }} px-2">{{ $entry_code->activation==1 ? "Ակտիվ" : "Պասիվ" }}</span></div>


                                            </td>
                                            <td>

                                                <div class="dropdown action"data-id="{{ $entry_code['id'] }}" data-tb-name="entry_codes">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>

                                                    <div class="dropdown-menu">
                                                        @if(auth()->user()->hasRole('super_admin'))
                                                            <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input change_status" type="checkbox"
                                                                        role="switch" data-field-name="status"
                                                                        {{ $entry_code['status'] ? 'checked' : null }}>
                                                                </div>Կարգավիճակ
                                                            </a>
                                                        @endif
                                                        @if(auth()->user()->hasRole('client_admin'))
                                                            <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input change_status" type="checkbox"
                                                                        role="switch" data-field-name="activation"
                                                                        {{ $entry_code['activation'] ? 'checked' : null }}>
                                                                </div>Ակտիվացում
                                                            </a>
                                                        @endif

                                                    @if ($entry_code->active_person !=null  && $entry_code->active_person->people!=null)
                                                        <a class="dropdown-item" href="{{route('calendar',$entry_code->active_person->people->id )}}"><i
                                                            class="bx bx-edit-alt me-1"></i>Ժամանակացույց</a>

                                                    @endif


                                                        <a class="dropdown-item" href="{{route('entry-codes-edit',$entry_code['id'])}}"><i
                                                                class="bx bx-edit-alt me-1"></i>Խմբագրել</a>
                                                        <button type="button" class="dropdown-item click_delete_item"
                                                            data-bs-toggle="modal" data-bs-target="#smallModal"><i
                                                                class="bx bx-trash me-1"></i>
                                                            Ջնջել</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach


                                </tbody>
                            </table>
                            <!-- End Bordered Table -->
                        </div>

                        <div class="demo-inline-spacing">
                            {{ $data->links() }}
                        </div>

                </div>



        </div>

      </div>

    </section>


  </main><!-- End #main -->
<script>

    // let actionClass =document.querySelectorAll('.action');
    // console.log(actionClass)
</script>

@endsection

