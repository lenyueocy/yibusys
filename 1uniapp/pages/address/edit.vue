<template>
	<view class="tui-addr-box">
		<form :report-submit="true">
			<tui-list-cell :hover="false" padding="0">
				<view class="tui-line-cell">
					<view class="tui-title">收货人</view>
					<input v-model="addressData.realname" placeholder-class="tui-phcolor" class="tui-input" placeholder="请输入收货人姓名" maxlength="15" type="text" />
				</view>
			</tui-list-cell>
			<tui-list-cell :hover="false" padding="0">
				<view class="tui-line-cell">
					<view class="tui-title">手机号码</view>
					<input v-model="addressData.mobile" placeholder-class="tui-phcolor" class="tui-input" placeholder="请输入收货人手机号码" maxlength="11" type="text" />
				</view>
			</tui-list-cell>
			<tui-list-cell :arrow="true" padding="0">
				<view class="tui-line-cell">
					<view class="tui-title">
						<text class="tui-title-city-text">地区</text>
					</view>
					<input @click="openAddress" v-model="addressData.areas" placeholder-class="tui-phcolor" class="tui-input" disabled placeholder="请选择地区" maxlength="50" type="text" />
				</view>
			</tui-list-cell>
			<tui-list-cell :hover="false" padding="0">
				<view class="tui-line-cell">
					<view class="tui-title">详细地址</view>
					<input v-model="addressData.address" placeholder-class="tui-phcolor" class="tui-input" placeholder="请输入详细的收货地址" maxlength="50" type="text" />
				</view>
			</tui-list-cell>

			<!-- 默认地址 -->
			<tui-list-cell :hover="false" padding="0">
				<view class="tui-swipe-cell">
					<view>设为默认地址</view>
					<switch :class="{checked:parseInt(addressData.isdefault)==1}" @change="addressData.isdefault = !parseInt(addressData.isdefault)" :checked="parseInt(addressData.isdefault)==1" ></switch>
				</view>
			</tui-list-cell>
			<!-- 保存地址 -->
			<view class="tui-addr-save">
				<tui-button shadow type="danger" height="88rpx" shape="circle" @click="submit">保存收货地址</tui-button>
			</view>
			<view class="tui-del" >
				<tui-button shadow type="warning" height="88rpx" shape="circle" v-if="$Route.query.id">删除收货地址</tui-button>
			</view>
		</form>
		<simple-address ref="simpleAddress" :pickerValueDefault="cityPickerValueDefault" @onConfirm="onConfirm" themeColor='#007AFF'></simple-address>
	</view>
</template>

<script>
    import simpleAddress from "@/components/simple-address/simple-address.vue"
	export default {
		data() {
			return {
				addressData: {
                    realname: '',
					mobile: '',
					address: '',
                    areas: '',
                    isdefault: false
				},
                cityPickerValueDefault: [0, 0, 0],
			}
		},
        components: {
            simpleAddress
        },
		onLoad(){
			let title = '新增收货地址';
			if(this.$Route.query.id){
				title = '编辑收货地址'
				this.getList()
			}
			uni.setNavigationBarTitle({title})
		},
		methods: {
		    getList:function () {
                this.$http.get('member.address.get_detail',{id:this.$Route.query.id}).then((res)=>{
                    this.addressData = res.detail
                })
            },
            openAddress:function () {
		        if(this.$Route.query.id){
                    var index = this.$refs.simpleAddress.queryIndex([this.addressData.areas.split(' ')[0], this.addressData.areas.split(' ')[1], this.addressData.areas.split(' ')[2]], 'label').index;
                    this.cityPickerValueDefault = index
				}
				this.$refs.simpleAddress.open()
            },
            onConfirm(e) {
		        console.log(e)
                this.addressData.areas = e.label;
                this.addressData.provinceCode = e.provinceCode
                this.addressData.cityCode = e.cityCode
                this.addressData.areaCode = e.areaCode
            },
			submit(){
				let data = this.addressData;
				if(!data.realname){
					this.$utils.toast('请填写收货人姓名');
					return;
				}
				if(!/(^1[3|4|5|7|8][0-9]{9}$)/.test(data.mobile)){
					this.$utils.toast('请输入正确的手机号码');
					return;
				}
				if(!data.areas){
					this.$utils.toast('请选择地区');
					return;
				}
				if(!data.address){
					this.$utils.toast('请填写详细地址');
					return;
				}
				data.province = data.areas.split(' ')[0]
				data.city = data.areas.split(' ')[1]
				data.area = data.areas.split(' ')[2]
				this.$http.get('member.address.submit',data).then((res)=>{
				    this.$utils.toast('操作成功')
                    setTimeout(()=>{this.$Router.back()}, 800)
				})
				//this.$api.prePage()获取上一页实例，可直接调用上页所有数据和方法，在App.vue定义
				//this.$utils.prePage().refreshList(data, this.manageType);
				//this.$u.toast(`地址${this.manageType=='edit' ? '修改': '添加'}成功`);
			},
		}
	}
</script>

<style lang="scss">
	.tui-addr-box {
		padding: 20rpx 0;
	}

	.tui-line-cell {
		width: 100%;
		padding: 24rpx 30rpx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
	}

	.tui-title {
		width: 180rpx;
		font-size: 28rpx;
	}

	.tui-title-city-text {
		width: 180rpx;
		height: 40rpx;
		display: block;
		line-height: 46rpx;
	}

	.tui-input {
		width: 500rpx;
	}

	.tui-input-city {
		flex: 1;
		height: 40rpx;
		font-size: 28rpx;
		padding-right: 30rpx;
	}

	.tui-phcolor {
		color: #ccc;
		font-size: 28rpx;
	}
	.tui-cell-title{
		font-size: 28rpx;
	}
	.tui-addr-label {
		margin-left: 70rpx;
	}

	.tui-label-item {
		width: 76rpx;
		height: 40rpx;
		border: 1rpx solid rgb(136, 136, 136);
		border-radius: 6rpx;
		font-size: 26rpx;
		text-align: center;
		line-height: 40rpx;
		margin-right: 20rpx;
		display: inline-block;
		transform: scale(0.9);
	}
	.tui-label-active{
		background: #E41F19;
		border-color:#E41F19;
		color: #fff;
	}
	.tui-swipe-cell {
		width: 100%;
		display: flex;
		justify-content: space-between;
		align-items: center;
		background: #fff;
		padding: 30rpx 24rpx;
		box-sizing: border-box;
		border-radius: 6rpx;
		overflow: hidden;
		margin-top:20rpx;
		font-size: 28rpx;
	}

	.tui-switch-small {
		transform: scale(0.8);
		transform-origin: 100% center;
	}

	/* #ifndef H5 */
	.tui-switch-small .wx-switch-input {
		margin: 0 !important;
	}

	/* #endif */

	/* #ifdef H5 */
	>>>uni-switch .uni-switch-input {
		margin-right: 0 !important;
	}

	/* #endif */

	.tui-addr-save {
		padding: 24rpx;
		margin-top: 100rpx;
	}

	.tui-del {
		padding: 24rpx;
	}
</style>
