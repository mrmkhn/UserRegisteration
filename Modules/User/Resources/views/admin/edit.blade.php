@extends('adminmaster::master')
@section('title') ویرایش {{$user->firstName}} {{$user->lastName}}@endsection
@section('header') ویرایش {{$user->firstName}} {{$user->lastName}}@endsection
@section('tools')
    <a type="button" class="btn btn-tool btn-sm" href="{{route('user.index')}}"><i
            class="fa fa-arrow-circle-left fa-2x color-secondary color-secondary"></i></a>
@endsection
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/files/AdminMaster/plugins/select2/select2.min.css')}}">
@endsection

@section('content')

    <form class="form-horizontal" action="{{ route('user.update',$user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')


        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="col-form-label">پیشوند</label>


                <div>
                    <input class="form-control" type="text" value="{{$user->prefix}}"
                           name="prefix" placeholder="دکتر ، سرکارخانم ، جناب آقای و...">
                    <small class="text-danger">{{ $errors->first('prefix') }}</small>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="col-form-label">نام</label>


                <div>
                    <input class="form-control" type="text" value="{{$user->firstName}}"
                           name="firstName">
                    <small class="text-danger">{{ $errors->first('firstName') }}</small>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="col-form-label">نام خانوادگی</label>


                <div>
                    <input class="form-control" type="text" value="{{$user->lastName}}"
                           name="lastName">
                    <small class="text-danger">{{ $errors->first('lastName') }}</small>
                </div>
            </div>
            {{--                                        <div class="col-sm-4 mb-3">--}}
            {{--                                            <label class="col-form-label">نام کاربری</label>--}}
            {{--                                            <div>--}}
            {{--                                                <input class="form-control" type="text" value="{{$user->username}}"--}}
            {{--                                                       name="username">--}}
            {{--                                                <small class="text-danger">{{ $errors->first('username') }}</small>--}}
            {{--                                            </div>--}}
            {{--                                        </div>--}}
            <div class="col-sm-4 mb-3">
                <label class="col-form-label">نام انگلیسی </label>


                <div>
                    <input class="form-control" type="text" value="{{$user->english_name}}"
                           name="english_name">
                    <small class="text-danger">{{ $errors->first('english_name') }}</small>
                </div>
            </div>

            <div class="col-sm-4 mb-3">
                <label class="col-form-label">موبایل</label>


                <div>
                    <input class="form-control" type="text" value="{{$user->mobile}}"
                           name="mobile">
                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="col-form-label">شماره تلفن ثابت</label>


                <div>
                    <input class="form-control" type="text" value="{{$user->phone}}"
                           name="phone">
                    <small class="text-danger">{{ $errors->first('phone') }}</small>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label for="image" class="control-label ">نقش ها </label>
                    <select class="form-control select2" multiple="multiple" name="roles[]"
                            data-placeholder="لطفا نقش های کاربر را وارد نمایید"
                            style="width: 100%;text-align: right">
                        @foreach($roles as $role)
                            <option
                                value="{{$role->id}}" {{in_array($role->id, $this_roles ?: []) ? "selected": ""}}>{{$role->title}}</option>
                        @endforeach

                    </select>
                    <small class="text-danger">{{ $errors->first('roles') }}</small>

                </div>
            </div>
            <div class="col-md-4 mb-3">

                <label for="image" class="control-label mb-3">عکس پروفایل </label>


                <input class="form-control input-file"
                       name="image"
                       type="file" data-classbutton="btn btn-secondary"
                       data-classinput="form-control inline"
                       data-icon="&lt;span class='fa fa-upload mr-2'&gt;&lt;/span&gt;">
                <small class="text-danger">{{ $errors->first('image') }}</small>
            </div>
            <div class="col-sm-2 mb-3">
                @if($user->image_id != null)
                    <div id="file{{$user->image_id}}">
                        <img src="{{custom_asset($user->image->link) }}" id="image"
                             style="border-radius: 50%;height: 100px;width: 100px">
                        <i class="fa fa-trash nav-icon "
                           onclick="deleteFile({{$user->image_id}},{{$user->id}},'image_id','User','User')"></i>
                    </div>

                @endif
            </div>
            <div class="col-sm-2 mb-3">
            </div>
            <div class="col-sm-4 mb-3">
                <label class="col-form-label">مدرک تحصیلی </label>


                <div>
                    <input class="form-control" type="text"
                           value="{{$user->degree_of_education}}"
                           name="degree_of_education">
                    <small
                        class="text-danger">{{ $errors->first('degree_of_education') }}</small>
                </div>
            </div>


        </div>
        <div class="row mt-4 ">

            <div class="col-md-4">
                <div class="row">
                    <label class="col-form-label">تاریخ تولد </label>
                </div>
                <div class="row">

                <div class="col-4">
                        <select class="form-control form-control-sm" name="day">
                            <option value="" disabled>روز</option>

                            @for($i=1 ;$i<32 ;$i++)
                                <option
                                    value="{{$i}}" {{substr($user->bornDate,8,9)==$i?"selected":""}} >{{$i}}</option>
                            @endfor
                        </select>

                    </div>
                    <div class="col-4">
                        <select  class="form-control form-control-sm" name="month">
                            <option value="" disabled>ماه</option>

                            <option
                                value="1" {{substr($user->bornDate,5,6)==1?"selected":""}}>
                                فروردین
                            </option>
                            <option
                                value="2" {{substr($user->bornDate,5,6)==2?"selected":""}}>
                                اردیبهشت
                            </option>
                            <option
                                value="3" {{substr($user->bornDate,5,6)==3?"selected":""}}>
                                خرداد
                            </option>
                            <option
                                value="4" {{substr($user->bornDate,5,6)==4?"selected":""}}>
                                تیر
                            </option>
                            <option
                                value="5" {{substr($user->bornDate,5,6)==5?"selected":""}}>
                                مرداد
                            </option>
                            <option
                                value="6" {{substr($user->bornDate,5,6)==6?"selected":""}}>
                                شهریور
                            </option>
                            <option
                                value="7" {{substr($user->bornDate,5,6)==7?"selected":""}}>
                                مهر
                            </option>
                            <option
                                value="8" {{substr($user->bornDate,5,6)==8?"selected":""}}>
                                آبان
                            </option>
                            <option
                                value="9" {{substr($user->bornDate,5,6)==9?"selected":""}}>
                                آذر
                            </option>
                            <option
                                value="10" {{substr($user->bornDate,5,6)==10?"selected":""}}>
                                دی
                            </option>
                            <option
                                value="11" {{substr($user->bornDate,5,6)==11?"selected":""}}>
                                بهمن
                            </option>
                            <option
                                value="12" {{substr($user->bornDate,5,6)==12?"selected":""}}>
                                اسفند
                            </option>
                        </select>

                    </div>
                    <div class="col-4">
                        <select  class="form-control form-control-sm" name="year">
                            <option value="" disabled>سال</option>

                            @for($i=1330 ;$i<1381 ;$i++)
                                <option
                                    value="{{$i}}" {{substr($user->bornDate,0,4)==$i?"selected":""}} >{{$i}}</option>
                            @endfor
                        </select>

                    </div>
                </div>

            </div>
            <div class="col-md-4 mb-3">
                <label class="col-form-label">ایمیل </label>


                <div>
                    <input class="form-control" type="text" value="{{$user->email}}"
                           name="email">
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                </div>
            </div>
            <div class="col-md-4 mb-3" >
                <label class="col-form-label">کدملی </label>
                <i class="triangle-up text-danger " ></i>

                <div>
                    <input class="form-control" type="text"
                           value="{{$user->nationalCode}}"
                           name="nationalCode">
                    <small
                        class="text-danger">{{ $errors->first('nationalCode') }}</small>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-sm-4 mb-3">
                <label class="col-form-label">نام شرکت/فروشگاه/برند</label>


                <div>
                    <input class="form-control" type="text" value="{{$user->company_name}}"
                           name="company_name">
                    <small class="text-danger">{{ $errors->first('company_name') }}</small>
                </div>
            </div>


            <div class="col-md-4 mb-3">

                <label for="image" class="control-label mb-3">لوگو/آرم </label>


                <input class="form-control input-file"
                       name="company_logo"
                       type="file" data-classbutton="btn btn-secondary"
                       data-classinput="form-control inline"
                       data-icon="&lt;span class='fa fa-upload mr-2'&gt;&lt;/span&gt;">
                <small class="text-danger">{{ $errors->first('company_logo') }}</small>
            </div>

            <div class="col-sm-2 mb-3">
                @if($user->company_logo != null)
                    <div id="file{{$user->company_logo}}">
                        <img src="{{custom_asset($user->logo->link) }}" id="image"
                             width="80" height="80">
                        <i class="fa fa-trash nav-icon "
                           onclick="deleteFile({{$user->company_logo}},{{$user->id}},'company_logo','User','User')"></i>
                    </div>
                @endif
            </div>

            <div class="col-sm-2 mb-3">
            </div>
            <div class="col-md-4 mb-3">
                <label class="col-form-label">حوزه فعالیت </label>


                <div>
                    <select class="form-control select2" multiple="multiple" dir="rtl"
                            style="width: 100%;text-align: right" name="activities[]">
                        @foreach($activities as $activity)
                            <option
                                {{in_array($activity->id, explode(',',$user->activity_id) ?: []) ? "selected": ""}} value="{{$activity->id}}">{{$activity->title}}</option>
                        @endforeach
                    </select>
                    <small
                        class="text-danger">{{ $errors->first('activities') }}</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label class="col-form-label">استان محل فعالیت </label>


                <div>
                    <select class="form-control select2" dir="rtl"
                            style="width: 100%;text-align: right" name="state">
                        <option value="" disabled></option>

                        @foreach($states as $state)
                            <option value="{{$state->id}}"
                                    class="text-right" {{$city?($city->state->id==$state->id?"selected":" "):""}}>{{$state->name}}</option>
                        @endforeach
                    </select>
                    <small
                        class="text-danger">{{ $errors->first('state') }}</small>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label class="col-form-label">شهر محل فعالیت </label>


                <div>
                    <select class="form-control select2 text-right" dir="rtl"
                            style="width: 100%;text-align: right" name="city_id">

                        @if($city)
                            <option value="{{$city->id}}" selected>{{$city->title}}</option>
                        @else
                            <option value="" disabled></option>

                            <option value="" disabled>ابتدا استان را انتخاب نمایید</option>
                        @endif
                    </select>
                    <small
                        class="text-danger">{{ $errors->first('city_id') }}</small>
                </div>
            </div>
            <div class="col-sm-12 mb-3">
                <label class="col-form-label">آدرس دقیق پستی </label>


                <div>
                                                <textarea name="address" id="" rows="6"
                                                          class="form-control form-control-sm w-100 input-border-radius">{{$user->address}}</textarea>
                    <small
                        class="text-danger">{{ $errors->first('address') }}</small>
                </div>
            </div>

            <div class="col-sm-5 mb-3">
                <label class="col-form-label">معرفی کسب و کار </label>


                <div>
                                                <textarea name="company_description" id="" rows="6"
                                                          class="form-control form-control-sm w-100 input-border-radius">{{$user->company_description}}</textarea>
                    <small
                        class="text-danger">{{ $errors->first('company_description') }}</small>
                </div>

            </div>
            <div class="col-sm-7 mb-3">
                <label class="col-form-label">معرفی خود و کسب و کار به اساتید
                    دوره </label>


                <div>
                                                <textarea name="secret_description" id="" rows="6"
                                                          class="form-control form-control-sm w-100 input-border-radius">{{$user->secret_description}}</textarea>
                    <small
                        class="text-danger">{{ $errors->first('secret_description') }}</small>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="oldpassword">
                    <label class="form-check-label" for="defaultCheck1">
                        همان رمز عبور قبلی بدون تغییر باقی بماند
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-3">
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
            <div class="col-md-6 mb-3">
                <label for="image" class="control-label ">تکرار رمز عبور </label>
                <div>
                    <input class="form-control" type="password" value="{{old('confirm')}}" name="confirm" id="confirminput">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-eye" onclick="confirm()"></i></span>
                    </div>
                    <small class="text-danger">{{ $errors->first('confirm') }}</small>
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

    @include('adminmaster::layouts.password')
    @include('generalmaster::layouts.state-city')

@endsection
