$(function(){
  // $('#password').keyup(function(){
  //   var username = $('input[name=u]');  
  //   var password = $('input[name=p]');
  //   $.post(url2,{username:username.val(),password:password.val()},function(data){
  //     if(data == 1){
  //       $('.login-verify').fadeIn();       
  //     }    
  //   },'json');
  // });
//$('#spanid').html("");
  if($.cookie("captcha")){
    var count = $.cookie("captcha");
    var btn = $('#verify');
    btn.val(count+'秒后可重新获取').attr('disabled',true).css('cursor','not-allowed');
    var resend = setInterval(function(){
      count--;
      if (count > 0){
        btn.val(count+'秒后可重新获取').attr('disabled',true).css('cursor','not-allowed');
        $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
      }else {
        clearInterval(resend);
        btn.val("获取验证码").removeClass('disabled').removeAttr('disabled style');
      }
    }, 1000);
  }
  $('#verify').click(function(){
    $("#inverify").focus();
    var btn = $(this);
    $('.message').fadeIn();
    var count = 30;
    var username = $('input[name=u]');  
    $.post(url,{username:username.val()}, function(data){
      $('.message').val(data);
    },'json');
    var resend = setInterval(function(){
      count--;
      if (count > 0){
        btn.val(count+"秒后可重新获取");
        $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
      }else {
        clearInterval(resend);
        btn.val("获取验证码").removeAttr('disabled style');
      }
    }, 1000);
    btn.attr('disabled',true).css('cursor','not-allowed');
  });
});