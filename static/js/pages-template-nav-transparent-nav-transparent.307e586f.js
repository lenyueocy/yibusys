(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-template-nav-transparent-nav-transparent"],{"08db":function(i,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n={data:function(){return{showSwiper:!1,imgUrls:["../../../static/shuijiao.jpg","https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/muwu.jpg","https://img-cdn-qiniu.dcloud.net.cn/uniapp/images/cbd.jpg"],items:[{value:"img",name:"静态图",checked:!0},{value:"swiper",name:"轮播图",checked:!1}]}},methods:{radioChange:function(i){this.showSwiper="swiper"===i.detail.value}}};t.default=n},"22d1":function(i,t,e){"use strict";e.r(t);var n=e("08db"),a=e.n(n);for(var u in n)"default"!==u&&function(i){e.d(t,i,function(){return n[i]})}(u);t["default"]=a.a},3536:function(i,t,e){"use strict";e.r(t);var n=e("af82"),a=e("22d1");for(var u in a)"default"!==u&&function(i){e.d(t,i,function(){return a[i]})}(u);e("bda6");var s=e("2877"),r=Object(s["a"])(a["default"],n["a"],n["b"],!1,null,"178be6b5",null);t["default"]=r.exports},af82:function(i,t,e){"use strict";var n=function(){var i=this,t=i.$createElement,e=i._self._c||t;return e("v-uni-view",{staticClass:"page"},[i.showSwiper?i._e():e("v-uni-view",{staticClass:"img-view"},[e("v-uni-image",{attrs:{src:i.imgUrls[0]}})],1),i.showSwiper?e("v-uni-swiper",{attrs:{"indicator-dots":"true"}},i._l(i.imgUrls,function(i,t){return e("v-uni-swiper-item",{key:t},[e("v-uni-image",{attrs:{src:i}})],1)}),1):i._e(),e("v-uni-view",{staticClass:"uni-padding-wrap uni-common-mt"},[e("v-uni-view",{staticClass:"uni-title"},[e("v-uni-view",[i._v("在App端默认为标题栏透明，当用户向下滚动时，标题栏逐渐由透明转变为不透明；当用户再次向上滚动时，标题栏又从不透明变为透明状态。")]),e("v-uni-view",[i._v("在微信小程序端，导航栏始终为不透明样式。")])],1),e("v-uni-view",{staticClass:"uni-title uni-common-mt"},[i._v("图片类型")])],1),e("v-uni-view",{staticClass:"uni-list"},[e("v-uni-radio-group",{on:{change:function(t){t=i.$handleEvent(t),i.radioChange(t)}}},i._l(i.items,function(t,n){return e("v-uni-label",{key:n,staticClass:"uni-list-cell uni-list-cell-pd"},[e("v-uni-view",[i._v(i._s(t.name))]),e("v-uni-view",[e("v-uni-radio",{attrs:{value:t.value,checked:t.checked}})],1)],1)}),1)],1),e("v-uni-view",{staticStyle:{height:"1000upx"}})],1)},a=[];e.d(t,"a",function(){return n}),e.d(t,"b",function(){return a})},bda6:function(i,t,e){"use strict";var n=e("c8c4"),a=e.n(n);a.a},bf79:function(i,t,e){t=i.exports=e("2350")(!1),t.push([i.i,".img-view[data-v-178be6b5],uni-image[data-v-178be6b5],uni-swiper[data-v-178be6b5]{width:%?750?%;height:%?500?%}.page-section-title[data-v-178be6b5]{margin-top:%?50?%}",""])},c8c4:function(i,t,e){var n=e("bf79");"string"===typeof n&&(n=[[i.i,n,""]]),n.locals&&(i.exports=n.locals);var a=e("4f06").default;a("03f15700",n,!0,{sourceMap:!1,shadowMode:!1})}}]);