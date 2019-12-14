import Vue from 'vue'
import App from './App.vue'
import router from "./router/router.js"
// 引入饿了么ui
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
// 引入初始化样式
import './assets/style/base.css'
window.console.log(process.env.VUE_APP_BASEURL)
// 注册一下饿了么ui
Vue.use(ElementUI);

Vue.config.productionTip = false

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
