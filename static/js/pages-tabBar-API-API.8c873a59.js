(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-tabBar-API-API"],{"1baa":function(t,e,a){"use strict";a.r(e);var n=a("70de"),i=a("9e4f");for(var o in i)"default"!==o&&function(t){a.d(e,t,function(){return i[t]})}(o);a("f0a3");var r=a("2877"),s=Object(r["a"])(i["default"],n["a"],n["b"],!1,null,"f5cc20ee",null);e["default"]=s.exports},"2b00":function(t,e,a){"use strict";a.r(e);var n=a("6678"),i=a.n(n);for(var o in n)"default"!==o&&function(t){a.d(e,t,function(){return n[t]})}(o);e["default"]=i.a},"3c53":function(t,e,a){e=t.exports=a("2350")(!1),e.push([t.i,"uni-page-body[data-v-f5cc20ee]{min-height:100%;height:auto}\n\n/* 解决头条小程序字体图标不显示问题，因为头条运行时自动插入了span标签，且有全局字体 */\n.uni-icon[data-v-f5cc20ee]{font-family:uniicons;font-weight:400}.uni-container[data-v-f5cc20ee]{padding:15px;background-color:#f8f8f8}.uni-header-logo[data-v-f5cc20ee]{padding:15px 15px;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;margin-top:%?10?%}.uni-header-image[data-v-f5cc20ee]{width:80px;height:80px}.uni-hello-text[data-v-f5cc20ee]{margin-bottom:20px}.hello-text[data-v-f5cc20ee]{color:#7a7e83;font-size:14px;line-height:20px}.hello-link[data-v-f5cc20ee]{color:#7a7e83;font-size:14px;line-height:20px}.uni-panel[data-v-f5cc20ee]{margin-bottom:12px}.uni-panel-h[data-v-f5cc20ee]{background-color:#fff;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;padding:12px}\n/*\n.uni-panel-h:active {\n    background-color: #f8f8f8;\n}\n */.uni-panel-h-on[data-v-f5cc20ee]{background-color:#f0f0f0}.uni-panel-text[data-v-f5cc20ee]{-webkit-box-flex:1;-webkit-flex:1;-ms-flex:1;flex:1;color:#000;font-size:14px;font-weight:400}.uni-panel-icon[data-v-f5cc20ee]{margin-left:15px;color:#999;font-size:14px;font-weight:400;-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg);-webkit-transition-duration:0s;-o-transition-duration:0s;transition-duration:0s;-webkit-transition-property:-webkit-transform;transition-property:-webkit-transform;-o-transition-property:transform;transition-property:transform;transition-property:transform,-webkit-transform}.uni-panel-icon-on[data-v-f5cc20ee]{-webkit-transform:rotate(180deg);-ms-transform:rotate(180deg);transform:rotate(180deg)}.uni-navigate-item[data-v-f5cc20ee]{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;background-color:#fff;border-top-style:solid;border-top-color:#f0f0f0;border-top-width:1px;padding:12px}.uni-navigate-item[data-v-f5cc20ee]:active{background-color:#f8f8f8}.uni-navigate-text[data-v-f5cc20ee]{-webkit-box-flex:1;-webkit-flex:1;-ms-flex:1;flex:1;color:#000;font-size:14px;font-weight:400}.uni-navigate-icon[data-v-f5cc20ee]{margin-left:15px;color:#999;font-size:14px;font-weight:400}",""])},"49a0":function(t,e,a){var n=a("e323");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var i=a("4f06").default;i("85d34e6e",n,!0,{sourceMap:!1,shadowMode:!1})},6678:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n={data:function(){return{title:"tababr",hasSetTabBarBadge:!1,hasShownTabBarRedDot:!1,hasCustomedStyle:!1,hasCustomedItem:!1,hasHiddenTabBar:!1}},destroyed:function(){if(this.hasSetTabBarBadge&&uni.removeTabBarBadge({index:1}),this.hasShownTabBarRedDot&&uni.hideTabBarRedDot({index:1}),this.hasHiddenTabBar&&uni.showTabBar(),this.hasCustomedStyle&&uni.setTabBarStyle({color:"#7A7E83",selectedColor:"#007AFF",backgroundColor:"#F8F8F8",borderStyle:"black"}),this.hasCustomedItem){var t={index:1,text:"接口",iconPath:"/static/api.png",selectedIconPath:"/static/apiHL.png"};uni.setTabBarItem(t)}},methods:{navigateBack:function(){this.$emit("unmount")},setTabBarBadge:function(){this.hasShownTabBarRedDot&&(uni.hideTabBarRedDot({index:1}),this.hasShownTabBarRedDot=!this.hasShownTabBarRedDot),this.hasSetTabBarBadge?uni.removeTabBarBadge({index:1}):uni.setTabBarBadge({index:1,text:"1"}),this.hasSetTabBarBadge=!this.hasSetTabBarBadge},showTabBarRedDot:function(){this.hasSetTabBarBadge&&(uni.removeTabBarBadge({index:1}),this.hasSetTabBarBadge=!this.hasSetTabBarBadge),this.hasShownTabBarRedDot?uni.hideTabBarRedDot({index:1}):uni.showTabBarRedDot({index:1}),this.hasShownTabBarRedDot=!this.hasShownTabBarRedDot},hideTabBar:function(){this.hasHiddenTabBar?uni.showTabBar():uni.hideTabBar(),this.hasHiddenTabBar=!this.hasHiddenTabBar},customStyle:function(){this.hasCustomedStyle?uni.setTabBarStyle({color:"#7A7E83",selectedColor:"#007AFF",backgroundColor:"#F8F8F8",borderStyle:"black"}):uni.setTabBarStyle({color:"#FFF",selectedColor:"#007AFF",backgroundColor:"#000000",borderStyle:"black"}),this.hasCustomedStyle=!this.hasCustomedStyle},customItem:function(){var t={index:1,text:"接口",iconPath:"/static/api.png",selectedIconPath:"/static/apiHL.png"};this.hasCustomedItem?uni.setTabBarItem(t):(t.text="API",uni.setTabBarItem(t)),this.hasCustomedItem=!this.hasCustomedItem}}};e.default=n},"70de":function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",{staticClass:"uni-container"},[t.showSetTabBarPage?[a("set-tab-bar",{on:{unmount:function(e){e=t.$handleEvent(e),t.leaveSetTabBarPage(e)}}})]:[a("v-uni-view",{staticClass:"uni-header-logo"},[a("v-uni-image",{staticClass:"uni-header-image",attrs:{src:"/static/apiIndex.png"}})],1),a("v-uni-view",{staticClass:"uni-hello-text"},[a("v-uni-text",{staticClass:"hello-text"},[t._v("以下将演示uni-app接口能力，详细文档见：")]),a("u-link",{staticClass:"hello-link",attrs:{href:"https://uniapp.dcloud.io/api/",text:"https://uniapp.dcloud.io/api/",inWhiteList:!0}})],1),t._l(t.list,function(e,n){return a("v-uni-view",{key:e.id,staticClass:"uni-panel"},[a("v-uni-view",{staticClass:"uni-panel-h",class:e.open?"uni-panel-h-on":"",on:{click:function(e){e=t.$handleEvent(e),t.triggerCollapse(n)}}},[a("v-uni-text",{staticClass:"uni-panel-text"},[t._v(t._s(e.name))]),a("v-uni-text",{staticClass:"uni-panel-icon uni-icon",class:e.open?"uni-panel-icon-on":""},[t._v("")])],1),e.open?a("v-uni-view",{staticClass:"uni-panel-c"},t._l(e.pages,function(n,i){return a("v-uni-view",{key:i,staticClass:"uni-navigate-item",attrs:{url:e.url},on:{click:function(e){e=t.$handleEvent(e),t.goDetailPage(n.url)}}},[a("v-uni-text",{staticClass:"uni-navigate-text"},[t._v(t._s(n.name?n.name:n))]),a("v-uni-text",{staticClass:"uni-navigate-icon uni-icon"},[t._v("")])],1)}),1):t._e()],1)})]],2)},i=[];a.d(e,"a",function(){return n}),a.d(e,"b",function(){return i})},"8a41":function(t,e,a){"use strict";var n=a("49a0"),i=a.n(n);i.a},9741:function(t,e,a){"use strict";var n=a("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i=n(a("8ea0")),o=n(a("d315")),r={components:{uLink:i.default,setTabBar:o.default},data:function(){var t=[{name:"图片",url:"image"},{name:"视频",url:"video"}],e=[{id:"page",name:"界面",open:!1,pages:[{name:"设置导航条",url:"set-navigation-bar-title"},{name:"页面跳转",url:"navigator"},{name:"设置TabBar",url:"set-tabbar"},{name:"下拉刷新",url:"pull-down-refresh"},{name:"创建动画",url:"animation"},{name:"创建绘画",url:"canvas"},{name:"节点信息",url:"get-node-info"},{name:"节点布局交互状态",url:"intersection-observer"},{name:"显示操作菜单",url:"action-sheet"},{name:"显示模态弹窗",url:"modal"},{name:"显示加载提示框",url:"show-loading"},{name:"显示消息提示框",url:"toast"}]},{id:"device",name:"设备",open:!1,pages:[{name:"获取手机网络状态",url:"get-network-type"},{name:"获取手机系统信息",url:"get-system-info"},{name:"打电话",url:"make-phone-call"},{name:"监听加速度传感器",url:"on-accelerometer-change"},{name:"监听罗盘数据",url:"on-compass-change"}]},{id:"network",name:"网络",open:!1,pages:[{name:"发起一个请求",url:"request"},{name:"上传文件",url:"upload-file"},{name:"下载文件",url:"download-file"}]},{id:"media",name:"媒体",open:!1,pages:t},{id:"location",name:"位置",open:!1,pages:[{name:"获取当前位置",url:"get-location"},{name:"使用地图查看位置",url:"open-location"},{name:"使用地图选择位置",url:"choose-location"},{name:"地图控制",url:"map"}]},{id:"storage",name:"数据",open:!1,pages:[{name:"数据存储（key-value）",url:"storage"}]}];return{showSetTabBarPage:!1,list:e,navigateFlag:!1}},onShareAppMessage:function(){return{title:"欢迎体验uni-app",path:"/pages/tabBar/API/API"}},onNavigationBarButtonTap:function(t){uni.navigateTo({url:"/pages/about/about"})},onLoad:function(){},onReady:function(){},onShow:function(){this.navigateFlag=!1,this.leaveSetTabBarPage()},onHide:function(){this.leaveSetTabBarPage()},methods:{triggerCollapse:function(t){if(this.list[t].pages)for(var e=0;e<this.list.length;++e)this.list[e].open=t===e&&!this.list[t].open;else this.goDetailPage(this.list[t].url)},goDetailPage:function(t){if(!this.navigateFlag)if(this.navigateFlag=!0,"set-tabbar"!==t){var e=~t.indexOf("platform")?t:"/pages/API/"+t+"/"+t;uni.navigateTo({url:e})}else this.showSetTabBarPage=!0},leaveSetTabBarPage:function(){var t=this;setTimeout(function(){t.navigateFlag=!1},200),this.showSetTabBarPage=!1}}};e.default=r},"9e4f":function(t,e,a){"use strict";a.r(e);var n=a("9741"),i=a.n(n);for(var o in n)"default"!==o&&function(t){a.d(e,t,function(){return n[t]})}(o);e["default"]=i.a},a81a:function(t,e,a){var n=a("3c53");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var i=a("4f06").default;i("a4b26a52",n,!0,{sourceMap:!1,shadowMode:!1})},d315:function(t,e,a){"use strict";a.r(e);var n=a("f124"),i=a("2b00");for(var o in i)"default"!==o&&function(t){a.d(e,t,function(){return i[t]})}(o);a("8a41");var r=a("2877"),s=Object(r["a"])(i["default"],n["a"],n["b"],!1,null,"0a7af484",null);e["default"]=s.exports},e323:function(t,e,a){e=t.exports=a("2350")(!1),e.push([t.i,".button[data-v-0a7af484]{margin-top:%?30?%;margin-left:0;margin-right:0}.btn-area[data-v-0a7af484]{padding-top:%?30?%}",""])},f0a3:function(t,e,a){"use strict";var n=a("a81a"),i=a.n(n);i.a},f124:function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-uni-view",{staticClass:"uni-padding-wrap"},[a("page-head",{attrs:{title:t.title}}),a("v-uni-button",{staticClass:"button",on:{click:function(e){e=t.$handleEvent(e),t.setTabBarBadge(e)}}},[t._v(t._s(t.hasSetTabBarBadge?"移除tab徽标":"设置tab徽标"))]),a("v-uni-button",{staticClass:"button",on:{click:function(e){e=t.$handleEvent(e),t.showTabBarRedDot(e)}}},[t._v(t._s(t.hasShownTabBarRedDot?"移除红点":"显示红点"))]),a("v-uni-button",{staticClass:"button",on:{click:function(e){e=t.$handleEvent(e),t.customStyle(e)}}},[t._v(t._s(t.hasCustomedStyle?"移除自定义样式":"自定义Tab样式"))]),a("v-uni-button",{staticClass:"button",on:{click:function(e){e=t.$handleEvent(e),t.customItem(e)}}},[t._v(t._s(t.hasCustomedItem?"移除自定义信息":"自定义Tab信息"))]),a("v-uni-button",{staticClass:"button",on:{click:function(e){e=t.$handleEvent(e),t.hideTabBar(e)}}},[t._v(t._s(t.hasHiddenTabBar?"显示TabBar":"隐藏TabBar"))]),a("v-uni-view",{staticClass:"btn-area"},[a("v-uni-button",{staticClass:"button",attrs:{type:"primary"},on:{click:function(e){e=t.$handleEvent(e),t.navigateBack(e)}}},[t._v("返回上一级")])],1)],1)},i=[];a.d(e,"a",function(){return n}),a.d(e,"b",function(){return i})}}]);