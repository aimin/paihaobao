//app.js
var com = require('./com')

function tologin() {
  wx.login({
    success: function (res) {      
      if (res.code) {
        //首次登录并更新用户信息        
        com.loginTo3rd(res.code)
      } else {
        console.log('用户登录失败' + res.errMsg)
      }
    }
  });
};
App({
  onLaunch: function() {       
    //调用API从本地缓存中获取数据
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)    
    
    wx.checkSession({
        success: function (res) {
            //todo 登录有效处理            
            if(com.getSessionHeader()==''){
              console.log('to login')
              tologin();
            }
        },
        fail: function () {
            console.log('faile')
            tologin();
        }
    })

  },
 
  getUserInfo: function(cb) {
    var that = this
    if (this.globalData.userInfo) {
      typeof cb == "function" && cb(this.globalData.userInfo)
    } else {
      //调用登录接口
      wx.getUserInfo({
        withCredentials: false,
        success: function(res) {
          that.globalData.userInfo = res.userInfo
          typeof cb == "function" && cb(that.globalData.userInfo)
        }
      })
    }
  },

  globalData: {
    userInfo: null
  }
})



// //同步用户信息
// function updateUserInfo(){
//   wx.getUserInfo({
//     withCredentials: false,
//     success: function (res) {
//       console.log(res.userInfo)
//       wx.request({
//         url: 'https://63481573.qcloud.la/Test/updateUser', //仅为示例，并非真实的接口地址
//         data: res.userInfo,
//         header: getSessionHeader(),
//         success: function (res) {
//           console.log('xxxxxxx')
//           console.log(res.data)
//         }
//       })
//     }
//   })
// }

// //通过第三方登录
// function loginTo3rd(code){
//   console.log("request is "+code)
//   wx.request({
//     url: 'https://63481573.qcloud.la/Test/codeLogin', //仅为示例，并非真实的接口地址
//     data: {
//       code: code
//     },
//     header: {
//       'content-type': 'application/json'
//     },
//     success: function (res) {      
//       //暂存SessionHeaders   
//       var headers = {};
//       headers['skey'] = res.data['data']['skey'];
//       headers['uid'] = res.data['data']['uid'];
//       headers['timestamp'] = res.data['data']['timestamp'];
//       saveLocalSessionHeader(headers)
//       saveSessionUser(res.data['data'])
//       console.log(getSessionUser())

//     }
//   })
//   console.log("request to " + code)
// }

// //保存会话header
// function saveLocalSessionHeader(headers) {
//   wx.setStorageSync('SessionHeaders', headers)
// }
// //获得会话header
// function getSessionHeader() {
//   var headers = wx.getStorageSync('SessionHeaders');
//   headers['content-type'] = 'application/json';
//   return headers;
// }
// //保存用户信息
// function saveSessionUser(uinfo){
//   wx.setStorageSync('SessionUser', uinfo)
// }
// //获取用户信息
// function getSessionUser() {
//   return wx.getStorageSync('SessionUser');
// }

// function testQ(){
//   //登录后请求示例 
//   wx.request({
//     url: 'https://63481573.qcloud.la/Test/testQ', 
//     data: {
//     },
//     header: getSessionHeader(),
//     success: function (res) {
//       console.log(res.data)
//     }
//   })
// }
