@extends('adminmaster::master')
@section('title')ویرایش حوزه فعالیت@endsection
@section('header')ویرایش حوزه فعالیت  {{$activity->title}}@endsection
@section('tools')
    <a type="button" class="btn btn-tool btn-sm" href="{{route('activity.index')}}"><i
            class="fa fa-arrow-circle-left fa-2x color-secondary color-secondary"></i></a>
@endsection

@section('content')
    <form class="form-horizontal" action="{{ route('activity.update',$activity->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group ">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="col-form-label"> عنوان حوزه فعالیت *</label>
                    <div>
                        <input class="form-control" type="text" value="{{$activity->title}}"
                               name="title">
                        <small class="text-danger">{{ $errors->first('title') }}</small>
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

@endsection
