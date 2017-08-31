//获取应用实例
var com = require('../../com')
var app = getApp()
Page({
  data: {
      lname:""
      ,to_tip:""
      ,close_tip:""
  },
  onLoad: function () {
    console.log('add/index')
  },
  save:function(e){
      console.log('保存')      
      console.log(this.data)
      if(this.data.lname=="" || this.data.to_tip=="" || this.data.close_tip==""){
          com.showm("输入有误");
          return ;
      }
      //发出请求
      com.sessionRequest('/Line/add',this.data,function(r){   
          console.log(r)       
          if(r.data.status==200){
              com.showm('创建成功');
              wx.redirectTo({ url:'/pages/index2/index'});
          }else{
              com.showm('创建失败');
          }
      });
  }
  ,cancel:function(){
      console.log('取消')
  }
  ,input:function(e){
      this.data[e.target.id] = e.detail.value
  }
})