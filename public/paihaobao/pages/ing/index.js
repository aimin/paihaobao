//获取应用实例
var com = require('../../com')
var app = getApp()
Page({
  data: {
    detail:{}
  },
  onLoad: function (op) {
    console.log('ing/index')
    this.setData({
      detail: com.Get('paihao_detail')
    })
    console.log(com.Get('paihao_detail'))
  }

})