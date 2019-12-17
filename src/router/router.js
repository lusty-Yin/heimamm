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
    routes// routes:routes
})
// 暴露出去
export default router