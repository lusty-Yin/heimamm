<template>
<div class="subject">
  <!-- 搜索栏 -->
   <el-card class="box-card">
    <el-form :inline="true" :model="formInline" class="demo-form-inline">
      <el-form-item label="学科编号">
        <el-input v-model="formInline.user" ></el-input>
      </el-form-item>
      <el-form-item label="学科名称">
        <el-input v-model="formInline.user" ></el-input>
      </el-form-item>
      <el-form-item label="创建者">
        <el-input v-model="formInline.user" ></el-input>
      </el-form-item>
      <el-form-item label="状态">
        <el-select v-model="formInline.region" placeholder="请选择状态">
          <el-option label="区域一" value="shanghai"></el-option>
          <el-option label="区域二" value="beijing"></el-option>
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">搜索</el-button>
        <el-button  @click="onSubmit">清除</el-button>
        <el-button type="primary" @click="onSubmit" class="el-icon-plus">新增学科</el-button>
      </el-form-item>
    </el-form>
  </el-card>

<!-- 表格 -->
<el-card class="box-card sub_table">
  <el-table
      :data="tableData"
      style="width:100%">
      <el-table-column
        prop="num"
        label="序号"
        width="80">
      </el-table-column>
      <el-table-column
        prop="sub_id"
        label="学科编号"
       >
      </el-table-column>
      <el-table-column
        prop="sub_name"
        label="学科名称"
        >
      </el-table-column>
      <el-table-column
        prop="abbreviation"
        label="简称"
        >
      </el-table-column>
      <el-table-column
        prop="creator"
        label="创建者"
        >
      </el-table-column>
      <el-table-column
        prop="date"
        label="创建日期"
        >
      </el-table-column>
      <el-table-column
        prop="state"
        label="状态"
        >
      </el-table-column>
      <el-table-column  label="操作">
       <el-button type="text">编辑</el-button>
       <el-button type="text">禁用</el-button>
       <el-button type="text">删除</el-button>
      </el-table-column>
    </el-table>

    <!-- 分页 -->
    <el-pagination
      background
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
      :current-page="currentPage4"
      :page-sizes="[100, 200, 300, 400]"
      :page-size="100"
      layout="total, sizes, prev, pager, next, jumper"
      :total="400" class="page">
      
    </el-pagination>
</el-card>

</div>
 
</template>

<script>
export default {
  data() {
    return {
      formInline: {
        user: "",
        region: ""
      },
      tableData: [
          {
            num:'1',
            sub_id:'QD001',
            sub_name:'前端与移动开发',
            abbreviation:'前端',
            creator:'刘洋洋',
            date:'2019-11-21',
            state:'启用',
          },
      ],
      currentPage4: 1
    };
  },
  methods: {
    onSubmit() {
      window.console.log("submit!");
    },
    // 分页
     handleSizeChange(val) {
        window.console.log(`每页 ${val} 条`);
      },
      handleCurrentChange(val) {
        window.console.log(`当前页: ${val}`);
      }
  }
};
</script>

<style>
 .box-card {
    width: 100%;
    /* background-color: #fff; */
  }
  .sub_table{
    margin-top: 19px;
  }
  .page{
    text-align: center;
    margin-top: 30px;
  }
  .el-link{
    margin-left: 9px;
  }
</style>