<template>
  
  <el-container class="index-container">
  <el-header class="header">
     <div class="title_left">
         <i class="el-icon-s-fold title_icon" @click="Collapse"></i>
         <img src="../../assets/img/index_img.png" alt="" class="title_img">
         <span class="title_text">黑马面面</span>
     </div>
     <div class="title_right">
         <div class="user_img_box">
             <img :src="userInfo.avatar" alt="" class="user_img">
         </div>
         <span class="user_name">{{userInfo.username}},您好</span>
         <el-button type="success" size="small" class="exit_btn">退出</el-button>
     </div>
      
  </el-header>
  <el-container>
    <el-aside width="auto" class="aside">
        <el-menu
        router
      :default-active="$route.path"
      class="el-menu-vertical-demo"
       :collapse="isCollapse"
      >
      <el-menu-item index="/index/chart">
        <i class="el-icon-pie-chart"></i>
        <span slot="title">数据概览</span>
      </el-menu-item>
      <el-menu-item index="/index/user">
        <i class="el-icon-user"></i>
        <span slot="title">用户列表</span>
      </el-menu-item>
      <el-menu-item index="/index/question">
        <i class="el-icon-edit-outline"></i>
        <span slot="title">题库列表</span>
      </el-menu-item>
      <el-menu-item index="/index/enterprise">
        <i class="el-icon-office-building"></i>
        <span slot="title">企业列表</span>
      </el-menu-item>
      <el-menu-item index="/index/subject">
        <i class="el-icon-notebook-2"></i>
        <span slot="title">学科列表</span>
      </el-menu-item>
      
    </el-menu>
    </el-aside>
    <el-main class="main"><router-view></router-view></el-main>
  </el-container>
</el-container>
 
</template>

<script>
// import {chart,enterprise,question,subject,user} from '../../router/router'
// 导入token封装
import {getToken} from '../../utils/token.js';
// 导入user接口
import {userInfo} from '../../api/user.js';
export default {
    name:'index',
    data() {
        return {
            isCollapse: true,
            userInfo:''
        }
    },
    beforeCreate() {
       
        // 判断一:有无token
        if(!getToken()){
            this.$message.error('要先登录喔');
            this.$router.push('/login');
        }
        // 判断二:token是否正确
        // if(getToken() === localStorage.getItem('token')){
        //     this.$message.success('欢迎回来!')
        // }
        // else{
        //     this.$message.error('要先登录喔');
        //     this.$router.push('/login');
        // }
    },
    created(){
          window.console.log(this.$route)
          userInfo().then(res=>{
            //   window.console.log(res);
            res.data.data.avatar = process.env.VUE_APP_BASEURL + '/' + res.data.data.avatar;
              this.userInfo = res.data.data
          });
    },
    methods:{
       Collapse(){
           this.isCollapse =! this.isCollapse;
       }
     
    }
}
    
</script>

<style>
    .index-container{
        height: 100%;
    }
    .title_icon{
        font-size: 28px;
        margin-right: 22px;
    }
    .header{
        /* background-color: skyblue; */
        display: flex;
        justify-content: space-between;
        /* align-items: center; */
        box-shadow:0px 2px 5px 0px rgba(63, 63, 63, 0.35);
    }
    .aside{
        /* border-top: 1px solid black; */
        /* background-color: red; */
    }
    .main{
        background-color: pink;
    }
    .title_left{
        display: flex;
        align-items: center
    }
    .title_right{
        display: flex;
        align-items: center;
        /* width: 120px; */
    }
    .title_img{
        width: 33px;
        height: 28px;
        margin-right: 11px;
    }
    .title_text{
        font-size: 20px;
    }
    .user_img_box{
        width: 43px;
        height: 43px;
        margin-right: 9px;
    }
    .user_img{
        border-radius: 50%;
        width: 43px;
        height: 43px;
        margin-right: 9px;
    }
    .user_name{
        /* font-size: 12px; */
        margin-right: 38px;
        /* width: 120px; */
    }
    .exit_btn{
        /* margin-left: 38px; */
    }
    .el-menu-vertical-demo:not(.el-menu--collapse) {
            width: 200px;
            min-height: 400px;
        }
</style>