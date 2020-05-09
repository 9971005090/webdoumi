@extends('admin/default/layouts/app')

@section('content')
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Overview</span>
            <h3 class="page-title">Data Tables</h3>
        </div>
    </div>
    <!-- End Page Header -->
    <!-- Default Light Table -->
    <div class="row d-none d-xl-block">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <!--
                    <span style="float: right!important;">
                        <form class="form-inline">
                            <div class="form-group col-md-12">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start" style="width:100px;"/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" name="end" style="width:100px;"/>
                                </div>
                                <select class="form-control ng-pristine ng-valid" ng-model="search.type" ng-options="s.title for s in search_type"><option value="0" selected="selected">쿠폰유형</option><option value="1">상품적용쿠폰</option></select>

                                <select class="form-control ng-pristine ng-valid" ng-model="search.issue_type" ng-options="s.title for s in search_issue_type"><option value="0" selected="selected">발급유형</option><option value="1">수동발급</option><option value="2">자동발급</option><option value="3">회원다운로드</option></select>

                                <select class="form-control ng-pristine ng-valid" ng-model="search.benefit_type" ng-options="s.title for s in search_benefit_type"><option value="0" selected="selected">혜택구분</option><option value="1">가격할인</option><option value="2">포인트적립</option></select>
                                <select class="form-control ng-pristine ng-valid" ng-model="search.column" ng-options="s.title for s in search_column"><option value="0" selected="selected">검색어</option><option value="1">쿠폰명</option><option value="2">쿠폰설명</option></select>

                                <div class="input-group">
                                    <input type="text" class="form-control ng-pristine ng-valid" ng-model="search.word" placeholder="검색어">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary ng-binding">
                                            검색
                                        </button>
                                        <button type="button" class="btn btn-default ng-hide" ng-click="reset_filters()" ng-show="is_search()" translate=""><span class="ng-scope">취소</span></button>
                                        <a ui-sref="coupon_add" class="btn btn-info" translate="" href="/shop-admin.htm/coupon/add"><span class="ng-scope">등록</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start" style="width:100px;"/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" name="end" style="width:100px;"/>
                                </div>
                                <select class="form-control ng-pristine ng-valid" ng-model="search.type" ng-options="s.title for s in search_type"><option value="0" selected="selected">쿠폰유형</option><option value="1">상품적용쿠폰</option></select>

                                <select class="form-control ng-pristine ng-valid" ng-model="search.issue_type" ng-options="s.title for s in search_issue_type"><option value="0" selected="selected">발급유형</option><option value="1">수동발급</option><option value="2">자동발급</option><option value="3">회원다운로드</option></select>

                                <select class="form-control ng-pristine ng-valid" ng-model="search.benefit_type" ng-options="s.title for s in search_benefit_type"><option value="0" selected="selected">혜택구분</option><option value="1">가격할인</option><option value="2">포인트적립</option></select>
                                <select class="form-control ng-pristine ng-valid" ng-model="search.column" ng-options="s.title for s in search_column"><option value="0" selected="selected">검색어</option><option value="1">쿠폰명</option><option value="2">쿠폰설명</option></select>

                                <div class="input-group">
                                    <input type="text" class="form-control ng-pristine ng-valid" ng-model="search.word" placeholder="검색어">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary ng-binding">
                                            검색
                                        </button>
                                        <button type="button" class="btn btn-default ng-hide" ng-click="reset_filters()" ng-show="is_search()" translate=""><span class="ng-scope">취소</span></button>
                                        <a ui-sref="coupon_add" class="btn btn-info" translate="" href="/shop-admin.htm/coupon/add"><span class="ng-scope">등록</span></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </span>
                    -->
                    <!--
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    -->
                    <span style="float: right!important;">
                        <form class="row form-inline">
                            <div class="form-group col-md-12">
                                <label class="col-form-label">검색기간</label>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start" style="width:100px;" value="2019-10-05"/>
                                    <span class="input-group-addon">~</span>
                                    <input type="text" class="input-sm form-control" name="end" style="width:100px;"/>
                                </div>
                                <select class="form-control ng-pristine ng-valid" ng-model="search.order_by" ng-options="s.title for s in order_by" ng-change="search_coupon(search)"><option value="0" selected="selected">등록일↓</option><option value="1">등록일↑</option></select>

                                <select class="form-control ng-pristine ng-valid" ng-model="search.results_per_page" ng-options="s.title for s in results_per_page" ng-change="search_coupon(search)"><option value="0" selected="selected">10개 보기</option><option value="1">20개 보기</option><option value="2">30개 보기</option><option value="3">40개 보기</option><option value="4">50개 보기</option><option value="5">60개 보기</option><option value="6">70개 보기</option><option value="7">80개 보기</option><option value="8">90개 보기</option><option value="9">100개 보기</option></select>
                                <div class="input-group">
                                    <input type="text" class="form-control ng-pristine ng-valid" ng-model="search.word" placeholder="검색어">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary ng-binding">
                                            검색
                                        </button>
                                        <button type="button" class="btn btn-default ng-hide" ng-click="reset_filters()" ng-show="is_search()" translate=""><span class="ng-scope">취소</span></button>
                                        <a ui-sref="coupon_add" class="btn btn-info" translate="" href="/shop-admin.htm/coupon/add"><span class="ng-scope">등록</span></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </span>

                    <!--
                    <form>
                        <div class="form-row">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Name</label>
                                <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Jane Doe">
                            </div>
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@</div>
                                    </div>
                                    <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="autoSizingCheck">
                                    <label class="form-check-label" for="autoSizingCheck">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                            </div>
                        </div>
                    </form>
                    <form class="form-inline">
                        <label class="sr-only" for="inlineFormInputName2">Name</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Jane Doe">

                        <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Username">
                        </div>

                        <div class="form-check mb-2 mr-sm-2">
                            <input class="form-check-input" type="checkbox" id="inlineFormCheck">
                            <label class="form-check-label" for="inlineFormCheck">
                                Remember me
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">Submit</button>
                    </form>
                    -->
                </div>

                <div class="card-body p-0 pb-3 text-center">
                    <table class="table mb-0">
                        <thead class="bg-light">
                        <tr>
                            <th scope="col" class="border-0">번호</th>
                            <th scope="col" class="border-0">아이디</th>
                            <th scope="col" class="border-0">이름</th>
                            <th scope="col" class="border-0">이메일</th>
                            <th scope="col" class="border-0">승인여부</th>
                            <th scope="col" class="border-0">불량여부</th>
                            <th scope="col" class="border-0">가입일</th>
                            <th scope="col" class="border-0">관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ali</td>
                            <td>Kerry</td>
                            <td>Russian Federation</td>
                            <td>Gdańsk</td>
                            <td>107-0339</td>
                            <td>107-0339</td>
                            <td>107-0339</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Clark</td>
                            <td>Angela</td>
                            <td>Estonia</td>
                            <td>Borghetto di Vara</td>
                            <td>1-660-850-1647</td>
                            <td>107-0339</td>
                            <td>107-0339</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Jerry</td>
                            <td>Nathan</td>
                            <td>Cyprus</td>
                            <td>Braunau am Inn</td>
                            <td>214-4225</td>
                            <td>107-0339</td>
                            <td>107-0339</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Colt</td>
                            <td>Angela</td>
                            <td>Liberia</td>
                            <td>Bad Hersfeld</td>
                            <td>1-848-473-7416</td>
                            <td>107-0339</td>
                            <td>107-0339</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="px-3">
                        <form class="form-bordered form-horizontal">
                            <div class="form-body">
                                <h4 class="form-section">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#212529" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg> Personal Info
                                </h4>

                                <div class="position-relative row form-group">
                                    <label for="projectinput1" class="col-sm-3 col-form-label">First Name</label>
                                    <div class="col-sm-9" style="margin-top:10px;">
                                        강백호 끈 걸려 넘어지자 '빵' 터진 선배들,
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="projectinput1" class="col-sm-3 col-form-label">First Name:</label>
                                    <div class="col-sm-9">
                                        <input id="projectinput1" name="fname" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="projectinput2" class="col-sm-3 col-form-label">Last Name:</label>
                                    <div class="col-sm-9">
                                        <input id="projectinput2" name="lname" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="projectinput3" class="col-sm-3 col-form-label">E-mail:</label>
                                    <div class="col-sm-9">
                                        <input id="projectinput3" name="email" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="last position-relative row form-group">
                                    <label for="projectinput4" class="col-sm-3 col-form-label">Contact Number:</label>
                                    <div class="col-sm-9">
                                        <input id="projectinput4" name="phone" type="text" class="form-control">
                                    </div>
                                </div>
                                <h4 class="form-section">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#212529" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg> Requirements
                                </h4>
                                <div class="position-relative row form-group">
                                    <label for="companyName" class="col-sm-3 col-form-label">Company:</label>
                                    <div class="col-sm-9">
                                        <input id="companyName" name="company" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="projectinput5" class="col-sm-3 col-form-label">Interested in:</label>
                                    <div class="col-sm-9">
                                        <select id="projectinput5" name="interested" class="form-control">
                                            <option value="none">Interested in</option>
                                            <option value="design">design</option>
                                            <option value="development">development</option>
                                            <option value="illustration">illustration</option>
                                            <option value="branding">branding</option>
                                            <option value="video">video</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label for="projectinput6" class="col-sm-3 col-form-label">Budget:</label>
                                    <div class="col-sm-9">
                                        <select id="projectinput6" name="budget" class="form-control">
                                            <option value="0">Budget</option>
                                            <option value="less than 5000$">less than 5000$</option>
                                            <option value="5000$ - 10000$">5000$ - 10000$</option>
                                            <option value="10000$ - 20000$">10000$ - 20000$</option>
                                            <option value="more than 20000$">more than 20000$</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="position-relative row form-group">
                                    <label class="col-sm-3 col-form-label">Select File:</label>
                                    <div class="col-sm-9">
                                        <input id="projectinput8" type="file" class="form-control-file form-control-file">
                                    </div>
                                </div>
                                <div class="last position-relative row form-group">
                                    <label for="projectinput9" class="col-sm-3 col-form-label">About Project:</label>
                                    <div class="col-sm-9">
                                        <textarea id="projectinput9" rows="5" name="comment" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button class="mr-1 btn btn-warning">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg> Cancel
                                </button>
                                <button class="btn btn-primary">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="9 11 12 14 22 4"></polyline>
                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                    </svg> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <span style="float: right!important; margin-top:-20px;">
                        <form class="row form-inline">
                            <div class="form-group col-md-12">
                                <label class="col-form-label">검색기간</label>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" name="start" style="width:100px;" value="2019-10-05"/>
                                    <span class="input-group-addon">~</span>
                                    <input type="text" class="input-sm form-control" name="end" style="width:100px;"/>
                                </div>
                                <select class="form-control ng-pristine ng-valid" ng-model="search.order_by" ng-options="s.title for s in order_by" ng-change="search_coupon(search)"><option value="0" selected="selected">등록일↓</option><option value="1">등록일↑</option></select>

                                <select class="form-control ng-pristine ng-valid" ng-model="search.results_per_page" ng-options="s.title for s in results_per_page" ng-change="search_coupon(search)"><option value="0" selected="selected">10개 보기</option><option value="1">20개 보기</option><option value="2">30개 보기</option><option value="3">40개 보기</option><option value="4">50개 보기</option><option value="5">60개 보기</option><option value="6">70개 보기</option><option value="7">80개 보기</option><option value="8">90개 보기</option><option value="9">100개 보기</option></select>
                                <div class="input-group">
                                    <input type="text" class="form-control ng-pristine ng-valid" ng-model="search.word" placeholder="검색어">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary ng-binding">
                                            검색
                                        </button>
                                        <button type="button" class="btn btn-default ng-hide" ng-click="reset_filters()" ng-show="is_search()" translate=""><span class="ng-scope">취소</span></button>
                                        <a ui-sref="coupon_add" class="btn btn-info" translate="" href="/shop-admin.htm/coupon/add"><span class="ng-scope">등록</span></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </span>
                    <div class="nav-tabs-vc" style="clear: both; padding-top:10px;">
                        <div class="tab-content px-0">
                            <div class="tab-pane active">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        <div class="position-relative form-check">
                                                            <label class="form-check-label">
                                                                <input id="checkbox1" type="checkbox" class="form-check-input"> #
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="position-relative form-check">
                                                            <label class="form-check-label">
                                                                <input id="checkbox2" type="checkbox" class="form-check-input"> 1
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <td>Mark</td>
                                                    <td>Otto</td>
                                                    <td>markotto@mdo.com</td>
                                                    <td>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                                        </svg>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF586B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="position-relative form-check">
                                                            <label class="form-check-label">
                                                                <input id="checkbox3" type="checkbox" class="form-check-input"> 2
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <td>Jacob</td>
                                                    <td>Thornton</td>
                                                    <td>jacob@fat.com</td>
                                                    <td>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                                        </svg>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF586B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="position-relative form-check">
                                                            <label class="form-check-label">
                                                                <input id="checkbox4" type="checkbox" class="form-check-input"> 3
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <td>Larry</td>
                                                    <td>the Bird</td>
                                                    <td>larry@twitte.comr</td>
                                                    <td>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                                        </svg>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF586B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="position-relative form-check">
                                                            <label class="form-check-label">
                                                                <input id="checkbox5" type="checkbox" class="form-check-input"> 4
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <td>John</td>
                                                    <td>Doe</td>
                                                    <td>john@example.com</td>
                                                    <td>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                                        </svg>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF586B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="position-relative form-check">
                                                            <label class="form-check-label">
                                                                <input id="checkbox6" type="checkbox" class="form-check-input"> 5
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <td>Peater</td>
                                                    <td>Partker</td>
                                                    <td>peater@example.com</td>
                                                    <td>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                                            <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                            <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                                        </svg>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF586B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('.input-daterange').datepicker({format: "yyyy-mm-dd",});
    </script>
@endsection
