// 导入Vue
import Vue from 'vue'
// 导包
import VueRouter from 'vue-router'
import login from '../views/login/login.vue'
import index from "../views/index/index.vue"
import chart from '../views/index/chart/chart.vue'
import enterprise from '../views/index/enterprise/enterprise.vue'
import question from '../views/index/question/question.vue'
import subject from '../views/index/subject/subject.vue'
import user from '../views/index/user/user.vue'
// 导入获取用户信息请求封装
import {getUserInfo} from '../api/user.js';
// 导入获取token封装
import {getToken,removeToken} from '../utils/token.js'
// 导入仓库js
import store from '../store/store.js'

// Use一下 注册
Vue.use(VueRouter)

// 规则
const routes =[
    // 登录
    {
        path:"/login",
        component:login
    },
    // 首页
    {
        path:"/index",
        component:index,
        // 进入首页后路由重定向
        redirect: '/index/subject',
        // 嵌套路由
        children:[
            {
                path:'chart',
                component:chart
            },
            {
                path:'enterprise',
                component:enterprise
            },
            {
                path:'question',
                component:question
            },
            {
                path:'subject',
                component:subject
            },
            {
                path:'user',
                component:user
            }
        ]
    },
]


// 创建
const router = new VueRouter({
    routes,// routes:routes
    
})
// 创建路由白名单数组
const whitePaths = ["/login"];
// 全局导航守卫
router.beforeEach((to,from,next) => {
    
    // window.console.log(to.path)
    // 1.判断是否在白名单中
    if(whitePaths.includes(to.path) === false){
        // 2.判断是否有token
        if(!getToken()){
            window.alert('要先登录喔!')
            next('/login');
        }else{
          // 3.判断token的真伪
         getUserInfo().then(res=>{
            window.console.log(res.data.data)
            if(res.data.code == 200){
               
                // 用户头像url要加上基地址
                res.data.data.avatar = process.env.VUE_APP_BASEURL + '/' + res.data.data.avatar;
                 // 把用户信息存到仓库的userInfo中
                 store.commit('changeUserInfo',res.data.data);
                next();
            }else if(res.data.code == 206){
                window.alert('乱写的token还想进来?')
                removeToken();
                next('/login')
            }
        })

        }
         
    }else{
        // 这是登录页
        next()
    }
    
})
// 暴露出去
export default router