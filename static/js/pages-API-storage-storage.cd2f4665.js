(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-API-storage-storage"],{"031b":function(t,n,e){"use strict";var a=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("v-uni-view",[e("page-head",{attrs:{title:t.title}}),e("v-uni-view",{staticClass:"uni-common-mt"},[e("v-uni-view",{staticClass:"uni-list"},[e("v-uni-view",{staticClass:"uni-list-cell"},[e("v-uni-view",{staticClass:"uni-list-cell-left"},[e("v-uni-view",{staticClass:"uni-label"},[t._v("key")])],1),e("v-uni-view",{staticClass:"uni-list-cell-db"},[e("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",placeholder:"请输入key",name:"key",value:t.key},on:{input:function(n){n=t.$handleEvent(n),t.keyChange(n)}}})],1)],1),e("v-uni-view",{staticClass:"uni-list-cell"},[e("v-uni-view",{staticClass:"uni-list-cell-left"},[e("v-uni-view",{staticClass:"uni-label"},[t._v("value")])],1),e("v-uni-view",{staticClass:"uni-list-cell-db"},[e("v-uni-input",{staticClass:"uni-input",attrs:{type:"text",placeholder:"请输入value",name:"data",value:t.data},on:{input:function(n){n=t.$handleEvent(n),t.dataChange(n)}}})],1)],1)],1),e("v-uni-view",{staticClass:"uni-padding-wrap"},[e("v-uni-view",{staticClass:"uni-btn-v"},[e("v-uni-button",{staticClass:"btn-setstorage",attrs:{type:"primary"},on:{click:function(n){n=t.$handleEvent(n),t.setStorage(n)}}},[t._v("存储数据")]),e("v-uni-button",{on:{click:function(n){n=t.$handleEvent(n),t.getStorage(n)}}},[t._v("读取数据")]),e("v-uni-button",{on:{click:function(n){n=t.$handleEvent(n),t.clearStorage(n)}}},[t._v("清理数据")])],1)],1)],1)],1)},i=[];e.d(n,"a",function(){return a}),e.d(n,"b",function(){return i})},"0fb8":function(t,n,e){"use strict";e.r(n);var a=e("24f5"),i=e.n(a);for(var s in a)"default"!==s&&function(t){e.d(n,t,function(){return a[t]})}(s);n["default"]=i.a},"24f5":function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var a={data:function(){return{title:"get/set/clearStorage",key:"",data:""}},methods:{keyChange:function(t){this.key=t.target.value},dataChange:function(t){this.data=t.target.value},getStorage:function(){var t=this.key;this.data;0===t.length?uni.showModal({title:"读取数据失败",content:"key 不能为空",showCancel:!1}):uni.getStorage({key:t,success:function(t){uni.showModal({title:"读取数据成功",content:"data: '"+t.data+"'",showCancel:!1})},fail:function(){uni.showModal({title:"读取数据失败",content:"找不到 key 对应的数据",showCancel:!1})}})},setStorage:function(){var t=this.key,n=this.data;0===t.length?uni.showModal({title:"保存数据失败",content:"key 不能为空",showCancel:!1}):uni.setStorage({key:t,data:n,success:function(t){uni.showModal({title:"存储数据成功",content:" ",showCancel:!1})},fail:function(){uni.showModal({title:"储存数据失败!",showCancel:!1})}})},clearStorage:function(){uni.clearStorageSync(),this.key="",this.data="",uni.showModal({title:"清除数据成功",content:" ",showCancel:!1})}}};n.default=a},"33c2":function(t,n,e){n=t.exports=e("2350")(!1),n.push([t.i,".btn-setstorage[data-v-7b922815]{background-color:#007aff;color:#fff}",""])},"5fd0":function(t,n,e){"use strict";e.r(n);var a=e("031b"),i=e("0fb8");for(var s in i)"default"!==s&&function(t){e.d(n,t,function(){return i[t]})}(s);e("e1c2");var u=e("2877"),l=Object(u["a"])(i["default"],a["a"],a["b"],!1,null,"7b922815",null);n["default"]=l.exports},b07e:function(t,n,e){var a=e("33c2");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var i=e("4f06").default;i("0b6f2172",a,!0,{sourceMap:!1,shadowMode:!1})},e1c2:function(t,n,e){"use strict";var a=e("b07e"),i=e.n(a);i.a}}]);