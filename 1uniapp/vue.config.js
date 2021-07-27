const TransformPages = require('uni-read-pages')
const {webpack} = new TransformPages()
module.exports = {
    configureWebpack: {
        plugins: [
            new webpack.DefinePlugin({
                ROUTES: webpack.DefinePlugin.runtimeValue(() => {
                    const tfPages = new TransformPages({
                        includes: ['path', 'name', 'meta','aliasPath','requiresAuth']
                    });
                    tfPages.routes.forEach((item,index)=>{
                        if(!item.name){
                            let pathArr = item.path.split('/')
                            pathArr.splice(0,2)
                            item.name = pathArr.join('_')
                        }
                    })
                    return JSON.stringify(tfPages.routes)
                }, true )
            })
        ]
    }
}

/*new webpack.DefinePlugin({
 ROUTES: webpack.DefinePlugin.runtimeValue(() => {
 const tfPages = new TransformPages({
 includes: ['path', 'name', 'meta','requiresAuth']
 });
 tfPages.routes.forEach((item,index)=>{
 if(!item.name){
 let pathArr = item.path.split('/')
 pathArr.splice(0,2)
 item.name = pathArr.join('_')
 }
 })
 return JSON.stringify(tfPages.routes)
 }, true )
 }),*/

//const tfPages = new TransformPages({includes: ['path','name','aliasPath','meta','requiresAuth']})

/*new tfPages.webpack.DefinePlugin({
    ROUTES: tfPages.webpack.DefinePlugin.runtimeValue(() => {
        tfPages.routes.forEach((item,index)=>{
            if(!item.name){
                let pathArr = item.path.split('/')
                pathArr.splice(0,2)
                item.name = pathArr.join('_')
            }
        })
        return JSON.stringify(tfPages.routes)
    }, true )
})*/
