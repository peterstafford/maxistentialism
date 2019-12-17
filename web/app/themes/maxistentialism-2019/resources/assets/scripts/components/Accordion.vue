<template class="bg-white-400">
	<div class="ul-special bg-white-400 px-6 py-16 max-w-6xl mx-auto sm:px-12 md:px-16 md:py-32 lg:px-32 ">
		<div v-for="(item, index) in items" class="li-special bg-white">
			<div @click="select(index)" class="bg-white-400 flex justify-between items-center py-5 border-t-4">
				<button class="bg-white-400 font-700 text-left">
					<h4 v-html="item.question" class="leading-normal max-w-xxs hover:text-grey-500 transition-all sm:max-w-xs md:max-w-lg">
					</h4>
				</button>
				<button class="bracket-rotate" v-bind:class="[selectedIndex === index ? 'bracket-down' : '']">
					<icon icon="right-bracket"></icon>
				</button>
			</div>
			<transition
			v-on:before-enter="beforeEnter" v-on:enter="enter"
      		v-on:before-leave="beforeLeave" v-on:leave="leave">
				<article v-show="selectedIndex === index" class="transition-all overflow-hidden max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-3xl">
					<div v-html="item.answer" class="pt-5 pb-8 wysiwyg">
					</div>
				</article>
			</transition>
		</div>
	</div>
</template>

<script>

	import Icon from 'laravel-mix-vue-svgicon/IconComponent.vue';

	export default {
		props: {
			items: {
				default: () => ([]),
			},
		},

		data: () => ({

			selectedIndex: null,
		}),

		methods: {
			select(index) {
				if (this.selectedIndex === index) {
					this.selectedIndex = null;
				} else {
					this.selectedIndex = index;
				}
			},

			beforeEnter: function(el) {
				el.style.height = '0';
				},
				enter: function(el) {
				el.style.height = el.scrollHeight + 'px';
				},
				beforeLeave: function(el) {
				el.style.height = el.scrollHeight + 'px';
				},
				leave: function(el) {
				el.style.height = '0';
				},
		},
	}
</script>
