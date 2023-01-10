@extends('admin.layouts.master')
@section('title', 'Edit Event')

@push('style')
<link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/daterangepicker/daterangepicker.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- dropzonejs -->
<link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/dropzone/min/dropzone.min.css">
@endpush

@section('breadcrumb-title')
    <h1>Edit Event</h1>
    <a href="{{ url()->previous() }}" tooltip="events List" class="badge badge-primary"><i class="fa fa-arrow-left"></i></a>
    <span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
  @if($login == 'ADM')
      <li class="breadcrumb-item" aria-current="page">{{ __('Church Name: ')}}<a href="{{ route('admin.churches.index') }}">{{ $church->church_name }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('Add Event')}}</li>
  @else
      <li class="breadcrumb-item" aria-current="page">{{ __('Church Name: ')}}<a href="{{ route('church.show') }}">{{ $church->church_name }}</a></li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{ route('events.index') }}">{{ __('Events')}}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ __('Add')}}</li>
  @endif
@stop
@section('content')
    @include('church.components.breadcrumb')
   
      <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
          <!-- right column -->
          <div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Event Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <form class="forms-sample" id="blogForm" action="{{ route('events.update', [$event->id, 'church_user_id' => $church_user_id, 'login' => $login, 'page' => $page]) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="user_id" value="{{$user_id}}">
                  <input type="hidden" name="church_user_id" value="{{$church_user_id}}">
                  <input type="hidden" name="login" value="{{$login}}">
                  <input type="hidden" name="page" value="{{$page}}">
                  <div class="row">
                    <div class="col-sm-12">
                      <!-- textarea -->
                      <div class="form-group">
                        <label for="title">{{ __('Name')}}</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{old('title', $event->title)}}" required="" autocomplete="off">
                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                          @php
                            $schedule_date =  date('m/d/Y g:i a', strtotime($event->schedule) );
                          @endphp
                          <label>{{ __('Schedule')}}</label>
                          <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input @error('schedule') is-invalid @enderror" id="schedule" name="schedule" placeholder="Schedule" value="{{old('schedule', $schedule_date)}}" required="" autocomplete="off" data-target="#reservationdatetime" />
                              <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                          @error('schedule')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="description">{{ __('Description')}}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" required="" autocomplete="off">{{old('description', $event->description)}}</textarea>
                        @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary mr-2">{{ __('Save')}}</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
           </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
@endsection
@push('script')
<script src="{{asset('/')}}assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="{{asset('/')}}assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('/')}}assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="{{asset('/')}}assets/admin/plugins/moment/moment.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="{{asset('/')}}assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="{{asset('/')}}assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('/')}}assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('/')}}assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="{{asset('/')}}assets/admin/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="{{asset('/')}}assets/admin/plugins/dropzone/min/dropzone.min.js"></script>

<script>
  //Date and time picker
  $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
</script>
@endpush
