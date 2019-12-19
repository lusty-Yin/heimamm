// 导入axios
import axios from "axios"
// 获取token
import {getToken} from '../utils/token.js'
const instance = axios.create({
    baseURL:process.env.VUE_APP_BASEURL,
    // 允许携带cooki跨域
    withCredentials:true
})
// 暴露接口
// 学科添加
export function  s_add(){
    return instance({
        url:'/subject/add',
        method:'post',
        headers:{
            token:getToken()
        }
    })
}
// 学科列表
export function  s_list(){
    return instance({
        url:'/subject/list',
        method:'get',
        headers:{
            token:getToken()
        }
    })
}
// 学科状态
export function  s_status(){
    return instance({
        url:'/subject/status',
        method:'post',
        headers:{
            token:getToken()
        }
    })
}
// 学科添加
export function  s_edit(){
    return instance({
        url:'/subject/edit',
        method:'post',
        headers:{
            token:getToken()
        }
    })
}
// 学科添加
export function  s_remove(){
    return instance({
        url:'/subject/remove',
        method:'post',
        headers:{
            token:getToken()
        }
    })
}