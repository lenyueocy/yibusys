(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-extUI-swipe-action-swipe-action"],{"0a5c":function(t,e,i){var n=i("726f");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var o=i("4f06").default;o("7f96d571",n,!0,{sourceMap:!1,shadowMode:!1})},1682:function(t,e,i){"use strict";i.r(e);var n=i("ace0"),o=i("9778");for(var s in o)"default"!==s&&function(t){i.d(e,t,function(){return o[t]})}(s);i("4489");var a=i("2877"),c=i("c8eb"),r=Object(a["a"])(o["default"],n["a"],n["b"],!1,null,"0250da48",null);"function"===typeof c["a"]&&Object(c["a"])(r),e["default"]=r.exports},"2adc":function(t,e,i){e=t.exports=i("2350")(!1),e.push([t.i,'uni-page-body[data-v-98fb662e]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;-webkit-box-sizing:border-box;box-sizing:border-box;background-color:#efeff4}uni-view[data-v-98fb662e]{font-size:%?28?%;line-height:inherit}.example[data-v-98fb662e]{padding:0 %?30?% %?30?%}.example-title[data-v-98fb662e]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;font-size:%?32?%;color:#464e52;padding:%?30?% %?30?% %?30?% %?50?%;margin-top:%?20?%;position:relative;background-color:#fdfdfd;border-bottom:1px #f5f5f5 solid}.example-title__after[data-v-98fb662e]{position:relative;color:#031e3c}.example-title[data-v-98fb662e]:after{content:"";position:absolute;left:%?30?%;margin:auto;top:0;bottom:0;width:%?6?%;height:%?32?%;background-color:#ccc}.example .example-title[data-v-98fb662e]{margin:%?40?% 0}.example-body[data-v-98fb662e]{padding:%?30?%;background:#fff}.example-info[data-v-98fb662e]{padding:%?30?%;color:#3b4144;background:#fff}.cont[data-v-98fb662e]{height:%?90?%;line-height:%?90?%;padding:0 %?30?%;position:relative;background:#fff}.cont[data-v-98fb662e]:before{position:absolute;z-index:3;left:0;right:0;top:0;height:1px;content:"";-webkit-transform:scaleY(.5);-ms-transform:scaleY(.5);transform:scaleY(.5);background-color:$uni-border-color}.cont[data-v-98fb662e]:after{position:absolute;z-index:3;left:0;right:0;bottom:0;height:1px;content:"";-webkit-transform:scaleY(.5);-ms-transform:scaleY(.5);transform:scaleY(.5);background-color:$uni-border-color}.example-body[data-v-98fb662e]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;padding:%?20?% 0}\n\n/* .button-view {\n\tdisplay: flex;\n\tflex-direction: row;\n\tjustify-content: center;\n\tpadding: 20upx 0;\n\tbackground: #fff;\n} */.button[data-v-98fb662e]{border:1px solid #e7e7e7;padding:%?8?% %?16?%;border-radius:%?8?%}body.?%PAGE?%[data-v-98fb662e]{background-color:#efeff4}',""])},4489:function(t,e,i){"use strict";var n=i("0a5c"),o=i.n(n);o.a},"5a3b":function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("v-uni-view",{staticClass:"example-title"},[t._v("基本用法")]),i("uni-swipe-action",{attrs:{options:t.options2},on:{click:function(e){e=t.$handleEvent(e),t.bindClick(e)}}},[i("v-uni-view",{staticClass:"cont"},[t._v("SwipeAction 基础使用场景")])],1),i("v-uni-view",{staticClass:"example-title"},[t._v("禁止滑动")]),i("uni-swipe-action",{attrs:{disabled:!0}},[i("v-uni-view",{staticClass:"cont"},[t._v("SwipeAction 禁止滑动展示")])],1),i("v-uni-view",{staticClass:"example-title"},[t._v("使用变量控制开关")]),i("v-uni-view",{staticClass:"example-body"},[i("v-uni-view",{staticClass:"button",on:{click:function(e){e=t.$handleEvent(e),t.setOpened(e)}}},[t._v("当前状态："+t._s(t.isOpened?"开":"关"))])],1),i("uni-swipe-action",{attrs:{options:t.options2,show:t.isOpened,"auto-close":!1},on:{change:function(e){e=t.$handleEvent(e),t.change(e)}}},[i("v-uni-view",{staticClass:"cont"},[t._v("使用变量控制SwipeAction的开启状态")])],1),i("v-uni-view",{staticClass:"example-title"},[t._v("与 List 组件一起使用")]),i("uni-list",[i("uni-swipe-action",{attrs:{options:t.options1}},[i("uni-list-item",{attrs:{"show-arrow":!1,title:"item1"}})],1),i("uni-swipe-action",{attrs:{options:t.options2}},[i("uni-list-item",{attrs:{"show-arrow":!1,title:"item2"}})],1),i("uni-swipe-action",{attrs:{options:t.options3}},[i("uni-list-item",{attrs:{"show-arrow":!1,title:"item3"}})],1)],1)],1)},o=[];i.d(e,"a",function(){return n}),i.d(e,"b",function(){return o})},"726f":function(t,e,i){e=t.exports=i("2350")(!1),e.push([t.i,".uni-swipe_content[data-v-0250da48]{position:relative;width:100%;-webkit-box-sizing:border-box;box-sizing:border-box;overflow:hidden}.uni-swipe_move-box[data-v-0250da48]{position:relative;z-index:1;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;width:100%}.uni-swipe_box[data-v-0250da48]{-webkit-flex-shrink:0;-ms-flex-negative:0;flex-shrink:0;width:100%;font-size:14px;color:#333;-webkit-box-sizing:border-box;box-sizing:border-box;background:#fff;z-index:1}.uni-swipe_button-group[data-v-0250da48]{\n\tdisplay:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-shrink:0;-ms-flex-negative:0;flex-shrink:0;-webkit-box-sizing:border-box;box-sizing:border-box}.uni-swipe_button[data-v-0250da48]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;padding:0 20px;font-size:14px;-webkit-box-sizing:border-box;box-sizing:border-box}.ani[data-v-0250da48]{-webkit-transition:-webkit-transform .35s cubic-bezier(.165,.84,.44,1);transition:-webkit-transform .35s cubic-bezier(.165,.84,.44,1);-o-transition:transform .35s cubic-bezier(.165,.84,.44,1);transition:transform .35s cubic-bezier(.165,.84,.44,1);transition:transform .35s cubic-bezier(.165,.84,.44,1),-webkit-transform .35s cubic-bezier(.165,.84,.44,1)}",""])},"811d":function(t,e,i){var n=i("2adc");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var o=i("4f06").default;o("0687ed06",n,!0,{sourceMap:!1,shadowMode:!1})},"84e5":function(t,e,i){"use strict";i.r(e);var n=i("5a3b"),o=i("fe9f");for(var s in o)"default"!==s&&function(t){i.d(e,t,function(){return o[t]})}(s);i("8f39");var a=i("2877"),c=Object(a["a"])(o["default"],n["a"],n["b"],!1,null,"98fb662e",null);e["default"]=c.exports},"8f39":function(t,e,i){"use strict";var n=i("811d"),o=i.n(n);o.a},9778:function(t,e,i){"use strict";i.r(e);var n=i("e72b"),o=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,function(){return n[t]})}(s);e["default"]=o.a},"97fa":function(t,e,i){"use strict";var n=i("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var o=n(i("e814")),s={data:function(){return{uniShow:!1,left:0}},computed:{moveLeft:function(){return"translateX(".concat(this.left,"px)")}},watch:{show:function(t){this.autoClose||(t?(this.$emit("change",!0),this.open()):(this.$emit("change",!1),this.close()),uni.$emit("__uni__swipe__event",this))}},onReady:function(){this.init(),this.getSelectorQuery()},beforeDestoy:function(){uni.$off("__uni__swipe__event")},methods:{init:function(){var t=this;uni.$on("__uni__swipe__event",function(e){e!==t&&t.autoClose&&0!==t.left&&t.close()})},onClick:function(t,e){this.$emit("click",{content:e,index:t})},touchstart:function(t){var e=t.touches[0].pageX;if(!this.disabled){var i=this.position[0].left;uni.$emit("__uni__swipe__event",this),this.width=e-i,this.isopen||this.uniShow&&(this.uniShow=!1,this.isopen=!0,this.openleft=this.left+this.position[1].width)}},touchmove:function(t,e){if(!this.disabled){var i=t.touches[0].pageX;this.setPosition(i)}},touchend:function(){this.disabled||(this.isopen?this.move(this.openleft,0):this.move(this.left,-40))},setPosition:function(t,e){this.position[1].width&&(this.left=t-this.width,this.setValue(t-this.width))},setValue:function(t){this.left=Math.max(-this.position[1].width,Math.min((0,o.default)(t),0)),this.position[0].left=this.left,this.isopen&&(this.openleft=this.left+this.position[1].width)},move:function(t,e){t>=e?(this.$emit("change",!1),this.close()):(this.$emit("change",!0),this.open())},open:function(){this.uniShow=!0,this.left=-this.position[1].width,this.setValue(-this.position[1].width)},close:function(){var t=this;this.uniShow=!0,this.setValue(0),setTimeout(function(){t.uniShow=!1,t.isopen=!1},200)},getSelectorQuery:function(){var t=this,e=uni.createSelectorQuery().in(this);e.selectAll(".selector-query-hock").boundingClientRect(function(e){t.position=e,t.autoClose||(t.show?t.open():t.close())}).exec()}}};e.default=s},ace0:function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"uni-swipe_content"},[i("v-uni-view",{wxsProps:{"change:prop":"pos"},staticClass:"uni-swipe_move-box selector-query-hock move-hock",attrs:{"data-disabled":t.disabled,"data-position":t.pos,"change:prop":t.swipe.sizeReady,prop:t.pos},on:{touchstart:function(e){e=t.$handleWxsEvent(e),t.swipe.touchstart(e,t.$getComponentDescriptor())},touchmove:function(e){e=t.$handleWxsEvent(e),t.swipe.touchmove(e,t.$getComponentDescriptor())},touchend:function(e){e=t.$handleWxsEvent(e),t.swipe.touchend(e,t.$getComponentDescriptor())},change:function(e){e=t.$handleEvent(e),t.change(e)}}},[i("v-uni-view",{staticClass:"uni-swipe_box"},[t._t("default")],2),i("v-uni-view",{staticClass:"uni-swipe_button-group selector-query-hock move-hock"},t._l(t.options,function(e,n){return i("v-uni-view",{key:n,staticClass:"uni-swipe_button button-hock",style:{backgroundColor:e.style&&e.style.backgroundColor?e.style.backgroundColor:"#C7C6CD",color:e.style&&e.style.color?e.style.color:"#FFFFFF",fontSize:e.style&&e.style.fontSize?e.style.fontSize:"16px"},attrs:{"data-button":t.btn},on:{click:function(i){i.stopPropagation(),i=t.$handleEvent(i),t.onClick(n,e)}}},[t._v(t._s(e.text))])}),1)],1)],1)},o=[];i.d(e,"a",function(){return n}),i.d(e,"b",function(){return o})},c8eb:function(t,e,i){"use strict";var n=function(t){(t.options.wxs||(t.options.wxs={}))["swipe"]=function(t){function e(t,e,i,n){var o=n.getState();if(o.position=JSON.parse(n.getDataset().position),0!==o.position.length){var s=o.position[0].show;o.left=o.left||o.position[0].left,r(!!s,n,i)}}function i(t,e){var i=t.instance,n=i.getState(),o=t.touches[0].pageX;i.removeClass("ani");for(var s=e.selectAllComponents(".button-hock"),a=0;a<s.length;a++)s[a].removeClass("ani");n.position=JSON.parse(i.getDataset().position),n.left=n.left||n.position[0].left,n.width=o-n.left,e.callMethod("openSwipe")}function n(t,e){var i=t.instance,n=i.getDataset().disabled,o=i.getState();if(!n){var a=t.touches[0].pageX;s(a-o.width,i,e)}}function o(t,e){var i=t.instance,n=i.getDataset().disabled,o=i.getState();n||a(o.left,-40,i,e)}function s(t,e,i){var n=e.getState(),o=Math.max(-n.position[1].width,Math.min(t,0));n.left=o,e.setStyle({transform:"translateX("+o+"px)","-webkit-transform":"translateX("+o+"px)"}),c(o,e,i)}function a(t,e,i,n){var o=i.getState(),s=o.position,a=o.isopen;s[1].width?a?-t<=s[1].width?r(!1,i,n):r(!0,i,n):r(t<=e,i,n):r(!1,i,n)}function c(t,e,i){for(var n=i.selectAllComponents(".button-hock"),o=e.getState(),s=o.position,a=[],c=0,r=0;r<n.length;r++){if(!n[r].getDataset().button)return;var l=JSON.parse(n[r].getDataset().button),u=l[r]&&l[r].width||0;c+=u,a.push(-c);var f=a[r-1]+t*(a[r-1]/s[1].width);0!=r&&n[r].setStyle({transform:"translateX("+f+"px)"})}}function r(t,e,i){var n=e.getState(),o=n.position;n.isopen=t,i.callMethod("change",{open:t}),e.addClass("ani");for(var a=i.selectAllComponents(".button-hock"),c=0;c<a.length;c++)a[c].addClass("ani");s(t?-o[1].width:0,e,i)}return t.exports={sizeReady:e,touchstart:i,touchmove:n,touchend:o},t.exports}({exports:{}})};e["a"]=n},cc5e:function(t,e,i){"use strict";var n=i("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var o=n(i("f499")),s={data:function(){return{position:[],button:[]}},computed:{pos:function(){return(0,o.default)(this.position)},btn:function(){return(0,o.default)(this.button)}},watch:{show:function(t){if(!this.autoClose){var e=this.position[0];e&&(e.show=t,this.$set(this.position,0,e))}}},mounted:function(){this.init(),this.getSize(),this.getButtonSize()},methods:{init:function(){var t=this;uni.$on("__uni__swipe__event",function(e){if(e!==t&&t.autoClose){var i=t.position[0];i.show=!1,t.$set(t.position,0,i)}})},openSwipe:function(){uni.$emit("__uni__swipe__event",this)},change:function(t){this.$emit("change",t.open);var e=this.position[0];e.show=t.open,this.$set(this.position,0,e)},onClick:function(t,e){this.$emit("click",{content:e,index:t})},getSize:function(){var t=this,e=uni.createSelectorQuery().in(this);e.selectAll(".selector-query-hock").boundingClientRect(function(e){t.autoClose?e[0].show=!1:e[0].show=t.show,t.position=e}).exec()},getButtonSize:function(){var t=this,e=uni.createSelectorQuery().in(this);e.selectAll(".button-hock").boundingClientRect(function(e){t.button=e}).exec()}}};e.default=s},e72b:function(t,e,i){"use strict";var n=i("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;n(i("97fa"));var o=n(i("cc5e")),s={mixins:[o.default],props:{options:{type:Array,default:function(){return[]}},disabled:{type:Boolean,default:!1},show:{type:Boolean,default:!1},autoClose:{type:Boolean,default:!0}}};e.default=s},e952:function(t,e,i){"use strict";var n=i("288e");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var o=n(i("1682")),s=n(i("8c6d")),a=n(i("c9c3")),c={components:{uniSwipeAction:o.default,uniList:s.default,uniListItem:a.default},data:function(){return{isOpened:!1,options1:[{text:"取消置顶"}],options2:[{text:"取消",style:{backgroundColor:"#007aff"}},{text:"确认",style:{backgroundColor:"#dd524d"}}],options3:[{text:"置顶"},{text:"标记为已读",style:{backgroundColor:"rgb(254,156,1)"}},{text:"删除",style:{backgroundColor:"rgb(255,58,49)"}}]}},onReady:function(){var t=this;this.$nextTick(function(){t.isOpened=!0})},methods:{bindClick:function(t){console.log(t),uni.showToast({title:"点击了".concat(t.content.text,"按钮"),icon:"none"})},setOpened:function(){this.isOpened=!this.isOpened},change:function(t){this.isOpened=t}}};e.default=c},fe9f:function(t,e,i){"use strict";i.r(e);var n=i("e952"),o=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,function(){return n[t]})}(s);e["default"]=o.a}}]);