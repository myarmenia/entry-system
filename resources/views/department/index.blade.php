@extends('layouts.app')

@section("page-script")
    <script src="{{ asset('assets/js/change-status.js') }}"></script>
    <script src="{{ asset('assets/js/delete-item.js') }}"></script>
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
                                            <li class="breadcrumb-item active">Ստորաբաժանումների ցանկ</li>
                                        </ol>
                                    </nav>
                                </h5>
                                @if (auth()->user()->hasAnyRole(['client_admin','super_admin','manager']))
                                    <div class="pull-right d-flex justify-content-end m-3" >
                                        <a class="btn btn-primary  mb-2" href="{{ route('department.create') }}"><i class="fa fa-plus"></i> Ստեղծել</a>
                                    </div>

                                @endif


                            </div>

                            <!-- Bordered Table -->
                            @if (count($data) > 0)
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">Հ/Հ</th>
                                        {{-- <th scope="col">ID</th> --}}
                                        <th scope="col">Անուն</th>
                                        {{-- <th scope="col">Կարգավիճակ</th> --}}
                                        <th scope="col">Գործողություն</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($data as $item)


                                            <tr class="parent">
                                                <td>{{ ++$i }}</td>

                                                <td>
                                                    {{ $item->name ?? null }}
                                                </td>

                                                <td>

                                                    <div class="dropdown action"data-id="{{ $item['id'] }}" data-tb-name="departments" >
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            {{-- @if(auth()->user()->hasRole(['super_admin','client_admin', 'client_admin_rfID']))
                                                                <a class="dropdown-item d-flex" href="javascript:void(0);">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input change_status" type="checkbox"
                                                                            role="switch" data-field-name="status"
                                                                            {{ $item['status'] ? 'checked' : null }}>
                                                                    </div>Կարգավիճակ
                                                                </a>
                                                            @endif --}}
                                                            @if (!auth()->user()->hasRole('client_admin_rfID'))

                                                                <a class="dropdown-item" href="{{route('department.edit',$item['id'])}}"><i
                                                                        class="bx bx-edit-alt me-1"></i>Խմբագրել</a>
                                                            @endif
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

                                <div class="demo-inline-spacing">
                                    {{-- {{ $data->links() }} --}}
                                </div>
                            @else
                              <div class="alert alert-danger" role="alert">
                                 <p>Դուք չունեք ստեղծած ստորաբաժանումներ</p>
                              </div>
                            @endif
                        </div>



                </div>



        </div>

      </div>

    </section>

  </main><!-- End #main -->

@endsection
<x-modal-delete></x-modal-delete>

