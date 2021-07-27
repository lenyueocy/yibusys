<template>
	<view>
		<view class="text-red padding-sm">请绑定持卡人本人银行卡<text class="text-green text-bold" v-if="is_certification">（已实名认证）</text><text class="text-black text-bold" v-else >（未实名认证）</text></view>
		<view class="cu-form-group">
			<input v-model="bankCardData.name" placeholder="持卡人" name="input" />
		</view>
		<view class="cu-form-group">
			<input v-model="bankCardData.card_no" placeholder="卡号" name="input" />
		</view>
		<view class="cu-form-group" v-if="!is_certification">
			<input v-model="bankCardData.card_id" placeholder="身份证件号码" name="input" />
		</view>
		<view class="padding-sm">请补充银行卡相关信息</view>
		<!--<view class="cu-form-group">
			<view class="title">开户银行</view>
			<picker @change="PickerChange" :value="bankIndex" :range="bankNameList">
				<view class="picker text-grey" style="text-align: left;font-size: 30rpx;">
					{{bankIndex>-1?bankNameList[bankIndex]:'请选择开户行'}}
				</view>
			</picker>
		</view>-->
		<view class="cu-form-group">
			<view class="title">开户支行</view>
			<input v-model="bankCardData.bank_branch" placeholder="请输入开户银行的支行" name="input" />
		</view>
		<view class="cu-form-group">
			<view class="title">手机号(选填)</view>
			<input v-model="bankCardData.mobile" placeholder="请输入手机号" name="input" />
		</view>

		<view class="margin-top-xl" style="text-align: center;">
			<u-button @click="submit" size="medium" :hair-line="false" :ripple="true" style="width:90%;height:90rpx;border: none;background-color:#ff1c50;color: #fff;">添加</u-button>
		</view>

	</view>
</template>

<script>
    import uniCombox from '@/components/uni-combox/uni-combox.vue'
	export default {
		data() {
			return {
                bankNameList: ['交通银行', '中国光大银行', '中国建设银行', '中国银行', '中国工商银行', '中国农业银行', '中国民生银行','招商银行','中信银行','中国邮政储蓄银行'],
                bankCardData:{},
				bankIndex: -1,
                is_certification: false,
			}
		},
        components:{
            uniCombox
		},
		onLoad(){
		    this.getList()
		},
		methods: {
            getList:function () {
				this.$http.get('member.bankcard.getBankNameList').then((res)=>{
					this.bankNameList = res.bankNameList
					this.is_certification = res.is_certification
				})
            },
			submit:function () {
                if(this.bankCardData.card_no.length<16 || !this.bankCardData || !this.bankCardData.card_no){
                    this.$utils.toast('请输入正确的银行卡卡号')
                    return ;
				}
				this.$http.get('member.bankcard.add',this.bankCardData).then((res)=>{
				    this.$utils.toast(res.message)
					setTimeout(()=>{this.$Router.back()},1500)
                })
            },
            PickerChange:function (e) {
                if(e.detail.value<0) e.detail.value = 0
				this.bankIndex = e.detail.value
				this.$set(this.bankCardData,'bank_name',this.bankNameList[e.detail.value])
            }
		}
	}
</script>

<style lang='scss'>
	.radius{
		border-radius: 22rpx;
	}
	﻿.cu-form-group .title {
		min-width: calc(25% + 15px);
	}
</style>
