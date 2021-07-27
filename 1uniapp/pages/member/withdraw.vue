<template>
	<view>

		<view class="" style="" v-if="payType==0">
			<view class="margin-sm padding-lr-sm flex align-center text-white" style="height: 180rpx;background-color: #66ce70;border-radius: 20rpx;">
				<view class="iconfont icon-weixinzhifu" style="color: #0abb07;"></view>
				<view class="margin-left-sm">微信钱包</view>
			</view>
		</view>

		<view class="" style="" v-else-if="payType==3">
			<view v-if="selectedBankId">
				<view @click="showModal=true" v-if="selectedBankId==item.id" v-for="(item,index) in data.banklist" class="margin-sm padding-lr-sm flex align-center text-white bankcard-bgcolor" style="height: 180rpx;border-radius: 20rpx;">
					<view class="iconfont icon-yinhangqia" style="font-size: 80rpx;color: #80a833;"></view>
					<view class="padding-left-sm">
						<view class="text-bold">{{item.bank_name}}</view>
						<view class="margin-top-xs text-sm">{{item.card_no}}</view>
					</view>
				</view>
			</view>
			<view v-else>
				<view v-if="data.banklist==false" @click="$Router.push('/pages/member/wallet/bankcard')" class="bg-white margin-tb-sm flex align-center justify-center" style="height: 180rpx;" >
					<text class="cuIcon-roundadd text-lg text-grey" style="font-size: 40rpx;"></text>
					<view class="text-lg text-grey margin-left-xs">添加银行卡</view>
				</view>
				<view v-else @click="showModal=true" class="bg-white margin-tb-sm flex align-center justify-center" style="height: 180rpx;" >
					<view class="text-lg text-grey">请选择银行卡</view>
				</view>
			</view>
		</view>

		<view class="" style="" v-else>
			<view class="bg-white margin-tb-sm flex align-center justify-center" style="height: 180rpx;" >
				<view class="text-lg text-gray">请先选择提现方式</view>
			</view>
		</view>


		<view class="bg-white">
			<view class="padding-sm" style="color: #999;">
				<text>可提现余额</text>
				<text class="text-red">{{data.credit}}</text>
				<text>元</text>
			</view>
			<view class="padding-sm flex justify-between align-center" style="border-bottom: 1rpx solid #f2f1f7;">
				<view class="flex align-center" style="width: 70%;">
					<text style="font-size: 50rpx;line-height:50rpx;height: 60rpx;">¥</text>
					<input v-model="money" style="font-size: 50rpx;line-height:50rpx;height:60rpx;padding-left:30rpx;" type="digit" placeholder="0" @input="checkFloatInput" />
				</view>
				<view class="text-red text-right" style="width: 30%;" @click="money=data.credit">全部提现</view>
			</view>
			<view v-if="payType==0" class="padding-sm  text-sm">每日可以提现2次,单次最大提现金额不能超过2000元,今日剩余{{canWithdrawCount[0]||0}}次</view>
			<view class="padding-sm  text-sm" v-else>每日可以提现5次,单次最大提现金额不能超过5000元,今日剩余{{canWithdrawCount[3]||0}}次</view>
		</view>
		<view class="bg-white margin-top-sm ">
			<view class="padding-top-lg padding-lr-sm" style="color: #999;">请选择提现方式</view>
			<view class="padding-tb-sm">
				<view v-for="(item,index) in data.type_array" :key="index">
					<tui-list-cell unlined>
						<label class="tui-pay-item">
							<image v-if="item.type==0" src="http://appstore.bai918.com/static/app/icon/pay/weixin.png" class="tui-pay-logo"></image>
							<image v-if="item.type==2" src="http://appstore.bai918.com/static/app/icon/pay/zhifubao.png" class="tui-pay-logo"></image>
							<image v-if="item.type==3" src="http://appstore.bai918.com/static/app/icon/pay/bank.png" class="tui-pay-logo"></image>
							<text class="margin-left-sm">{{item.title}}</text>
							<view class="tui-radio">
								<radio-group @change="payTypeChange(item.type)">
									<radio color="#EB0909" :checked="payType==item.type"></radio>
								</radio-group>
							</view>
						</label>
					</tui-list-cell>
				</view>
			</view>
		</view>
		<view class="margin-top-xl text-center padding-lr-xl">
			<tui-button shadow shape="circle" type="danger" height="88rpx" @click="submit">确认提现</tui-button>
		</view>
		<u-modal v-model="modalAction.status" :content="modalAction.content" :show-cancel-button="modalAction.cancel" @confirm="modalAction.confirmCallback(true)"></u-modal>

		<tui-bottom-popup :show="showModal" @close="closeModal" :zIndex="999">
			<tui-list-cell :lineLeft="false" :hover="false">
				<view class="tui-pay-item__title">
					<view>选择到账银行卡</view>
				</view>
			</tui-list-cell>
			<view v-for="(item,index) in data.banklist" :key="index">
				<tui-list-cell >
					<label class="tui-pay-item">
						<view class="iconfont icon-yinhangqia" style="font-size: 80rpx;color: #888;"></view>
						<view class="padding-left-sm">
							<view class="text-black text-bold">{{item.bank_name}}</view>
							<view class="margin-top-xs text-sm">{{item.card_no}}</view>
						</view>
						<view class="tui-radio">
							<radio-group @change="bankChange(item.id)" >
								<radio color="#EB0909" :checked="selectedBankId==item.id"></radio>
							</radio-group>
						</view>
					</label>
				</tui-list-cell>
			</view>
			<tui-list-cell @click="bankChange('new')" :arrow="false">
				<label class="tui-pay-item">
					<view class="padding-left-sm">
						<view class="text-black text-bold" style="margin-left: 80rpx;">提现到新卡</view>
					</view>
					<view class="tui-radio">
						<view class="cuIcon-right" style="font-size: 40rpx;"></view>
					</view>
				</label>
			</tui-list-cell>

			<view class="tui-btn-pay">
				<tui-button height="88rpx" type="danger" shape="circle" shadow @click="showModal=false">确定</tui-button>
			</view>
		</tui-bottom-popup>

	</view>
