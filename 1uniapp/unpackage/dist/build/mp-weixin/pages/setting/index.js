(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages/setting/index"],{4052:function(t,e,n){"use strict";n.d(e,"b",(function(){return o})),n.d(e,"c",(function(){return i})),n.d(e,"a",(function(){return r}));var r={tuiListCell:function(){return n.e("components/thorui/tui-list-cell/tui-list-cell").then(n.bind(null,"d016"))},tuiButton:function(){return n.e("components/thorui/tui-button/tui-button").then(n.bind(null,"7133"))},uModal:function(){return n.e("node-modules/uview-ui/components/u-modal/u-modal").then(n.bind(null,"5a91"))}},o=function(){var t=this,e=t.$createElement;t._self._c;t._isMounted||(t.e0=function(e){return t.$Router.push({name:"member_info"})},t.e1=function(e){return t.$Router.push({name:"address_index"})},t.e2=function(e){return t.$Router.push({name:"setting_security"})},t.e3=function(e){return t.modalAction.confirmCallback(!0)})},i=[]},"78a6":function(t,e,n){"use strict";n.r(e);var r=n("4052"),o=n("83ec");for(var i in o)"default"!==i&&function(t){n.d(e,t,(function(){return o[t]}))}(i);n("bcc8");var u,a=n("f0c5"),c=Object(a["a"])(o["default"],r["b"],r["c"],!1,null,null,null,!1,r["a"],u);e["default"]=c.exports},"83ec":function(t,e,n){"use strict";n.r(e);var r=n("e057"),o=n.n(r);for(var i in r)"default"!==i&&function(t){n.d(e,t,(function(){return r[t]}))}(i);e["default"]=o.a},b4ae:function(t,e,n){"use strict";(function(t){n("57ba");r(n("66fd"));var e=r(n("78a6"));function r(t){return t&&t.__esModule?t:{default:t}}t(e.default)}).call(this,n("543d")["createPage"])},bcc8:function(t,e,n){"use strict";var r=n("bf00"),o=n.n(r);o.a},bf00:function(t,e,n){},e057:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var r=n("2f62");function o(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function i(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?o(Object(n),!0).forEach((function(e){u(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):o(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function u(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var a={data:function(){return{}},computed:i(i({},(0,r.mapState)(["modalAction"])),(0,r.mapGetters)(["hasLogin","userInfo","version"])),onLoad:function(){this.hasLogin&&this.getList()},methods:i(i({},(0,r.mapMutations)(["logout"])),{},{getList:function(){var t=this;this.$http.get("member.info").then((function(e){t.updateUserInfo(e)}))},checkAuth:function(){},updateUserInfo:function(t){t.nickname&&this.$store.commit("updateUserInfo",{nickname:t.nickname}),t.avatar&&this.$store.commit("updateUserInfo",{avatar:t.avatar}),t.realname&&this.$store.commit("updateUserInfo",{realname:t.realname}),t.mobile&&this.$store.commit("updateUserInfo",{mobile:t.mobile}),t.weixin&&this.$store.commit("updateUserInfo",{weixin:t.weixin})},clearCache:function(){var t=this;this.$utils.modal.confirm("确认清除缓存？").then((function(e){t.$store.commit("clearCache"),setTimeout((function(){t.$utils.modal.alert("清除缓存成功")}),300)}))},switchChange:function(t){var e=t.detail.value?"打开":"关闭";this.$api.msg("".concat(e,"消息推送"))}})};e.default=a}},[["b4ae","common/runtime","common/vendor"]]]);