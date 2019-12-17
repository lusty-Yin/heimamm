// 定义token的key
// 一般作为key要大写
const KEY ="token";

// 创建获取token函数,并暴露出去
export const setToken = (token)=>{
     localStorage.setItem(KEY,token)
}
// 创建调用token函数,并暴露出去
export const getToken = ()=> {
   return localStorage.getItem(KEY);
}
// 创建移除token函数,并暴露出去
export const removeToken = ()=>{
    localStorage.removeItem(KEY);
}