</template>

<script>
    import {mapMutations,mapState,mapGetters} from 'vuex';
    export default {
        computed:{
            ...mapState(['modalAction']),
        },
        data() {
            return {
                data: '',
                money: '',
                payType:'',
                showModal:false,
				selectedBankId: 0,
                canWithdrawCount:{},
            }
        },
        onLoad(){
            this.getList()
        },
        onShow(){
            this.getList()
        },
        methods: {
            getList:function () {
                this.$http.get('member.withdraw').then((res)=>{
                    this.data = res
					this.canWithdrawCount = res.canWithdrawCount
                })
            },
			closeModal:function () {
			   	this.showModal = false
            },
            payTypeChange:function(e){
                this.payType = e
				//.detail.value
            },
            bankChange:function (e) {
                if(e=='new'){
                    this.$Router.push('/pages/member/wallet/bankcard')
                    this.selectedBankId = 0
                    this.showModal = false
					return false;
				}
				this.selectedBankId = e
				this.showModal = false
            },
            submit:function () {
				if(this.payType==3 && !this.selectedBankId){
                    this.$utils.toast('请选择你要提现的银行卡')
                    this.showModal = true
					return;
				}
                this.$utils.modal.confirm('确认申请提现？').then((res)=>{
                    this.$http.get('member.withdraw.submit',{applytype:this.payType,money:this.money,bankid:this.selectedBankId}).then((res)=>{
                        if(res.error==0){
                            if(res.no_certification){
                                this.$utils.toast(res.message)
								setTimeout(()=>{this.$Router.push({name:'member_wallet_bankcard'})},1500)
								return;
							}
                            this.money = ''
							this.getList()
                            this.$utils.toast('申请提现成功！请耐心等待审核')
                        }
                    })
                })
            },
            checkFloatInput:function (e) {
                this.$nextTick(()=>{this.money = this.$utils.checkFloatInput(e)})
            }
        }
    }
</script>

<style lang="scss">
	uni-radio-group{
		display: block;
	}
	.bankcard-bgcolor{
		background-image: linear-gradient(56deg,#008666 0%,#80a833 100%,#ffca00 100%,#8ac94e 100%,#14c89b 100%),linear-gradient(#ffffff,#ffffff);
		background-blend-mode: normal,normal;
		box-shadow: 0rpx 0rpx 20rpx 0rpx rgba(0, 134, 102, 0.35);
	}
	.tui-pay-item__title {
		width: 100%;
		height: 90rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 20rpx;
		box-sizing: border-box;
		font-size: 28rpx;
	}

	.tui-pay-amuont {
		color: #eb0909;
		font-weight: 500;
		font-size: 34rpx;
	}

	.tui-pay-item {
		width: 100%;
		height: 80rpx;
		display: flex;
		align-items: center;
		padding: 0 20rpx;
		box-sizing: border-box;
		font-size: 28rpx;
	}

	.tui-pay-logo {
		width: 80rpx;
		height: 80rpx;
		margin-right: 15rpx;
	}

	.tui-radio {
		margin-left: auto;
		transform: scale(0.8);
		transform-origin: 100% center;
	}

	.tui-btn-pay {
		width: 100%;
		padding: 68rpx 35rpx 50rpx 35rpx;
		box-sizing: border-box;
	}

	.tui-recharge {
		color: #fc872d;
		margin-left: auto;
		padding: 12rpx 0;
	}
</style>
