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
             <img src="" alt="" class="user_img">
         </div>
         <span class="user_name">李达,您好</span>
         <el-button type="success" size="small">退出</el-button>
     </div>
      
  </el-header>
  <el-container>
    <el-aside width="200px" class="aside">Aside</el-aside>
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
        font-size: 20px;
        margin-right: 22px;
    }
    .header{
        background-color: skyblue;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .aside{
        background-color: red;
    }
    .main{
        background-color: pink;
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
        width: 100%;
    }
    .user_img{
        border-radius: 50%;
        width: 43px;
        height: 43px;
        margin-right: 9px;
    }
    .user_name{
        font-size: 15px;
        margin-right: 52px;
    }
</style>