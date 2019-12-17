// 导入axios
import axios from "axios";
// 导入token函数
import {getToken} from "../utils/token.js"

// 统一设置 axios的设置
// axios.defaults 只能设置一个 axios对象
// 如果项目中 可能用到多个 axios 支持创建一个
// 后续的接口调用直接用  instance 即可
const instance = axios.create({
    baseURL:process.env.VUE_APP_BASEURL,
    // 跨域携带cookie
    withCredentials:true
}) 


export function userInfo(){
    return instance({
        url:'/info',
        method:'get',
        headers:{
            token:getToken()
        }
    })
}