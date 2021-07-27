<template>
    <view style="background-color: #fc1968;min-height: 100vh;">
        <!-- 轮播图 -->
        <view>
            <swiper class="screen-swiper round-dot" :indicator-dots="true" :circular="true" :autoplay="true" interval="5000" duration="500">
                <swiper-item @click="item.link?$Router.push({path:item.link}):''" v-for="(item,index) in advs" :key="index">
                    <image :src="item.thumb" mode="aspectFill" ></image>
                </swiper-item>
            </swiper>
        </view>

        <!-- 今日推荐 -->
        <view class="bg-white padding-sm margin-sm radius">
            <view class="text-bold text-black text-center text-lg" style="font-style: oblique;"><text class="text-red">今日</text><text>推荐</text></view>
            <scroll-view class="floor-list margin-top-sm" scroll-x>
                <view class="flex align-center" v-if="recommand">
                    <view @click="navTo('/pages/integralmall/detail',{id:item.id})" class="floor-item margin-left-sm" v-for="(item,index) in recommand" :key="index" style="width: 200rpx;">
                        <image :src="item.thumb" mode="aspectFill" style="width: 200rpx;height: 200rpx;z-index: 2;border-radius: 10rpx;"></image>
                        <view class="text-black text-lg" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{item.title}}</view>
                        <view class="text-lg text-center" style="width: 100%;max-width: 100%;font-size: 30rpx;">
                            <view class="flex justify-between align-center">
                                <view class="cu-capsule round">
                                    <view class="cu-tag text-white" style="background-color: #ff107f;">积分</view>
                                    <view class="cu-tag line-blue text-bold" style="background-color: #ffdeed;color: #ff1565;">{{item.credit}}</view>
                                </view>
                                <text style="text-decoration:line-through;color: #999999;">{{item.old_credit}}</text>
                            </view>
                        </view>
                    </view>
                </view>
                <view class="flex align-center justify-center text-sml" style="height: 100rpx;">
                    暂无推荐
                </view>
            </scroll-view>
        </view>

        <!-- 积分商品 -->
<!--        <view class="grid col-5 margin-lr-sm text-center text-xl text-white margin-tb-xl" :class="">
            <view @click="getGoods(item.id)" v-for="(item,index) in category" :key="index" class="flex justify-center">
                <view style="width: 100rpx;color: #ffdeed;" v-if="item.id==cateId">{{item.name}}</view>
                <view style="width: 100rpx;color: #f793b6;" v-else>{{item.name}}</view>
            </view>&lt;!&ndash; ffdeed &ndash;&gt;
        </view>-->
        <scroll-view scroll-x class="nav text-white" scroll-with-animation :scroll-left="scrollLeft">
            <view class="cu-item" :class="index==tabCur?'text-yellow cur':''" v-for="(item,index) in category" :key="index" @tap="tabSelect" :data-id="index">
                {{item.name}}
            </view>
        </scroll-view>

        <view class="bg-white radius padding-sm margin-lr-sm margin-top-sm" >
            <view v-if="goodsData">
                <view @click="navTo('/pages/integralmall/detail',{id:item.id})" class="flex margin-top-sm" v-for="(item,index) in goodsData" :key="index">
                    <view><image :src="item.thumb" mode="aspectFill" style="width: 280rpx;height: 280rpx;border-radius: 10rpx;"></image></view>
                    <view class="flex justify-between margin-left-sm text-black text-xl" style="flex-direction: column;flex: 1;">
                        <view style="overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;line-clamp: 2;overflow:hidden;-webkit-box-orient: vertical;">{{item.title}}</view>
                        <view class="flex justify-between align-end padding-bottom-sm">
                            <view style="color: #ff107f;">
                                <text style="font-size: 45rpx;">{{item.credit}}</text>
                                <text class="margin-left-sm">积分</text>
                                <text class="margin-left-sm" style="text-decoration:line-through;color: #999999;">{{item.old_credit}}</text>
                            </view>
                            <view><image src="http://appstore.bai918.com/static/app/images/integralmall_dui.png" mode="widthFix" style="width: 70rpx;height: 72rpx;display: block;"></image></view>
                        </view>
                    </view>
                </view>
            </view>
            <view class="flex align-center justify-center text-sml" style="height: 300rpx;" v-else><text>暂无商品</text></view>
        </view>
        <view style="height: 100rpx;"></view>
    </view>
</template>

<script>
    import {mapMutations,mapState,mapGetters} from 'vuex';
    export default {
        computed: {
            ...mapGetters(['tabbarIndex']),
        },
        data() {
            return {
                advs: '',
                category:'',
                recommand:'',
                goodsData:'',
                tabCur:0,
                scrollLeft: 0
            }
        },
        onLoad(){
            this.getList()
        },
        methods: {
            getList: function () {
                this.$http.get('creditshop.getlist').then((res) => {
                    this.advs = res.data.advs
                    this.category = res.data.category
                    this.recommand = res.data.recommand
                    //this.tabSelect(res.data.category[0]['id'])
                })
            },
            tabSelect:function (e) {
                this.tabCur = e.currentTarget.dataset.id;
                this.scrollLeft = (e.currentTarget.dataset.id - 1) * 60
                this.$http.get('creditshop.getGoods',{cateId:this.category[this.tabCur].id}).then((res) => {
                    this.goodsData = res.data
                })
            },
            navTo:function (url,params) {
                params = params||{}
                let tabArr = ['/pages/index/index','/pages/tabbar/integralmall','/pages/tabbar/luckybag','/pages/tabbar/cart','/pages/member/index']
                if(tabArr.indexOf(url)>=0) this.$Router.pushTab({path:url})
                else this.$Router.push({path:url,query:params})
            },
        }
    }
</script>

<style lang='scss'>
    .radius{
        border-radius: 22rpx;
    }
</style>
