<template>
    <view class="text-lg margin-left-xl">
        <view class="margin-top-xl">
            <text class="cuIcon-service" style="font-size: 45rpx;"></text>
            <text class="margin-left-sm">客服QQ：xxxxxxxxx</text>
            <text @click="$utils.uniCopy('xxxxxxxxx','复制成功！请打开QQ联系客服')" class="margin-left-sm cuIcon-mark" style="font-size: 40rpx;color: #46d65e;"></text>
        </view>
        <view class="margin-top-xl">
            <text class="cuIcon-time" style="font-size: 45rpx;"></text>
            <text class="margin-left-sm">服务时间：9:30 - 19:00</text>
        </view>
    </view>
</template>

<script>

    export default {
        data() {
            return {

            }
        },
        onLoad(){
            let msg = {
                scene:'kefu',
                toUser:'all',
                type: 'text',
                nickname: '冷月',
                text: 'kefu index',
                uniacid: 1,
                time: 123
            };
            this.$socket.nsend(JSON.stringify(msg));
            //this.$socket.nsend()
        },
        methods: {

        }
    }
</script>

<style lang="scss">
    page{
        background-color: #fff;
        color: #636363;
    }
</style>
