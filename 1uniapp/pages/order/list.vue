<template>
	<view class="container">
		<tui-tabs :tabs="tabs" :isFixed="scrollTop>=0" :currentTab="tabIndex" selectedColor="#E41F19" sliderBgColor="#E41F19" @change="tabsChange" itemWidth="20%"></tui-tabs>

		<swiper :style="{height: height}" :current="tabIndex" @change="swiperChange">
			<swiper-item v-for="(tab,i) in tabs" :key="i">
				<order-list-item ref="mescrollItem" :i="i" :index="tabIndex" :tabs="tabs"></order-list-item>
			</swiper-item>
		</swiper>
		<!-- lenyue注释 -->
		<u-modal v-model="modalAction.status" :content="modalAction.content" :show-cancel-button="modalAction.cancel" @confirm="modalAction.confirmCallback(true)"></u-modal>
	</view>
</template>

<script>
    import {mapMutations,mapState,mapGetters} from 'vuex';
    import OrderListItem from "./list-item.vue";
	export default {
        components: {
            OrderListItem
        },
		data() {
			return {
				tabs: [{name: "全部"},{name: "待付款"},{name: "待发货"},{name: "待收货"},{name: "待评价"}],
				tabIndex: 0,
				pageIndex: 1,
				loadding: false,
				pullUpOn: true,
				scrollTop: 0,
				height:'400px',
			}
		},
        computed:{
            ...mapState(['modalAction']),
        },
		onLoad(){
            if(this.$Route.query.status) this.tabIndex = parseInt(this.$Route.query.status)
            this.height = uni.getSystemInfoSync().windowHeight + 'px'
		},
		onShow(){
		    //console.log(this.$refs.mescrollItem[this.tabIndex].checkPayStatus())
		    //console.log('触发了返回')
		},
		methods: {
            takeDelivery:function (item) {
		        this.$utils.modal.confirm('确认完成收货？').then((res)=>{
                    this.$http.get('order.confirm_receipt',{orderid:item.id}).then((res)=>{
                        this.$set(item,'status',3)
                    })
				})
            },
            swiperChange:function (e) {
                this.tabIndex = e.detail.current
            },
            tabsChange:function(e){
                this.tabIndex = e.index
			}
		},
		onPageScroll(e) {
			this.scrollTop = e.scrollTop;
		}
	}
</script>
