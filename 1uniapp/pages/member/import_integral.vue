<template>
	<view class="flex" style="flex-direction: column;min-height: 100vh;">
		<view class="padding-tb-xl">
			<text class="text-lg margin-left-sm">可兑换余额：{{data.credit2||0}}</text>
		</view>
		<view class="bg-white padding-lr-lg" style="flex: 1;border-radius: 25rpx 25rpx 0 0;">
			<view class="padding-top-sm flex align-center justify-between">
				<text class="text-lg">余额兑换为积分</text>
				<text class="iconfont icon-qianbao1" style="width: 70rpx;height: 70rpx;"></text>
			</view>
			<view class="padding-bottom-sm flex justify-between align-center" style="border-bottom: 1rpx solid #f2f1f7;margin-top: 150rpx;">
				<view class="flex align-center" >
					<input v-model="value" style="font-size: 35rpx;margin-left:10rpx;" type="digit" placeholder="请输入兑换金额" @input="checkFloatInput" />
				</view>
				<view @click="value = data.credit2" class="text-red text-lg">全部兑换</view>
			</view>
			<view class="padding-top-sm text-gray">余额兑换积分兑换比例为<text class="text-red">1:1</text>请确保余额充足</view>

		</view>

		<view class="padding-lr-xl" style="position: fixed;bottom: 3%;width: 100%;text-align: center;">
			<tui-button shadow shape="circle" type="danger" height="88rpx" @click="submit">确定兑换</tui-button>
		</view>

		<!-- lenyue 注释 -->
		<u-modal v-model="modalAction.status" :content="modalAction.content" :show-cancel-button="modalAction.cancel" @confirm="modalAction.confirmCallback(true)"></u-modal>

	</view>
</template>

<script>
    import {mapMutations,mapState,mapGetters} from 'vuex';
	export default{
        computed: {
            ...mapState(['modalAction']),
        },
		data(){
		    return {
		        data:'',
                value:'',
			}
		},
		onLoad(){
		    this.getList()
		},
		methods:{
			getList:function () {
                this.$http.get('member.wallet').then((res)=>{
                    this.data = res
                })
            },
			submit:function () {
			    if(!this.value || this.value==' '){
                    this.$utils.toast('请输入正确的金额')
					return;
				}
                this.$utils.modal.confirm('确认兑换吗？').then((res)=>{
                    this.$http.get('member.balanceTointegral',{value:this.value}).then((res)=>{
                        this.value = ''
                        this.$utils.toast('兑换成功成功')
                        this.getList()
                        setTimeout(()=>{this.$Router.back()},1500)
                    })
                })
            },
            checkFloatInput:function (e) {
                this.$nextTick(()=>{this.value = this.$utils.checkFloatInput(e)})
            }
        }
	}
</script>

<style lang="scss">

</style>
