@extends('adminmaster::master')
@section('title')   کاربران غیرفعال@endsection
@section('header') کاربران غیرفعال@endsection

@section('tools')
    <a type="button" class="btn btn-tool btn-sm" href="{{route('user.index')}}"><i class="fa fa-arrow-left fa-2x color-secondary "></i></a>

@endsection
@section('css')

    @include('adminmaster::layouts.data_table_css')
@endsection

@section('content')
    <table id="datatable" class="table table-bordered table-sm   display responsive nowrap "
           style="width: 100%">
        <thead>
        <tr>
            <th>نام و نام خانوادگی</th>
            <th>نام کاربری</th>
            <th>موبایل</th>
            <th>ایمیل</th>
            <th>نقش ها</th>
            <th>فعال سازی</th>

        </tr>
        </thead>
        <tbody>
        @foreach( $users as $key=>$user)
            <tr>

                <td>{{$user->firstName}}  {{$user->lastName}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->mobile}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge badge-info"> {{$role->title}}</span>
                    @endforeach
                </td>

                <td>

                        <a href="{{route('user_activation',$user->id)}}"><i
                                class="fa fa-check-square text-success m-2"></i></a>

                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

@endsection

@section('js')

    @include('adminmaster::layouts.data_table')
@endsection
