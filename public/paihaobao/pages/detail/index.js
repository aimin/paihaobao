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
    // console.log(this.data.detail.line)
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
  ,stop:function(){    
    var p = this;
    com.sessionRequest('/Line/stop', { lid: this.data.detail.line.lid }, function (r) {
      if (r.data.status == '200') {
        p.data.detail.line.status=2;        
        p.setData({
          detail: p.data.detail
        });
        com.Set('paihao_detail', p.data.detail)
        com.showm('停止成功!');
      } else {
        com.showm('停止排号失败!');
      }
    });
  }
  , del: function () {
    var p = this;
    com.sessionRequest('/Line/del', { lid: this.data.detail.line.lid }, function (r) {
      if (r.data.status == '200') {
        p.data.detail.line.status = -1;
        p.setData({
          detail: p.data.detail
        });
        com.Set('paihao_detail', p.data.detail)
        com.showm('删除成功!');
      } else {
        com.showm('操作失败!');
      }
    });
  }

})