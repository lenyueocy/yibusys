(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-template-list2detail-detail-list2detail-detail"],{"0603":function(e,t,n){t=e.exports=n("2350")(!1),t.push([e.i,".banner[data-v-d62e381e]{height:%?360?%;overflow:hidden;position:relative;background-color:#ccc}.banner-img[data-v-d62e381e]{width:100%}.banner-title[data-v-d62e381e]{max-height:%?84?%;overflow:hidden;position:absolute;left:%?30?%;bottom:%?30?%;width:90%;font-size:%?32?%;font-weight:400;line-height:%?42?%;color:#fff;z-index:11}.article-meta[data-v-d62e381e]{padding:%?20?% %?40?%;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;-ms-flex-direction:row;flex-direction:row;-webkit-box-pack:start;-webkit-justify-content:flex-start;-ms-flex-pack:start;justify-content:flex-start;color:grey}.article-text[data-v-d62e381e]{font-size:%?26?%;line-height:%?50?%;margin:0 %?20?%}.article-author[data-v-d62e381e],.article-time[data-v-d62e381e]{font-size:%?30?%}.article-content[data-v-d62e381e]{padding:0 %?30?%;overflow:hidden;font-size:%?30?%;margin-bottom:%?30?%}",""])},"283e":function(e,t,n){var i=n("0603");"string"===typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);var a=n("4f06").default;a("2991b9ce",i,!0,{sourceMap:!1,shadowMode:!1})},6173:function(e,t,n){"use strict";n.r(t);var i=n("9278"),a=n.n(i);for(var r in i)"default"!==r&&function(e){n.d(t,e,function(){return i[e]})}(r);t["default"]=a.a},"61fb":function(e,t,n){"use strict";n.r(t);var i=n("a155"),a=n("6173");for(var r in a)"default"!==r&&function(e){n.d(t,e,function(){return a[e]})}(r);n("6922");var s=n("2877"),o=Object(s["a"])(a["default"],i["a"],i["b"],!1,null,"d62e381e",null);t["default"]=o.exports},6922:function(e,t,n){"use strict";var i=n("283e"),a=n.n(i);a.a},9278:function(e,t,n){"use strict";var i=n("288e");Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,n("a481");var a=i(n("f499"));n("55dd");var r=i(n("c907")),s="/pages/template/list2detail-detail/list2detail-detail";function o(e){for(var t=[],n=0,i=e.length;n<i;n++)switch(e[n]){case"weixin":t.push({text:"分享到微信好友",id:"weixin",sort:0}),t.push({text:"分享到微信朋友圈",id:"weixin",sort:1});break;default:break}return t.sort(function(e,t){return e.sort-t.sort}),t}var l={data:function(){return{title:"",banner:{},htmlNodes:[]}},onLoad:function(e){var t=e.detailDate||e.payload;try{this.banner=JSON.parse(decodeURIComponent(t))}catch(n){this.banner=JSON.parse(t)}uni.setNavigationBarTitle({title:this.banner.title}),this.getDetail()},onShareAppMessage:function(){return{title:this.banner.title,path:s+"?detailDate="+(0,a.default)(this.banner)}},onNavigationBarButtonTap:function(e){var t=this,n=e.index;if(0===n){uni.getProvider({service:"share",success:function(e){if(e.provider&&e.provider.length&&~e.provider.indexOf("weixin")){var n=o(e.provider);uni.showActionSheet({itemList:n.map(function(e){return e.text}),success:function(e){var n=e.tapIndex;uni.share({provider:"weixin",type:0,title:t.banner.title,scene:0===n?"WXSceneSession":"WXSenceTimeline",href:"https://uniapp.dcloud.io/h5"+s+"?detailDate="+(0,a.default)(t.banner),imageUrl:"https://img-cdn-qiniu.dcloud.net.cn/uniapp/app/share-logo@3.png"})}})}else uni.showToast({title:"未检测到可用的微信分享服务"})},fail:function(e){uni.showToast({title:"获取分享服务失败"})}})}},methods:{getDetail:function(){var e=this;uni.request({url:"https://unidemo.dcloud.net.cn/api/news/36kr/"+this.banner.post_id,success:function(t){if(200==t.statusCode){var n=t.data.content.replace(/\\/g,"").replace(/<img/g,'<img style="display:none;"');e.htmlNodes=(0,r.default)(n)}},fail:function(){console.log("fail")}})}}};t.default=l},a155:function(e,t,n){"use strict";var i=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("v-uni-view",[n("v-uni-view",{staticClass:"banner"},[n("v-uni-image",{staticClass:"banner-img",attrs:{src:e.banner.cover}}),n("v-uni-view",{staticClass:"banner-title"},[e._v(e._s(e.banner.title))])],1),n("v-uni-view",{staticClass:"article-meta"},[n("v-uni-text",{staticClass:"article-author"},[e._v(e._s(e.banner.author_name))]),n("v-uni-text",{staticClass:"article-text"},[e._v("发表于")]),n("v-uni-text",{staticClass:"article-time"},[e._v(e._s(e.banner.published_at))])],1),n("v-uni-view",{staticClass:"article-content"},[n("v-uni-rich-text",{attrs:{nodes:e.htmlNodes}})],1)],1)},a=[];n.d(t,"a",function(){return i}),n.d(t,"b",function(){return a})},c907:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,n("28a5"),n("7f7f"),n("3b2b"),n("a481"),n("4917");var i=/^<([-A-Za-z0-9_]+)((?:\s+[a-zA-Z_:][-a-zA-Z0-9_:.]*(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/,a=/^<\/([-A-Za-z0-9_]+)[^>]*>/,r=/([a-zA-Z_:][-a-zA-Z0-9_:.]*)(?:\s*=\s*(?:(?:"((?:\\.|[^"])*)")|(?:'((?:\\.|[^'])*)')|([^>\s]+)))?/g,s=h("area,base,basefont,br,col,frame,hr,img,input,link,meta,param,embed,command,keygen,source,track,wbr"),o=h("a,address,article,applet,aside,audio,blockquote,button,canvas,center,dd,del,dir,div,dl,dt,fieldset,figcaption,figure,footer,form,frameset,h1,h2,h3,h4,h5,h6,header,hgroup,hr,iframe,isindex,li,map,menu,noframes,noscript,object,ol,output,p,pre,section,script,table,tbody,td,tfoot,th,thead,tr,ul,video"),l=h("abbr,acronym,applet,b,basefont,bdo,big,br,button,cite,code,del,dfn,em,font,i,iframe,img,input,ins,kbd,label,map,object,q,s,samp,script,select,small,span,strike,strong,sub,sup,textarea,tt,u,var"),c=h("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr"),d=h("checked,compact,declare,defer,disabled,ismap,multiple,nohref,noresize,noshade,nowrap,readonly,selected"),u=h("script,style");function f(e,t){var n,f,h,p=[],v=e;p.last=function(){return this[this.length-1]};while(e){if(f=!0,p.last()&&u[p.last()])e=e.replace(new RegExp("([\\s\\S]*?)</"+p.last()+"[^>]*>"),function(e,n){return n=n.replace(/<!--([\s\S]*?)-->|<!\[CDATA\[([\s\S]*?)]]>/g,"$1$2"),t.chars&&t.chars(n),""}),g("",p.last());else if(0==e.indexOf("\x3c!--")?(n=e.indexOf("--\x3e"),n>=0&&(t.comment&&t.comment(e.substring(4,n)),e=e.substring(n+3),f=!1)):0==e.indexOf("</")?(h=e.match(a),h&&(e=e.substring(h[0].length),h[0].replace(a,g),f=!1)):0==e.indexOf("<")&&(h=e.match(i),h&&(e=e.substring(h[0].length),h[0].replace(i,m),f=!1)),f){n=e.indexOf("<");var b=n<0?e:e.substring(0,n);e=n<0?"":e.substring(n),t.chars&&t.chars(b)}if(e==v)throw"Parse Error: "+e;v=e}function m(e,n,i,a){if(n=n.toLowerCase(),o[n])while(p.last()&&l[p.last()])g("",p.last());if(c[n]&&p.last()==n&&g("",n),a=s[n]||!!a,a||p.push(n),t.start){var u=[];i.replace(r,function(e,t){var n=arguments[2]?arguments[2]:arguments[3]?arguments[3]:arguments[4]?arguments[4]:d[t]?t:"";u.push({name:t,value:n,escaped:n.replace(/(^|[^\\])"/g,'$1\\"')})}),t.start&&t.start(n,u,a)}}function g(e,n){if(n){for(i=p.length-1;i>=0;i--)if(p[i]==n)break}else var i=0;if(i>=0){for(var a=p.length-1;a>=i;a--)t.end&&t.end(p[a]);p.length=i}}g()}function h(e){for(var t={},n=e.split(","),i=0;i<n.length;i++)t[n[i]]=!0;return t}function p(e){return e.replace(/<\?xml.*\?>\n/,"").replace(/<!doctype.*>\n/,"").replace(/<!DOCTYPE.*>\n/,"")}function v(e){return e.reduce(function(e,t){var n=t.value,i=t.name;return e[i]?e[i]=e[i]+" "+n:e[i]=n,e},{})}function b(e){e=p(e);var t=[],n={node:"root",children:[]};return f(e,{start:function(e,i,a){var r={name:e};if(0!==i.length&&(r.attrs=v(i)),a){var s=t[0]||n;s.children||(s.children=[]),s.children.push(r)}else t.unshift(r)},end:function(e){var i=t.shift();if(i.name!==e&&console.error("invalid state: mismatch end tag"),0===t.length)n.children.push(i);else{var a=t[0];a.children||(a.children=[]),a.children.push(i)}},chars:function(e){var i={type:"text",text:e};if(0===t.length)n.children.push(i);else{var a=t[0];a.children||(a.children=[]),a.children.push(i)}},comment:function(e){var n={node:"comment",text:e},i=t[0];i.children||(i.children=[]),i.children.push(n)}}),n.children}var m=b;t.default=m}}]);