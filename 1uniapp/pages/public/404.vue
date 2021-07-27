<template>
    <view class="flex align-center justify-center" style="width: 100%;height: 60vh">
        <tui-no-data :fixed="false" imgUrl="/static/images/toast/img_nodata.png"  btnText="回首页" @click="$Router.replace({path:'/'})">
            <text class="tui-color__black">没有找到你要访问的页面~</text>
        </tui-no-data>
    </view>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        onLoad(op) {

        },
        onShow(){

        },
        onHide(){

        },
        onUnload(){
        },
        mounted(){
        },
        methods: {

        }
    }
</script>

<style lang="scss">
</style>
