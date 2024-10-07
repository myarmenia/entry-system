@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>


</div> --}}


{{-- commentel em heto karox e petq gal  --}}
   {{-- @include("navbar") --}}




   <main id="main" class="main">



    <section class="section">
      <div class="row">

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <div class = "d-flex justify-content-between">
                    <h5 class="card-title">Աշխատակիցների ցուցակ</h5>
                    <a href="{{ route('people-create') }}">Create</a>
                </div>
              <!-- Bordered Table -->
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
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
                            <th scope="row">{{ $entry_code->id }}</th>

                            <td>
                                {{-- <img src="{{ \Storage::dis($entry_code->image) }}" style="width:150px"> --}}
                                <img src="{{ \Storage::disk('local')->get($entry_code->image) }}" style="width:150px">
                            </td>
                            <td>D</td>
                            <td>28</td>
                            <td>2016-05-25</td>
                            <td>
                                <div class="dropdown action"
                                 {{-- data-id="{{ $entry_code['id'] }}" data-tb-name="entry_codes" --}}
                                 >
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item d-flex" href="javascript:void(0);">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input change_status" type="checkbox"
                                                role="switch" data-field-name="status"
                                                {{ $entry_code['status'] ? 'checked' : null }}>
                                        </div>Կարգավիճակ
                                       </a>
                                        <a class="dropdown-item" href="{{route('people-edit',$entry_code['id'])}}"><i
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



        </div>
      </div>
    </section>

  </main><!-- End #main -->


@endsection
