(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-category-index"],{1088:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'uni-page-body[data-v-a2a15ccc]{background:#f5f5f5}\n\n\t/* 左侧导航布局 start*/\n\n\t/* 隐藏scroll-view滚动条*/[data-v-a2a15ccc]::-webkit-scrollbar{width:0;height:0;color:transparent}.tui-searchbox[data-v-a2a15ccc]{width:100%;height:%?92?%;padding:0 %?30?%;box-sizing:border-box;background:#fff;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;position:fixed;left:0;top:0;\ntop:44px;\nz-index:100}.tui-searchbox[data-v-a2a15ccc]::after{content:"";position:absolute;border-bottom:%?1?% solid #d2d2d2;-webkit-transform:scaleY(.5);transform:scaleY(.5);bottom:0;right:0;left:0}.tui-search-input[data-v-a2a15ccc]{width:100%;height:%?60?%;background:#f1f1f1;border-radius:%?30?%;font-size:%?26?%;color:#999;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.tui-search-text[data-v-a2a15ccc]{padding-left:%?16?%}.tab-view[data-v-a2a15ccc]{\n\t\t/* height: 100%; */width:%?200?%;position:fixed;left:0;z-index:10}.tab-bar-item[data-v-a2a15ccc]{width:%?200?%;height:%?110?%;box-sizing:border-box;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;font-size:%?26?%;color:#7c7b7b;font-weight:400}.active[data-v-a2a15ccc]{position:relative;color:#e01d20;font-size:%?30?%;font-weight:400;background:#f5f5f5}.active[data-v-a2a15ccc]::before{content:"";position:absolute;border-left:%?8?% solid #e01d20;height:%?30?%;left:0}\n\n\t/* 左侧导航布局 end*/.right-box[data-v-a2a15ccc]{width:100%;position:fixed;padding-left:%?220?%;box-sizing:border-box;left:0}.page-view[data-v-a2a15ccc]{width:100%;overflow:hidden;padding-top:%?20?%;padding-right:%?20?%;box-sizing:border-box;padding-bottom:env(safe-area-inset-bottom)}.swiper[data-v-a2a15ccc]{width:100%;height:%?220?%;\n\t\t/*border-radius: 12rpx;*/overflow:hidden;-webkit-transform:translateZ(0);transform:translateZ(0)}\n[data-v-a2a15ccc] .swiper .uni-swiper-dot{width:%?8?%;height:%?8?%;display:-webkit-inline-box;display:-webkit-inline-flex;display:inline-flex;background:none;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}[data-v-a2a15ccc] .swiper .uni-swiper-dot::before{content:"";-webkit-box-flex:1;-webkit-flex-grow:1;flex-grow:1;background:hsla(0,0%,100%,.8);border-radius:%?16?%;overflow:hidden}[data-v-a2a15ccc] .swiper .uni-swiper-dot-active::before{background:#fff}[data-v-a2a15ccc] .swiper .uni-swiper-dot.uni-swiper-dot-active{width:%?16?%}\n.slide-image[data-v-a2a15ccc]{width:100%;height:%?220?%}.class-item[data-v-a2a15ccc]{width:100%;box-sizing:border-box;padding:%?20?%;margin-bottom:%?20?%;border-radius:%?12?%}.class-name[data-v-a2a15ccc]{font-size:%?22?%}.g-container[data-v-a2a15ccc]{\n\t\t/* padding-top: 20rpx; */display:-webkit-box;display:flex;display:-webkit-flex;-webkit-box-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-flex-wrap:wrap;flex-wrap:wrap}.g-box[data-v-a2a15ccc]{width:33.3333%;text-align:center;padding-top:%?40?%}.g-image[data-v-a2a15ccc]{width:%?120?%;height:%?120?%}.g-title[data-v-a2a15ccc]{color:#2e2e2e;font-size:%?22?%;word-break:break-all;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2}.sale-price[data-v-a2a15ccc]{font-size:%?24?%;font-weight:500;color:#ea1500}body.?%PAGE?%[data-v-a2a15ccc]{background:#f5f5f5}',""]),t.exports=e},"254a":function(t,e,i){"use strict";i.r(e);var a=i("c48c"),n=i("78a8");for(var c in n)"default"!==c&&function(t){i.d(e,t,(function(){return n[t]}))}(c);i("5131");var o,s=i("f0c5"),r=Object(s["a"])(n["default"],a["b"],a["c"],!1,null,"a2a15ccc",null,!1,a["a"],o);e["default"]=r.exports},"2e81":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a={data:function(){return{tabbar:[],dataList:[],height:0,top:0,currentTab:0,scrollViewId:"id_0"}},onLoad:function(t){this.setTop(),this.getList()},methods:{getList:function(){var t=this;this.$http.get("shop.get_category",{}).then((function(e){t.dataList=e.category}))},setTop:function(){var t=this;uni.getSystemInfo({success:function(e){var i=92,a=0;a=44,t.height=e.windowHeight-uni.upx2px(i),t.top=a+uni.upx2px(i)}})},swichNav:function(t){var e=t.currentTarget.dataset.current;if(this.currentTab==e)return!1;this.currentTab=e,this.checkCor()},checkCor:function(){this.currentTab>6?this.scrollViewId="id_".concat(this.currentTab-2):this.scrollViewId="id_0"},detail:function(t){uni.navigateTo({url:"../productDetail/productDetail"})},productList:function(t){var e=t.currentTarget.dataset.key;uni.navigateTo({url:"../productList/productList?searchKey="+e})},search:function(){uni.navigateTo({url:"../../news/search/search"})}}};e.default=a},5131:function(t,e,i){"use strict";var a=i("614f"),n=i.n(a);n.a},"614f":function(t,e,i){var a=i("1088");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("1ff069be",a,!0,{sourceMap:!1,shadowMode:!1})},"78a8":function(t,e,i){"use strict";i.r(e);var a=i("2e81"),n=i.n(a);for(var c in a)"default"!==c&&function(t){i.d(e,t,(function(){return a[t]}))}(c);e["default"]=n.a},c48c:function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return c})),i.d(e,"a",(function(){return a}));var a={tuiIcon:i("5d29").default},n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"container"},[i("v-uni-view",{staticClass:"tui-searchbox"},[i("v-uni-view",{staticClass:"tui-search-input",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.$Router.push({name:"index_search"})}}},[i("v-uni-icon",{attrs:{type:"search",size:13,color:"#999"}}),i("v-uni-text",{staticClass:"tui-search-text"},[t._v("搜索商品")])],1)],1),i("v-uni-scroll-view",{staticClass:"tab-view",style:{height:t.height+"px",top:t.top+"px"},attrs:{"scroll-y":!0,"scroll-with-animation":!0,"scroll-into-view":t.scrollViewId}},t._l(t.dataList,(function(e,a){return i("v-uni-view",{key:a,staticClass:"tab-bar-item bg-white",class:[t.currentTab==a?"active":""],attrs:{id:"id_"+a,"data-current":a},on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.swichNav.apply(void 0,arguments)}}},[i("v-uni-text",[t._v(t._s(e.name))])],1)})),1),t._l(t.dataList,(function(e,a){return[t.currentTab==a?i("v-uni-scroll-view",{key:a+"_0",staticClass:"right-box",style:{height:t.height+"px",top:t.top+"px"},attrs:{"scroll-y":!0}},[i("v-uni-view",{staticClass:"page-view"},[e.advimg?i("v-uni-swiper",{staticClass:"swiper margin-bottom-sml",attrs:{"indicator-dots":!0,autoplay:!0,circular:!0,interval:5e3,duration:150}},[i("v-uni-swiper-item",{on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.$Router.push({path:e.advurl})}}},[i("v-uni-image",{staticClass:"slide-image",attrs:{src:e.advimg}})],1)],1):t._e(),i("v-uni-view",{staticClass:"class-box"},[i("v-uni-view",{staticClass:"class-item bg-white"},[i("v-uni-view",{staticClass:"class-name"},[t._v(t._s(e.name))]),e.goods&&e.goods.length>0?i("v-uni-view",{staticClass:"g-container"},t._l(e.goods,(function(e,a){return i("v-uni-view",{staticClass:"g-box",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.$Router.push({name:"goods_detail",params:{id:e.id}})}}},[i("v-uni-image",{staticClass:"g-image border-10",attrs:{src:e.thumb}}),i("v-uni-view",{staticClass:"g-title"},[t._v(t._s(e.title))]),i("v-uni-view",{staticClass:"sale-price text-center"},[t._v("￥"+t._s(e.marketprice))])],1)})),1):i("v-uni-view",{staticClass:"text-gray text-sm padding-lg text-center"},[i("tui-icon",{attrs:{name:"nodata",size:40}}),i("v-uni-view",{staticClass:"margin-top-xs"},[t._v("无更多商品")])],1),i("v-uni-view",{staticClass:"flex align-center justify-center padding-top-sm",staticStyle:{color:"#4a4a4a"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.$Router.push({name:"goods_list",params:{cate_id:e.id}})}}},[i("v-uni-view",{staticClass:"text-sml"},[t._v("发现更多"+t._s(e.name))]),i("tui-icon",{attrs:{name:"arrowright",size:26}})],1)],1)],1)],1)],1):t._e()]}))],2)},c=[]}}]);