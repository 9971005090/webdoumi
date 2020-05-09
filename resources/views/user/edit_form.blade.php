@extends('layouts.new_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('회원정보') }}</div>

                <div class="card-body">

                    @if (session()->has('error') === true)
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    @if (session()->has('info') === true)
                        <div class="alert alert-info" role="alert">
                            {{ session()->get('info') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ url("/user/edit")."/".$user->id }}">
                        @csrf

                        <input type="hidden" name="is_requested" value="1" class="form-control">
                        <div class="form-group row">
                            <label for="user_name" class="col-md-4 col-form-label text-md-right">{{ __('아이디') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $user->user_name }}" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('이름') }}</label>

                            <div class="col-md-6">
                                <input id="real_name" type="text" class="form-control @error('real_name') is-invalid @enderror" name="real_name" value="{{ old('real_name') ?? (old('is_requested') == null ? $user->real_name : null) }}">

                                @error('real_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('이메일') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? (old('is_requested') == null ? $user->email : null) }}">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('수정하기') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
