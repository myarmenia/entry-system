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

                      <li class="breadcrumb-item active">Ստեղծել գործատուի մուտքի կոդերը</li>
                    </ol>
                  </nav>
              </h5>

              <!-- General Form Elements -->
              <form action="{{ route('entry-codes-store')}}" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Գործատուների ցուցակ </label>
                    <div class="col-sm-10">
                      <select class="form-select" aria-label="Default select example" name ="user_id">
                        <option value='' disabled >Ընտրել գործատուին </option>
                        @foreach ($clients as  $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach

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
                        <label for="inputEmail" class="col-sm-2 col-form-label">Թոքեն </label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="token" value={{ old('token') }}>
                        </div>
                        @error("token")
                            <div class="mb-3 row justify-content-end">
                                <div class="col-sm-10 text-danger fts-14">{{ $message }}
                                </div>
                            </div>
                        @enderror
                  </div>
                {{-- <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">ներբեռնել նկար</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="formFile" name="image">
                  </div>
                </div> --}}
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
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Ստեղծել</button>
                  </div>
                </div>

              </form>

            </div>
          </div>

        </div>
    </section>

  </main><!-- End #main -->


@endsection
