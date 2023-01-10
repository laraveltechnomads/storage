@extends('admin.layouts.master')
@section('title', 'Show Category')

@section('breadcrumb-title')
<h1>Show Category</h1>
<a href="{{ route('admin.category.index') }}" tooltip="Category List" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
<span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.category.index') }}">{{ __('Category')}}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Show')}}</li>
@stop
@section('content')
@include('admin.components.breadcrumb')

<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<table id="tech-data-table" class="tech-data-table table table-bordered table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Image</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{ $category->name }}</td>
								<td>{{ $category->description }}</td>
								<td>
									@if($category->image)
										<img src="{{ category_file_show($category->image) }}" width="70">
									@else
										<img src="{{ asset('No-Image.png') }}" width="100">
									@endif
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection