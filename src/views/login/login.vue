<template>
  <div class="login-box">
    <div class="login_form">
      <!-- 标题 -->
      <div class="title">
        <img src="../../assets/img/title.png" alt />
        <span class="heima">黑马面面</span>
        <i></i>
        <span class="user">用户登录</span>
      </div>
      <el-form ref="form" :model="form" :rules="rules">
        <!-- 手机号 -->
        <el-form-item prop='phone'>
          <el-input
            class="login_input"
            placeholder="请输入手机号"
            prefix-icon="el-icon-user"
            v-model="form.phone"
            prop="phone"
          ></el-input>
          </el-form-item>
          <!-- 密码 -->
          <el-form-item prop='password'>
          <el-input
            class="login_input"
            placeholder="请输入密码"
            prefix-icon="el-icon-lock"
            show-password
            v-model="form.password"
            prop="password"
          ></el-input>
          </el-form-item>
          <!-- 验证码 -->
          <el-form-item prop='captcha'>
          <el-row>
            <el-col :span="18">
              <el-input
                class="login_input"
                placeholder="请输入验证码"
                prefix-icon="el-icon-key"
                v-model="form.captcha"
              ></el-input>
              <!-- 验证码图片 -->
            </el-col>
            <el-col :span="6">
              <img :src="yzmUrl" alt class="yzm" @click="yzm"/>
            </el-col>
          </el-row>
        </el-form-item>
        <!-- check-box -->
        <el-checkbox-group v-model="form.type" class="checkbox_login">
          <el-checkbox name="type" class="agree">
            我已阅读并同意
            <el-link type="primary">用户协议</el-link>和
            <el-link type="primary">隐私条例</el-link>
          </el-checkbox>
        </el-checkbox-group>
        <!-- 按钮 -->
        <el-form-item>
          <el-button type="primary" class="button_login" @click="submitForm">登录</el-button>
          <el-button type="primary" class="zhuce">注册</el-button>
        </el-form-item>
      </el-form>

      <!-- 右边的图片 -->
    </div>
    <div class="login_img">
      <img src="../../assets/img/login_banner_ele.png" alt />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  
  data() {
    var checkPhone = (rule, value, callback) => {
      if (!value) {
        return callback(new Error("手机号不能为空"));
      } else {
        // 判断手机号的格式
        // 正则
        const reg = /^(0|86|17951)?(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/;
        // 判断是否符合
        // .test(验证的字符串) 返回的是 true 或者false
        if (reg.test(value) == true) {
          callback();
        } else {
          // 不满足 手机号的格式
          callback(new Error("老铁，你的手机号写错了噢"));
        }
      }
    };
    return {
      form: {
        phone: "",
        password: "",
        captcha: "",
        type:false
      },
      yzmUrl:process.env.VUE_APP_BASEURL + '/captcha?type=login',
      rules: {
        // message 提示信息
        // trigger：触发方式  blur（失焦） change(改变)
        // min:最短
        // max:最长
        // required：是否不能为空
        phone: [{ required: true, validator: checkPhone, trigger: "blur" }],
        // 密码
        password: [
          {
            required: true,
            message: "密码不能为空",
            trigger: "change"
          },
          {
            min: 6,
            max: 18,
            message: "密码长度为 6 到 18",
            trigger: "change"
          }
        ],
        // 验证码
        captcha: [
          {
            required: true,
            message: "验证码不能为空",
            trigger: "change"
          },
          {
            min: 4,
            max: 4,
            message: "验证码长度为4",
            trigger: "change"
          }
        ]
      }
    };
  },
  methods: {
    submitForm() {
      // 是否勾选
      if (this.form.checked === false) {
        // 没勾，提示
        this.$message.warning("老铁，没勾哦，先勾一下呗！")
      } else {
        this.$refs.form.validate(valid => {
          if (valid) {
            // 验证成功
            // this.$message.success("恭喜你，成功啦");
            axios({
              url:process.env.VUE_APP_BASEURL + '/login',
              method:'post',
              withCredentials:true,
              data:{
                phone:this.form.phone,
                password:this.form.password,
                code:this.form.captcha
              }
            }).then(res=>{
              window.console.log(res)
            })
          } else {
            // 验证失败
            this.$message.error("很遗憾，内容没有写对！");

            return false;
          }
        });
      }
    },
    yzm(){
      this.yzmUrl = process.env.VUE_APP_BASEURL + '/captcha?type=login&_t=' + Date.now();
    }
  }
};
</script>

<style lang="less">
.login-box {
  width: 100%;
  height: 100%;
  // box-sizing: border-box;

  background: linear-gradient(
    225deg,
    rgba(20, 147, 250, 1),
    rgba(1, 198, 250, 1)
  );
  display: flex;
  align-items: center;
  justify-content: space-around;

  .yzm{
    height: 40px;
  }
  .login_form {
    width: 478px;
    height: 550px;
    background-color: #f5f5f5;
    padding: 44px;

    .login_input {
      margin-top: 25px;
    }

    .el-checkbox {
      display: flex;
      align-items: center;

      .el-checkbox__label {
        display: flex;
        align-items: center;
      }
    }

    .yzm {
      width: 100%;
      margin-top: 25px;
    }

    .button_login {
      width: 100%;
      margin: 0;
      margin-bottom: 26px;
      margin-top: 29px;
    }

    .zhuce {
      width: 100%;
      margin: 0;
    }

    .title {
      display: flex;
      align-items: center;
      //   margin-bottom: 27px;

      img {
        margin-right: 17px;
        height: 17px;
        width: 22px;
      }

      .heima {
        font-size: 24px;
        margin-right: 22px;
      }

      .user {
        font-size: 22px;
      }

      i {
        width: 1px;
        height: 28px;
        background-color: #c7c7c7;
        margin-right: 28px;
      }
    }
  }
}
</style>