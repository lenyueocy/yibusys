import $store from '@/utils/store/index'
import {utils} from '@/utils/common'
import {RouterMount,createRouter} from 'uni-simple-router';
//import TransformPages from 'uni-read-pages'

if(process.env.NODE_ENV === 'development'){
    //const tfPages = new TransformPages({includes: ['path','name','aliasPath','meta','requiresAuth']})
    /*new tfPages.webpack.DefinePlugin({
        ROUTES: tfPages.webpack.DefinePlugin.runtimeValue( () => {
            return JSON.stringify(tfPages.routes)
        }, true, )
    })*/
}
console.log(ROUTES)
const router = createRouter({
    platform: process.env.VUE_APP_PLATFORM,
    h5:{
        paramsToQuery: true,
        //mode: 'hash',
        //base:'/',
    },
    routes: [
        ...ROUTES,
        {
            path: '*',
            redirect:(to)=>{
                return {name:'public_404'}
            }
        },
    ]
});

//全局路由前置守卫  --全局拦截需要登录的窗口
router.beforeEach((to, from, next) => {
    // #ifdef H5
    var ua = window.navigator.userAgent.toLowerCase();
    if (0 && $store.getters.hasLogin!=true && to.name!='login_bidding' && ua.match(/MicroMessenger/i) == 'micromessenger') {
        utils.wxLogin(to,next)
        return false;
    }
    //if ($store.getters.hasLogin!=true && to.requiresAuth==true && to.name=='member_index') $util.wxLogin(to,next)
    // #endif

    switch (to.name){
        case 'tabbar_luckybag':
            next({
                name: 'luckybag_index',
                NAVTYPE: 'push'
            });
            break;
        case 'tabbar_integralmall':
            next({
                name: 'integralmall_index',
                NAVTYPE: 'push'
            });
            break;
        case 'tabbar_cart':
            next({
                name: 'cart_index',
                NAVTYPE: 'push'
            });
            break;
        default:
            if(to.requiresAuth==true && $store.getters.hasLogin!=true){
                uni.showModal({
                    title: '提示',content: '您还未登录,是否前往登录？',
                    success: function (res) {
                        if (res.confirm){ next({name: 'login_login',NAVTYPE: 'push' })}else{ next(false) }
                    }
                });
            }else{
                next()
            }
            break;
    }
})
// 全局路由后置守卫
router.afterEach((to, from) => {

})
export {router,RouterMount}
