@extends('admin.layouts.master')
@section('title', 'All Events')

@push('style')

@endpush

@section('breadcrumb-title')
    <h1>Calender</h1>
@stop

@section('breadcrumb-items')
    <li class="breadcrumb-item" aria-current="page">{{ __('Events')}}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Index')}}</li>
@stop

@section('content')
    @include('admin.components.breadcrumb')
    
    <div class="container-fluid">
        {{--  <h3 class="page-title">{{ trans('Event Calender') }}</h3>  --}}
            <div class="card">
                <div class="card-header">
                    {{ trans('All Events') }}
                </div>

                <div class="card-body">
                   {{--  <form action="{{ route('/') }}" method="GET">
                        Events:
                        <select name="venue_id">
                            <option value="">-- all Events --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" >{{$event->title}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </form> --}}
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
                    <div id='calendar'></div>
                </div>
            </div>
    </div>

@endsection

@push('script')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function () {
            // page is now ready, initialize the calendar...
            events={!! json_encode($events) !!};
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                events: events,
                initialView: 'listWeek',
            })
        });
</script>
@endpush