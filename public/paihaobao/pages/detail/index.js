//获取应用实例
var com = require('../../com')
var app = getApp()
Page({
  data: {
    detail:{}
  },
  onLoad: function (op) {
    var p = this;
    com.sessionRequest('/Line/detail', { lid:op.lid}, function (r) {      
      p.setData({
        detail: r.data.data
      });
      com.Set('paihao_detail',r.data.data)
    });
  }
  ,start:function(){
    console.log(this.data.detail.line)
    if (this.data.detail.line.status == 1){
      // console.log('111111')
      wx.navigateTo({ url: '/pages/ing/index', });
    }else{
      // console.log('000000')
      var p = this;
      com.sessionRequest('/Line/start', { lid: this.data.detail.line.lid }, function (r) {
        if(r.data.status=='200'){
          p.data.detail.inline = r.data.data;          
          p.setData({
            detail: r.data.data
          });
          com.Set('paihao_detail', p.data.detail)
          wx.navigateTo({ url: '/pages/ing/index', });
        }else{
          com.showm('启动排号失败!');
        }
      });
    }    
  }


})