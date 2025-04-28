// JavaScript Document

$(document).ready(function(){
	$("body").css('overflow-x', 'hidden')

  }); 
  
// responsive menu
$(document).ready(function(){
	$(".respon_second_tab_menu").click(function(e){
    $(".responsive_second_nav ul").slideToggle('300');
	e.stopPropagation();
  });  
  
  $(document).click(function() {
    $(".responsive_second_nav ul").slideUp('300');  
});
  
});
// responsive menu


// after log
$(document).ready(function(){
	$(".after_lo_pannel").click(function(e){
    $(".after_log_pannel").slideToggle('300');
	e.stopPropagation();
  });  
  
  $(document).click(function() {
    $(".after_log_pannel").slideUp('300');  
});
  
});
// after log

// cvv
$(document).ready(function(){
	
 $('.cvv_ask').hover(  
        function()  
        {  
        $('.cvv_img').css('visibility', 'visible')
         },  
         function()  
         {  
          $('.cvv_img').css('visibility', 'hidden')
                   
         }); 
	
	});
// cvv

// pop
$(document).ready(function(){
	
$(".pop").css('opacity', '0');
$(".pop").css('z-index', '-100');

$(".pop1").css('opacity', '0');
$(".pop1").css('z-index', '-100');

$(".popup").css('opacity', '0');	
$(".popup").css('z-index', '-100');

$(".popup1").css('opacity', '0');	
$(".popup1").css('z-index', '-100');


 $(".popclick").click(function(){
	$(".pop").css('z-index', '100');
	$(".popup").css('z-index', '100');
	
	
	

	
	
	 $('html,body').animate({ scrollTop: 0 }, 'slow', function () {
                    });
	
	
	$(".pop").animate(  
                  {   
                   opacity:1, 
                  }, 300);
				  
				  $(".popup").animate(  
                  {   
                   opacity:1, 
                  }, 300);
 });
 
 
  $(".popclick1").click(function(){
	$(".pop1").css('z-index', '100');
	$(".popup1").css('z-index', '100');
	
	
	 $('html,body').animate({ scrollTop: 0 }, 'slow', function () {
                    });
	
	
	$(".pop1").animate(  
                  {   
                   opacity:1, 
                  }, 300);
				  
				  $(".popup1").animate(  
                  {   
                   opacity:1, 
                  }, 300);
				  
				  
				  $(".pop_main1").css('display', 'block');
 });


 
 
  $(".close_pop").click(function(){
	  $(".pop").css('z-index', '-100');
	$(".popup").css('z-index', '-100');
	$(".pop").css('opacity', '0');
   $(".popup").css('opacity', '0');
   
   
   
  
   
   $(".gym_registration").hide();
   $(".trainer_registration").hide();
   $(".select_account").hide();
   $(".gym_login").hide();
   $(".trainer_login").hide();
   $(".pop_main").hide();
   $(".contact_gym_pop").hide();
    $(".forgot_pass_form").hide();  
	$(".normal_loin_form").show();
});


$(".close_pop1").click(function(){
	  $(".pop1").css('z-index', '-100');
	$(".popup1").css('z-index', '-100');
	$(".pop1").css('opacity', '0');
   $(".popup1").css('opacity', '0');
   $(".pop_main1").css('display', 'none');
   $(".pop_main").css('display', 'none');
 
   
   
   
  
  
});




 $('.pop_main_container').hover(  
        function()  
        {  
        $(".left_ring").animate(  
                  {   
                   left:17, 
                  }, 300);
         },  
         function()  
         {  
           $(".left_ring").animate(  
                  {   
                   left:0, 
                  }, 300);
                   
         }); 
		 
		 $('.pop_main_container').hover(  
        function()  
        {  
        $(".right_ring").animate(  
                  {   
                   right:18, 
                  }, 300);
         },  
         function()  
         {  
           $(".right_ring").animate(  
                  {   
                   right:0, 
                  }, 300);
                   
         }); 
		 
		 
		 
		 
$(".sign_up_click").click(function(){
$(".for_sign_up_type").show();
});

$(".sign_in_click").click(function(){
$(".for_sign_in_type").show();
});

$(".type_block").click(function(){
$(".select_account").hide();
$(".pop_main").show();
});

$(".gym_type_block_up").click(function(){
$(".gym_registration").show();
});
$(".trainer_type_block_up").click(function(){
$(".trainer_registration").show();
});

$(".gym_type_block_in").click(function(){
$(".gym_login").show();
});
$(".trainer_type_block_in").click(function(){
$(".trainer_login").show();
});


$(".contact_to_gym").click(function(){
$(".contact_gym_pop").show();
$(".pop_main").show();

});




	
	});
