//com.js
function _getSessionHeader() {//获得会话header
    var headers = wx.getStorageSync('SessionHeaders');
    headers['content-type'] = 'application/json';
    return headers;
}
function _saveSessionUser(uinfo) {//保存用户信息
    wx.setStorageSync('SessionUser', uinfo)
}

function _saveLocalSessionHeader(headers) {//保存会话header
    wx.setStorageSync('SessionHeaders', headers)
} 

function _getSessionUser() {//获取用户信息
    return wx.getStorageSync('SessionUser');
}

var com={
    getSessionHeader: _getSessionHeader
  ,updateUserInfo: function () {//同步用户信息
    wx.getUserInfo({
      withCredentials: false,
      success: function (res) {
        console.log(res.userInfo)
        wx.request({
          url: 'https://63481573.qcloud.la/Test/updateUser', //仅为示例，并非真实的接口地址
          data: res.userInfo,
          header: _getSessionHeader(),
          success: function (res) {
            console.log('xxxxxxx')
            console.log(res.data)
          }
        })
      }
    })
  }
  , loginTo3rd: function(code) {//通过第三方登录
    console.log("request is " + code)
    wx.request({
      url: 'https://63481573.qcloud.la/Test/codeLogin', //仅为示例，并非真实的接口地址
      data: {
        code: code
      },
      header: {
        'content-type': 'application/json'
      },
      success: function (res) {
        //暂存SessionHeaders   
        var headers = {};
        headers['skey'] = res.data['data']['skey'];
        headers['uid'] = res.data['data']['uid'];
        headers['timestamp'] = res.data['data']['timestamp'];
        _saveLocalSessionHeader(headers)
        _saveSessionUser(res.data['data'])
        console.log(_getSessionUser())
      }
    })
    console.log("request to " + code)
  }
    , saveLocalSessionHeader: _saveLocalSessionHeader
    , saveSessionUser: _saveSessionUser
    , getSessionUser: _getSessionUser
  , testQ:function () {
    //登录后请求示例 
    wx.request({
      url: 'https://63481573.qcloud.la/Test/testQ',
      data: {
      },
      header: _getSessionHeader(),
      success: function (res) {
        console.log(res.data)
      }
    })
  }
}

module.exports = com;















