<template>
	<view class="container">
		<tui-list-cell :hover="false" :unlined="true" v-if="!is_openNotice">
			<view class="tui-message-item">
				<view>
					<view class="tui-title">开启消息推送</view>
					<view class="tui-sub-title">开启后，可以第一时间收到订阅的消息哦！</view>
				</view>
				<tui-button type="danger" width="140rpx" height="60rpx" :size="24" @click="toAppSet">前往设置</tui-button>
			</view>
		</tui-list-cell>
		<view class="tui-top " :class="{'margin-top-sm':!is_openNotice}">
			<tui-list-cell @click="goKefu"><!--$Router.push({name:'message_service'})-->
				<view class="tui-message-item">
					<view class="tui-title-box">
						<view class="tui-icon-box tui-bg-danger">
							<tui-icon name="kefu" color="#fff" :size="26"></tui-icon>
						</view>
						<view class="tui-title">联系客服</view>
					</view>
					<!--<tui-badge :position="false" type="red" :scale="false">1</tui-badge>-->
				</view>
			</tui-list-cell>
			<!--<tui-list-cell @click="href(3)">
				<view class="tui-message-item">
					<view class="tui-title-box">
						<view class="tui-icon-box tui-bg-warning">
							<tui-icon name="transport" color="#fff" :size="28"></tui-icon>
						</view>
						<view class="tui-title">发货通知</view>
					</view>
					<tui-badge :position="false" type="red" :scale="false">12</tui-badge>
				</view>
			</tui-list-cell>-->
			<!--<tui-list-cell @click="href(4)">
				<view class="tui-message-item">
					<view class="tui-title-box">
						<view class="tui-icon-box tui-bg-pink">
							<tui-icon name="unreceive" color="#fff" :size="26"></tui-icon>
						</view>
						<view class="tui-title">收货通知</view>
					</view>
					<tui-badge :position="false" type="red" :scale="false" v-if="false">1</tui-badge>
				</view>
			</tui-list-cell>-->
			<!--<tui-list-cell @click="href(5)">
				<view class="tui-message-item">
					<view class="tui-title-box">
						<view class="tui-icon-box tui-bg-success">
							<tui-icon name="wallet" color="#fff" :size="26"></tui-icon>
						</view>
						<view class="tui-title">付款通知</view>
					</view>
					<tui-badge :position="false" type="red" :scale="false">8</tui-badge>
				</view>
			</tui-list-cell>-->
			<!--<tui-list-cell :unlined="true" @click="href(6)">
				<view class="tui-message-item">
					<view class="tui-title-box">
						<view class="tui-icon-box tui-bg-blue">
							<tui-icon name="message" color="#fff" :size="30"></tui-icon>
						</view>
						<view class="tui-title">系统通知</view>
					</view>
					<tui-badge :position="false" type="red" :scale="false">10</tui-badge>
				</view>
			</tui-list-cell>-->
		</view>
	</view>
</template>

<script>
    export default {
        data() {
            return {
                is_openNotice:true,
			};
        },
		onLoad(){
            // #ifdef APP-PLUS
            var main = plus.android.runtimeMainActivity();
            var NotificationManagerCompat = plus.android.importClass("android.support.v4.app.NotificationManagerCompat");
            var areNotificationsEnabled = NotificationManagerCompat.from(main).areNotificationsEnabled();
			if(!areNotificationsEnabled) this.is_openNotice = false
			// #endif
		},
        methods: {
            goKefu(){
                if(this.$utils.getPlatform()!='mp-weixin'){
                    this.$utils.toast('该平台不支持此功能')
                }else{

                }
            },
            toAppSet(){
                var main = plus.android.runtimeMainActivity();
                var pkName = main.getPackageName();
                var uid = main.getApplicationInfo().plusGetAttribute("uid");

                var Intent = plus.android.importClass('android.content.Intent');
                var Build = plus.android.importClass("android.os.Build");
                //android 8.0引导
                if (Build.VERSION.SDK_INT >= 26) {
                    var intent = new Intent('android.settings.APP_NOTIFICATION_SETTINGS');
                    intent.putExtra('android.provider.extra.APP_PACKAGE', pkName);
                } else if (Build.VERSION.SDK_INT >= 21) { //android 5.0-7.0
                    var intent = new Intent('android.settings.APP_NOTIFICATION_SETTINGS');
                    intent.putExtra("app_package", pkName);
                    intent.putExtra("app_uid", uid);
                } else { //(<21)其他--跳转到该应用管理的详情页
                    var Settings = plus.android.importClass("android.provider.Settings");
                    var Uri = plus.android.importClass("android.net.Uri");
                    var intent = new Intent();
                    intent.setAction(Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
                    var uri = Uri.fromParts("package", main.getPackageName(), null);
                    intent.setData(uri);
                }
                // 跳转到该应用的系统通知设置页
                main.startActivity(intent);
            },
        }
    };
</script>

<style lang="scss">
	.container {
		padding:0rpx 0 48rpx;

		.tui-message-item {
			width: 100%;
			display: flex;
			align-items: center;
			justify-content: space-between;

			box-sizing: border-box;

			.tui-title {
				font-size: $uni-font-size-lg;
			}

			.tui-sub-title {
				font-size: $uni-font-size-sm;
				color: $uni-text-color-grey;
				padding-top: 4rpx;
			}

			.tui-title-box {
				display: flex;
				align-items: center;
				justify-content: center;

				.tui-icon-box {
					width: 88rpx;
					height: 88rpx;
					color: $uni-text-color-inverse;
					border-radius: $uni-border-radius-lg;
					display: flex;
					align-items: center;
					justify-content: center;
					margin-right: $uni-spacing-row-base;
				}

				.tui-bg-danger {
					background-color: #eb0909;
				}

				.tui-bg-warning {
					background-color: #ff7900;
				}

				.tui-bg-success {
					background-color: #19be6b;
				}

				.tui-bg-primary {
					background-color: #5677fc;
				}

				.tui-bg-pink {
					background-color: #f74d54;
				}

				.tui-bg-blue {
					background-color: #5677fc;
				}
			}
		}

	}
</style>
