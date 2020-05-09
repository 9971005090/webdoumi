@extends('layouts.new_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('에러') }}</div>

                <div class="card-body">

                    @if (session()->has('error') === true)
                        <div class="form-group row">
                            <div class="col-md-12" style="text-align: center">
                                <h3>{{ session()->get('error') }}</h3>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-12" style="text-align: center">
                        @if ($service_type === "user")
                            <a href="{{ url("/home") }}" class="btn btn-primary">홈으로</a>
                        @endif
                        @if ($service_type === "admin")
                            <a href="{{ url("/admin/home") }}" class="btn btn-primary">홈으로</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
