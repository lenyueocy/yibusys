<template>
	<view class="container">
		<tui-picture-cropper :lockRatio="true" :imageUrl="imageUrl" @ready="ready" @cropper="cropper" :isBase64="false"></tui-picture-cropper>
	</view>
</template>

<script>
export default {
	data() {
		return {
			src: '',
			imageUrl: ''
		};
	},
	onLoad(options) {
		this.src = options.src || '';
		//如果从上个页面传值时可显示loading
		this.src &&
			uni.showLoading({
				title: '请稍候...',
				mask: true
			});
	},
	methods: {
		ready() {
			this.imageUrl = this.src;
		},
		cropper(e) {
            this.$utils.prePage().uploadAvatar(e)
            this.$Router.back()
		}
	}
};
</script>

<style></style>
