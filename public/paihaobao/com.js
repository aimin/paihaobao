//com.js
function _getSessionHeader() {//获得会话header
    var headers = wx.getStorageSync('SessionHeaders');
    if(headers!=''){
      headers['content-type'] = 'application/json';
    }
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

function _sessionRequest(uri,data,cb){ //发出会话请求
    wx.getUserInfo({
        withCredentials: false,
        success: function (res) {
            // console.log(res.userInfo)
            wx.request({
                url: 'https://63481573.qcloud.la'+uri, //仅为示例，并非真实的接口地址
                data: data,
                header: _getSessionHeader(),
                success: function (res) {
                    if(cb!=undefined){
                        cb(res);   
                    }
                }
            })
        }
    })
}


function _updateUserInfo() {//同步用户信息
    wx.getUserInfo({
        withCredentials: false,
        success: function (res) {
            // console.log(res.userInfo)
            wx.request({
                url: 'https://63481573.qcloud.la/Login/updateUser', //仅为示例，并非真实的接口地址
                data: res.userInfo,
                header: _getSessionHeader(),
                success: function (res) {
                    // console.log(res.data)
                }
            })
        }
    })
}

function _showm(title){
    wx.showToast({
        title: title,
        icon: 'success',
        duration: 2000
    })
}
var com={
    getSessionHeader: _getSessionHeader
    ,showm:_showm
  ,updateUserInfo: _updateUserInfo
  , loginTo3rd: function(code) {//通过第三方登录
    // console.log("request is " + code)
    wx.request({
      url: 'https://63481573.qcloud.la/Login/codeLogin', //仅为示例，并非真实的接口地址
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
        _updateUserInfo();
      }
    })
    // console.log("request to " + code)
  }
    , saveLocalSessionHeader: _saveLocalSessionHeader
    , saveSessionUser: _saveSessionUser
    , getSessionUser: _getSessionUser
    , sessionRequest: _sessionRequest
  , testQ:function () {
    //登录后请求示例 
    wx.request({
      url: 'https://63481573.qcloud.la/Login/testQ',
      data: {
      },
      header: _getSessionHeader(),
      success: function (res) {
        // console.log(res.data)
      }
    })
  }
}

module.exports = com;