//pop


// flag

$(document).ready(function(){
	
	$(".gym_share_block_flag").click(function(){
$(".flag_form").slideDown();
});

	$(".flag_form_close").click(function(){
$(".flag_form").slideUp();
});
	
	});


// add class
$(document).ready(function(){

$(".pop_notice_container").first().addClass("pop_notice_container_last");		
$(".footer_block").last().addClass("last_footer_block");
$(".search_result_row").first().addClass("search_result_row_first");


	
		});
// add class

// pass
$(document).ready(function(){
  $(".forgot_pass").click(function() {
    $(this).parent().parent().parent().parent().find(".forgot_pass_form").show();  
	$(this).parent().parent().parent().parent().find(".normal_loin_form").hide();
});

  $(".again_login").click(function() {
    $(this).parent().parent().parent().parent().find(".forgot_pass_form").hide();  
	$(this).parent().parent().parent().parent().find(".normal_loin_form").show();
});

});
// pass


// placeholder
$(document).ready(function(){
var _debug = false;
var _placeholderSupport = function() {
    var t = document.createElement("input");
    t.type = "text";
    return (typeof t.placeholder !== "undefined");
}();

window.onload = function() {
    var arrInputs = document.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        var curInput = arrInputs[i];
        if (!curInput.type || curInput.type == "" || curInput.type == "text")
            HandlePlaceholder(curInput);
        else if (curInput.type == "password")
            ReplaceWithText(curInput);
    }

    if (!_placeholderSupport) {
        for (var i = 0; i < document.forms.length; i++) {
            var oForm = document.forms[i];
            if (oForm.attachEvent) {
                oForm.attachEvent("onsubmit", function() {
                    PlaceholderFormSubmit(oForm);
                });
            }
            else if (oForm.addEventListener)
                oForm.addEventListener("submit", function() {
                    PlaceholderFormSubmit(oForm);
                }, false);
        }
    }
};

function PlaceholderFormSubmit(oForm) {    
    for (var i = 0; i < oForm.elements.length; i++) {
        var curElement = oForm.elements[i];
        HandlePlaceholderItemSubmit(curElement);
    }
}

function HandlePlaceholderItemSubmit(element) {
    if (element.name) {
        var curPlaceholder = element.getAttribute("placeholder");
        if (curPlaceholder && curPlaceholder.length > 0 && element.value === curPlaceholder) {
            element.value = "";
            window.setTimeout(function() {
                element.value = curPlaceholder;
            }, 100);
        }
    }
}

function ReplaceWithText(oPasswordTextbox) {
    if (_placeholderSupport)
        return;
    var oTextbox = document.createElement("input");
    oTextbox.type = "text";
    oTextbox.id = oPasswordTextbox.id;
    oTextbox.name = oPasswordTextbox.name;
    //oTextbox.style = oPasswordTextbox.style;
    oTextbox.className = oPasswordTextbox.className;
    for (var i = 0; i < oPasswordTextbox.attributes.length; i++) {
        var curName = oPasswordTextbox.attributes.item(i).nodeName;
        var curValue = oPasswordTextbox.attributes.item(i).nodeValue;
        if (curName !== "type" && curName !== "name") {
            oTextbox.setAttribute(curName, curValue);
        }
    }
    oTextbox.originalTextbox = oPasswordTextbox;
    oPasswordTextbox.parentNode.replaceChild(oTextbox, oPasswordTextbox);
    HandlePlaceholder(oTextbox);
    if (!_placeholderSupport) {
        oPasswordTextbox.onblur = function() {
            if (this.dummyTextbox && this.value.length === 0) {
                this.parentNode.replaceChild(this.dummyTextbox, this);
            }
        };
    }
}

function HandlePlaceholder(oTextbox) {
    if (!_placeholderSupport) {
        var curPlaceholder = oTextbox.getAttribute("placeholder");
        if (curPlaceholder && curPlaceholder.length > 0) {
            Debug("Placeholder found for input box '" + oTextbox.name + "': " + curPlaceholder);
            oTextbox.value = curPlaceholder;
            oTextbox.setAttribute("old_color", oTextbox.style.color);
            oTextbox.style.color = "#c0c0c0";
            oTextbox.onfocus = function() {
                var _this = this;
                if (this.originalTextbox) {
                    _this = this.originalTextbox;
                    _this.dummyTextbox = this;
                    this.parentNode.replaceChild(this.originalTextbox, this);
                    _this.focus();
                }
                Debug("input box '" + _this.name + "' focus");
                _this.style.color = _this.getAttribute("old_color");
                if (_this.value === curPlaceholder)
                    _this.value = "";
            };
            oTextbox.onblur = function() {
                var _this = this;
                Debug("input box '" + _this.name + "' blur");
                if (_this.value === "") {
                    _this.style.color = "#c0c0c0";
                    _this.value = curPlaceholder;
                }
            };
        }
        else {
            Debug("input box '" + oTextbox.name + "' does not have placeholder attribute");
        }
    }
    else {
        Debug("browser has native support for placeholder");
    }
}

function Debug(msg) {
    if (typeof _debug !== "undefined" && _debug) {
        var oConsole = document.getElementById("Console");
        if (!oConsole) {
            oConsole = document.createElement("div");
            oConsole.id = "Console";
            document.body.appendChild(oConsole);
        }
        oConsole.innerHTML += msg + "<br />";
    }
}
});
//placeholder


