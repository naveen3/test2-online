$(document).ready(function(){

  // Maintaining height of all block in a region (ids of region list is given in array) 
  ids = new Array('content-top1', 'content-top4', 'content-bottom2', 'content-bottom3', 'footer1','footer2');
  for(i=0;i<ids.length;i++) {
    maxHeight = new Array();
    maxHeightBlockNo = new Array();
    blockCount = 1;
    j = 0;
    maxHeight[j] = 0;
    id ="#"+ids[i]+" div.content";
    $(id).each(function(){        //Calculating Max Height of content and title
	  totalHeight =  parseInt($(this).parent().parent().height());
	  totalHeight += parseInt($(this).parent().parent().css("padding-top"), 10) + parseInt($(this).parent().parent().css("padding-bottom"), 10); //Total Padding height

      if (totalHeight > maxHeight[j]) {
        maxHeight[j] = totalHeight;
		maxHeightBlockNo[j] = blockCount;
	  }
      if(blockCount%4 == 0 ) {
        j++;
        maxHeight[j]       = 0;
      }
      blockCount++;     
    });
      
    j = 0;
    blockCount = 1;
    $(id).each(function(){    //Changing hight according to max height of content and title
	  totalSpaceHeight =  parseInt($(this).parent().parent().height());
	  totalSpaceHeight += parseInt($(this).parent().parent().css("padding-top"), 10) + parseInt($(this).parent().parent().css("padding-bottom"), 10); //Total Padding height
	  totalSpaceHeight -=  parseInt($(this).height());
	  newheight = maxHeight[j] - totalSpaceHeight; 
	  if($(this).parent().children('h2.title').height() == null){  
        if( maxHeightBlockNo[j] == blockCount && blockCount%4 == 0) {  // If current block is with max height and its on 4th position then add 1px
		  newheight +=1 ; 
		}
	  }
	  else {  
  		if( maxHeightBlockNo[j] == blockCount && blockCount%4 != 0) {  // If current block is with max height and its not on 4th position then less 1px
		 newheight -=1 ; 
		}	 
      } 
      $(this).height(newheight);
      if(blockCount%4 == 0 ) {
        j++;
      }
      blockCount++;
     });
  } 
 
  // Add padding to either logo/header-2-3-container according to height of both for maintain vertical 
  header_2_3_container_height = $('div#header-middle div#header-2-3-container').height() ;
  logo_height = $('div#header-middle div#logo-title').height();
  if(logo_height < header_2_3_container_height) {
    padding =  (header_2_3_container_height - logo_height)/2 ;
    $('div#header-middle div#logo-title').css({'padding-bottom' : padding});
    $('div#header-middle div#logo-title').css({'padding-top' : padding});
  }
  else if(logo_height > header_2_3_container_height) {
    padding =  (logo_height - header_2_3_container_height)/2 ;
    $('div#header-middle div#header-2-3-container').css({'padding-bottom' : padding});
    $('div#header-middle div#header-2-3-container').css({'padding-top' : padding});
  } 

   // Add padding to either logo/site-name-slogan according to height of both for maintain vertical 
  site_name_height = $('div#logo-title div#site-name-slogan').height() ;
  logo_height = $('div#logo-title div#logo').height();
  if(logo_height < site_name_height) {
    padding =  (site_name_height - logo_height)/2 ;
    $('div#logo-title div#logo').css({'padding-bottom' : padding});
    $('div#logo-title div#logo').css({'padding-top' : padding});
  }
  else if(logo_height > site_name_height) {
    padding =  (logo_height - site_name_height)/2 ;
    $('div#logo-title div#site-name-slogan').css({'padding-bottom' : padding});
    $('div#logo-title div#site-name-slogan').css({'padding-top' : padding});
  } 



  // Add padding to either header-2/3 according to height of both for maintain vertical 
  header2_height = $('div#header-2-3-container div#header2').height();
  header3_height = $('div#header-2-3-container div#header3').height();
  if(header3_height < header2_height) {
    padding =  (header2_height - header3_height)/2 ;
    $('div#header-2-3-container div#header3').css({'padding-bottom' : padding});
    $('div#header-2-3-container div#header3').css({'padding-top' : padding});
  }
  else if(header3_height > header2_height) {
    padding_top =  (header3_height - header2_height)/2;
    padding_bottom =  (header3_height - header2_height)/2 ;
    $('div#header-2-3-container div#header2').css({'padding-bottom' : padding_bottom});
    $('div#header-2-3-container div#header2').css({'padding-top' : padding_top});
  }


  // theme-settings - breadcrumb settings
  $("#edit-breadcrumb-yes").click( function () { 
    if (this.checked) {
	  $("#edit-breadcrumb-separator").attr('disabled', false);
	  $("#edit-breadcrumb-home").attr('disabled', false);
	  $("#edit-breadcrumb-trailing").attr('disabled', false);
	  $("#edit-breadcrumb-title").attr('disabled', false);
	}
  });
  $("#edit-breadcrumb-admin").click( function () { 
    if (this.checked) {
	  $("#edit-breadcrumb-separator").attr('disabled', false);
	  $("#edit-breadcrumb-home").attr('disabled', false);
	  $("#edit-breadcrumb-trailing").attr('disabled', false);
	  $("#edit-breadcrumb-title").attr('disabled', false);
	}
  });
  $("#edit-breadcrumb-no").click( function () { 
    if (this.checked) {
	  $("#edit-breadcrumb-separator").attr('disabled', true);
	  $("#edit-breadcrumb-home").attr('disabled', true);
	  $("#edit-breadcrumb-trailing").attr('disabled', true);
	  $("#edit-breadcrumb-title").attr('disabled', true);
	}
    });

  //Code to show/hide tooltip based on selected theme settings
  if(Drupal.settings.CMSBASE.TOOLTIP) {
	$('#navigation a').tooltip({ 
		track: true, 
		delay: 0, 
		showURL: false, 
		showBody: false, 
		fade: 0 
	});
  }
  else {
	$('#navigation a').attr('title','');
  }

});