@php
$d_img = carbon_get_post_meta(get_the_ID(), 'd_footer_image');
$m_img = carbon_get_post_meta(get_the_ID(), 'm_footer_image');
$alt = carbon_get_post_meta(get_the_ID(), 'alt_text');
@endphp

<footer class="content-info bg-black-400 relative overflow-hidden h-68 lg:h-20 xl:h-32">
	<!-- Mobile -->
	<img src="{!! $m_img !!}" alt="Geometric Shapes With Smiling Faces" class="absolute inset-0 object-cover w-full lg:hidden">
	<div class="absolute footer-logo lg:hidden">
		@php svg('footer-logo'); @endphp
	</div>
	<p class="absolute copyright font-sans text-white-400 lg:hidden">
		©<?php echo date('Y'); ?> Maxistentialism
	</p>
	<!-- Desktop -->
	<img src="{!! $d_img !!}" alt="Geometric Shapes With Smiling Faces" class="hidden absolute inset-0 object-cover w-full hidden lg:block">
	<div class="mt-8 absolute flex items-center justify-between w-full px-16 xl:mt-16">
		<div class="footer-logo hidden lg:block">
			@php svg('footer-logo'); @endphp
		</div>
		<p class="copyright font-sans text-white-400 hidden lg:block">
			©<?php echo date('Y'); ?> Maxistentialism
		</p>
	</div>
</footer>
