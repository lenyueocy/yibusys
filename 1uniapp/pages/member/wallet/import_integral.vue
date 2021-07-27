<template>
	<view class="flex" style="flex-direction: column;min-height: 100vh;">
		<view class="padding-tb-xl">
			<text class="text-lg margin-left-sm">可转入积分：{{data.integral||0}}</text>
		</view>
		<view class="bg-white padding-lr-lg" style="flex: 1;border-radius: 25rpx 25rpx 0 0;">
			<view class="padding-top-sm flex align-center justify-between">
				<text class="text-lg">转入到积分钱包</text>
				<text class="iconfont icon-qianbao1" style="width: 70rpx;height: 70rpx;"></text>
			</view>
			<view class="padding-bottom-sm flex justify-between align-center" style="border-bottom: 1rpx solid #f2f1f7;margin-top: 150rpx;">
				<view class="flex align-center" >
					<input v-model="integral" style="font-size: 35rpx;margin-left:10rpx;" type="digit" placeholder="请输入转入数量" @input="checkFloatInput" />
				</view>
				<view @click="integral = data.integral" class="text-red text-lg">全部转入</view>
			</view>
			<view class="padding-top-sm text-gray">转入积分钱包每天可释放<text class="text-red">5%</text>成余额</view>

		</view>

		<view class="padding-lr-xl" style="position: fixed;bottom: 3%;width: 100%;text-align: center;">
			<tui-button shadow shape="circle" type="danger" height="88rpx" @click="submit">确定转入</tui-button>
		</view>
	</view>
</template>

<script>
	export default{
		data(){
		    return {
                integral:'',
		        data:''
			}
		},
		onLoad(){
		    this.getList()
		},
		methods:{
			getList:function () {
                this.$http.get('member.get_integral').then((res)=>{
                    this.data = res.data
                })
            },
			submit:function () {
                this.$http.get('member.change_integral',{integral:this.integral}).then((res)=>{
                    this.integral = ''
                    this.$utils.toast('转入成功')
					this.getList()
					setTimeout(()=>{this.$Router.back()},1500)
                })
            },
            checkFloatInput:function (e) {
                this.$nextTick(()=>{this.integral = this.$utils.checkFloatInput(e)})
            }
        }
	}
</script>

<style lang="scss">

</style>