//account check radio

$(document).ready(function(){

var d = document;
var safari = (navigator.userAgent.toLowerCase().indexOf('safari') != -1) ? true : false;
var gebtn = function(parEl,child) { return parEl.getElementsByTagName(child); };
onload = function() {
    
    var body = gebtn(d,'body')[0];
    body.className = body.className && body.className != '' ? body.className + ' has-js' : 'has-js';
    
    if (!d.getElementById || !d.createTextNode) return;
    var ls = gebtn(d,'label');
    for (var i = 0; i < ls.length; i++) {
        var l = ls[i];
        if (l.className.indexOf('label_') == -1) continue;
        var inp = gebtn(l,'input')[0];
        if (l.className == 'label_check') {
            l.className = (safari && inp.checked == true || inp.checked) ? 'label_check c_on' : 'label_check c_off';
			
            l.onclick = check_it;
        };
        if (l.className == 'label_radio') {
            l.className = (safari && inp.checked == true || inp.checked) ? 'label_radio r_on' : 'label_radio r_off';
			
            l.onclick = turn_radio;
        };
    };
};
var check_it = function() {
    var inp = gebtn(this,'input')[0];
    if (this.className == 'label_check c_off' || (!safari && inp.checked)) {
        this.className = 'label_check c_on';
        if (safari) inp.click();
    } else {
        this.className = 'label_check c_off';
        if (safari) inp.click();
    };
};
var turn_radio = function() {
    var inp = gebtn(this,'input')[0];
    if (this.className == 'label_radio r_off' || inp.checked) {
        var ls = gebtn(this.parentNode,'label');
        for (var i = 0; i < ls.length; i++) {
            var l = ls[i];
            if (l.className.indexOf('label_radio') == -1)  continue;
            l.className = 'label_radio r_off';
        };
        this.className = 'label_radio r_on';
        if (safari) inp.click();
    } else {
        this.className = 'label_radio r_off';
        if (safari) inp.click();
    };
};

});
//account check radio

