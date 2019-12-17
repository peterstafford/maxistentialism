<section class="slider-module">
	<tiny-slider :autoplay="false" :items="1" :nav="true" :slide-by="1" :controls-text="['', '']" class="full-screen-slider">
		@foreach ($slider as $slide)
			<li class="slide relative aspect-ratio aspect-ratio-8:10 z-0 md:aspect-ratio-9:5">
				<img src="{{ $slide['image'] }}" alt="" class="absolute object-cover inset-0 w-full h-full">

				<div class="z-10">
					<div class="slider-text absolute z-10 text-white-400">
						<h2>
							{!! $slide['title'] !!}
						</h2>
						<div>
							@if (!empty($slide['podcast']))
								@php
									// $feed =  new SimpleXmlElement(file_get_contents($slide['podcast']), null, true);
									// $podcast = $feed['channel']->item;
								@endphp

								{{-- <p>Listen to this week's podcast: <a class="underline text-white-400" href="{{ $podcast->link }}" target="_blank">{{ $podcast->title }}</a></p> --}}
							@endif

							{!! wpautop($slide['body']) !!}
						</div>
					</div>
				</div>
			</li>
		@endforeach
	</tiny-slider>
</section>