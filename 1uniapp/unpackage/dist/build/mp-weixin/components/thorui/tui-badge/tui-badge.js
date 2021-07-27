(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/thorui/tui-badge/tui-badge"],{"2eca":function(t,e,n){"use strict";n.r(e);var a=n("eefa"),u=n("6942");for(var r in u)"default"!==r&&function(t){n.d(e,t,(function(){return u[t]}))}(r);n("d242");var i,c=n("f0c5"),o=Object(c["a"])(u["default"],a["b"],a["c"],!1,null,"5eb90b82",null,!1,a["a"],i);e["default"]=o.exports},"577f":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a={name:"tuiBadge",props:{type:{type:String,default:"primary"},dot:{type:Boolean,default:!1},margin:{type:String,default:"0"},absolute:{type:Boolean,default:!1},top:{type:String,default:"-8rpx"},right:{type:String,default:"0"},scaleRatio:{type:Number,default:1},translateX:{type:String,default:"0"}},computed:{getStyle:function(){return"scale(".concat(this.scaleRatio,") translateX(").concat(this.translateX,")")}},methods:{handleClick:function(){this.$emit("click",{})}}};e.default=a},6942:function(t,e,n){"use strict";n.r(e);var a=n("577f"),u=n.n(a);for(var r in a)"default"!==r&&function(t){n.d(e,t,(function(){return a[t]}))}(r);e["default"]=u.a},a279:function(t,e,n){},d242:function(t,e,n){"use strict";var a=n("a279"),u=n.n(a);u.a},eefa:function(t,e,n){"use strict";var a;n.d(e,"b",(function(){return u})),n.d(e,"c",(function(){return r})),n.d(e,"a",(function(){return a}));var u=function(){var t=this,e=t.$createElement;t._self._c},r=[]}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/thorui/tui-badge/tui-badge-create-component',
    {
        'components/thorui/tui-badge/tui-badge-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("2eca"))
        })
    },
    [['components/thorui/tui-badge/tui-badge-create-component']]
]);
