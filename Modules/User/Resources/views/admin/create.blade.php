@extends('adminmaster::master')
@section('title')افزودن کاربر@endsection
@section('header')افزودن کاربر@endsection
@section('tools')
    <a type="button" class="btn btn-tool btn-sm" href="{{route('user.index')}}"><i
            class="fa fa-arrow-circle-left fa-2x color-secondary color-secondary"></i></a>
@endsection
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/files/AdminMaster/plugins/select2/select2.min.css')}}">
@endsection

@section('content')

    <form class="form-horizontal" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">

        @csrf
        <div class="form-group ">
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="col-form-label">نام</label>
                    <div>
                        <input class="form-control" type="text" value="{{old('firstName')}}"
                               name="firstName">
                        <small class="text-danger">{{ $errors->first('firstName') }}</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">نام خانوادگی</label>
                    <div>
                        <input class="form-control" type="text" value="{{old('lastName')}}"
                               name="lastName">
                        <small class="text-danger">{{ $errors->first('lastName') }}</small>
                    </div>
                </div>
{{--                <div class="col-md-4 mb-3">--}}
{{--                    <label class="col-form-label">نام کاربری</label>--}}
{{--                    <div>--}}
{{--                        <input class="form-control" type="text" value="{{old('username')}}"--}}
{{--                               name="username">--}}
{{--                        <small class="text-danger">{{ $errors->first('username') }}</small>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">موبایل</label>
                    <div>
                        <input class="form-control" type="text" value="{{old('mobile')}}"
                               name="mobile">
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">ایمیل </label>
                    <div>
                        <input class="form-control" type="text" value="{{old('email')}}"
                               name="email">
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="col-form-label">کدملی </label>
                    <div>
                        <input class="form-control" type="text" value="{{old('nationalCode')}}"
                               name="nationalCode">
                        <small class="text-danger">{{ $errors->first('nationalCode') }}</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">

                    <label for="image" class="control-label ">تصویر </label>
                    <input class="form-control input-file"
                           name="image"
                           type="file" data-classbutton="btn btn-secondary"
                           data-classinput="form-control inline"
                           data-icon="&lt;span class='fa fa-upload mr-2'&gt;&lt;/span&gt;">
                    <small class="text-danger">{{ $errors->first('image') }}</small>
                </div>
                <div class="col-md-8 mb-3">

                    <div class="form-group">
                        <label for="image" class="control-label ">نقش ها </label>

                        <select class="form-control select2" multiple="multiple" name="roles[]"
                                data-placeholder="لطفا نقش های کاربر را وارد نمایید"
                                style="width: 100%;text-align: right">
                            @foreach($roles as $role)
                                @can('ACL-create-role')
                                    <option
                                        value="{{$role->id}}" {{in_array($role->id, old("roles") ?: []) ? "selected": ""}}>{{$role->title}}</option>
                                @endcan
                                @cannot('ACL-create-role')
                                       @if($role->slug=='Teacher' ||  $role->slug=='Student' )
                                        <option value="{{$role->id}}" {{in_array($role->id, old("roles") ?: []) ? "selected": ""}}>{{$role->title}}</option>
                                        @endif
                                @endcannot

                            @endforeach

                        </select>
                        <small class="text-danger">{{ $errors->first('roles') }}</small>

                    </div>
                </div>
                <div class="col-md-4 mb-3">

                    <label for="image" class="control-label ">رمزعبور </label>
                    <div>
                        <input class="form-control" type="password" value="{{old('password')}}"
                               name="password" id="passwordinput">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-eye" onclick="password()"></i></span>
                        </div>
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3">

                    <label for="image" class="control-label ">تکرار رمز عبور </label>
                    <div>
                        <input class="form-control" type="password" value="{{old('confirm')}}"
                               name="confirm" id="confirminput">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-eye" onclick="confirm()"></i></span>
                        </div>
                        <small class="text-danger">{{ $errors->first('confirm') }}</small>
                    </div>
                </div>

            </div>
        </div>
        <div class="d-flex justify-content-end align-content-end">
            <input class="btn  btn-success" type="submit" value="ثبت">


        </div>
    </form>

@endsection


@section('js')

    <script src="{{asset('/files/AdminMaster/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        $(function () {
            $('.select2').select2()
        })
    </script>

    <script>

        function password() {
            var x = document.getElementById("passwordinput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function confirm() {
            var x = document.getElementById("confirminput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

    </script>
@endsection
