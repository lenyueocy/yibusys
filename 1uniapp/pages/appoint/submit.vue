<template>
    <view >
        <view class="bg-white" style="border-radius: 30rpx 30rpx 0rpx 0rpx;">
            <tui-list-cell padding="30rpx 30rpx 30rpx 30rpx" :lineLeft="false" :hover="false" @click="detail" >
                <view class="tui-item-box">
                    <view class="tui-msg-box">
                        <image :src="doctorData.avatar" class="tui-msg-pic" mode="widthFix" style="border-radius: 50%;"></image>
                        <view class="tui-msg-item">
                            <view class="tui-msg-name">{{doctorData.name}}</view>
                            <view class="tui-msg-content margin-top-sm text-sm " :class="doctorData.price>0?'':''" >预约付费：{{doctorData.price>0?doctorData.price+'元':'免费'}}</view>
                        </view>
                    </view>
                    <view class="tui-msg-right text-gery">
                        <text>可预约</text>
                    </view>
                </view>
            </tui-list-cell>
        </view>

        <tui-list-view title="预约时间（7:00-24:00）" style="padding: 100rpx 0rpx;" v-if="appointList"><!--background-color: #F2F2F2;-->
            <view  class="padding-left-sm" @click="appointCheck=false">
                <view class="grid margin-bottom text-center col-4 padding-tb-lg text-center">
                    <view class="padding-right-sm margin-top-sm" v-for="(item,index) in appointList">
                        <view class="padding-tb-sm text-sm yuyue-block" :class="[item.time_slot==appointCheck.time_slot?'tui-danger':(curTime<item.starttime?'bg-white':'bg-dc')]" @click.stop="appoint(item)">
                            <view style="white-space: nowrap;">{{item.time_slot}}</view>
                            <view class="padding-top-xs">
                                <text v-if="curTime<item.starttime">可预约</text>
                                <text v-else>已过时</text>
                            </view>
                        </view>
                    </view>

                </view>
            </view>

            <view @click="appointCheck=false" class="padding-lr-sm text-lg " style="border-top: solid 2rpx #e2e2e2;color: #666666;">
                <view class="margin-top-xl text-center">预约说明：</view>
                <view class="margin-top-sm text-sml">预约说明预约说明预约说明预约说明预约说明预约说明预约说明预约说明预约说明。</view>
            </view>

        </tui-list-view>

        <button v-if="appointCheck" class="cu-btn lg text-white tui-danger" style="position:fixed;bottom:2%;width:92%;margin-left:4%;" @click="submit">确定预约({{appointCheck.time_slot}})</button>
        <button v-else class="cu-btn lg text-white" style="position:fixed;bottom:2%;width:92%;margin-left:4%;background-color: #d2d2d2;" >确定预约</button>



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
                doctorData:[],
                dateList:[],
                appointList:[],
                appointCheck:false,
                curTime:false,
            }
        },
        onLoad(){
            this.getList()
        },
        methods: {
            getList: function () {
                this.$http.get('doctor.get_detail',{id:this.$Route.query.doctorid}).then((res) => {
                    this.doctorData = res.list
                })
                this.$http.get('appoint.get_date',{id:this.$Route.query.doctorid}).then((res) => {
                    this.appointList = res.list
                })
                this.curTime = parseInt(new Date().getTime()/1000);
            },
            appoint:function (item) {
                if(this.curTime>item.starttime) return false;
                this.curTime = parseInt(new Date().getTime()/1000);
                this.appointCheck = item
            },
            submit:function () {
                this.$http.get('appoint.submit',{doctorid:this.$Route.query.doctorid,time_slot:this.appointCheck.time_slot}).then((res) => {
                    this.$Router.push({name:'order_pay_index',params:{orderid:res.orderid,type:'appoint'}})
                }).catch((err)=>{
                    this.getList()
                    this.curTime = parseInt(new Date().getTime()/1000);
                })
            }
        },

    }
</script>

<style >
    page{
        background-color: #f1f1f1;
    }
    .bg-dc{
        color: #999999;
        background-color: #dcdcdc;
    }
    >>>.tui-list-title{
        color: #666;
        font-size: 28rpx;
        padding: 0rpx 30rpx;
    }
    .yuyue-block{
        border-radius: 10rpx;
    }
    .appoint-week{
        max-width:100%;
        width: 60rpx;
        height: 60rpx;
        border-radius: 50%;
        color: #999;
        background-color: #f2f2f2;
    }
    .appoint-week-cur{
        color: #fff;
        background-color: #0060ff;
    }
    .appoint-date{
        color: #999999;
    }
    .appoint-date-cur{
        color: #121212;
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

</style>

