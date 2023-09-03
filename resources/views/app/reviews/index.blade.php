@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 d-flex justify-content-between mt-3">
				<div class="heading-title">
					<h1>{{ $data['title'] }}</h1>
				</div>
				<div class="text-right"></div>
			</div>
		</div>
		<div class="card">
			<div class="card-body card-content">
				<div class="row">
					<div class="col-12">
						@if($data['reviews']->isEmpty())
							<div>
								<p>Нет отзывов</p>
							</div>
						@else
							@if(session()->has('message'))
								<div class="alert alert-success">
									<b>{{ session()->get('message') }}</b>
								</div>
							@endif
							<table class="main-table table table-hover">
								<thead>
									<tr>
										<td>Оценка</td>
										<td>Сообщение</td>
										<td class="text-right">Дата создания</td>
									</tr>
								</thead>
								<tbody>
									@foreach($data['reviews'] as $review)
										<tr>
											<td>
												@if(empty($review['rating']))
													Без оценки
												@else
													@for($i = 1; $i <= 5; $i++)
														<i class="{{ ($i <= $review['rating'] ? 'fas' : 'far') }} fa-star"></i>
													@endfor
												@endempty
											</td>
											<td>{{ $review['text'] }}</td>
											<td class="text-right">{{ $review['created_at'] }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@endempty
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-12">
						{{ $data['reviews']->links('assets.pagination') }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection