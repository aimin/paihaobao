//获取应用实例
var com = require('../../com')
var app = getApp()

var pg = Page({
  data: {
    detail: com.Get('paihao_detail')
  }
  ,onLoad:function(){    
    this.setData({
      detail: com.Get('paihao_detail')
    });   
  }
})

