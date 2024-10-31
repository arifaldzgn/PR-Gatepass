@extends('layouts.main')

@section('container')

    <div class="login-page bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                <h3 class="mb-3">Login To Your Account</h3>
                    <div class="bg-white shadow rounded">
                        <div class="row">
                            <div class="col-md-7 pe-0">
                                <div class="form-left h-100 py-5 px-5">
                                    <form action="{{ route('authenticate') }}" class="row g-4" method="POST">
                                        @csrf
                                            <div class="col-12">
                                                <label>Employee Badge<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text @error('badge_no') is-invalid @enderror"><i class="bi bi-person-fill"></i></div>
                                                    <input type="text" class="form-control" placeholder="Enter Employee Badge Number" name="badge_no" autofocus required value="{{ old('badge_no')}}">
                                                    @error('badge_no')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label>Password<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" name="password" required>
                                                    @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary px-4 float-end mt-4">login</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 ps-0 d-none d-md-block">
                                <div class="form-right h-100 bg-primary text-white text-center pt-5">
                                    <i class="bi bi-person"></i>
                                    <h2 class="fs-1">Welcome Back!!!</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(session()->has('loginError'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        <center>Login error</center>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
