function send_request(data_order) {
  $.ajax({
    type: 'POST',
    url: "/index.php/Page/send_request_email",
    data: {request: JSON.stringify(data_order)},
    //data: {brand: val},
    //dataType: "html",
    success: function (response) {
      console.log(response);
    },
  });

  var phone = $('.block-form__el_three input[name="phone"]').val();
  if (phone !== '' && typeof phone !== 'undefined')
  {
    $.ajax({
      type: 'POST',
      url: "/index.php/Auth",
      data: {
        phone: phone,
        action: 'auth-reg',
        not_main_page: 'true'
      },
      //data: {brand: val},
      //dataType: "html",
      success: function (response) {
        console.log(response);
      },
    });
  }

  //window.location.href = '/';
}

$(document).ready(function() {
  $('#cat_search').click(function() {
    let display = $('.search_wrapper .brand_list').css('display');
    console.log(display);
    if (display === 'none')
      $('.search_wrapper .brand_list').css('display', 'block');
    if (display === 'block')
      $('.search_wrapper .brand_list').css('display', 'none');
  });

  $('#full_engine').on('click', function() {
    //console.log($(this));
    let state = $(this).prop('checked');
    //console.log(state);
    if (state === true)
    {
      $(this).parents('.block-form__el-top').next('#wrap-form-elements').css('display', 'none');
      $('#wrap-form-elements').next('.block-form__el-bottom .btn-add block-form__el_two__add').css('display', 'none');
      $('.block-form__el.block-form__el_two a.btn-add.block-form__el_two__add').css('display', 'none');
      $('.block-form__el_two > .block-form__el-dec:first-child').css('display','none');
    }
    else
    {
      $(this).parents('.block-form__el-top').next('#wrap-form-elements').css('display', 'block');
      $('#wrap-form-elements').next('.block-form__el-bottom .btn-add block-form__el_two__add').css('display', 'block');
      $('.block-form__el.block-form__el_two a.btn-add.block-form__el_two__add').css('display', 'block');
      $('.block-form__el_two > .block-form__el-dec:first-child').css('display','block');
    }
  });
  $("select[name=appointment]").change(function() {
    let type = $(this).find('option:selected').val();
    console.log("type:" + type);
    if (type == 70)
    {
      // console.log("element to hide: ");
      // console.log($(this).parents('form.block-form__el-body')
      //     .find('input[name=engine]')
      //     .parents('.block-form__el-el.form-el'));
      $(this).parents('form.block-form__el-body')
          .find('input[name=engine]')
          .parents('.block-form__el-el.form-el')
          .css('display', 'none')
          .prop('required', false);

      $('#full_engine_container').css('display', 'none');
    }
    else
    {
      $(this).parents('form.block-form__el-body')
          .find('input[name=engine]')
          .parents('.block-form__el-el.form-el')
          .css('display', 'flex')
          .prop('required', false);

      $('#full_engine_container').css('display', 'block');
    }
  });

function setNoscroll(){
	$('html').addClass('noscroll');
}
function unsetNoscroll(){
	$('html').removeClass('noscroll');
}

// $('.inpTel').mask("7 (999) 999 99 99");

function getScrollBarWidth (){
  var inner = document.createElement('p');
  inner.style.width = "100%";
  inner.style.height = "200px";

  var outer = document.createElement('div');
  outer.style.position = "absolute";
  outer.style.top = "0px";
  outer.style.left = "0px";
  outer.style.visibility = "hidden";
  outer.style.width = "200px";
  outer.style.height = "150px";
  outer.style.overflow = "hidden";
  outer.appendChild (inner);

  document.body.appendChild (outer);
  var w1 = inner.offsetWidth;
  outer.style.overflow = 'scroll';
  var w2 = inner.offsetWidth;
  if (w1 == w2) w2 = outer.clientWidth;

  document.body.removeChild(outer);

  return (w1 - w2);
};

$('head').append('<style>.noscroll{margin-right: '+getScrollBarWidth()+'px;}</style>');
$('head').append('<style>.noscroll .top-menu{padding-right: '+getScrollBarWidth()+'px;}</style>');


// jQuery(function($){
// 	$('body').mouseup(function (e){ // событие клика по веб-документу
// 		var div = $('.top-menu');
// 		if (!div.is(e.target) // если клик был не по нашему блоку
// 		    && div.has(e.target).length === 0) { // и не по его дочерним элементам
// 				if ( $(e.target).closest('.modal').length ) {
					
// 				}else{
// 					$('.top-menu__burger').removeClass('active');
// 					$('.top-menu').removeClass('active');
// 					$('.top-menu__menu').fadeOut(400);
// 					unsetNoscroll();
// 				}
// 		}
// 	});

// });

$('.block-form__el_two__add').on('click', function(){
  $('#wrap-form-elements').append('<div class="form-block-el block-form__el-formel">\
    <div class="form-block-el__content">\
      <div class="form-block-el__left">\
        <div class="form-block-el__count">№'+ (+$("#wrap-form-elements").find(".block-form__el-formel").length + 1) +'</div>\
      </div>\
      <div class="form-block-el__right">\
        <div class="form-block-el__inp">\
          <div class="form-block-el__inp-title">Название детали</div>\
          <input type="text" class="form-block-el__inp-inp formInp inp">\
        </div>\
        <div class="form-block-el__inputs">\
          <div class="form-block-el__inputs-big">\
            <div class="form-block-el__inp">\
              <div class="form-block-el__inp-title">Номер в каталогах</div>\
              <input type="text" class="form-block-el__inp-inp formInp inp">\
            </div>\
          </div>\
          <div class="form-block-el__inputs-small">\
            <div class="form-block-el__inp">\
              <div class="form-block-el__inp-title">Количество</div>\
              <input type="text" name="detail_amount[]" class="form-block-el__inp-inp formInp inp">\
            </div>\
          </div>\
        </div>\
      </div>\
    </div>\
    <label class="form-block-el__content wrap-file">\
      <input type="file" class="wrap-file__inp">\
      <div class="form-block-el__left">\
        <img src="../img/photo.png" alt="" class="form-block-el__icon">\
      </div>\
      <div class="form-block-el__right">\
        <div class="form-block-el__textsmall">Прикрепить<br> фото</div>\
      </div>\
    </label>\
  </div>');
  $('#wrap-form-elements').scrollTop(99999);
  return false;
});
var anim;
var indCheck = 0;;
function checkInp(wrap){
  var wrap = $(wrap);
  var req_inps = 0;
  wrap.find('[required]').each(function(){
    if ( $(this).hasClass('checkbox__inp') ) {
      if ( $(this).prop('checked') ) {
        $(this).closest('.block-form__el-checkbox').removeClass('error');
        req_inps++;
      }else{
        $(this).closest('.block-form__el-checkbox').addClass('error');
      }
    }else{
      if ( $(this).val() === '' || $(this).val() === undefined || $(this).val() === null || $(this).val() === false ) {
        $(this).addClass('error');
      }else{
        $(this).removeClass('error');
        req_inps++;
      }
    }
  });
  if ( wrap.find('[required]').length === req_inps ) {
    $('.block-form__valve').removeClass('anim');
    $('.block-form__valve').removeClass('animPrev');
    anim = null;
    if ( indCheck > wrap.index() ) {
      $('.block-form__valve').addClass('anim');
    }else{
      $('.block-form__valve').addClass('animPrev');
    }
    setTimeout(animF, 1000);
    function animF(){
      $('.block-form__valve').removeClass('anim');
      $('.block-form__valve').removeClass('animPrev');
    }
    return true;
  }else{
    alert('Заполните пустые поля');
    return false;
  }
}
$('.block-form__next').on('click', function(){
  var wrapAll = $(this).closest('.block-form');
  var wrap = $(this).closest('.block-form__el');
  indCheck = wrap.index() + 1;
 if ( checkInp(wrap, 2) ) { 
    wrap.addClass('block-form__el_hide');
    wrap.removeClass('active');
    wrap.next('.block-form__el').removeClass('block-form__el_dec');
    wrap.next('.block-form__el').addClass('active');
 }else{
 }
  return false;
});
$('.block-form__prev').on('click', function(){
  var wrapAll = $(this).closest('.block-form');
  var wrap = $('.block-form__el.active');
  indCheck = wrap.index() - 1;
  //if ( checkInp(wrap, 1) ) {
    wrap.addClass('block-form__el_dec');
    wrap.prev('.block-form__el').removeClass('block-form__el_dec');
    wrap.prev('.block-form__el').removeClass('block-form__el_hide');
    wrap.removeClass('active');
    wrap.prev('.block-form__el').addClass('active');
  //}
  return false;
});
$('.block-form__el').on('click', function(){
  var wrap = $('.block-form__el.active');
  indCheck = $(this).index();
  if ( $(this).hasClass('block-form__el_dec') ) {
    if ( checkInp(wrap) ) {
      $(this).removeClass('block-form__el_dec');
      $(this).prevAll('.block-form__el').removeClass('block-form__el_dec');
      $(this).prevAll('.block-form__el').addClass('block-form__el_hide');
      $(this).nextAll('.block-form__el').addClass('block-form__el_dec');
      $(this).nextAll('.block-form__el').removeClass('block-form__el_hide');
      $('.block-form__el.active').removeClass('active');
      $(this).addClass('active');
    }
  }
  if ( $(this).hasClass('block-form__el_hide') ) {
    //if ( checkInp(wrap) ) {
      $(this).removeClass('block-form__el_dec');
      $(this).removeClass('block-form__el_hide');
      $(this).prevAll('.block-form__el').addClass('block-form__el_hide');
      $(this).prevAll('.block-form__el').removeClass('block-form__el_dec');
      $(this).nextAll('.block-form__el').addClass('block-form__el_dec');
      $(this).nextAll('.block-form__el').removeClass('block-form__el_hide');
      $('.block-form__el.active').removeClass('active');
      $(this).addClass('active');
    //}
  }
  
});

$('.block-form__el-commentAdd').on('click', function(){
  $(this).hide();
  $('.block-form__el-comment').show().focus();
  // $('.block-form__el-comment').focus();
  return false;
});

var dataOrder = {
  'step_1': {},
  'step_2': [],
  'step_3': {},
  'step_4': {},
};
$('.block-form__send').on('click', function(){
  var wrap = $(this).closest('.block-form');
  wrap.find('.block-form__el_one').find('.form-el').each(function(){
    if ( $(this).find('.form-el__text').length ) {
      if ($(this).find('.form-el__inp').is("select"))
        dataOrder['step_1'][$(this).find('.form-el__text').text()] = $(this).find('.form-el__inp').find('option:selected').text();//$(this).find('.form-el__inp').val();
      else
        dataOrder['step_1'][$(this).find('.form-el__text').text()] = $(this).find('.form-el__inp').val();
    }
  });
  wrap.find('.block-form__el_two').find('.block-form__el-formel').each(function(){
    dataOrder['step_2'].push( {
      "№": $(this).find('.form-block-el__count').text(),
      'Название детали': $(this).find('.form-block-el__inp .form-block-el__inp-inp').val(),
      'Номер в каталогах': $(this).find('.form-block-el__inputs-big .form-block-el__inp-inp').val(),
      'Количество': $(this).find('.form-block-el__inputs-small .form-block-el__inp-inp').val(),
      'Фото': $(this).find('.wrap-file__inp')[0].files[0],
    });
  });
  wrap.find('.block-form__el_three').find('.block-form__el-el').each(function(){
    dataOrder['step_3'][$(this).find('.form-el__text').text()] = $(this).find('.form-el__inp').val();
  });
  dataOrder['step_4']['comment'] = wrap.find('.block-form__el_four').find('.formInp').val();

  console.log(dataOrder);

  $('.block-form__el').hide();
  $('.block-form__el_final').fadeIn(400);

  send_request(dataOrder);
  return false;
});


$('.view_request_btn').on('click', function(){
  $('.block-form__el').hide();
  $('.block-order').empty();
  $('.block-form__el_table-content__table').empty();
  $('.block-form__el_table-comments').text('');

  Object.keys(dataOrder['step_1']).forEach(function(key) {
    $('.block-order').append('<div class="block-order__el">\
      <div class="block-order__el-title">'+ key +': </div>\
      <div class="block-order__el-val"> '+ dataOrder['step_1'][key] +'</div>\
    </div>');
  });
  for(var i=0; i<dataOrder['step_2'].length; i++){
    $('.block-form__el_table-content__table').append('<tr class="table-order__tr">\
      <td class="table-order__cell"><div class="table-order__cell-body"><div class="table-order__cell-text"></div>'+(i+1)+'.</div></td>\
      <td class="table-order__cell"><div class="table-order__cell-body"><div class="table-order__cell-text">'+ dataOrder['step_2'][i]['Название детали'] +'</div></div></td>\
      <td class="table-order__cell"><div class="table-order__cell-body"><div class="table-order__cell-text">'+ dataOrder['step_2'][i]['Номер в каталогах'] +'</div></div></td>\
      <td class="table-order__cell"><div class="table-order__cell-body"><div class="table-order__cell-text">'+ dataOrder['step_2'][i]['Количество'] +'</div></div></td>\
    </tr>');
  }
  $('.block-form__el_table-comments').text(dataOrder['step_4']['comment']);
  $('.block-form__el_table').fadeIn(400);
  return false;
});

$(".btnPrint").click(function(){
  window.print();
  return false;
});

$('#close_request').click(function() {
  $('.block-form__el_table').fadeOut(400);
  $('.block-form__el_final').removeClass('block-form__el_hide');
  $('.block-form__el_final').fadeIn(400);
});


}); //end ready