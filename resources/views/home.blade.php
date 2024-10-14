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

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <div class = "d-flex justify-content-between">
                    <h5 class="card-title">

                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Աշխատակիցների ցուցակ</li>
                        </ol>
                    </nav>

                    </h5>
                    <a href="{{ route('entry-codes-create') }}">Create</a>
                </div>
              <!-- Bordered Table -->

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Հ/Հ</th>
                    <th scope="col">ID</th>
                    <th scope="col">Նկար</th>
                    <th scope="col">Անուն</th>
                    <th scope="col">Ազգանուն</th>

                    <th scope="col">Հեռախոսահամար</th>
                    <th scope="col">Գործողություն</th>
                  </tr>
                </thead>
                <tbody>

                    @foreach ($data as $entry_code)

                        <tr>
                            <td>{{ ++$i }}</td>
                            <th scope="row">{{ $entry_code->id }}</th>

                            <td>
                                <img src = "{{ $entry_code->image ? route('get-file',['path' => $entry_code->image ]) : null }}" style="width:80px">
                            </td>
                            <td>
                                {{ $entry_code->person_permissions->people->name ?? null }}

                            </td>
                             <td>
                                {{ $entry_code->person_permissions->people->surname ?? null }}

                            </td>
                            <td>
                                {{ $entry_code->person_permissions->people->phone ?? null }}
                            </td>
                            <td>

                                <div class="dropdown action"data-id="{{ $entry_code['id'] }}" data-tb-name="entry_codes">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu ">
                                      <a class="dropdown-item d-flex" href="javascript:void(0);">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input change_status" type="checkbox"
                                                role="switch" data-field-name="status"
                                                {{ $entry_code['status'] ? 'checked' : null }}>
                                        </div>Կարգավիճակ
                                       </a>
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


          </div>
          <div class="demo-inline-spacing">
            {{ $data->links() }}
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

