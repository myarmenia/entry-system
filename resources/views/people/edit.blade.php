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
              <h5 class="card-title">Խմբագրել</h5>

              <!-- General Form Elements -->
              <form action="{{ route('entry_codes-update',$data->id)}}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf

                <div class="row mb-3">

                  <label for="inputText" class="col-sm-2 col-form-label">Անուն</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="name"  value={{ old('name') }}>
                  </div>

                </div>
                <div class="row mb-3">

                    <label for="inputText" class="col-sm-2 col-form-label" value={{ old('surname') }}>Ազգանուն </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="surname">
                    </div>

                </div>

                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Էլ.հասցե</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control"  name="email"  value={{ old('email') }}>
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Հեռախոսահամար</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="phone"  value={{ old('phone') }}>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Թոքեն </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="token" value={{ $data->token}}>
                    </div>
                    @error("token")
                        <div class="mb-3 row justify-content-end">
                            <div class="col-sm-10 text-danger fts-14">{{ $message }}
                            </div>
                        </div>
                    @enderror
                  </div>

                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">ներբեռնել նկար</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="formFile" name="image">
                  </div>
                </div>
                <div class="uploaded-images-container uploaded-photo-project" id="uploadedImagesContainer">

                    <div class="uploaded-image-div mx-2">
                        <img src="{{route('get-file', ['path' => $data->path])}}" class="d-block rounded uploaded-image uploaded-photo-project">
                    </div>

                  </div>





                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Տեսակ</label>
                  <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" name ="type">
                      <option value='' disabled >Ընտրել տեսակը</option>
                      <option value="rfId">rfId</option>
                      <option value="FaceId">FaceId</option>
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
                    <label class="col-sm-4 col-form-label">Կարգավիճակ</label>
                    <div class="col-sm-8">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" {{ $data->status==1 ? 'checked' : ''  }} name="status" value="{{$data->status  }}">

                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Ակտիվացում </label>
                    <div class="col-sm-8">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" {{ $data->activation==1 ? 'checked' : ''  }} name="activation">

                        </div>
                    </div>
                </div>



                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
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
