// The purpose of this code is to fix the height of overflow: auto blocks, because some browsers can't figure it out for themselves.
function smf_codeBoxFix()
{
	var codeFix = document.getElementsByTagName('code');
	for (var i = codeFix.length - 1; i >= 0; i--)
	{
		if (is_webkit && codeFix[i].offsetHeight < 20)
			codeFix[i].style.height = (codeFix[i].offsetHeight + 20) + 'px';

		else if (is_ff && (codeFix[i].scrollWidth > codeFix[i].clientWidth || codeFix[i].clientWidth == 0))
			codeFix[i].style.overflow = 'scroll';

		else if ('currentStyle' in codeFix[i] && codeFix[i].currentStyle.overflow == 'auto' && (codeFix[i].currentStyle.height == '' || codeFix[i].currentStyle.height == 'auto') && (codeFix[i].scrollWidth > codeFix[i].clientWidth || codeFix[i].clientWidth == 0) && (codeFix[i].offsetHeight != 0))
			codeFix[i].style.height = (codeFix[i].offsetHeight + 24) + 'px';
	}
}

// Add a fix for code stuff?
if ((is_ie && !is_ie4) || is_webkit || is_ff)
	addLoadEvent(smf_codeBoxFix);

// Toggles the element height and width styles of an image.
function smc_toggleImageDimensions()
{
	var oImages = document.getElementsByTagName('IMG');
	for (oImage in oImages)
	{
		// Not a resized image? Skip it.
		if (oImages[oImage].className == undefined || oImages[oImage].className.indexOf('bbc_img resized') == -1)
			continue;

		oImages[oImage].style.cursor = 'pointer';
		oImages[oImage].onclick = function() {
			this.style.width = this.style.height = this.style.width == 'auto' ? null : 'auto';
		};
	}
}

// Add a load event for the function above.
addLoadEvent(smc_toggleImageDimensions);

// Adds a button to a certain button strip.
function smf_addButton(sButtonStripId, bUseImage, oOptions)
{
	var oButtonStrip = document.getElementById(sButtonStripId);
	var aItems = oButtonStrip.getElementsByTagName('span');

	// Remove the 'last' class from the last item.
	if (aItems.length > 0)
	{
		var oLastSpan = aItems[aItems.length - 1];
		oLastSpan.className = oLastSpan.className.replace(/\s*last/, 'position_holder');
	}

	// Add the button.
	var oButtonStripList = oButtonStrip.getElementsByTagName('ul')[0];
	var oNewButton = document.createElement('li');
	setInnerHTML(oNewButton, '<a href="' + oOptions.sUrl + '" ' + ('sCustom' in oOptions ? oOptions.sCustom : '') + '><span class="last"' + ('sId' in oOptions ? ' id="' + oOptions.sId + '"': '') + '>' + oOptions.sText + '</span></a>');

	oButtonStripList.appendChild(oNewButton);
}

// Adds hover events to list items. Used for a versions of IE that don't support this by default.
var smf_addListItemHoverEvents = function()
{
	var cssRule, newSelector;

	// Add a rule for the list item hover event to every stylesheet.
	for (var iStyleSheet = 0; iStyleSheet < document.styleSheets.length; iStyleSheet ++)
		for (var iRule = 0; iRule < document.styleSheets[iStyleSheet].rules.length; iRule ++)
		{
			oCssRule = document.styleSheets[iStyleSheet].rules[iRule];
			if (oCssRule.selectorText.indexOf('LI:hover') != -1)
			{
				sNewSelector = oCssRule.selectorText.replace(/LI:hover/gi, 'LI.iehover');
				document.styleSheets[iStyleSheet].addRule(sNewSelector, oCssRule.style.cssText);
			}
		}

	// Now add handling for these hover events.
	var oListItems = document.getElementsByTagName('LI');
	for (oListItem in oListItems)
	{
		oListItems[oListItem].onmouseover = function() {
			this.className += ' iehover';
		};

		oListItems[oListItem].onmouseout = function() {
			this.className = this.className.replace(new RegExp(' iehover\\b'), '');
		};
	}
}

// Add hover events to list items if the browser requires it.
if (is_ie7down && 'attachEvent' in window)
	window.attachEvent('onload', smf_addListItemHoverEvents);
 