// radio tooltio
$(document).ready(function(){

 $('.sheet_type_two_assesment_row p').hover(  
        function()  
        {  
        $(this).find('.radio_tooltip').show();
         },  
         function()  
         {  
          $(this).find('.radio_tooltip').hide();
                   
         });
		 
		  $('.label_radio_type_three p').hover(  
        function()  
        {  
        $(this).find('.radio_tooltip').show();
         },  
         function()  
         {  
          $(this).find('.radio_tooltip').hide();
                   
         });  
	
	});
// radio tooltio



// active
$(document).ready(function(){

$('.in_up').click(function() {
      $('.active').removeClass('active');
      $(this).find('span').addClass('active');
});




});
//active


// class table
$(document).ready(function(){
	
  $(".the_class").click(function(){
  $(".class_table_detail").show();
  $(".class_table_detail").animate(  
                  {   
                   opacity:1, 
                  }, 300);
				  
			  

});






  $(".hide_class_table").click(function(){
  $(".class_table_detail").hide();
  $(".class_table_detail").animate(  
                  {   
                   opacity:0, 
                  }, 300);

});

  $(".close_class_detail").click(function(){
  $(".class_table_detail").hide();
  $(".class_table_detail").animate(  
                  {   
                   opacity:0, 
                  }, 300);

});









$(".vp").click(function(){
  $(".class_profile_detail").show();
  $(".class_profile_detail").animate(  
                  {   
                   opacity:1, 
                  }, 300);
				  
			  

});






  $(".hide_calss_profile").click(function(){
  $(".class_profile_detail").hide();
  $(".class_profile_detail").animate(  
                  {   
                   opacity:0, 
                  }, 300);

});

  $(".close_class_detail").click(function(){
  $(".class_profile_detail").hide();
  $(".class_profile_detail").animate(  
                  {   
                   opacity:0, 
                  }, 300);

});



  $(".open_instructor").click(function(){
  $(".hide_calss_profile").removeClass("selected");
  $(".show_class_table_instructor").addClass("selected");
    $(".class_table_detail").hide();
  $(".class_table_detail").animate(  
                  {   
                   opacity:0, 
                  }, 300);
  
$("#classes-and-timetable").hide();
$("#location").hide();
$("#our-team").show();

    $(".class_profile_detail").show();
  $(".class_profile_detail").animate(  
                  {   
                   opacity:1, 
                  }, 300);

});





});



// check radio
$(document).ready(function(){
	
$('.membership_block').click(function() {     
$(this).find('.membership_radio').attr('checked', true);
});

$('.membership_block').click(function() {
      $('.active').removeClass('active');
      $(this).addClass('active');
});


});




