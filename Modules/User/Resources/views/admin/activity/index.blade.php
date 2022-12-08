@extends('adminmaster::master')
@section('title')حوزه های فعالیت کاربران@endsection
@section('header')حوزه های فعالیت کاربران@endsection

@section('tools')
    <a type="button" class="btn btn-tool btn-sm" href="{{route('activity.create')}}"><i class="fa fa-plus-circle fa-2x color-secondary color-success"></i></a>
@endsection
@section('css')

    @include('adminmaster::layouts.data_table_css')
@endsection

@section('content')
    <table id="datatable-with_pagination" class="table table-bordered table-sm   display responsive nowrap " style="width: 100%">
        <thead>
        <tr>
            <th>عنوان</th>


            <th>ویرایش/حذف</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $activities as $key=>$activity)
            <tr>

                <td>{{$activity->title}}</td>

                <td>
                    <div class="btn-group">

                        <a href="{{route('activity.edit',$activity->id)}}"><i class="fa fa-edit text-info m-2"></i></a>

                        <form action="{{ route('activity.destroy' ,$activity->id) }}" method="POST" id="deleteForm">
                            @method('DELETE')
                            @csrf
                                <button  class="btn-none" onclick="return confirm(' آیا از حذف این فعالیت اطمینان دارید؟')"><i class="fa fa-trash text-danger m-2"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

@endsection
@section('js')

    @include('adminmaster::layouts.data_table')
@endsection
