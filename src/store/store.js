// 导入vuex vue
import Vue from 'vue'
import Vuex from 'vuex';
// use一下
Vue.use(Vuex);
// 创建数据库
const store = new Vuex.Store({
    state:{
        // 存储信息
        userInfo:''
    },
    mutations:{
        changeUserInfo(state,newdata){
            state.userInfo = newdata;
        }
    }
})
// 暴露出去
export default store;