// type file
$(document).ready(function(){
(function( $ ) {

  // Browser supports HTML5 multiple file?
  var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
      isIE = /msie/i.test( navigator.userAgent );

  $.fn.customFile = function() {

    return this.each(function() {

      var $file = $(this).addClass('customfile'), // the original file input
          $wrap = $('<div class="customfile-wrap">'),
          $input = $('<input type="text" class="customfile-filename" />'),
          // Button that will be used in non-IE browsers
          $button = $('<button type="button" class="customfile-upload">Browse</button>'),
		
          // Hack for IE
          $label = $('<label class="customfile-upload" for="'+ $file[0].id +'">Open</label>');

      // Hide by shifting to the left so we
      // can still trigger events
      $file.css({
        position: 'absolute',
        left: '-9999px'
      });

      $wrap.insertAfter( $file )
        .append( $file, $input, ( isIE ? $label : $button ) );

      // Prevent focus
      $file.attr('tabIndex', -1);
      $button.attr('tabIndex', -1);

      $button.click(function () {
        $file.focus().click(); // Open dialog
      });

      $file.change(function() {

        var files = [], fileArr, filename;

        // If multiple is supported then extract
        // all filenames from the file array
        if ( multipleSupport ) {
          fileArr = $file[0].files;
          for ( var i = 0, len = fileArr.length; i < len; i++ ) {
            files.push( fileArr[i].name );
          }
          filename = files.join(', ');

        // If not supported then just take the value
        // and remove the path to just show the filename
        } else {
          filename = $file.val().split('\\').pop();
        }

        $input.val( filename ) // Set the value
          .attr('title', filename) // Show filename in title tootlip
          .focus(); // Regain focus

      });

      $input.on({
        blur: function() { $file.trigger('blur'); },
        keydown: function( e ) {
          if ( e.which === 13 ) { // Enter
            if ( !isIE ) { $file.trigger('click'); }
          } else if ( e.which === 8 || e.which === 46 ) { // Backspace & Del
            // On some browsers the value is read-only
            // with this trick we remove the old input and add
            // a clean clone with all the original events attached
            $file.replaceWith( $file = $file.clone( true ) );
            $file.trigger('change');
            $input.val('');
          } else if ( e.which === 9 ){ // TAB
            return;
          } else { // All other keys
            return false;
          }
        }
      });

    });

  };

  // Old browser fallback
  if ( !multipleSupport ) {
    $( document ).on('change', 'input.customfile', function() {

      var $this = $(this),
          // Create a unique ID so we
          // can attach the label to the input
          uniqId = 'customfile_'+ (new Date()).getTime(),
          $wrap = $this.parent(),

          // Filter empty input
          $inputs = $wrap.siblings().find('.customfile-filename')
            .filter(function(){ return !this.value }),

          $file = $('<input type="file" id="'+ uniqId +'" name="'+ $this.attr('name') +'"/>');

      // 1ms timeout so it runs after all other events
      // that modify the value have triggered
      setTimeout(function() {
        // Add a new input
        if ( $this.val() ) {
          // Check for empty fields to prevent
          // creating new inputs when changing files
          if ( !$inputs.length ) {
            $wrap.after( $file );
            $file.customFile();
          }
        // Remove and reorganize inputs
        } else {
          $inputs.parent().remove();
          // Move the input so it's always last on the list
          $wrap.appendTo( $wrap.parent() );
          $wrap.find('input').focus();
        }
      }, 1);

    });
  }

}( jQuery ));

$('input[type=file]').customFile();
 });                                                                                                                                                // //type file
 
 // msg pop
$(document).ready(function(){
  $(".exit_msg_cross").click(function() {
    $(".msg_pop_container").hide();  
});
});
// msg pop






$(document).ready(function(){

    
        //$('.search_result_row').each(function(){  
            
            //var highestBox = 0;
            //$('.search_result_block', this).each(function(){
            
               // if($(this).height() > highestBox) 
                   //highestBox = $(this).height(); 
           //});  
            
            //$('.search_result_block',this).height(highestBox);
            
        
    //});
	
	
	
	
	  	$('iframe').each( function() {
    var url = $(this).attr("src")
    $(this).attr({
        "src" : url.replace('?rel=0', '')+"?wmode=transparent",
        "wmode" : "Opaque"
    })
});    
	
  
    
    
   

});



// map

$(document).ready(function(){
 $('.map_search_button').click(  
        function()  
        {  
        $(".map_search").animate(  
                  {   
                   left:0, 
                  }, 300);
				  
				   $(this).hide();
				   $(".map_search_button_close").show();

                   
         });
		 
		 
		 
		 
		  $('.map_search_button_close').click(  
        function()  
        {  
        $(".map_search").animate(  
                  {   
                   left:-231, 
                  }, 300);
				  
				   $(this).hide();
				   $(".map_search_button").show();

                   
         });
		 
		 
});		 