@extends('admin.layouts.master')
@section('title', 'Event Name : '.$event->title)

@push('style')

@endpush

@section('breadcrumb-title')
    {{-- <h1>Church: {{ $church->church_name }}</h1> --}}
    @if($login == 'ADM')        
        <a href="{{ route('admin.churches.show', [ $church->id, 'church_user_id' => $church_user_id, 'login' => $login, 'page' => $page]) }}" tooltip="Blogs List" class="badge badge-primary"><i class="fa fa-arrow-left"></i></a>    
    @else
        <a href="{{ route('events.index', ['church_user_id' => $church_user_id, 'login' => $login, 'page' => $page]) }}" tooltip="Blogs List" class="badge badge-primary"><i class="fa fa-arrow-left"></i></a>
    @endif
    <span>{{ __('Back')}}</span>
@stop

@section('breadcrumb-items')
    @if($login == 'ADM')
        <li class="breadcrumb-item" aria-current="page">{{ __('Church Name: ')}}<a href="{{ route('admin.churches.show', [ $church->id, 'church_user_id' => $church_user_id, 'login' => $login, 'page' => $page]) }}">{{ $church->church_name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('Add Event')}}</li>
    @else
        <li class="breadcrumb-item" aria-current="page">{{ __('Church Name: ')}}<a href="{{ route('church.show', ['church_user_id' => $church_user_id, 'login' => $login, 'page' => $page]) }}">{{ $church->church_name }}</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('events.index') }}">{{ __('Events')}}</a></li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">{{ $event->title }}</li>
@stop

@section('content')
    @include('church.components.breadcrumb')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Event Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                            <table>
                                <tbody>
                                    <tr>
                                        <th style="width: 15%;">{{ __('Event Name')}}</th>
                                        <td>: {{$event->title}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Schedule')}}</th>
                                        <td>: {{$event->schedule}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Description')}}</th>
                                        <td>: {{$event->description}}</td>
                                    </tr>
                                    <tr>
                                        <th><a href="{{ route('events.edit', [$event->id, 'church_user_id' => $church_user_id, 'login' => $login, 'page' => $page]) }}" class="btn btn-primary">Edit <i class="fa fa-edit"></i></a></th>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
</script>
@endpush