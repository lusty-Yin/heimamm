<template>
  
  <el-container class="index-container">
  <el-header class="header">
     <div class="title_left">
         <i class="el-icon-s-fold title_icon"></i>
         <img src="../../assets/img/index_img.png" alt="" class="title_img">
         <span class="title_text">黑马面面</span>
     </div>
     <div class="title_right">
         <div class="user_img_box">
             <img src="../../assets/img/index_img.png" alt="" class="user_img">
         </div>
         <span class="user_name">李达,您好</span>
         <el-button type="success" size="small" class="exit_btn">退出</el-button>
     </div>
      
  </el-header>
  <el-container>
    <el-aside width="200px" class="aside">
        <el-menu
        router
      default-active="2"
      class="el-menu-vertical-demo"
      @open="handleOpen"
      @close="handleClose">
      <el-menu-item index="1">
        <i class="el-icon-pie-chart"></i>
        <span slot="title">导航二</span>
      </el-menu-item>
      <el-menu-item index="2">
        <i class="el-icon-user"></i>
        <span slot="title">导航二</span>
      </el-menu-item>
      <el-menu-item index="3">
        <i class="el-icon-edit-outline"></i>
        <span slot="title">导航二</span>
      </el-menu-item>
      <el-menu-item index="4">
        <i class="el-icon-office-building"></i>
        <span slot="title">导航二</span>
      </el-menu-item>
      <el-menu-item index="5">
        <i class="el-icon-notebook-2"></i>
        <span slot="title">导航二</span>
      </el-menu-item>
      
    </el-menu>
    </el-aside>
    <el-main class="main">Main</el-main>
  </el-container>
</el-container>
 
</template>

<script>
export default {
    name:'index'
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
</style>