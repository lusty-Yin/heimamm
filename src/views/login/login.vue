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
        <el-form-item prop="phone">
          <el-input
            class="login_input"
            placeholder="请输入手机号"
            prefix-icon="el-icon-user"
            v-model="form.phone"
            prop="phone"
          ></el-input>
        </el-form-item>
        <!-- 密码 -->
        <el-form-item prop="password">
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
        <el-form-item prop="captcha">
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
              <img :src="yzmUrl" alt class="yzm" @click="yzm" />
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
          <el-button type="primary" class="zhuce" @click="dialogFormVisible = true">注册</el-button>
          <!-- 注册表单 -->
          <el-dialog title="用户注册" class="zc_title" :visible.sync="dialogFormVisible">
            <el-form :model="regForm" :rules="registerRules">
              <el-form-item label="昵称" required :label-width="formLabelWidth">
                <el-upload
                  class="avatar-uploader"
                  action="http://127.0.0.1/heimamm/public/uploads"
                  :show-file-list="false"
                  :on-success="handleAvatarSuccess"
                  :before-upload="beforeAvatarUpload"
                >
                  <img v-if="imageUrl" :src="imageUrl" class="avatar" />
                  <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
              </el-form-item>
              <el-form-item label="昵称" required :label-width="formLabelWidth" prop="userName">
                <el-input v-model="regForm.userName" autocomplete="off"></el-input>
              </el-form-item>
              <el-form-item label="邮箱" required :label-width="formLabelWidth" prop="email">
                <el-input v-model="regForm.email" autocomplete="off"></el-input>
              </el-form-item>
              <el-form-item label="手机" required :label-width="formLabelWidth" prop="phone">
                <el-input v-model="regForm.phone" autocomplete="off"></el-input>
              </el-form-item>
              <el-form-item label="密码" required :label-width="formLabelWidth" prop="password">
                <el-input v-model="regForm.password" autocomplete="off"></el-input>
              </el-form-item>
              <el-form-item label="图形码" :label-width="formLabelWidth" prop="code">
                <el-row>
                  <el-col :span="16">
                    <el-input v-model="regForm.code" autocomplete="off"></el-input>
                  </el-col>
                  <el-col :span="7" :offset="1">
                    <img :src="regCaptchaUrl" alt class="zc_yzm" @click="changeCode">
                  </el-col>
                </el-row>
              </el-form-item>
              <el-form-item label="验证码" :label-width="formLabelWidth" prop="captcha">
                <el-col :span="16">
                  <el-input v-model="regForm.captcha" autocomplete="off"></el-input>
                </el-col>
                <el-col :span="7" :offset="1">
                  <el-button @click="getRegCaptcha">获取用户验证码</el-button>
                </el-col>
              </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
              <el-button @click="dialogFormVisible = false">取 消</el-button>
              <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
            </div>
          </el-dialog>
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
import axios from "axios";
export default {
  data() {
    // 手机判断
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
    // 邮箱判断
    var checkEmail = (rule, value, callback) => {
      if (!value) {
        return callback(new Error("手机号不能为空"));
      } else {
        // 判断手机号的格式
        // 正则
        const reg = /\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/;
        // 判断是否符合
        // .test(验证的字符串) 返回的是 true 或者false
        if (reg.test(value) == true) {
          callback();
        } else {
          // 不满足 手机号的格式
          callback(new Error("老铁，你的邮箱格式写错了噢"));
        }
      }
    };
    return {
      form: {
        phone: "",
        password: "",
        captcha: "",
        type: false
      },
      regForm:{
        userName:'',
        email:'',
        password:'',
        phone:'',
        code:'',
        captcha:''
      },
      yzmUrl: process.env.VUE_APP_BASEURL + "/captcha?type=login",
      regCaptchaUrl:process.env.VUE_APP_BASEURL + "/captcha?type=sendsms",
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
      },
      // 注册表单规则
      registerRules:{
        // 手机
         phone: [{ required: true, validator: checkPhone, trigger: "blur" }],
        //  邮箱
        email:[
          {
            required: true, validator: checkEmail, trigger: "blur"
          }
        ],
        //  昵称
        userName:[
          {
            required:true,
             message: "昵称不能为空",
            trigger: "blur"
          },
          {
            min: 2,
            max: 18,
            message: "昵称长度为 6 到 18",
            trigger: "change"
          }
        ],
         // 密码
        password: [
          {
            required: true,
            message: "密码不能为空",
            trigger: "blur"
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
            trigger: "blur"
          },
          {
            min: 4,
            max: 4,
            message: "验证码长度为4",
            trigger: "blur"
          }
        ],
        // 图形码
        code: [
          {
            required: true,
            message: "图形码不能为空",
            trigger: "blur"
          },
          {
            min: 4,
            max: 4,
            message: "图形码长度为4",
            trigger: "blur"
          }
        ]
      },
      // 注册表单
      dialogTableVisible: false,
      dialogFormVisible: false,
      zc_form: {
        
      },
      imageUrl:'',
      formLabelWidth: "120px"
    };
  },
  methods: {
    submitForm() {
      // 是否勾选
      if (this.form.checked === false) {
        // 没勾，提示
        this.$message.warning("老铁，没勾哦，先勾一下呗！");
      } else {
        this.$refs.form.validate(valid => {
          if (valid) {
            // 验证成功
            // this.$message.success("恭喜你，成功啦");
            axios({
              url: process.env.VUE_APP_BASEURL + "/login",
              method: "post",
              withCredentials: true,
              data: {
                phone: this.form.phone,
                password: this.form.password,
                code: this.form.captcha
              }
            }).then(res => {
              window.console.log(res);
            });
          } else {
            // 验证失败
            this.$message.error("很遗憾，内容没有写对！");

            return false;
          }
        });
      }
    },
    yzm() {
      this.yzmUrl =
        process.env.VUE_APP_BASEURL + "/captcha?type=login&_t=" + Date.now();
    },
    changeCode(){
      this.regCaptchaUrl =
        process.env.VUE_APP_BASEURL + "/captcha?type=sendsms&_t=" + Date.now();
    },
    getRegCaptcha(){
      // 手机正则判断
       const reg = /^(0|86|17951)?(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/;
      if(! reg.test(this.regForm.phone) ){
        return this.$message.error('手机号不太对喔!')
      }
      if(this.regForm.code.length != 4 || this.regForm.code == ''){
        return this.$message.error('图形码不正确')
      }

      axios({
        url:process.env.VUE_APP_BASEURL + '/sendsms',
        method:'post',
        withCredentials: true,
        data:{
          code:this.regForm.code,
          phone:this.regForm.phone
        }
      }).then(res=>{
        window.console.log(res);
        this.$message.success("短信验证码是:" +res.data.data.captcha)
      })
    },
    // 文件上传
     handleAvatarSuccess(res, file) {
        this.imageUrl = URL.createObjectURL(file.raw);
      },
      beforeAvatarUpload(file) {
        const isJPG = file.type === 'image/jpeg';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPG) {
          this.$message.error('上传头像图片只能是 JPG 格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return isJPG && isLt2M;
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

  .yzm {
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
    .zc_yzm{
      width: 100%;
    }
    .el-dialog {
      width: 603px;
      .el-dialog__header {
        text-align: center;
        background: linear-gradient(to right, #01c4fa, #1294fa);
        padding-bottom: 20px;
        .el-dialog__title {
          color: white;
        }
      }
      .el-form-item {
        margin-top: 24px;
      }
    }

   .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    
  }
  .avatar-uploader{
    text-align: center;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
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