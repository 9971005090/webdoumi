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
                    <form method="get" action="{{ url("admin/user/index") }}">
                    <span class="form-inline" style="float: right!important; margin-top:-20px; margin-bottom:5px;">
                        <div class="form-group">
                            <label class="col-form-label">검색기간</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control" name="begin" style="width:100px;" value="{{ request()->begin }}"/>
                                <span class="input-group-addon">~</span>
                                <input type="text" class="input-sm form-control" name="end" style="width:100px; margin-right:2px;" value="{{ request()->end }}"/>
                            </div>

                            <div class="input-group">
                                <input type="text" class="form-control" name="search_keyword" value="{{ request()->search_keyword }}" placeholder="검색어" style="margin-right:2px;">
                                <div class="input-group-btn">
                                    <input type="submit" class="btn btn-primary ng-binding" value="검색">
                                </div>
                            </div>
                        </div>
                    </span>
                    <span style="float: left!important;clear: both;">
                        <a class="btn btn-info" href="{{ url("/admin/user/add_form") }}"><span class="ng-scope">등록</span></a>
                    </span>
                    <span class="form-inline" style="float: right!important;">
                        <select class="form-control" name="order_by" style="margin-right:2px;">
                            @foreach($form_select_options['order_by'] as $key => $order_by)
                            <option value="{{ $key }}" {{ request()->order_by == $key ? 'selected=true' : '' }}>{{ $order_by }}</option>
                            @endforeach
                        </select>
                        <select class="form-control" name="per_page">
                            @foreach($form_select_options['per_page'] as $key => $per_page)
                            <option value="{{ $key }}" {{ request()->per_page == $key ? 'selected=true' : '' }}>{{ $per_page }}</option>
                            @endforeach
                        </select>
                    </span>
                    </form>
                    <div class="nav-tabs-vc" style="clear: both; padding-top:10px;">
                        <div class="tab-content px-0">
                            <div class="tab-pane active">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="border-0">
                                                        <div class="position-relative form-check">
                                                            <label class="form-check-label">
                                                                <input id="checkbox1" type="checkbox" class="form-check-input"> 번호
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th scope="col" class="border-0">아이디</th>
                                                    <th scope="col" class="border-0">이름</th>
                                                    <th scope="col" class="border-0">이메일</th>
                                                    <th scope="col" class="border-0">승인여부</th>
                                                    <th scope="col" class="border-0">불량여부</th>
                                                    <th scope="col" class="border-0">가입일</th>
                                                    <th scope="col" class="border-0">관리</th>
                                                </tr>
                                                </thead>

                                                @if (sizeof($users) <= 0)
                                                <tbody>
                                                    <tr>
                                                        <td colspan="8" style="font-size:15px;font-weight: bold;text-align: center;vertical-align: middle">등록된 데이타가 없습니다</td>
                                                    </tr>
                                                </tbody>
                                                @endif

                                                @if (sizeof($users) > 0)
                                                <tbody>
                                                    @foreach($users as $key => $user)
                                                    <tr>
                                                        <th scope="row">

                                                            <div class="position-relative form-check">
                                                                <label class="form-check-label">
                                                                    <input id="checkbox2" type="checkbox" class="form-check-input"> {{ \App\Helpers\Custom\Utils::virtual_number($users, $key) }}
                                                                </label>
                                                            </div>
                                                        </th>
                                                        <td>
                                                            {{ $user->user_name }}
                                                        </td>
                                                        <td>{{ $user->real_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                            @if ($user->confirmed === 1) O @endif
                                                            @if ($user->confirmed === 0) X @endif
                                                        </td>

                                                        <td>
                                                            @if ($user->suspended === 1) O @endif
                                                            @if ($user->suspended === 0) X @endif
                                                        </td>
                                                        <td>{{ \App\Helpers\Custom\Utils::get_date_change($user->created_at) }}</td>
                                                        <td>
                                                            <a href="{{ url("admin/user/edit_form/".$user->id."?".$query_string) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                                                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                                            </svg>
                                                            </a>
                                                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$user->id}})"
                                                               data-target="#DeleteModal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF586B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                                            </svg>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                @endif

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-center">
                                        {{ $users->appends(request()->query())->links() }}
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-center">
                                        <pre>
                                        {{ print_r($queries) }}
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="DeleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" id="deleteForm" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="begin" value="{{ request()->begin }}"/>
                    <input type="hidden" name="end" value="{{ request()->end }}"/>
                    <input type="hidden" name="search_keyword" value="{{ request()->search_keyword }}">
                    <input type="hidden" name="order_by" value="{{ request()->order_by }}">
                    <input type="hidden" name="per_page" value="{{ request()->per_page }}">
                    <div class="modal-header">
                        <h5 class="modal-title">확인</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="text-center">정말로 삭제하시겠습니까?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <button type="submit" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">삭제</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <script>
        $('.input-daterange').datepicker({format: "yyyy-mm-dd",});

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
    </script>
@endsection
