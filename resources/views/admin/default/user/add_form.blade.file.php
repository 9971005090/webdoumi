@extends('admin/default/layouts/app')

@section('content')
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">회원</span>
            <h3 class="page-title">등록</h3>
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
                        <form action="{{ url("/filemanager/upload") }}" enctype="multipart/form-data" method="post" class="form-bordered form-horizontal">
                            @csrf
                            <input type="file" class="form-control" name="file">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-double"></i> 등록
                            </button>
                        </form>
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
                    {title : "Zip files", extensions : "zip"}
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
