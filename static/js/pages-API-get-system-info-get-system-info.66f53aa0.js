(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-API-get-system-info-get-system-info"],{"00b5":function(t,i,s){i=t.exports=s("2350")(!1),i.push([t.i,".uni-pd[data-v-25d435a1]{padding-left:%?30?%}",""])},"0258":function(t,i,s){var e=s("00b5");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var a=s("4f06").default;a("3f31bade",e,!0,{sourceMap:!1,shadowMode:!1})},"083a":function(t,i,s){"use strict";Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var e={data:function(){return{title:"getSystemInfo",systemInfo:{}}},onUnload:function(){this.systemInfo={}},methods:{getSystemInfo:function(){var t=this;uni.getSystemInfo({success:function(i){t.systemInfo=i}})}}};i.default=e},"334d":function(t,i,s){"use strict";s.r(i);var e=s("8df3"),a=s("ab67");for(var l in a)"default"!==l&&function(t){s.d(i,t,function(){return a[t]})}(l);s("f878");var n=s("2877"),u=Object(n["a"])(a["default"],e["a"],e["b"],!1,null,"25d435a1",null);i["default"]=u.exports},"8df3":function(t,i,s){"use strict";var e=function(){var t=this,i=t.$createElement,s=t._self._c||i;return s("v-uni-view",[s("page-head",{attrs:{title:t.title}}),s("v-uni-view",{staticClass:"uni-common-mt"},[s("v-uni-view",{staticClass:"uni-list"},[s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("手机型号")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.model}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("客户端平台")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.platform}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("操作系统版本")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.system}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("语言")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.language}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("版本")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.version}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("屏幕宽度")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.screenWidth}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("屏幕高度")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.screenHeight}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("可使用窗口高度")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.windowHeight}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("可使用窗口的顶部位置")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.windowTop}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("可使用窗口的底部位置")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.windowBottom}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("状态栏的高度")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.statusBarHeight}})],1)],1),s("v-uni-view",{staticClass:"uni-list-cell"},[s("v-uni-view",{staticClass:"uni-pd"},[s("v-uni-view",{staticClass:"uni-label",staticStyle:{width:"180px"}},[t._v("DPI")])],1),s("v-uni-view",{staticClass:"uni-list-cell-db"},[s("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",disabled:!0,placeholder:"未获取",value:t.systemInfo.pixelRatio}})],1)],1)],1),s("v-uni-view",{staticClass:"uni-padding-wrap"},[s("v-uni-view",{staticClass:"uni-btn-v"},[s("v-uni-button",{attrs:{type:"primary"},on:{click:function(i){i=t.$handleEvent(i),t.getSystemInfo(i)}}},[t._v("获取手机系统信息")])],1)],1)],1)],1)},a=[];s.d(i,"a",function(){return e}),s.d(i,"b",function(){return a})},ab67:function(t,i,s){"use strict";s.r(i);var e=s("083a"),a=s.n(e);for(var l in e)"default"!==l&&function(t){s.d(i,t,function(){return e[t]})}(l);i["default"]=a.a},f878:function(t,i,s){"use strict";var e=s("0258"),a=s.n(e);a.a}}]);