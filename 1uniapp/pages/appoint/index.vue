<template>
    <view>

        <swiper :indicator-dots="true" circular :interval="5000" :duration="150" class="swiper " indicator-color="rgba(255, 255, 255, 0.8)" indicator-active-color="#fff"><!--square-dot-->
            <swiper-item v-for="swIndex in Math.floor(departmentList.length/5)">
                <view class="cu-list grid col-5 no-border" >
                    <view @click="$Router.push({name:'department_index',params:{id:item.id}})" class="cu-item" v-for="(item,index) in departmentList" v-if="Math.floor(index/10)+1 == swIndex">
                        <view><image :src="item.logo" mode="widthFix" style="width: 60%;" /></view>
                        <view><text>{{item.name}}</text></view>
                    </view>
                </view>
            </swiper-item>
        </swiper>

        <!--<view class="tui-group-name" @tap="more">
            <tui-icon name="reduce" :size="42" unit="rpx" color="#dcdcdc"></tui-icon>
            <text class="padding-lr-xs">附近门店</text>
            <tui-icon name="reduce" :size="42" unit="rpx" color="#dcdcdc"></tui-icon>
        </view>-->

        <tui-list-view title="附近门店" style="background-color: #fafafa;" v-if="storeList">
            <tui-list-cell :lineLeft="false" v-for="(item,index) in storeList" @click="$Router.push({name:'store_index',params:{id:item.id}})">
                <view class="tui-item-box">
                    <view class="tui-msg-box">
                        <image :src="item.logo" class="tui-msg-pic" mode="widthFix"></image>
                        <view class="tui-msg-item">
                            <view class="tui-msg-name">{{item.storename}}</view>
                            <view class="tui-msg-content margin-top-sm">{{item.province}}{{item.city}}{{item.area}}{{item.address}}</view>
                        </view>
                    </view>
                    <view class="tui-msg-right">
                        <view class="tui-msg-time">{{item.dast}}</view>
                        <!--<tui-badge type="danger" class="tui-badge">9</tui-badge>-->
                    </view>
                </view>
            </tui-list-cell>
        </tui-list-view>

        <tui-list-view title="附近门店" style="background-color: #fafafa;" v-else>
            <tui-no-data class="margin-top-xl" :fixed="false" imgUrl="/static/images/toast/img_nodata.png" >
                <text class="tui-color__black">暂无数据...</text>
            </tui-no-data>
        </tui-list-view>

    </view>
</template>

<script>
    import {mapMutations, mapState, mapGetters} from 'vuex';
    export default {
        computed: {
            ...mapState(['modalAction']),
            ...mapGetters(['tabbarIndex']),
        },
        components: {},
        data() {
            return {
                departmentList:[],
                storeList:[],
            }
        },
        onLoad(){
            this.getList()
        },
        methods: {
            getList: function () {
                this.$http.get('department.get_list').then((res) => {
                    this.departmentList = res.list
                })
                this.$http.get('store.selector').then((res) => {
                    this.storeList = res.list
                })
            },

        },

    }
</script>

<style >
    page{
        background-color: #fff;
    }
    .swiper{
        min-height: 400rpx;
    }
    .swiper uni-swiper-item{
        background-color: #fff;
    }

    .tui-group-name {
        width: 100%;
        font-size: 32rpx;
        font-weight: bold;
        text-align: center;
        padding: 24rpx 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .tui-item-box {
        width: 100%;
        display: flex;
        align-items: center;
    }

    .tui-list-cell_name {
        padding-left: 20rpx;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tui-ml-auto {
        margin-left: auto;
    }

    .tui-right {
        margin-left: auto;
        margin-right: 34rpx;
        font-size: 26rpx;
        color: #999;
    }

    .tui-logo {
        height: 52rpx;
        width: 52rpx;
        flex-shrink: 0;
    }

    .tui-flex {
        display: flex;
        align-items: center;
    }

    .tui-msg-box {
        display: flex;
        align-items: center;
    }

    .tui-msg-pic {
        width: 120rpx;
        height: 120rpx;
        border-radius: 10rpx;
        display: block;
        margin-right: 24rpx;
        flex-shrink: 0;
    }

    .tui-msg-item {
        max-width: 500rpx;
        min-height: 80rpx;
        /*height: 100%;*/
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .tui-msg-name {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        font-size: 32rpx;
        line-height: 1;
        color: #262b3a;
    }

    .tui-msg-content {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        font-size: 26rpx;
        margin-top: 35rpx;
        color: #9397a4;
    }

    .tui-msg-right {
        max-width: 120rpx;
        height: 88rpx;
        margin-left: auto;
        text-align: right;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-end;
    }

    .tui-right-dot {
        height: 76rpx !important;
        padding-bottom: 10rpx !important;

    }

    .tui-msg-time {
        width: 100%;
        font-size: 24rpx;
        line-height: 24rpx;
        color: #9397a4;
    }

    >>> .swiper .uni-swiper-dot {
        width: 30rpx;
        height: 6rpx;
        display: inline-flex;
        background-color: none;
        justify-content: space-between;
        margin-right: 0rpx;
    }

    >>> .swiper .uni-swiper-dot::before {
        content: '';
        flex-grow: 1;
        background-color: #E6E6E6;
        /*border-radius: 16rpx;*/
        overflow: hidden;
    }

    >>> .swiper .uni-swiper-dot-active::before {
        background-color: #00D2C3;
    }

    >>> .swiper .uni-swiper-dot.uni-swiper-dot-active {
        width: 30rpx;
    }
</style>

