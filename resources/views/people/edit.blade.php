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
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">

              <h5 class="card-title">
                <nav>
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>

                      <li class="breadcrumb-item active">Խմբագրել</li>
                    </ol>
                  </nav>
              </h5>

              <!-- General Form Elements -->
              <form action="{{ route('entry_codes-update',$data->id)}}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf

                <div class="row mb-3">

                  <label for="inputText" class="col-sm-3 col-form-label">Անուն</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="name"  value="{{ $data->person_permissions->people->name ?? null }}">
                  </div>

                </div>
                <div class="row mb-3">

                    <label for="inputText1" class="col-sm-3 col-form-label" >Ազգանուն </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="surname" value="{{ $data->person_permissions->people->surname??null }}">
                    </div>

                </div>

                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-3 col-form-label">Էլ.հասցե</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control"  name="email"  value="{{ $data->person_permissions->people->email??null }}">
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Հեռախոսահամար</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="phone"  value="{{ $data->person_permissions->people->phone??null }}">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Թոքեն </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="token" value={{ $data->token}}>

                    </div>
                    @error("token")
                        <div class="mb-3 row justify-content-end">
                            <div class="col-sm-9 text-danger fts-14">{{ $message }}
                            </div>
                        </div>
                    @enderror
                  </div>

                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-3 col-form-label">ներբեռնել նկար</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="file" id="formFile" name="image">
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="inputNumber" class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <div class="uploaded-image-div mx-2">
                            <img src="{{route('get-file', ['path' => $data->image])}}" class="d-block rounded uploaded-image uploaded-photo-project" style="width:150px">
                        </div>
                    </div>
                  </div>
                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Տեսակ</label>
                  <div class="col-sm-9">
                    <select class="form-select" aria-label="Default select example" name ="type">
                      <option value='' disabled >Ընտրել տեսակը</option>
                      <option value="rfId" {{$data->type=="rfId" ? "selected" : ""}}>rfId</option>
                      <option value="FaceId" {{$data->type=="FaceId" ? "selected" : ""}}>FaceId</option>
                    </select>
                    @error("type")
                    <div class="mb-3 row justify-content-end">
                        <div class="col-sm-10 text-danger fts-14">{{ $message }}
                        </div>
                    </div>
                    @enderror
                  </div>

                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Կարգավիճակ</label>
                    <div class="col-sm-9">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" {{ $data->status==1 ? 'checked' : ''  }} name="status" value="{{$data->status  }}">

                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Ակտիվացում </label>
                    <div class="col-sm-9">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" {{ $data->activation==1 ? 'checked' : ''  }} name="activation">

                        </div>
                    </div>
                </div>



                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary">Պահպանել</button>
                  </div>
                </div>

              </form>

            </div>
          </div>

        </div>
    </section>

  </main><!-- End #main -->


@endsection
