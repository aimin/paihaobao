//获取应用实例
var com = require('../../com')
var app = getApp()
Page({
  data: {
    lindetail:{}
  },
  onLoad: function (op) {
    var p = this;
    com.sessionRequest('/Line/detail', { lid:op.lid}, function (r) {
      
      p.setData({
        lindetail: r.data.data
      });
      console.log(r.data.data.line)
    });
  }

})