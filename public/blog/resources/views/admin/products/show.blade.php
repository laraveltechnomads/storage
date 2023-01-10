@extends('admin.layouts.master')
@section('title', 'Show Product')

@section('breadcrumb-title')
<h1>Show Product</h1>
<a href="{{ route('admin.products.index') }}" tooltip="Category List" class="badge badge-secondary"><i class="fa fa-arrow-left"></i></a>
<span>{{ __('Back')}}</span>
@stop
@section('breadcrumb-items')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.products.index') }}">{{ __('Products')}}</a></li>
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
								<th>Category Name</th>
								<th>Product Name</th>
								<th>Product Description</th>
								<th>Product Image</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{ $product->cat_name }}</td>
								<td>{{ $product->product_name }}</td>
								<td>{{ $product->product_description }}</td>
								<td>
									@if($product->product_image)
										<img src="{{ product_file_show($product->product_image) }}" width="70">
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