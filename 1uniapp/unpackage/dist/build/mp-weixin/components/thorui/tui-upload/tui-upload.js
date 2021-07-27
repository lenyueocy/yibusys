(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/thorui/tui-upload/tui-upload"],{"482b":function(t,e,r){"use strict";var n;r.d(e,"b",(function(){return i})),r.d(e,"c",(function(){return a})),r.d(e,"a",(function(){return n}));var i=function(){var t=this,e=t.$createElement;t._self._c},a=[]},"4fe4":function(t,e,r){"use strict";r.r(e);var n=r("482b"),i=r("7031");for(var a in i)"default"!==a&&function(t){r.d(e,t,(function(){return i[t]}))}(a);r("4ff1");var s,u=r("f0c5"),o=Object(u["a"])(i["default"],n["b"],n["c"],!1,null,"981e9a36",null,!1,n["a"],s);e["default"]=o.exports},"4ff1":function(t,e,r){"use strict";var n=r("9134"),i=r.n(n);i.a},7031:function(t,e,r){"use strict";r.r(e);var n=r("9323"),i=r.n(n);for(var a in n)"default"!==a&&function(t){r.d(e,t,(function(){return n[t]}))}(a);e["default"]=i.a},9134:function(t,e,r){},9323:function(t,e,r){"use strict";(function(t){function r(t,e){var r;if("undefined"===typeof Symbol||null==t[Symbol.iterator]){if(Array.isArray(t)||(r=a(t))||e&&t&&"number"===typeof t.length){r&&(t=r);var n=0,i=function(){};return{s:i,n:function(){return n>=t.length?{done:!0}:{done:!1,value:t[n++]}},e:function(t){throw t},f:i}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var s,u=!0,o=!1;return{s:function(){r=t[Symbol.iterator]()},n:function(){var t=r.next();return u=t.done,t},e:function(t){o=!0,s=t},f:function(){try{u||null==r.return||r.return()}finally{if(o)throw s}}}}function n(t){return u(t)||s(t)||a(t)||i()}function i(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}function a(t,e){if(t){if("string"===typeof t)return o(t,e);var r=Object.prototype.toString.call(t).slice(8,-1);return"Object"===r&&t.constructor&&(r=t.constructor.name),"Map"===r||"Set"===r?Array.from(t):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?o(t,e):void 0}}function s(t){if("undefined"!==typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)}function u(t){if(Array.isArray(t))return o(t)}function o(t,e){(null==e||e>t.length)&&(e=t.length);for(var r=0,n=new Array(e);r<e;r++)n[r]=t[r];return n}Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var f={name:"tuiUpload",props:{width:{type:[Number,String],default:220},height:{type:[Number,String],default:220},value:{type:Array,default:function(){return[]}},forbidDel:{type:Boolean,default:!1},forbidAdd:{type:Boolean,default:!1},serverUrl:{type:String,default:""},limit:{type:Number,default:9},sizeType:{type:Array,default:function(){return["original","compressed"]}},sourceType:{type:Array,default:function(){return["album","camera"]}},imageFormat:{type:Array,default:function(){return[]}},size:{type:Number,default:4},fileKeyName:{type:String,default:"file"},header:{type:Object,default:function(){return{}}},formData:{type:Object,default:function(){return{}}},params:{type:[Number,String],default:0}},data:function(){return{imageList:[],statusArr:[]}},created:function(){this.initImages()},watch:{value:function(t){t&&this.initImages()}},computed:{isShowAdd:function(){var t=!0;return(this.forbidAdd||this.limit&&this.imageList.length>=this.limit)&&(t=!1),t}},methods:{initImages:function(){this.imageList=n(this.value);var t,e=r(this.imageList);try{for(e.s();!(t=e.n()).done;){t.value;this.statusArr.push("1")}}catch(i){e.e(i)}finally{e.f()}},reUpLoad:function(t){var e=this;this.$set(this.statusArr,t,"2"),this.change(),this.uploadImage(t,this.imageList[t]).then((function(){e.change()})).catch((function(){e.change()}))},change:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0],e=~this.statusArr.indexOf("2")?2:1;2!=e&&~this.statusArr.indexOf("3")&&(e=3),this.$emit("complete",{status:e,imgArr:this.imageList,params:this.params,manual:t})},toast:function(e){e&&t.showToast({title:e,icon:"none"})},chooseImage:function(){var e=this;t.chooseImage({count:e.limit-e.imageList.length,sizeType:e.sizeType,sourceType:e.sourceType,success:function(t){for(var r=[],n=0;n<t.tempFiles.length;n++){var i=e.imageList.length;if(i>=e.limit){e.toast("最多可上传".concat(e.limit,"张图片"));break}var a=t.tempFiles[n].path;if(e.imageFormat.length>0){var s="";if(s=a.split(".")[a.split(".").length-1],-1==e.imageFormat.indexOf(s)){var u="只能上传 ".concat(e.imageFormat.join(",")," 格式图片！");e.toast(u);continue}}var o=t.tempFiles[n].size;if(1024*e.size*1024<o){var f="单张图片大小不能超过：".concat(e.size,"MB");e.toast(f)}else r.push(a),e.imageList.push(a),e.statusArr.push("2")}e.change();for(var l=e.imageList.length-r.length,c=0;c<r.length;c++){var h=l+c;e.serverUrl?e.uploadImage(h,r[c]).then((function(){e.change()})).catch((function(){e.change()})):(e.$set(e.statusArr,h,"1"),e.change())}}})},uploadImage:function(e,r,n){var i=this,a=this;return new Promise((function(s,u){t.uploadFile({url:i.serverUrl||n,name:i.fileKeyName,header:i.header,formData:i.formData,filePath:r,success:function(t){if(200==t.statusCode){var r=JSON.parse(t.data.replace(/\ufeff/g,"")||"{}");0===r.error?(r.files&&r.files[0]&&r.files[0].url&&(a.imageList[e]=r.files[0].url),a.$set(a.statusArr,e,r.files&&r.files[0].url?"1":"3")):a.$set(a.statusArr,e,"3"),s(e)}else a.$set(a.statusArr,e,"3"),u(e)},fail:function(t){a.$set(a.statusArr,e,"3"),u(e)}})}))},delImage:function(t){this.imageList.splice(t,1),this.statusArr.splice(t,1),this.$emit("remove",{index:t,params:this.params}),this.change()},previewImage:function(e){this.imageList.length&&t.previewImage({current:this.imageList[e],loop:!0,urls:this.imageList})},uploadAllImage:function(t){var e=this;if(t)for(var r=n(this.imageList),i=r.length,a=function(n){if(r[n].startsWith("http"))return"continue";e.$set(e.statusArr,n,"2"),e.uploadImage(n,r[n],t).then((function(){n===i-1&&e.change(!0)})).catch((function(){n===i-1&&e.change(!0)}))},s=0;s<i;s++)a(s);else this.toast("服务器接口地址不能为空！")}}};e.default=f}).call(this,r("543d")["default"])}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/thorui/tui-upload/tui-upload-create-component',
    {
        'components/thorui/tui-upload/tui-upload-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("4fe4"))
        })
    },
    [['components/thorui/tui-upload/tui-upload-create-component']]
]);
