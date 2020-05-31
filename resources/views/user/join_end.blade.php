@extends('layouts.new_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">

                    @if (session()->has('error') === true)
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <div class="form-group row">
                        <div class="col-md-12" style="text-align: left">
                            <h4>회원 가입 완료</h4>
                            <p>
                            입력하신 이메일 인증이 필요합니다.<br>
                            입력하신 이메일로 발송된 인증 메일의 링크를 클릭하셔셔 인증을 완료해 주세요.
                            </p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="{{ url('/') }}" class="btn btn-secondary">{{ __('홈으로') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
