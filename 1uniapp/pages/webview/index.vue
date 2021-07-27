<template>
    <view>
        <web-view :src="url"></web-view>
    </view>
    
</template>

<script>
    export default {
        data() {
            return {
                url: ''
            }
        },
        onLoad() {
            console.log(this.$Route.query.url)
            this.url = decodeURIComponent(this.$Route.query.url)
            var title = this.$Route.query.title
            title = title?title:'外部链接'
            uni.setNavigationBarTitle({title: title});
            /*var webView = plus.webview.create(decodeURIComponent(this.$Route.query.url), '微信支付', {additionalHttpHeaders:{Referer:this.$http.config.baseURL}});
            if(this.$Route.query.type=='type'){
                var webView = plus.webview.create(decodeURIComponent(this.$Route.query.url), '微信支付', {additionalHttpHeaders:{Referer:this.$http.config.baseURL}});
            }*/
        }
    }
</script>