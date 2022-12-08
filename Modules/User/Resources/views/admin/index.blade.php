@extends('adminmaster::master')
@section('title') کاربران@endsection
@section('header') کاربران@endsection

@section('tools')
    <a type="button" class="btn btn-info btn-sm" href="{{route('inactive_users')}}">کاربران غیرفعال</a>
    <a type="button" class="btn btn-tool btn-sm" href="{{route('user.create')}}"><i class="fa fa-plus-circle fa-2x color-secondary color-success"></i></a>

@endsection
@section('css')

@include('adminmaster::layouts.data_table_css')
<!-- Persian Data Picker -->
<link rel="stylesheet" href="{{asset('/files/AdminMaster/dist/css/persian-datepicker.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('/files/AdminMaster/plugins/select2/select2.min.css')}}">
@endsection

@section('content')
    <p>
        <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#collapseExample" role="button"
           aria-expanded="false" aria-controls="collapseExample">
            فیلتر
        </a>

    </p>
    <div class="row">
        @foreach($tags as $tag)
            <span class="badge badge-info m-2">{{$tag}}</span>
        @endforeach
    </div>
    <a href="{{route('user.index')}}" class="text-info">نمایش همه</a>

    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form method="get" action="{{route('admin-search-user')}}">
                @csrf

                <div class="form-group">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <div>
                                <label>جستجو</label>

                                <input class="form-control " type="text"
                                       name="search" placeholder="جستجو نام ، نام خانوادگی ، موبایل ،ایمیل">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div>
                                <label>تعداد نمایش کاربران</label>
                                <select name="per_page" class="form-control">
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div>
                                <label>شهر</label>
                                <select name="city" class="form-control select2"  style="width: 100%">
                                    <option value=""></option>

                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div>
                                <label>حوزه فعالیت</label>
                                <select name="activity" class="form-control select2 " style="width: 100%">
                                    <option value=""></option>

                                @foreach($activities as $activity)
                                        <option value="{{$activity->id}}">{{$activity->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label"> ثبت نام از تاریخ</label>
                            <div>
                                <input class="form-control datePicker" type="text"
                                       name="from" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label">ثبت نام تا تاریخ</label>
                            <div>
                                <input class="form-control datePicker" type="text"
                                       name="to" readonly>
                            </div>
                        </div>
                        <div class="col-md-12  d-flex justify-content-end align-content-end ">
                            <input class="btn bg-blue-them btn-sm" type="submit" value="فیلتر">
                        </div>
                    </div>
                </div>


            </form>

        </div>
    </div>
    <table id="datatable" class="table table-bordered table-sm   display responsive nowrap "
           style="width: 100%">
        <thead>
        <tr>
            <th>ردیف</th>
            <th>نام و نام خانوادگی</th>
            <th>موبایل</th>
            <th>ایمیل</th>
            <th>شهر</th>
            <th>تولد</th>
            <th>تاریخ عضویت</th>
            <th>حوزه های فعالیت</th>
            <th>نقش ها</th>
            <th>فعال/غیرفعال</th>
            <th> مشاهده/ویرایش/حذف</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $users as $key=>$user)
            <tr>
                <td>{{$users->total() -$key - (($users->currentPage()-1)*$users->perpage())}}</td>

                <td>{{$user->firstName}}  {{$user->lastName}}</td>
                <td>{{$user->mobile}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if(!is_null($user->city_id))
                    {{$user->city->state->name}},{{$user->city->title}}
                    @endif
                </td>
                <td>{{$user->bornDate}}</td>
                <td>{{verta($user->created_at)->formatDate()}}</td>
                <td>
                    @foreach($user->activities as $key=>$activity)
                        {{$key>0?",":""}}
                    {{$activity->title}}
                    @endforeach
                </td>

                <td>
                @foreach($user->roles as $role)
                    <span class="badge badge-info"> {{$role->title}}</span>
                    @endforeach
                </td>
                <td><input type="checkbox" class="status_input" id="{{$user->id}}" onclick="change_field({{$user->id}},'status','User','User')"
                           value="{{$user->id}}" {{$user->status=='active'?"checked":""}}></td>


                <td>
                    <div class="btn-group">

                        <a href="{{route('user.show',$user->id)}}"><i
                                class="fa fa-list text-secondary m-2"></i></a>
                        <a href="{{route('user.edit',$user->id)}}"><i
                                class="fa fa-edit text-info m-2"></i></a>

                        <form action="{{ route('user.destroy' ,$user->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="btn-none" onclick="return confirm(' آیا از حذف این  کاربر اطمینان دارید؟')"><i
                                    class="fa fa-trash text-danger m-2"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center align-content-center  ">{{ $users->links() }}</div>
    </div>


@endsection

@section('js')

@include('adminmaster::layouts.data_table')
@include('adminmaster::layouts.persianDatePicker')
<script src="{{asset('/files/AdminMaster/plugins/select2/select2.full.min.js')}}"></script>
<script>
    $(function () {
        $('.select2').select2()
    })
</script>
@endsection
