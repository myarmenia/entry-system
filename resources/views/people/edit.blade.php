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
                            {{-- {{ dd($data->active_person->people) }} --}}
                            <form action="{{ route('people.update', $data['person']->id) }}" method="post"
                                enctype="multipart/form-data">
                                @method('put')

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Նույնականացման կոդ</label>
                                    <div class="col-sm-9">
                                      <select class="form-select" aria-label="Default select example" name ="entry_code_id">
                                        <option value='' disabled >Ընտրել նույնականացման կոդը</option>
                                        @foreach ($data['non_active_entry_code'] as $code )
                                        <option value="{{ $code->id }}">{{ $code->id }}</option>
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

                                    <label for="inputText" class="col-sm-3 col-form-label">Անուն </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Աշխատակցի անունը"
                                            value="{{ $data['person']->name ?? null }}">
                                    </div>

                                </div>
                                <div class="row mb-3">

                                    <label for="inputText1" class="col-sm-3 col-form-label">Ազգանուն </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="surname"
                                            placeholder="Աշխատակցի ազգանունը"
                                            value="{{ $data['person']->surname ?? null }}">
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <label for="inputEmail" class="col-sm-3 col-form-label">Էլ.հասցե</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email"
                                            placeholder="example@gmail.com"
                                            value="
                                            {{ $data['person']->email ?? null }}
                                             ">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail" class="col-sm-3 col-form-label">Հեռախոսահամար</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="phone"
                                            placeholder="+374 98-00 00"
                                            value="{{ $data['person']->phone ?? null }}">
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-3 col-form-label">ներբեռնել նկար</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" id="formFile" name="image">
                                    </div>
                                </div>

                                @if ($data['person'] !== null)
                                    <div class="row mb-3">
                                        <label for="inputNumber" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <div class="uploaded-image-div mx-2">
                                                <img src="{{ route('get-file', ['path' => $data['person']->image]) }}"
                                                    class="d-block rounded uploaded-image uploaded-photo-project"
                                                    style="width:150px">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Անձի կարգավիճակ</label>
                                    <div class="col-sm-9">
                                      <select class="form-select" aria-label="Default select example" name ="type">
                                            <option value='' disabled>Անձի կարգավիճակը</option>
                                            <option value="worker" {{ $data['person']->type=="worker" ?'selected': null}}> Աշխատող</option>
                                            <option value="visitor" {{ $data['person']->type=="visitor" ?'selected': null}}>Այցելու</option>


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
