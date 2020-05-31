@extends('layouts.new_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('이메일 인증') }}</div>

                <div class="card-body">

                    @if (session()->has('error') === true)
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    
                    @if ($result['code'] == 200)
                        <div class="form-group row">
                            <div class="col-md-12" style="text-align: left">
                                <h4>이에일 인증 완료</h4>
                                <p>
                                입력하신 이메일 인증이 정상적으로 처리됐습니다.
                                </p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                                <a href="{{ url('/') }}" class="btn btn-secondary">{{ __('홈으로') }}</a>
                                <a href="{{ url('/user/login_form') }}" class="btn btn-success">{{ __('로그인') }}</a>
                            </div>
                        </div>
                    @else
                    <div class="form-group row">
                        <div class="col-md-12" style="text-align: left">
                            <h4>이에일 인증 실패</h4>
                            <p>
                            {{ $result['msg'] }}
                            </p>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="{{ url('/') }}" class="btn btn-secondary">{{ __('홈으로') }}</a>
                            <a href="{{ url('/user/email_verify_resend') }}" class="btn btn-warning">{{ __('인증 메일 재발송') }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
