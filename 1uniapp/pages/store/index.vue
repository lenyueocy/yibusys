<template>
    <view >
        <view class="margin-top-lg bg-white" style="border-radius: 30rpx 30rpx 0rpx 0rpx;padding-top: 30rpx;">
            <tui-list-cell padding="30rpx 30rpx 50rpx 30rpx" :lineLeft="false" :hover="false" @click="detail" >
                <view class="tui-item-box">
                    <view class="tui-msg-box">
                        <image :src="storeData.logo" class="tui-msg-pic" mode="widthFix"></image>
                        <view class="tui-msg-item">
                            <view class="tui-msg-name">{{storeData.storename}}</view>
                            <view class="tui-msg-content margin-top-sm">{{storeData.province}} {{storeData.city}} {{storeData.area}}</view>
                        </view>
                    </view>
                    <view class="tui-msg-right">
                        <view class="tui-msg-time">{{storeData.dast}}</view>
                        <!--<tui-badge type="danger" class="tui-badge">9</tui-badge>-->
                    </view>
                </view>
            </tui-list-cell>
            <tui-list-cell unlined @click="detail" :arrow="false" padding="20rpx 20rpx">
                <view class="tui-item-box">
                    <tui-icon name="gps" :size="16" color="#9397a4"></tui-icon>
                    <view class="tui-list-cell_name margin-left-xs text-sm">{{storeData.province}}{{storeData.city}}{{storeData.area}}{{storeData.address}}</view>
                    <view class="tui-ml-auto">
                        <!--<tui-tag padding="10rpx 12rpx" margin="0 30rpx 0 0" size="24rpx" type="light-green" shape="circle"></tui-tag>-->
                        <tui-icon name="voipphone" :size="16" color="#9397a4"></tui-icon>
                    </view>
                </view>
            </tui-list-cell>
        </view>

        <tui-list-view title="预约医生" style="background-color: #F2F2F2;" v-if="doctorList">
            <tui-list-cell :lineLeft="false" v-for="(item,index) in doctorList" @click="$Router.push({name:'store_index',params:{id:item.id}})">
                <view class="tui-item-box">
                    <view class="tui-msg-box">
                        <image :src="item.avatar" class="tui-msg-pic" mode="widthFix" style="border-radius: 50%;"></image>
                        <view class="tui-msg-item">
                            <view class="tui-msg-name">{{item.name}}</view>
                            <view class="tui-msg-content text-sm" >可预约</view>
                        </view>
                    </view>
                    <view class="tui-msg-right">
                        <button @click.stop="$Router.push({name:'appoint_submit',params:{doctorid:item.id}})" class="cu-btn tui-btn-danger sm margin-top-xs" style="white-space: nowrap;">立即预约</button>
                    </view>
                </view>
            </tui-list-cell>
        </tui-list-view>
        <tui-list-view title="预约医生" style="background-color: #F2F2F2;" v-else>
            <tui-no-data class="margin-top-xl" :fixed="false" imgUrl="/static/images/toast/img_nodata.png"  @click="getList">
                <text class="tui-color__black">暂无医生可预约...</text>
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
                doctorList:[],
                storeData:[],
            }
        },
        onLoad(){
            this.getList()
        },
        methods: {
            getList: function () {
                this.$http.get('doctor.get_list').then((res) => {
                    this.doctorList = res.list
                })
                this.$http.get('store.get_detail',{id:this.$Route.query.id}).then((res) => {
                    this.storeData = res.list
                })
            },

        },

    }
</script>

<style >
    page{
        background-color: #F2F2F2;
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
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
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

