(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages/member/wallet/integral"],{"50e4":function(t,e,n){"use strict";(function(t){n("57ba");a(n("66fd"));var e=a(n("676b"));function a(t){return t&&t.__esModule?t:{default:t}}t(e.default)}).call(this,n("543d")["createPage"])},6122:function(t,e,n){"use strict";n.r(e);var a=n("6e2d"),u=n.n(a);for(var r in a)"default"!==r&&function(t){n.d(e,t,(function(){return a[t]}))}(r);e["default"]=u.a},"676b":function(t,e,n){"use strict";n.r(e);var a=n("a72b"),u=n("6122");for(var r in u)"default"!==r&&function(t){n.d(e,t,(function(){return u[t]}))}(r);n("74e1");var i,o=n("f0c5"),c=Object(o["a"])(u["default"],a["b"],a["c"],!1,null,null,null,!1,a["a"],i);e["default"]=c.exports},"6e2d":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a={data:function(){return{data:""}},onLoad:function(){this.getList()},onShow:function(){this.getList()},methods:{getList:function(){var t=this;this.$http.get("member.get_wallet_integral").then((function(e){t.data=e.data}))},actionRelease:function(){var t=this;this.$http.get("member.release").then((function(e){t.$utils.toast("释放成功"),t.getList()}))}}};e.default=a},"74e1":function(t,e,n){"use strict";var a=n("e958"),u=n.n(a);u.a},a72b:function(t,e,n){"use strict";var a;n.d(e,"b",(function(){return u})),n.d(e,"c",(function(){return r})),n.d(e,"a",(function(){return a}));var u=function(){var t=this,e=t.$createElement;t._self._c;t._isMounted||(t.e0=function(e){return t.$Router.push({name:"member_record_wallet_integral"})})},r=[]},e958:function(t,e,n){}},[["50e4","common/runtime","common/vendor"]]]);