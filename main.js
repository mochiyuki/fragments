$(document).ready(function(){

  $('#login-button').on('click', function(event){
    event.preventDefault();

    var data = {
      username:$('#username').val(),
      password:$('#password').val()
    };

      $.ajax({
        url: 'login.php',
        type: 'POST',
        data: data,
        dataType: 'JSON'
      })
      .done(function(data){
        $('#login_error1').val('');
        $('#login_error2').val('');
        $('#login_error3').val('');
        $('#login_error4').val('');

        $('#login_error1').css('display', 'none');
        $('#login_error2').css('display', 'none');
        $('#login_error3').css('display', 'none');
        $('#login_error4').css('display', 'none');
        if(data.type == 'success'){
          window.location = 'home';
        }
        else if(data.type == 'error1'){
          $('#login_error1').css('display', 'block');
        }
        else if(data.type == 'error2'){
          $('#login_error2').css('display', 'block');
        }
        else if(data.type == 'error3'){
          $('#login_error3').css('display', 'block');
        }
        else if(data.type == 'error4'){
          $('#login_error4').css('display', 'block');
        }
    });
  });

  $('#register-button').on('click', function(event){
    event.preventDefault();

    var data = {
      username:$('.username').val(),
      password:$('.password').val(),
      passwordver:$('.passwordver').val(),
      email:$('.email').val()
    };

    $.ajax({
      url: 'register.php',
      type: 'POST',
      data: data,
      dataType: 'JSON'
    })
    .done(function(data){
      $('#passwordver_error').val('');
      $('#email_error1').val('');
      $('#email_error2').val('');
      $('#username_error1').val('');
      $('#username_error2').val('');
      $('#fields_error').val('');

      $('#passwordver_error').css('display', 'none');
      $('#email_error1').css('display', 'none');
      $('#email_error2').css('display', 'none');
      $('#username_error1').css('display', 'none');
      $('#username_error2').css('display', 'none');
      $('#fields_error').css('display', 'none');

      if(data.type == 'success'){
        alert('A confirmation key has been sent, please check your email inbox :)');
      }
      else if(data.type == 'error1'){
        $('#passwordver_error').css('display', 'block');
      }
      else if(data.type == 'error2'){
        $('#email_error1').css('display', 'block');
      }
      else if(data.type == 'error3'){
        $('#email_error2').css('display', 'block');
      }
      else if(data.type == 'error4'){
        $('#username_error1').css('display', 'block');
      }
      else if(data.type == 'error5'){
        $('#username_error2').css('display', 'block');
      }
      else if(data.type == 'error6'){
        $('#fields_error').css('display', 'block');
      }
    });
  });

  $('#write a').on('click', function(){
    $('#openModal-new').css('display', 'block');
  });

  $('.send-new').on('click', function(event){
    event.preventDefault();
      var title=$('.title').val();
      var content=$('.content').val();
    if(title && content){
      $.ajax({
        type:'POST',
        url:'php/add-post.php',
        data:{title:title, content:content}
      })
      .done(function(data){
        $('#openModal-new').css('display', 'none');
        //console.log(data);
        window.location.hash = '';
        history.replaceState({}, document.title, location.href.replace('#', ''));
        window.location.reload();
      });
    } else {$('.modal-new p').fadeIn();}
  });

  $('#closeModal').on('click', function(){
    $('#openModal-new').css('display', 'none');
    window.location.hash = '';
    history.replaceState({}, document.title, location.href.replace('#', ''));
  });


  $('.closePost').on('click', function(){
    $('.post-modal').css('display', 'none');
    window.location.reload();
    window.location.hash = '';
    history.replaceState({}, document.title, location.href.replace('#', ''));
  });

  $('.post button').on('click', function(event){
    var postId = $(this).attr('data-id');
    event.preventDefault();

    $.ajax({
      type:'POST',
      url:'php/see-comments.php',
      data:{postId:postId}
    })
    .done(function(data){
      $('.post-modal').css('display', 'flex');
      $('.test1').html(data);
    });
  });

  $('.story-author').on('click', function(event){
    var memberId = $(this).attr('member-id');
    event.preventDefault();

    $.ajax({
      type:'POST',
      url:'php/see-profile.php',
      data:{memberId:memberId}
    })
    .done(function(data){
      $('.member-profile').css('display', 'block');
      $('.test3').html(data);
    });
  });

  $('.label-logging input').focus(function(){
    $(this).parent().css({'color':'#ace5ee','font-size':'4.2vh'});
  });

  $('.label-logging input').blur(function(){
    $(this).parent().css(({'color':'white','font-size':'4vh'}));
  });

  $('#info').on('click', function(){
    $('#inforeply').slideToggle();
  });

  $('#register-redirection').on('click', function(){
    $('#login-form').fadeOut();
    $('#register-form').fadeIn().css('display', 'flex');
  });

  $('#options li').on('click', function(){
    $(this).addClass('active');
    $(this).siblings().removeClass('active');
  });

  $('#write').on('click', function(){
    $('#write li').slideToggle();
  });

  $('#latest').on('click', function(){
    $('#container').fadeIn(800);
    $('#container2').css('display', 'none');
    $('#container3').css('display', 'none');
  });

  $('#popular').on('click', function(){
    $('#container').css('display', 'none');
    $('#container2').fadeIn(800);
    $('#container3').css('display', 'none');
  });

  $('#trending').on('click', function(){
    $('#container').css('display', 'none');
    $('#container2').css('display', 'none');
    $('#container3').fadeIn(800);
  });

  $('.story-author').on('click', function(){
    $('#see-profile').css('display', 'block');
  });

  $('#myprofile a').on('click', function(){
      $('#modifyProfile').css('display', 'block');
  });

  $('#modifyProfile button').on('click', function(){
    $('#modifyProfile').css('display', 'none');
    window.location.hash = '';
    history.replaceState({}, document.title, location.href.replace('#', ''));
  });

  var searchTimeout;
  $('#searchbar').on('keyup', function(event){
    var value = $(this).val();
    if(value.length > 2){
      clearTimeout(searchTimeout);
      searchTimeout=setTimeout(function(){
        $.ajax({
          type:'POST',
          url:'php/search.php',
          data:{keyword:value},
          dataType:'JSON'
        })
        .done(function(data){
          $('#search-list').html('');
          data.forEach(function(val){
          $('<li><label><input type="radio" name="search-member" value="'+val.id+'">&nbsp;'+val.username+'</label></li>').appendTo($('#search-list'));
          })
        })
      }, 200);
    }
  else{$('#search-list').html('');}
  })

  $('#search-button').on('click', function(){
    var data={
      member:$('input[name="search-member"]').val()
  };

  $.ajax({
    type:'POST',
    url:'php/show-member.php',
    data:data
  })
  .done(function(data){
    $('#modal-search').css('display', 'block');
    $('#modal-view').html(data);
  });
  });
});