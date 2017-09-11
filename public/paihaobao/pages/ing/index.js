//获取应用实例
var com = require('../../com')
var app = getApp()
Page({
  data: {
    detail: {}
  }  
  ,onLoad:function(){    
    this.setData({
      detail: com.Get('paihao_detail')
    });   
  }
})

