@extends('admin/default/layouts/app')

@section('content')
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">회원</span>
            <h3 class="page-title">목록</h3>
        </div>
    </div>

    @if (session()->has('error') === true)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session()->get('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session()->has('info') === true)
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('info') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <!-- End Page Header -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="px-3">
                        <form action="{{ url("/admin/user/add") }}" method="post" class="form-bordered form-horizontal">
                            @csrf
                            <input type="hidden" name="is_requested" value="1" class="form-control">
                            <div class="form-body">
                                <h4 class="form-section">
                                    <h4 class="form-section">
                                        <i class="fas fa-user"></i> 기본
                                    </h4>
                                </h4>

                                <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">{{ __('아이디') }}</label>
                                    <div class="col-sm-9" style="margin-top:10px;">
                                        <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}">

                                        @error('user_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="real_name" class="col-sm-3 col-form-label">{{ __('이름') }}</label>
                                    <div class="col-sm-9">
                                        <input id="real_name" type="text" class="form-control @error('real_name') is-invalid @enderror" name="real_name" value="{{ old('real_name') }}">

                                        @error('real_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="email" class="col-sm-3 col-form-label">{{ __('이메일') }}</label>
                                    <div class="col-sm-9">
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="pass" class="col-sm-3 col-form-label">{{ __('비밀번호') }}</label>
                                    <div class="col-sm-9">
                                        <input id="pass" type="password" class="form-control @error('pass') is-invalid @enderror" name="pass" value="{{ old('pass') }}">

                                        @error('pass')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label for="pass_confirm" class="col-sm-3 col-form-label">{{ __('비밀번호 확인') }}</label>
                                    <div class="col-sm-9">
                                        <input id="pass_confirm" type="password" class="form-control @error('pass_confirm') is-invalid @enderror" name="pass_confirm" value="{{ old('pass_confirm') }}">

                                        @error('pass_confirm')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <h4 class="form-section">
                                    <i class="far fa-list-alt"></i> 부가
                                </h4>


                                <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">{{ __('전화번호') }}</label>
                                    <div class="col-sm-9">
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">

                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">{{ __('휴대폰번호') }}</label>
                                    <div class="col-sm-9">
                                        <input id="mobile_phone" type="text" class="form-control @error('mobile_phone') is-invalid @enderror" name="mobile_phone" value="{{ old('mobile_phone') }}">

                                        @error('mobile_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">{{ __('성별') }}</label>
                                    <div class="col-sm-9 form-inline" >
                                        <div class="custom-control custom-radio mb-1">
                                            <input id="gender" type="radio" class="custom-control-input" name="gender" value="M"{{ (old('gender') == null || old('gender') == "M") ? ' checked' : null }}>
                                            <label class="custom-control-label" for="gender">남성</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-1" style="margin-left:20px;">
                                            <input id="gender" type="radio" class="custom-control-input" name="gender" value="F"{{ old('gender') == "F" ? ' checked' : null }}>
                                            <label class="custom-control-label" for="gender">여성</label>
                                        </div>
                                        <input type="hidden" class="form-control @error('gender') is-invalid @enderror">
                                        @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">{{ __('생일') }}</label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <input type="text" id="birthday" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ old('birthday') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>

                                        @error('birthday')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <style>
                                    .zip-scroll {
                                        margin:0;
                                        padding:0;
                                        overflow-y:scroll;
                                        height:243px;
                                        border: 1px solid #ccc;
                                    }
                                    .zip-scroll ul {
                                        margin:0 10px 10px 15px;
                                        padding:0;
                                    }
                                    .zip-scroll ul li {
                                        list-style-type:none;
                                        background:none;
                                        padding:0;
                                        margin:0;
                                        display:block;
                                        padding:10px 0px;
                                        border-bottom:1px solid #ddd;
                                        vertical-align:top;
                                    }
                                    .zip-scroll ul li a {
                                    }
                                    .zip-scroll ul li a:hover,
                                    .zip-scroll ul li a:focus {
                                        text-decoration:none;
                                    }
                                </style>
                                <div class="position-relative row form-group" id="content_zipcode_find_after"@if ( old('zipcode') === null ) style="display:none"@endif>
                                    <label class="col-sm-3 col-form-label">{{ __('우편번호') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" id="zipcode" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><a onclick="zipcode_edit()"><i class="fas fa-pencil-alt"></i></a></span>
                                                <span class="input-group-text"><a onclick="zipcode_back();"><i class="fas fa-times"></i></a></span>
                                            </div>
                                        </div>

                                        @error('zipcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="position-relative row form-group" id="content_zipcode_find_before"@if ( old('zipcode') !== null ) style="display:none"@endif>
                                    <label class="col-sm-3 col-form-label">{{ __('우편번호') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="address_dong" id="address_dong" placeholder="도로명 주소, 건물명 또는 지번 입력">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><a onclick="zipcode_find();"><i class="fas fa-search"></i></a></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="zip-scroll" style="display:none;width:100%;margin-top:-3px;" id="zipcode_list">
                                            <ul class="zipcode" id="zipcode_list_ul"></ul>
                                        </div>
                                    </div>

                                </div>

                                <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">{{ __('기본주소') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="address1" class="form-control @error('address1') is-invalid @enderror" name="address1" value="{{ old('address1') }}">

                                        @error('address1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">{{ __('상세주소') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="address2" class="form-control @error('address2') is-invalid @enderror" name="address2" value="{{ old('address2') }}">

                                        @error('address2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">{{ __('test') }}</label>
                                    <div class="col-sm-9">
                                        <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                                        <br />

                                        <div id="container">
                                            <a id="pickfiles" href="javascript:;">[Select files]</a>
                                            <a id="uploadfiles" href="javascript:;">[Upload files]</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="console"></div>


                                <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">이미지</label>
                                    <div class="col-sm-9">
                                        <!- <img src="{{ url("filemanager/view/AfFiqlfn2ngfp6WFD4IhHP4Qvs5L1vUPhV3S9sWG") }}">
                                        <img src="{{ asset('storage/test/logo.png') }}">  ->
                                    </div>
                                </div> -->

                                <div class="position-relative row form-group">
                                    <label for="email" class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <input id="move" type="checkbox" name="move" value="yes"> 등록 후 목록으로 이동
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check-double"></i> 등록
                                </button>
                                <a href="{{ url("admin/user/index?".$query_string) }}" class="mr-1 btn btn-warning" style="color: white">
                                    <i class="fas fa-align-justify"></i> 목록
                                </a>
                            </div>
                        </form>
                        <!-- <form action="{{ url("/filemanager/upload") }}" enctype="multipart/form-data" method="post" class="form-bordered form-horizontal">
                            @csrf
                            <input type="file" class="form-control" name="file">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-double"></i> 등록
                            </button>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="{{ asset('js/plupload/plupload.full.min.js') }}"></script>
    <script src="{{ asset('js/plupload/plupload.min.js') }}"></script>
    <script src="{{ asset('js/plupload/moxie.js') }}"></script>
    <!-- <script src="{{ asset('js/plupload/plupload.dev.js') }}"></script> -->

    <script>
        $('.date').datepicker({format: "yyyy-mm-dd"}).datepicker("setDate", new Date());

        function deleteData(id)
        {
            var url = "{{ url("admin/user/delete/:id") }}";
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
        }


        var zipcodes = [];
        function zipcode_find()
        {
            if($('#address_dong').val() === "")
            {
                alert("도로명 주소, 건물명 또는 지번을 입력하세요");
                return;
            }
            var ajaxurl = "{{ url('/admin/user/find_zipcode') }}" + "/" + $('#address_dong').val();
            $.get(ajaxurl, {}, function(response){
                var obj = jQuery.parseJSON(response);
                if(obj['results']['common']['errorMessage'] == "정상")
                {
                    $("#zipcode_list_ul").html(null);
                    zipcodes = obj['results']['juso'];
                    for(var i=0;i<zipcodes.length;i++)
                    {
                        var temp = '';
                        temp += '    <li>';
                        temp += '        <span class="float-right">';
                        temp += '            <a class="btn btn-light btn-sm" onclick="select_zipcode(' + i + ')">선택</a>';
                        temp += '        </span>';
                        temp += '        <strong style="color:#FF11CE">(' + zipcodes[i]['zipNo'] + ')</strong><br/>';
                        temp += '        <span style="color:#11CD4B">도로명주소</span>: ' + zipcodes[i]['roadAddr'] + '</span><br/>';
                        temp += '        <span style="color:#E0DAD6">지번</span>: ' + zipcodes[i]['jibunAddr'];
                        temp += '    </li>';
                        $("#zipcode_list_ul").append( temp );
                    }
                    $("#zipcode_list").css("display", "block");
                }
                else
                {
                    alert(obj['results']['common']['errorMessage']);
                }
                $( "#address1").val(null);
                $( "#data_address2").val(null);
            });
        }

        function select_zipcode(pt)
        {
            $( "#zipcode").val(zipcodes[pt]['zipNo']);
            $( "#address1").val(zipcodes[pt]['roadAddr']);
            //$( "#zipcode_list").css("display", "none");
            //$( "#content_zipcode_find_before").css("display", "none");
            //$( "#content_zipcode_find_after").css("display", "table");
            $( "#zipcode_list").hide();
            $( "#content_zipcode_find_before").hide();
            $( "#content_zipcode_find_after").show();

        }


        function zipcode_edit()
        {
            //$("#content_zipcode_find_before").css("display", "table");
            //$("#content_zipcode_find_after").css("display", "none");
            $( "#content_zipcode_find_before").show();
            $( "#content_zipcode_find_after").hide();
            $("#zipcode_button_search").html(null);
            $("#zipcode_button_search").append( '<a class="btn btn-primary" onclick="zipcode_find();"><i class="fa fa-search"></i></a>' );
            $("#zipcode_button_search").append( '<a class="btn btn-danger" onclick="zipcode_back();"><i class="fa fa-close"></i></a>' );
        }

        function zipcode_back()
        {
            $( "#content_zipcode_find_before").hide();
            $( "#content_zipcode_find_after").show();
            //$("#content_zipcode_find_before").css("display", "none");
            //$("#content_zipcode_find_after").css("display", "table");
        }

        var uploader = new plupload.Uploader({
            runtimes : 'html5,flash,silverlight,html4',
            browse_button : 'pickfiles', // you can pass an id...
            container: document.getElementById('container'), // ... or DOM Element itself
            url : '{{ url("/filemanager/upload") }}',
            flash_swf_url : '{{ asset("js/plupload/Moxie.swf") }}',
            silverlight_xap_url : '{{ asset("js/plupload/Moxie.xap") }}',

            filters : {
                max_file_size : '10mb',
                mime_types: [
                    {title : "Image files", extensions : "jpg,gif,png"},
                    {title : "Zip files", extensions : "zip"},
                    // {title : "Js files", extensions : "js"}
                ]
            },
            // multipart_params : {
            //     "name1" : "value1",
            //     "name2" : "value2"
            // },
            headers: {
                "x-csrf-token" : $("[name=_token]").val()
            },

            init: {
                PostInit: function() {
                    document.getElementById('filelist').innerHTML = '';

                    document.getElementById('uploadfiles').onclick = function() {
                        uploader.start();
                        return false;
                    };
                },

                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                    });
                },

                UploadProgress: function(up, file) {
                    document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                },

                FileUploaded: function(up, file, response) {
                    console.log("file:::::::::::", file);
                    console.log("response:::::::::::", response); 
                    console.log("response.response:::::::::::", JSON.parse(response.response)); 
                    // 서버에서 내려준 내용은 다시 json으로 디코딩. json으로 내려주나, 문자열로 다시 파싱되는듯
                },

                Error: function(up, err) {
                    document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
                }
            }
        });

        uploader.init();
    </script>
@endsection
