//index.js
//获取应用实例
var com = require('../../com')

var app = getApp()

var pp = {
    data: {
        motto: 'Hello World',
        userInfo: {}
        , list: []
    },
    onLoad: function (op) {
        wx.showNavigationBarLoading()      
        this.data = [{ lid: 1, lname: "tttt" }, { lid: 2, lname: "rrrr" }];
        var that = this
        //调用应用实例的方法获取全局数据
        app.getUserInfo(function (userInfo) {
            //更新数据
            that.setData({
                userInfo: userInfo
            })
        })
    }   
    ,onShow:function(){
        var p = this;
        com.sessionRequest('/Line/list', {page:0}, function (r) {                        
            var datalist = r.data.data;
            // console.log(datalist);
            p.setData({
                list: datalist
            });
            wx.hideNavigationBarLoading()
        }); 
    }   
 
};

var p = Page(pp)
