(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-API-get-user-info-get-user-info"],{"04f9":function(n,e,t){"use strict";t.r(e);var i=t("5bf9"),s=t.n(i);for(var o in i)"default"!==o&&function(n){t.d(e,n,function(){return i[n]})}(o);e["default"]=s.a},"075a":function(n,e,t){"use strict";t.r(e);var i=t("ad67"),s=t("04f9");for(var o in s)"default"!==o&&function(n){t.d(e,n,function(){return s[n]})}(o);t("38eb");var a=t("2877"),r=Object(a["a"])(s["default"],i["a"],i["b"],!1,null,"0a7b1c41",null);e["default"]=r.exports},"38eb":function(n,e,t){"use strict";var i=t("4786"),s=t.n(i);s.a},4786:function(n,e,t){var i=t("4940");"string"===typeof i&&(i=[[n.i,i,""]]),i.locals&&(n.exports=i.locals);var s=t("4f06").default;s("6ab918a4",i,!0,{sourceMap:!1,shadowMode:!1})},4940:function(n,e,t){e=n.exports=t("2350")(!1),e.push([n.i,".userinfo-avatar[data-v-0a7b1c41]{border-radius:%?128?%;width:%?128?%;height:%?128?%}",""])},"5bf9":function(n,e,t){"use strict";var i=t("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var s=i(t("cebc")),o=t("2f62"),a={data:function(){return{title:"getUserInfo",hasUserInfo:!1,userInfo:{}}},computed:(0,s.default)({},(0,o.mapState)({loginProvider:function(n){return n.loginProvider}})),methods:{getUserInfo:function(){var n=this;uni.getUserInfo({provider:this.loginProvider,success:function(e){console.log("getUserInfo success",e),n.hasUserInfo=!0,n.userInfo=e.userInfo},fail:function(n){console.log("getUserInfo fail",n);var e=n.errMsg;~e.indexOf("uni.login")&&(e="请在登录页面完成登录操作"),uni.getSetting({success:function(n){var t=n.authSetting["scope.userInfo"];t?uni.showModal({title:"获取用户信息失败",content:"错误原因"+e,showCancel:!1}):uni.showModal({title:"授权失败",content:"Hello uni-app需要获取您的用户信息，请在设置界面打开相关权限",success:function(n){n.confirm&&uni.openSetting()}})}})}})},mpGetUserInfo:function(n){console.log("mpGetUserInfo",n),"getUserInfo:ok"===n.detail.errMsg?(this.hasUserInfo=!0,this.userInfo=n.detail.userInfo):uni.showModal({title:"获取用户信息失败",content:"错误原因"+n.detail.errMsg,showCancel:!1})},clear:function(){this.hasUserInfo=!1,this.userInfo={}}}};e.default=a},ad67:function(n,e,t){"use strict";var i=function(){var n=this,e=n.$createElement,t=n._self._c||e;return t("v-uni-view",[t("page-head",{attrs:{title:n.title}}),t("v-uni-view",{staticClass:"uni-padding-wrap"},[t("v-uni-view",{staticStyle:{background:"#FFF",padding:"40upx"}},[!1===n.hasUserInfo?[t("v-uni-view",{staticClass:"uni-hello-text uni-center"},[t("v-uni-text",[n._v("请点击下方按钮获取用户头像及昵称")])],1)]:n._e(),!0===n.hasUserInfo?[t("v-uni-view",{staticClass:"uni-h4 uni-center uni-common-mt"},[n._v(n._s(n.userInfo.nickName))]),t("v-uni-view",{staticStyle:{padding:"30upx 0","text-align":"center"}},[t("v-uni-image",{staticClass:"userinfo-avatar",attrs:{src:n.userInfo.avatarUrl}})],1)]:n._e()],2),t("v-uni-view",{staticClass:"uni-btn-v"},[t("v-uni-button",{on:{click:function(e){e=n.$handleEvent(e),n.clear(e)}}},[n._v("清空")])],1)],1)],1)},s=[];t.d(e,"a",function(){return i}),t.d(e,"b",function(){return s})}}]);