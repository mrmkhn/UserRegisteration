@extends('adminmaster::master')
@section('title') {{$user->firstName}} {{$user->lastName}}@endsection
@section('header') {{$user->firstName}} {{$user->lastName}}@endsection

@section('tools')
    <a type="button" class="btn btn-tool btn-sm" href="{{route('user.index')}}"><i
            class="fa fa-arrow-circle-left fa-2x color-secondary color-secondary"></i></a>
@endsection
@section('css')

@endsection

@section('content')
    <div class="row d-flex align-content-end justify-content-end">
        <a class="btn btn-info " href="{{route('user.edit',$user->id)}}"><i class="fa fa-edit"></i></a>
    </div>
    <div class="row">
        <div class="col-md-12">
            <span class="text-success border-lable"><b>اطلاعات عمومی</b></span>
            <div style="border: dashed gray 1px;border-radius: 10px" class="px-5 pt-3">

                <div class="row">
                    <div class="col-md-3 mb-3 ">
                        <div class="d-flex justify-content-center align-content-center">

                            @if($user->image_id != null)
                                <div >
                                    <img src="{{custom_asset($user->image->link) }}" id="image"
                                         style="border-radius: 50%;height: 100px;width: 100px">
                                </div>
                            @else
                                <div >
                                    <img src="{{custom_asset($default_image_profile) }}" id="image"
                                         style="border-radius: 50%;height: 100px;width: 100px">
                                </div>
                            @endif
                        </div>
                        <h5 class="text-dark-blue text-center my-3">
                            <b>{{$user->prefix}} {{$user->firstName}} {{$user->lastName}}</b></h5>
                        <h5 class="text-light-gray text-center my-3"><b>{{$user->english_name}}</b>
                        </h5>

                    </div>
                    <div class="col-md-4 mb-5 mt-5 "
                         style="border-right: 2px solid #ff8800 ;height: 90px">
                        <p><b><span class="text-dark-blue mb-4">نام برند/فروشگاه</span> :
                                {{$user->company_name}}</b></p>
                        <p><b><span class="text-dark-blue mb-4">حوزه فعالیت </span> :
                                @foreach($user_activities as $key=>$activity)
                                    {{$key==0?$activity->title:",".$activity->title}}
                                @endforeach
                            </b></p>
                        <p><b><span class="text-dark-blue mb-4">محل فعالیت</span> :
                                @if(!is_null($user->city_id))
                                    {{$user->city->state->name}} ,{{$user->city->title}}
                                @endif
                            </b></p>

                    </div>
                    <div class="col-md-5  ">
                        <div class="card my-3 p-4"
                             style="min-height: 160px;border-radius: 10px ;border: 1px solid gray">
                            <p>
                                {{$user->company_description}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 mb-3 ">
            <h6 class="text-success text-center my-3"><b>اطلاعات عمومی</b></h6>

            <div class="d-flex justify-content-center align-content-center">

                @if($user->company_logo != null)
                    <div id="file{{$user->company_logo}}">
                        <img src="{{custom_asset($user->logo->link) }}" id="image"
                             style="border-radius: 50%;height: 140px;width: 140px">
                    </div>
                @else
                    <div >
                        <img src="{{custom_asset($default_image_profile) }}" id="image"
                             style="border-radius: 50%;height: 100px;width: 100px">
                    </div>
                @endif
            </div>
            <h4 class=" text-center my-3"><b>  {{$user->company_name}}</b></h4>

        </div>

        <div class="col-md-8  ">
            <h6 class="text-danger text-right my-3"><b>اطلاعات محرمانه</b></h6>

            <div class="card my-3 p-4"
                 style="height: 160px;border-radius: 10px ;border: 1px dashed lightgrey">

                <p>
                    {{$user->secret_description}}
                </p>
            </div>
        </div>
    </div>
    <div class="row mt-3">

        <div class="col-xl-4  ">
            <h6 class="text-danger text-right my-3"><b>اطلاعات محرمانه</b></h6>

            <div class="card my-3 py-2 px-4"
                 style="border-radius: 10px ;border: 1px dashed lightgrey">

                <div class="row p-4 " style="border-bottom:dashed 2px lightgrey ">
                    <div class="col-12 text-center mb-2 text-light-gray">
                        شماره موبایل
                    </div>
                    <div class="col-12 text-center">
                        <h5><b> {{$user->mobile}}</b></h5>

                    </div>
                </div>
                <div class="row p-4 ">
                    <div class="col-12 text-center mb-2 text-light-gray">
                        شماره تلفن ثابت
                    </div>
                    <div class="col-12 text-center">
                        <h5><b> {{$user->phone}}</b></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4  ">
            <h6 class="text-danger text-right my-3"><b>اطلاعات محرمانه</b></h6>

            <div class="card my-3 py-2 px-4"
                 style="border-radius: 10px ;border: 1px dashed lightgrey">

                <div class="row p-4" style="border-bottom:dashed 2px lightgrey ">
                    <div class="col-12 text-center text-light-gray mb-2">
                        کدملی
                    </div>
                    <div class="col-12 text-center">
                        <h5><b> {{$user->nationalCode}}</b></h5>

                    </div>
                </div>
                <div class="row p-4 ">
                    <div class="col-12 text-center text-light-gray mb-2">
                        ایمیل
                    </div>
                    <div class="col-12 text-center">
                        <h5><b> {{$user->email}}</b></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4  ">
            <h6 class="text-danger text-right my-3"><b>اطلاعات محرمانه</b></h6>

            <div class="card my-3 py-2 px-4"
                 style="border-radius: 10px ;border: 1px dashed lightgrey">

                <div class="row p-4" style="border-bottom:dashed 2px lightgrey ">
                    <div class="col-12 text-center text-light-gray mb-2">
                        تاریخ تولد
                    </div>
                    <div class="col-12 text-center">
                        <h5><b> {{$user->bornDate}}</b></h5>

                    </div>
                </div>
                <div class="row p-4 ">
                    <div class="col-12 text-center text-light-gray mb-2">
                        مدرک تحصیلی
                    </div>
                    <div class="col-12 text-center">
                        <h5><b> {{$user->degree_of_education}}</b></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">

        <div class="col-md-12  ">
            <h6 class="text-danger text-right my-3"><b>اطلاعات محرمانه</b></h6>

            <div class="card my-3 py-2 px-4"
                 style="min-height:100px;border-radius: 10px ;border: 1px dashed lightgrey">
                <h6 class="text-light-gray">آدرس</h6>
                <p>{{$user->address}}</p>
            </div>
        </div>


    </div>

@endsection


@section('js')


@endsection
