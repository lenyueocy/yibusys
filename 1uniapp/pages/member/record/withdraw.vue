<template>
	<view class="bg-white" >
		<mescroll-body class="" ref="mescrollRef" @init="mescrollInit" @down="downCallback" @up="upCallback" >
			<view v-if="listData.length>0">
				<tui-list-cell :hover="false" :lineLeft="false"  v-for="(item,index) in listData">
					<view class="flex align-center justify-between">
						<view style="width: 15%;">
							<image :src="'http://appstore.bai918.com/static/app/images/index_fudai.png'" class="" style="width: 80rpx;height: 80rpx;"></image>
						</view>
						<view class="" style="width: 62%;">
							<view class="" style="font-size: 26rpx;">提现到{{item.typestr}}</view>
							<view class="text-sm text-grey" v-if="item.deductionmoney>0">扣除手续费{{item.deductionmoney}}元</view>
							<view class="text-sm text-grey">{{item.createtime}}</view>
						</view>
						<view class="margin-left-sm" style="flex: 1;">
							<view class="text-bold">{{item.money}}</view>
							<view class="text-sm text-green" v-if="item.status==0">审核中</view>
							<view class="text-sm " :class="[item.status>0?'text-green':'text-red']" v-else>{{item.status==1?'提现成功':'提现失败'}}</view>
						</view>
					</view>
				</tui-list-cell>
			</view>
			<view class="margin-tb-xl" style="" v-else>
				<tui-no-data :fixed="false" imgUrl="http://appstore.bai918.com/static/app/icon/toast/img_noorder_3x.png"  btnText="返回钱包" @click="$Router.back()">
					<text class="tui-color__black">您没有提现记录~</text>
				</tui-no-data>
			</view>
		</mescroll-body>
	</view>
</template>

<script>
    import MescrollMixin from "@/components/mescroll-uni/mescroll-mixins.js";
    export default{
        mixins: [MescrollMixin],
        data(){
            return {
                listData: [],
                listTotal: 0,
            }
        },
        methods:{
            getList:function () {
                let params = {page:this.mescroll.num,pagesize:this.mescroll.size,type:1}
                this.$http.get('member.log.get_list',params).then((res)=>{
                    this.mescroll.endBySize(this.mescroll.size, res.total);
                    if(this.mescroll.num == 1) this.listData = [];
                    if(res.list) this.listData = this.listData.concat(res.list)
                    this.listTotal = res.total
                })
            },
            downCallback:function () {
                this.mescroll.resetUpScroll()
                this.getList()
            },
            upCallback() {
                this.getList()
            },
        }
    }
</script>

<style lang="scss">
	.radius{
		border-radius: 22rpx;
	}
	.bg-image{
		min-height: 100vh;
		background: url("http://appstore.bai918.com/static/app/images/member_integral_bg.png");
		background-size:100% 100%;
		background-repeat:no-repeat;
	}
</style>
