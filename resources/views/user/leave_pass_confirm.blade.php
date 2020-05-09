@extends('layouts.new_app')

@section('content')
<div class="container">
    <span style="text-align: center;"><h3>{{ __('회원탈퇴') }}</h3></span>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('회원탈퇴') }}</div>

                <div class="card-body">

                    @if (session()->has('error') === true)
                        <div class="alert alert-danger" role="alert">
                            {{ session()->get('error') }}
                        </div>
                    @endif



                    <form method="POST" action="{{ url("/user/leave") }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12" style="text-align: left">
                                <h4 style="color:red">탈퇴시 주의 사항</h4>
                                <p>회원을 탈퇴하시겠습니까?<br>
                                    회원탈퇴시 바로 회원님의 <strong style="color:red">모든 데이터가 삭제</strong>되고 서비스 <strong style="color:red">접속이 불가능</strong>해집니다.
                            </div>
                        </div>

                        <div style="border: 1px solid #ddd;padding: 20px;overflow: auto;overflow: hidden;background-color: #f7f8fa;margin-bottom: 20px;text-align:center;">
                            <h5 class="ng-binding"><span class="grey">탈퇴할 계정 정보:</span> &nbsp;
                                {{$user->user_name}}
                            </h5>
                        </div>

                        <div class="form-group row">
                            <label for="pass" class="col-md-4 col-form-label text-md-right">{{ __('비밀번호') }}</label>

                            <div class="col-md-6">
                                <input id="pass" type="pass" class="form-control @error('pass') is-invalid @enderror" name="pass">

                                @error('pass')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('확인') }}
                                </button>

                                <a href="{{ url("/home") }}" class="btn btn-secondary">{{ __('취소') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">


    $(document).ready(function() {
        $(".btn-submit").click(function(e){
            e.preventDefault();


            var _token = $("input[name='_token']").val();
            var first_name = $("input[name='first_name']").val();
            var last_name = $("input[name='last_name']").val();
            var email = $("input[name='email']").val();
            var address = $("textarea[name='address']").val();


            $.ajax({
                url: "/my-form",
                type:'POST',
                data: {_token:_token, first_name:first_name, last_name:last_name, email:email, address:address},
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        alert(data.success);
                    }else{
                        printErrorMsg(data.error);
                    }
                }
            });


        });


        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    });


</script>

@endsection
