<div class="container-fluid pb-3 pt-3 why-choose-section">
		<div class="section1 text-center pb-4">
			<div class="wave d-flex justify-content-center align-items-center">
				<h4 class="section-header">WHY CHOOSE US</h4>
			</div>
			
		</div>
		<div class="choose-section-row container">
			@foreach($choose as $choose)
			<div class="text-center mb-3 bg-white">
				<div class="section-ico-img mb-4">
					<img src="{{  asset('Choose/'.$choose->icon) }}" alt="{{ $choose->title }}" width="70" height="70">
				</div>
				
				<div class="text1">
					<h4 class="section-heading text-capitalize">{{ $choose->title }}</h4>
					<p class="section-subheading mt-3">
						{{$choose->description}}
					</p>
				</div>
			</div>
			@endforeach
			
		</div>
	</div>