$( document ).ready(function() { 
   if (smf_colorpiker == 'true') {
  	     color_piker('input#dhayzon_header_bg','#panel_1, #footer_section .frame','background',true);  	     
  	     color_piker('input#dhayzon_news_bg','.dhayzon_news','background',false);
  	     color_piker('input#dhayzon_menu_bg','.dhayzon_menu','background',false);
  	     color_piker('input#dhayzon_color_link','#content_section a,.navigate_section a','color',false);

		 //tabs admin theme
			$('.dhayzon_theme_options a').click(function(event){
				event.preventDefault();
				var tab_id = $(this).attr('href');

				$('.dhayzon_theme_options a').removeClass('current');
				$('.dhayzon_theme_content>div').removeClass('current');

				$(this).addClass('current');
				$(tab_id).addClass('current');
				console.log(tab_id);
			})

	}; //end color piker
	//togle hamburger
	$('.aHamburger-icon').click(function(event) {
		event.preventDefault();
		var id = $(this).attr('data-open');
		$('body').toggleClass(id);
	});

   dhayzon_fixed_block("#content_section",".navigate_section","navigation",false);

   dhayzon_fixed_block("#dhayzon_wrapper","#sSidenav","activeScroll",false);
    
    $('.toggle').click(function(event) {

    	 var parent = $(this).parent().attr('id'); 
     	 var leve1 = $('#' + parent+'>ul');

    	$('#' + parent+'  ul').slideToggle("slow", function() { 
    		var value = $('#' + parent+'  ul').css('display');
				console.log(value);
				if(value == 'block')
					$(this).prev().addClass('open_toggle');
				else
					$(this).prev().removeClass('open_toggle');
			}
  		);
    });
 
$('.clicked').click(function(event) {
	event.preventDefault();
        var ident = $(this).attr('id');
        var cl = $(this).attr('data-toggle');
        if (ident=='oBreadcrumb') {
        	var status = $(this).next('ul').css('display');
        	if (status=='none')
        		$(this).next('ul').css('display','block').addClass('active');
        	else
        		$(this).next('ul').css('display','none').removeClass('active');       	 
        };

        if (cl=='dhayzonTogleOptions') {
             	var status = $(this).next('ul').css('display');
             	$(this).addClass('activeB');

        	if (status=='none'){
        		$(this).next('ul').css('display','block').addClass('active'); 
        	}
        	else{
        		$(this).next('ul').css('display','none').removeClass('active');
        		$(this).removeClass('activeB');    	
        	}
        };

        if (ident == 'Qreply_dhayzon') {
        	var getval = $('#quickReplyOptions').css('display');
        	$(this).addClass('activeB ');

        	if (getval !== 'block'){
        		$('#quickReplyOptions').css('display','block');         
        	}else{
        		$(this).removeClass('activeB ');
        		$('#quickReplyOptions').css('display','none');
        	} 
        };
        if (cl == 'TopicButtons') {        	  
        	$(this).addClass('activeB');
        	var ss = $(this).parent('div').attr('id');
        	var attr =   $('#'+ss+' .TopicButtons').css('display');
        	
        	console.log(ss);
        	if(attr !== 'block'){
        		$('#'+ss+' .TopicButtons').css('display','block'); 
        	}
        	else{
        		$('#'+ss+' .TopicButtons').css('display','none'); 
        		$(this).removeClass('activeB')        		
        	}

        	 
        };
});
    //user info
    $('#user_options>a').click(function(event) {
    	/* Act on the event */
    	 var opt = $(this).parent().attr('id');
    	 var value = $("#"+opt+" .open_options").css('display');
  
				
                if(value != 'block'){
					 console.log(opt);
 					$("#"+opt+"  .open_options").css('display', 'block'); 
            	}else{
					  console.log(' else');
					  $("#"+opt+"  .open_options").css('display', 'none'); 
                }
  

    });


});
function color_piker(input,clase,css,fill){
	var input = input;
	var clase = clase;
	var css = css;
	$(input).minicolors({
		    change: function(value, opacity) {
 		        $(clase).css(css,value);
 		        if(fill)
 		         $('#footer_section  svg').css('fill',value);

		    }
	});
} 
function dhayzon_fixed_block(f,e,stiky,margin){
          var f = $(f);
          var c = $(e);
          var h = c.height();
         if (f.length > 0){
        var pos = f.position();                    
        $(window).scroll(function() {
          var windowpos = $(window).scrollTop();
          // s.html("Distance from top:" + pos.top + "<br />Scroll position: " + windowpos);
            if (windowpos >= pos.top) {
              c.addClass(stiky);
              if (margin)
              f.css('margin-top', h+'px');
            } else {
              c.removeClass(stiky); 
              if (margin)
              f.css('margin-top', '0px');
            }
          });
        }
}
 