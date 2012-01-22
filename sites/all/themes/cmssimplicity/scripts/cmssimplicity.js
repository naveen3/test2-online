$(document).ready(function(){
 
 
  // Adding active class on list item of primary menus 
  $('#nice-menu-1 li ul li ul li ul').children().each(function(){
    if($(this).children().hasClass('active')) {
      $(this).parent().parent().parent().parent().addClass('active');
    }
  });
  $('#nice-menu-1 li ul li ul').children().each(function(){
    if($(this).children().hasClass('active')) {
      $(this).parent().parent().parent().addClass('active');
    }
  });
  $('#nice-menu-1 li ul').children().each(function(){
    if($(this).children().hasClass('active')) {
      $(this).parent().parent().addClass('active');
    }
  });
  $('#nice-menu-1').children().each(function(){
    if($(this).children().hasClass('active')) {
      $(this).addClass('active'); 
    }
  }); 

 
 
  // Code for ddblock play and pause button's functionality. 

  $('#pause-cycle').click(function(){
    $('div.ddblock-contents').cycle('pause');
    $('#resume-cycle').show();
    $(this).hide(); 
  });
  $('#resume-cycle').click(function(){
     $('div.ddblock-contents').cycle('resume'); 
     $('#pause-cycle').show();
     $(this).hide();
   });
  $('#resume-cycle').hide();

  // Adding Clearfix class to links
  $('#navigation ul.nice-menu li a').each(function(){
	  text = '<span>'+$(this).html()+ '</span>';
	  $(this).html(text);
  });
});