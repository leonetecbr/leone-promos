const KeyV3Recaptcha = '6LdiepQaAAAAAAzLXLD1le5GHf0JRShTQvNX2LHt';

$(document).ready(function(){
  if (navigator.share) {
    $('.plus-share').fadeIn("slow");
  }
  
  var nav = $('#cabecalho');   
  $(window).scroll(function () { 
    if ($(this).scrollTop() > 136) { 
      nav.addClass("menu-fixo");
      $('body').css('padding-top', 70);
    } else { 
      nav.removeClass("menu-fixo"); 
      $('body').css('padding-top', 0);
    } 
  });
  
  $('#deeplink').submit(function(e){ 
    e.preventDefault();
    var url_validate = /(https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if(!url_validate.test($('#url').val())){
      $('#url').css({"border":"1px solid #F00"});
      $('.iurl').show();
    }else{
      window.open('/redirect?url='+$('#url').val());
      $('#url').val("");
    }
  });
  
  $(".ajax_form").submit(function(e){
    e.preventDefault();
    var valores = new Object();
    for(var valor of $(this).serializeArray()){
      valores[valor.name] = valor.value;
    }
    let id = this.id;
    let value = $('#'+id+'_submit').html();
    let btn = $('#'+id+'_submit');
    btn.attr('disabled', true);
    btn.html('Aguarde ...');
    $.ajax({
      url: this.action,
      data: JSON.stringify(valores),
      dataType: "json",
      contentType: 'application/json',
      type: "POST",
      success: function (data) {
        processResponse(data, id);
        btn.html(value);
        btn.attr('disabled', false);
      }
    }).fail(function() {
      $('#error_'+id).html('<p class="erro mt-1">Não foi possível enviar os dados, tente novamente!</p>');
      btn.html(value);
      btn.attr('disabled', false);
    });
  });
  
  var search = false;
  $('#btn-menu').click(function(){
    $('#menu').fadeIn("slow");
  });
  
  $('#btn-search').click(function(){
    if (search === false){
      $('#form').fadeIn("slow");
      $('#btn-search').html('<i class="fas fa-times"></i>');
      $('html, body').animate({scrollTop:'80px'},800);
      search = true;
    }else{
      $('#form').fadeOut("slow");
      $('#btn-search').html('<i class="fas fa-search"></i>');
      search = false;
    }
  });
  
  $('#close').click(function(){
    $('#menu').fadeOut("slow");
  });
  
  $("input").change(function(){
    $(this).css({"border": "1px solid #fff"});
    var id = $(this).attr("id"); 
    $('.i'+id).hide();
  });
  
  $("select").change(function(){
    $(this).css({"border": "1px solid #fff"});
    var id = $(this).attr("id"); 
    $('.i'+id).hide();
  });
  
  $("textarea").change(function(){
    $(this).css({"border": "1px solid #fff"});
    var id = $(this).attr("id"); 
    $('.i'+id).hide();
  });
  
  $('#inotify').click(function(){
    $('#notify').fadeOut("slow");
    createCookie("no_notify", 1, 365);
  });
  
  $('.pages').click(function() {
    event.preventDefault();
    var href = $(this).attr('href');
    grecaptcha.ready(function() {
        grecaptcha.execute(KeyV3Recaptcha, {action: 'pagination'}).then(function(token) {
          $('body').append('<form method="post" id="reload" action="'+href+'"><input type="hidden" name="g-recaptcha-response" value="'+token+'"/></form>');
          $('#reload').submit();
        });
      });
  });
});

function accept() {
  createCookie('accept', 'true', 365);
  $(".aviso_eu_cookie").fadeOut("slow");
}

function copy_s(t) {
  $('#noeye').html('<input value="'+t+'" id="text_copy"/>');
  $('#text_copy').select();
  document.execCommand('copy');
  $('#noeye').html('');
  $('#copy_sucess').fadeIn("slow");
  setTimeout(function() {$('#copy_sucess').fadeOut("slow");}, 3000);
}

function copy(e, o) {
  $(o).attr("disabled", false);
  $(o).select();
  document.execCommand('copy');
  $(o).attr("disabled", true);
  window.open(e);
}

function validate_search(){
  if($('#qs').val().length < 3 || $('#qs').val().length > 64){
    $('#qs').css({"border":"1px solid #F00"});
    $('.iqs').show();
  }else{
    grecaptcha.ready(function() {
      grecaptcha.execute(KeyV3Recaptcha, {action: 'search'}).then(function(token) {
          $("#form").append('<input type="hidden" name="g-recaptcha-response" value="'+token+'">');
          var valores = new Object();
          for(var valor of $('#form').serializeArray()){
            valores[valor.name] = valor.value;
          }
          $('#form').attr('action', '/search/'+valores.q);
          $("#form").submit();
      });
    });
  }
}

function validate_newsletter(){
  var erro = false;
  var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);

  if($('#name').val().length < 3 || $('#name').val().length > 20){
    $('#name').css({"border":"1px solid #F00"});
    $('.iname').show();
    erro = true;
  }
  
  if(!er.test($('#email').val())){
    $('#email').css({"border":"1px solid #F00"});
    $('.iemail').show();
    erro = true;
  }
  
  if (!erro) {
    grecaptcha.ready(function() {
      grecaptcha.execute(KeyV3Recaptcha, {action: 'newsletter'}).then(function(token) {
          $("#news").append('<input type="hidden" name="g-recaptcha-response" value="'+token+'">');
          $("#news").submit();
      });
    });
  }
}

function submit(token){
  $('#checkbox').submit();
}

function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
    
}

function processResponse(data, form){
  if (typeof data.success == 'undefined' || typeof data.message == 'undefined'){
    $('#'+form).html('<p class="erro mt-1">Erro desconhecido :(</p>');
  }else if (!data.success){
    $('#error_'+form).html('<p class="erro mt-1">'+data.message+'</p>');
  }else{
    $('#error_'+form).html('<p class="bolder">'+data.message+'</p>');
  }
}