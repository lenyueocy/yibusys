(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-order-submit"],{"301bd":function(t,i,e){"use strict";e.r(i);var a=e("d580"),n=e.n(a);for(var s in a)"default"!==s&&function(t){e.d(i,t,(function(){return a[t]}))}(s);i["default"]=n.a},"3f97":function(t,i,e){var a=e("24fb");i=a(!1),i.push([t.i,"uni-radio-group[data-v-5ccb07e0]{display:block}.tui-bottom-popup[data-v-5ccb07e0]{z-index:9999!important}.tui-pay-item__title[data-v-5ccb07e0]{width:100%;height:%?90?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;padding:0 %?45?% 0 %?20?%;box-sizing:border-box;font-size:%?28?%}.tui-pay-amuont[data-v-5ccb07e0]{color:#eb0909;font-weight:700;font-size:%?45?%}.tui-pay-item[data-v-5ccb07e0]{width:100%;height:%?80?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding:0 %?20?%;box-sizing:border-box;font-size:%?28?%}.tui-pay-logo[data-v-5ccb07e0]{width:%?48?%;height:%?48?%;margin-right:%?15?%}.tui-radio[data-v-5ccb07e0]{margin-left:auto;-webkit-transform:scale(.8);transform:scale(.8);-webkit-transform-origin:100% center;transform-origin:100% center}.tui-btn-pay[data-v-5ccb07e0]{width:100%;padding:%?68?% %?35?% %?50?% %?35?%;box-sizing:border-box}.tui-recharge[data-v-5ccb07e0]{color:#fc872d;margin-left:auto;padding:%?12?% 0}",""]),t.exports=i},"50e3":function(t,i,e){var a=e("ed5e");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=e("4f06").default;n("08ae782a",a,!0,{sourceMap:!1,shadowMode:!1})},"6f2d":function(t,i,e){"use strict";var a=e("4ea4");e("e25e"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var n=a(e("5530")),s=a(e("d8ca")),o=e("2f62"),r={components:{tPayWay:s.default},computed:(0,n.default)({},(0,o.mapState)(["modalAction"])),data:function(){return{hasCoupon:!1,insufficient:!1,show:!1,listData:{},goods:{},remark:"",payInfo:"",credit:0,addressData:""}},onLoad:function(){this.getList()},methods:{getList:function(){var t=this,i={};this.$Route.query.goodsid&&(i.id=this.$Route.query.goodsid||!1),this.$Route.query.total&&(i.total=this.$Route.query.total||1),this.$Route.query.optionid&&(i.optionid=this.$Route.query.optionid),this.$http.get("order.create",i).then((function(i){t.listData=i,t.goods=i.goods,t.addressData=i.address}))},chooseAddrCallback:function(t){this.addressData=t},submit:function(){var t=this;if(this.addressData.id){var i={goods:this.goods[0]["goods"],addressid:this.addressData.id,remark:this.remark,hasinvoice:!1};this.$Route.query.goodsid||(i.fromcart=1),this.$http.post("order.create.submit",i).then((function(i){0==i.error&&t.actionPay(i.orderid)}))}else this.$utils.toast("请选择收货地址")},payment:function(t){var i=this;switch(t.type){case"credit":this.$http.get("order.pay.complete",{id:this.payInfo.order.id,type:t.type}).then((function(t){0==t.error?(i.$utils.toast("支付成功"),i.show=!1,i.$Router.push({path:"/pages/order/pay/result",query:{type:"order",orderid:i.payInfo.order.id}})):i.$utils.toast("支付出错")}));break;case"wechat":this.$utils.weixinPay(this.payInfo.wechat.payinfo).then((function(t){!1!==t&&i.$utils.toast("支付成功"),i.show=!1,!1!==t?i.$Router.push({path:"/pages/order/pay/result",query:{type:"order",orderid:i.payInfo.order.id}}):setTimeout((function(){i.$Router.push({path:"/pages/order/detail",query:{id:i.payInfo.order.id,listener:!0}})}),1500)})).catch((function(t){i.$utils.toast("支付失败")}));break;default:return void this.$utils.toast("请先选择支付方式")}},actionPay:function(t){var i=this;this.$http.get("order.pay",{id:t}).then((function(t){i.payInfo=t,i.credit=parseInt(t.credit.current),i.show=!0}))},popupClose:function(){var t=this;this.$utils.modal.confirm("确定取消支付吗？").then((function(i){t.show=!1}))}}};i.default=r},7852:function(t,i,e){"use strict";e.r(i);var a=e("6f2d"),n=e.n(a);for(var s in a)"default"!==s&&function(t){e.d(i,t,(function(){return a[t]}))}(s);i["default"]=n.a},8991:function(t,i,e){var a=e("3f97");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=e("4f06").default;n("272e6b64",a,!0,{sourceMap:!1,shadowMode:!1})},ce9b:function(t,i,e){"use strict";var a=e("50e3"),n=e.n(a);n.a},d580:function(t,i,e){"use strict";e("a9e3"),Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var a={name:"tPayWay",props:{show:{type:Boolean,default:!1},money:{type:String,default:"0.00"},credit:{type:String,default:"0.00"},page:{type:Number,default:1},payInfo:{type:Object,default:{order:{id:0,ordersn:"",price:"0.00",title:"订单"},credit:{success:!1,current:"0.00"},wechat:{success:!1},alipay:{success:!1}}}},data:function(){return{payType:!1}},onLoad:function(){},methods:{close:function(){this.$emit("close",{})},btnPay:function(){this.$emit("payment",{type:this.payType})},payTypeChange:function(t){this.payType=t.detail.value}}};i.default=a},d8ca:function(t,i,e){"use strict";e.r(i);var a=e("e18e"),n=e("301bd");for(var s in n)"default"!==s&&function(t){e.d(i,t,(function(){return n[t]}))}(s);e("da8f");var o,r=e("f0c5"),d=Object(r["a"])(n["default"],a["b"],a["c"],!1,null,"5ccb07e0",null,!1,a["a"],o);i["default"]=d.exports},da8f:function(t,i,e){"use strict";var a=e("8991"),n=e.n(a);n.a},e18e:function(t,i,e){"use strict";e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return s})),e.d(i,"a",(function(){return a}));var a={tuiBottomPopup:e("0f10").default,tuiListCell:e("d016").default,tuiButton:e("7133").default},n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-uni-view",[e("tui-bottom-popup",{attrs:{show:t.show,zIndex:999},on:{close:function(i){arguments[0]=i=t.$handleEvent(i),t.close.apply(void 0,arguments)}}},[e("tui-list-cell",{attrs:{hover:!1}},[e("v-uni-view",{staticStyle:{position:"absolute",right:"2%",top:"8%"}},[e("v-uni-text",{staticClass:"text-gray cuIcon-roundclosefill",staticStyle:{"font-size":"50rpx"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.close.apply(void 0,arguments)}}})],1),e("v-uni-view",{staticClass:"tui-pay-item__title"},[e("v-uni-view",[t._v("支付金额："),e("v-uni-text",{staticClass:"tui-pay-amuont text-price"},[t._v(t._s(t.payInfo.order.price||0))])],1)],1)],1),t.payInfo.credit&&t.payInfo.credit.success?e("tui-list-cell",{attrs:{unlined:!0}},[e("v-uni-label",{staticClass:"tui-pay-item"},[e("v-uni-image",{staticClass:"tui-pay-logo",attrs:{src:"http://appstore.bai918.com/static/app/icon/pay/balance.png"}}),parseFloat(t.payInfo.credit.current)>=parseFloat(t.payInfo.order.price)?e("v-uni-text",[t._v("余额支付（余额:"+t._s(t.payInfo.credit.current)+"元）")]):e("v-uni-text",[t._v("余额支付（余额:"+t._s(t.payInfo.credit.current)+"元，余额不足）")]),parseFloat(t.payInfo.credit.current)>=parseFloat(t.payInfo.order.price)?e("v-uni-view",{staticClass:"tui-radio"},[e("v-uni-radio-group",{on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.payTypeChange.apply(void 0,arguments)}}},[e("v-uni-radio",{attrs:{color:"#EB0909",value:"credit",checked:"credit"==t.payType}})],1)],1):e("v-uni-view",{staticClass:"tui-recharge",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.$Router.push({name:"member_wallet_index"})}}},[t._v("去充值")])],1)],1):t._e(),t.payInfo.wechat&&t.payInfo.wechat.success?e("tui-list-cell",{attrs:{unlined:!0}},[e("v-uni-label",{staticClass:"tui-pay-item"},[e("v-uni-image",{staticClass:"tui-pay-logo",attrs:{src:"http://appstore.bai918.com/static/app/icon/pay/weixin.png"}}),e("v-uni-text",[t._v("微信支付")]),e("v-uni-view",{staticClass:"tui-radio"},[e("v-uni-radio-group",{on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.payTypeChange.apply(void 0,arguments)}}},[e("v-uni-radio",{attrs:{color:"#EB0909",value:"wechat",checked:"wechat"==t.payType}})],1)],1)],1)],1):t._e(),t.payInfo.alipay&&t.payInfo.alipay.success?e("tui-list-cell",{attrs:{unlined:!0}},[e("v-uni-label",{staticClass:"tui-pay-item"},[e("v-uni-image",{staticClass:"tui-pay-logo",attrs:{src:"http://appstore.bai918.com/static/app/icon/pay/zhifubao.png"}}),e("v-uni-text",[t._v("支付宝支付")]),e("v-uni-view",{staticClass:"tui-radio"},[e("v-uni-radio-group",{on:{change:function(i){arguments[0]=i=t.$handleEvent(i),t.payTypeChange.apply(void 0,arguments)}}},[e("v-uni-radio",{attrs:{color:"#EB0909",value:"alipay",checked:"alipay"==t.payType}})],1)],1)],1)],1):t._e(),e("v-uni-view",{staticClass:"tui-btn-pay"},[e("tui-button",{attrs:{height:"88rpx",type:"danger",shape:"circle",shadow:!0},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.btnPay.apply(void 0,arguments)}}},[t._v("去付款")])],1)],1)],1)},s=[]},e855:function(t,i,e){"use strict";e.r(i);var a=e("ef0b"),n=e("7852");for(var s in n)"default"!==s&&function(t){e.d(i,t,(function(){return n[t]}))}(s);e("ce9b");var o,r=e("f0c5"),d=Object(r["a"])(n["default"],a["b"],a["c"],!1,null,"16699f01",null,!1,a["a"],o);i["default"]=d.exports},ed5e:function(t,i,e){var a=e("24fb");i=a(!1),i.push([t.i,'.container[data-v-16699f01]{padding-bottom:%?98?%}.tui-box[data-v-16699f01]{padding:%?20?% 0 %?118?%;box-sizing:border-box}.tui-address[data-v-16699f01]{min-height:%?80?%;padding:%?10?% 0;box-sizing:border-box;position:relative}.tui-userinfo[data-v-16699f01]{font-size:%?30?%;font-weight:500;line-height:%?30?%;padding-bottom:%?12?%}.tui-name[data-v-16699f01]{padding-right:%?40?%}.tui-addr[data-v-16699f01]{font-size:%?24?%;word-break:break-all;padding-right:%?25?%}.tui-addr-tag[data-v-16699f01]{padding:%?5?% %?8?%;-webkit-flex-shrink:0;flex-shrink:0;background:#eb0909;color:#fff;display:-webkit-inline-box;display:-webkit-inline-flex;display:inline-flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;font-size:%?25?%;line-height:%?25?%;-webkit-transform:scale(.8);transform:scale(.8);-webkit-transform-origin:0 center;transform-origin:0 center;border-radius:%?6?%}.tui-bg-img[data-v-16699f01]{position:absolute;width:100%;height:%?4?%;left:0;bottom:0;background:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAAAFCAYAAAAaAWmiAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6Rjk3RjkzMjM2NzMxMTFFOUI4RkU4OEZGMDcxQzgzOEYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6Rjk3RjkzMjQ2NzMxMTFFOUI4RkU4OEZGMDcxQzgzOEYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpGOTdGOTMyMTY3MzExMUU5QjhGRTg4RkYwNzFDODM4RiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpGOTdGOTMyMjY3MzExMUU5QjhGRTg4RkYwNzFDODM4RiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PrEOZlQAAAiuSURBVHjazJp7bFvV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") no-repeat;background-size:100% 100%}.tui-top[data-v-16699f01]{margin-top:%?20?%;overflow:hidden}.tui-goods-title[data-v-16699f01]{font-size:%?28?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.tui-padding[data-v-16699f01]{box-sizing:border-box}.tui-goods-item[data-v-16699f01]{width:100%;padding:%?20?% %?30?%;box-sizing:border-box;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.tui-goods-img[data-v-16699f01]{width:%?180?%;height:%?180?%;display:block;-webkit-flex-shrink:0;flex-shrink:0}.tui-goods-center[data-v-16699f01]{-webkit-box-flex:1;-webkit-flex:1;flex:1;padding:%?20?% %?8?%;box-sizing:border-box}.tui-goods-name[data-v-16699f01]{max-width:%?310?%;word-break:break-all;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;font-size:%?26?%;line-height:%?32?%}.tui-goods-attr[data-v-16699f01]{font-size:%?22?%;color:#888;line-height:%?32?%;padding-top:%?20?%;word-break:break-all;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2}.tui-price-right[data-v-16699f01]{text-align:right;font-size:%?24?%;color:#888;line-height:%?30?%;padding-top:%?20?%}.tui-flex[data-v-16699f01]{width:100%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;font-size:%?26?%}.tui-total-flex[data-v-16699f01]{-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end}.tui-color-red[data-v-16699f01],\n.tui-invoice-text[data-v-16699f01]{color:#e41f19;padding-right:%?30?%}.tui-balance[data-v-16699f01]{font-size:%?28?%;font-weight:500}.tui-black[data-v-16699f01]{color:#222;line-height:%?30?%}.tui-gray[data-v-16699f01]{color:#888;font-weight:400}.tui-light-dark[data-v-16699f01]{color:#666}.tui-goods-price[data-v-16699f01]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding-top:%?20?%}.tui-size-26[data-v-16699f01]{font-size:%?26?%;line-height:%?26?%}.tui-price-large[data-v-16699f01]{font-size:%?34?%;line-height:%?32?%;font-weight:600}.tui-flex-end[data-v-16699f01]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:end;-webkit-align-items:flex-end;align-items:flex-end;padding-right:0}.tui-phcolor[data-v-16699f01]{color:#b3b3b3;font-size:%?26?%}\n.tui-remark-box[data-v-16699f01]{padding:%?26?% %?30?%}\n.tui-remark[data-v-16699f01]{-webkit-box-flex:1;-webkit-flex:1;flex:1;font-size:%?26?%;padding-left:%?64?%}.tui-scale-small[data-v-16699f01]{-webkit-transform:scale(.8);transform:scale(.8);-webkit-transform-origin:100% center;transform-origin:100% center}.tui-scale-small .wx-switch-input[data-v-16699f01]{margin:0!important}\n[data-v-16699f01] uni-switch .uni-switch-input{margin-right:0!important}\n.tui-tabbar[data-v-16699f01]{width:100%;height:%?98?%;background:#fff;position:fixed;left:0;bottom:0;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;font-size:%?26?%;box-shadow:0 0 1px rgba(0,0,0,.3);\n\t/*padding-bottom: env(safe-area-inset-bottom);*/z-index:996}.tui-pr-30[data-v-16699f01]{padding-right:%?30?%}.tui-pr-20[data-v-16699f01]{padding-right:%?20?%}.tui-none-addr[data-v-16699f01]{height:%?80?%;padding-left:%?5?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.tui-addr-img[data-v-16699f01]{width:%?36?%;height:%?46?%;display:block;margin-right:%?15?%}.tui-pr25[data-v-16699f01]{padding-right:%?25?%}.tui-safe-area[data-v-16699f01]{height:%?1?%;padding-bottom:env(safe-area-inset-bottom)}',""]),t.exports=i},ef0b:function(t,i,e){"use strict";e.d(i,"b",(function(){return n})),e.d(i,"c",(function(){return s})),e.d(i,"a",(function(){return a}));var a={tuiListCell:e("d016").default,tuiButton:e("7133").default,uModal:e("5a91").default},n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-uni-view",{staticClass:"container"},[e("v-uni-view",{staticClass:"tui-box"},[e("tui-list-cell",{attrs:{arrow:!0,unlined:!0,radius:!0},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.$Router.push({name:"address_index"})}}},[e("v-uni-view",{staticClass:"tui-address"},[t.addressData?e("v-uni-view",[e("v-uni-view",{staticClass:"tui-userinfo"},[e("v-uni-text",{staticClass:"tui-name"},[t._v(t._s(t.addressData.realname))]),t._v(t._s(t.addressData.mobile))],1),e("v-uni-view",{staticClass:"tui-addr"},[e("v-uni-text",[t._v(t._s(t.addressData.province)+t._s(t.addressData.city)+t._s(t.addressData.area)+" "+t._s(t.addressData.address))])],1)],1):e("v-uni-view",{staticClass:"tui-none-addr"},[e("v-uni-image",{staticClass:"tui-addr-img",attrs:{src:"http://appstore.bai918.com/static/app/images/index/map.png",mode:"widthFix"}}),e("v-uni-text",[t._v("选择收货地址")])],1)],1),e("v-uni-view",{staticClass:"tui-bg-img"})],1),t.goods[0]?e("v-uni-view",{staticClass:"tui-top tui-goods-info"},[e("tui-list-cell",{attrs:{hover:!1,lineLeft:!1}},[e("v-uni-view",{staticClass:"tui-goods-title"},[t._v("商品信息")])],1),t._l(t.goods[0]["goods"],(function(i,a){return[e("tui-list-cell",{key:a+"_0",attrs:{hover:!1,padding:"0"}},[e("v-uni-view",{staticClass:"tui-goods-item"},[e("v-uni-image",{staticClass:"tui-goods-img radius",attrs:{src:i.thumb}}),e("v-uni-view",{staticClass:"tui-goods-center flex justify-between",staticStyle:{"flex-direction":"column","padding-left":"20rpx"}},[e("v-uni-view",{staticClass:"tui-goods-name"},[t._v(t._s(i.title))]),e("v-uni-view",{staticClass:"tui-goods-attr"},[t._v(t._s(i.optiontitle))])],1),e("v-uni-view",{staticClass:"tui-price-right flex justify-between padding-bottom-sm",staticStyle:{"flex-direction":"column"}},[e("v-uni-view",{staticClass:"text-price text-red text-bold"},[t._v(t._s(i.marketprice))]),e("v-uni-view",{staticClass:"text-black"},[t._v("x"+t._s(i.total))])],1)],1)],1)]})),e("tui-list-cell",{attrs:{hover:!1}},[e("v-uni-view",{staticClass:"tui-padding tui-flex"},[e("v-uni-view",[t._v("商品总额")]),e("v-uni-view",{staticClass:"text-price text-red text-bold"},[t._v(t._s(t.listData.goodsprice))])],1)],1),e("tui-list-cell",{attrs:{arrow:t.hasCoupon,hover:t.hasCoupon}},[e("v-uni-view",{staticClass:"tui-padding tui-flex"},[e("v-uni-view",[t._v("优惠券")]),e("v-uni-view",{class:{"tui-color-red":t.hasCoupon}},[t._v(t._s(t.hasCoupon?"满0减0":"没有可用优惠券"))])],1)],1),e("tui-list-cell",{attrs:{hover:!1}},[e("v-uni-view",{staticClass:"tui-padding tui-flex"},[e("v-uni-view",[t._v("运费")]),e("v-uni-view",[t._v("￥"+t._s(t.listData.dispatch_price))])],1)],1),e("tui-list-cell",{attrs:{hover:!1,lineLeft:!1,padding:"0"}},[e("v-uni-view",{staticClass:"tui-remark-box tui-padding tui-flex"},[e("v-uni-view",[t._v("订单备注")]),e("v-uni-input",{staticClass:"tui-remark",attrs:{type:"text",placeholder:"选填: 请先和商家协商一致","placeholder-class":"tui-phcolor"},model:{value:t.remark,callback:function(i){t.remark=i},expression:"remark"}})],1)],1)],2):t._e(),e("v-uni-view",{staticClass:"tui-top"},[e("tui-list-cell",{attrs:{hover:!1,unlined:!0}},[e("v-uni-view",{staticClass:"tui-padding tui-flex tui-total-flex"},[e("v-uni-view",{staticClass:"tui-flex-end tui-color-red"},[e("v-uni-view",{staticClass:"text-black"},[t._v("合计：")]),e("v-uni-view",{staticClass:"tui-size-26"},[t._v("￥")]),e("v-uni-view",{staticClass:"tui-price-large"},[t._v(t._s((t.listData.realprice||"").toString().split(".")[0]||"00"))]),e("v-uni-view",{staticClass:"tui-size-26"},[t._v("."+t._s((t.listData.realprice||"").toString().split(".")[1]||"00"))])],1)],1)],1)],1)],1),e("v-uni-view",{staticClass:"tui-safe-area"}),e("v-uni-view",{staticClass:"tui-tabbar"},[e("v-uni-view",{staticClass:"tui-flex-end tui-color-red tui-pr-20"},[e("v-uni-view",{staticClass:"text-black"},[t._v("实付金额:")]),e("v-uni-view",{staticClass:"tui-size-26"},[t._v("￥")]),e("v-uni-view",{staticClass:"tui-price-large"},[t._v(t._s((t.listData.realprice||"").toString().split(".")[0]||"00"))]),e("v-uni-view",{staticClass:"tui-size-26"},[t._v("."+t._s((t.listData.realprice||"").toString().split(".")[1]||"00"))])],1),e("v-uni-view",{staticClass:"tui-pr25"},[e("tui-button",{attrs:{width:"200rpx",height:"70rpx",size:28,type:"danger",shape:"circle"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.submit.apply(void 0,arguments)}}},[t._v("提交订单")])],1)],1),t.payInfo?e("t-pay-way",{attrs:{payInfo:t.payInfo,show:t.show},on:{close:function(i){arguments[0]=i=t.$handleEvent(i),t.popupClose.apply(void 0,arguments)},payment:function(i){arguments[0]=i=t.$handleEvent(i),t.payment.apply(void 0,arguments)}}}):t._e(),e("u-modal",{attrs:{content:t.modalAction.content,"show-cancel-button":t.modalAction.cancel},on:{confirm:function(i){arguments[0]=i=t.$handleEvent(i),t.modalAction.confirmCallback(!0)}},model:{value:t.modalAction.status,callback:function(i){t.$set(t.modalAction,"status",i)},expression:"modalAction.status"}})],1)},s=[]}}]);