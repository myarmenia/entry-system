@extends('layouts.app')

@section('page-script')
    <script src = "{{ asset('assets/js/user-role.js') }}"></script>
@endsection
@section('content')
{{-- <main id="main" class="main">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Create New User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm mb-2" href="{{ route('users.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" placeholder="Name" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" placeholder="Email" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Password:</strong>
                    <input type="password" name="password" placeholder="Password" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Role:</strong>
                    <select name="roles[]" class="form-control" multiple="multiple">
                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
            </div>
        </div>
    </form>

</main> --}}
<main id="main" class="main">

        <section class="section">
             <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">

                <div class="row">

                    {{-- @if (count($errors) > 0)
                        <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                    @endif --}}



                            <div class="col-lg-6">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <nav>
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>

                                                    <li class="breadcrumb-item active">Ստեղծել Օգտատեր</li>
                                                </ol>
                                            </nav>
                                        </h5>

                                        <!-- General Form Elements -->


                                            <div class="row mb-3">

                                                <label for="inputText" class="col-sm-3 col-form-label">Անուն</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Աշխատակցի անունը"
                                                        value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="mb-3 row justify-content-start">
                                                            <div class="col-sm-9 text-danger fts-14">{{ $message }}
                                                            </div>
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="row mb-3">
                                                <label for="inputEmail" class="col-sm-3 col-form-label">Էլ.հասցե</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="example@gmail.com"
                                                        value="{{ old('email') }}">
                                                    @error('email')
                                                        <div class="mb-3 row justify-content-start">
                                                            <div class="col-sm-9 text-danger fts-14">{{ $message }}
                                                            </div>
                                                        </div>
                                                    @enderror
                                                </div>



                                            </div>

                                            <div class="row mb-3">
                                                <label for="inputEmail"  class="col-sm-3 col-form-label">Գաղտնաբառ</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="password" class="form-control" placeholder="Password" value="">
                                                    @error('password')
                                                    <div class="mb-3 row justify-content-start">
                                                        <div class="col-sm-9 text-danger fts-14">{{ $message }}
                                                        </div>
                                                    </div>
                                                @enderror

                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="inputEmail" class="col-sm-3 col-form-label">Հաստատել գաղտնաբառը</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password" value="">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="inputEmail" class="col-sm-3 col-form-label">Դերեր</label>
                                                <div class="col-sm-9">
                                                    <select name = "roles[]" class="form-control" id="selectedRole" multiple="multiple">
                                                        @foreach ($roles as $value => $label)
                                                            <option value = "{{ $value }}" {{ in_array($value, old('roles', [])) ? 'selected' : '' }} >
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('roles')
                                                    <div class="mb-3 row justify-content-start">
                                                        <div class="col-sm-9 text-danger fts-14">{{ $message }}
                                                        </div>
                                                    </div>
                                                @enderror
                                                </div>

                                            </div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6" id="componentContainer">


                                    @if ($errors->has('client.name'))
                                        <x-client/>
                                    @endif

                            </div>

                        <div class="row mb-3" id="loginBtn">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Ստեղծել</button>
                            </div>
                        </div>



                </div>
                </form>

        </section>

</main>


@endsection
