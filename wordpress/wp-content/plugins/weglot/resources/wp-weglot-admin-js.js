jQuery(function($) {

generateWGWidgetCode();
$( "select[name=original_l]" ).change(function() {
	generateWGWidgetCode();
});
$( "select[name=type_flags]" ).change(function() {
	generateWGWidgetCode();
});
$( "input[name=destination_l]" ).blur(function() {
	generateWGWidgetCode();
});
$('input[name=with_flags]').change(function() {
	generateWGWidgetCode();
});
$('input[name=with_name]').change(function() {
	generateWGWidgetCode();
});
$('input[name=is_dropdown]').change(function() {
	generateWGWidgetCode();
});
$('input[name=is_fullname]').change(function() {
	generateWGWidgetCode();
});
$('textarea[name=override_css]').blur(function() {
	var style_value = $(this).val();
	if(style_value!="") {
		var style = $('<style wgstyle>'+$(this).val()+'</style>');
		$('style[wgstyle]').remove();
		$('html > body').append(style);
		generateWGWidgetCode();
	}
	else {
		$('style[wgstyle]').remove();
	}
});
$('.wgclose-btn').click(function() {
	$('.wgbox-blur').hide();
});
$('input[name=project_key]').blur(function() {
	var key = $(this).val();
	$.getJSON( "https://weglot.com/api/user-info?api_key="+key, function( data ) {
		$('.wg-keyres').remove();
		$('input[name=project_key]').after('<span class="wg-keyres wg-okkey"></span>');
		$('.wg-widget-option-form input[type=submit]').prop('disabled', false);
	}).fail(function() {
		$('.wg-keyres').remove();
		$('input[name=project_key]').after('<span class="wg-keyres wg-nokkey"></span>')
		$('.wg-widget-option-form input[type=submit]').prop('disabled', true);
	  });
});
function generateWGWidgetCode() {
	var original = $( "select[name=original_l]" ).val();
	var destination = $( "input[name=destination_l]" ).val();
	var dests = destination.split(',');
	var list='';
	if(destination.length>1) {
		list +='<ul>';
		for(var i=0;i<dests.length;i++) { 
				var d = dests[i];
				var l_name = $('input[name=with_name]').is(':checked') ? ($('input[name=is_fullname]').is(':checked') ? getLangNameFromCode(d,false):d.toUpperCase()):"";
				list += '<li class="'+d+'"><a href="#">'+l_name+'</a></li>';
		}
		list +='</ul>';
	}
	
	var current_name = $('input[name=with_name]').is(':checked') ? ($('input[name=is_fullname]').is(':checked') ? getLangNameFromCode(original,false):original.toUpperCase()):"";
	
	if($('input[name=is_dropdown]').is(':checked')) {
		var opt_class = "wg-drop";
	}
	else { 
		var opt_class = "wg-list";
	}
	
	if($('input[name=with_flags]').is(':checked')) {
		opt_class += " wg-flags";
	}
	
	
	opt_class += ($("select[name=type_flags]").val()=="0") ? "":" flag-"+$( "select[name=type_flags]" ).val();
				
	var button = '<aside id="weglot_switcher" wg-notranslate class="'+opt_class+' country-selector closed" onclick="openClose(this);"><div class="wgcurrent '+original+'"><a href="javascript:void(0);">'+current_name+'</a></div>'+list+'</aside>';
	$(".wg-widget-preview").html(button);
}
// Si vous faites la logique en PHP, plus qu'à enqueue la variable ;)
function getLangNameFromCode (original,english) {
	switch (original) {
		case "sq":
			return english ? "Albanian":"Shqip";	
		case "en":
			return english ? "English":"English";
		case "ar":
			return english ? "Arabic":"‏العربية‏";
		case "hy":
			return english ? "Armenian":"հայերեն";			
		case "az":
			return english ? "Azerbaijani":"Azərbaycan dili";	
		case "af":
			return english ? "Afrikaans":"Afrikaans";
		case "eu":
			return english ? "Basque":"Euskara";	
		case "be":
			return english ? "Belarusian":"Беларуская";	
		case "bg":
			return english ? "Bulgarian":"български";	
		case "bs":
			return english ? "Bosnian":"Bosanski";	
		case "cy":
			return english ? "Welsh":"Cymraeg";				
		case "vi":
			return english ? "Vietnamese":"Tiếng Việt";				
		case "hu":
			return english ? "Hungarian":"Magyar";				
		case "ht":
			return english ? "Haitian":"Kreyòl ayisyen";				
		case "gl":
			return english ? "Galician":"Galego";
		case "nl":
			return english ? "Dutch":"Nederlands";		
		case "el":
			return english ? "Greek":"Ελληνικά";			
		case "ka":
			return english ? "Georgian":"ქართული";
		case "da":
			return english ? "Danish":"Dansk";
		case "he":
			return english ? "Hebrew":"עברית";
		case "id":
			return english ? "Indonesian":"Bahasa Indonesia";				
		case "ga":
			return english ? "Irish":"Gaeilge";	
		case "it":
			return english ? "Italian":"Italiano";	
		case "is":
			return english ? "Icelandic":"Íslenska";	
		case "es":
			return english ? "Spanish":"Español";			
		case "kk":
			return english ? "Kazakh":"Қазақша";				
		case "ca":
			return english ? "Catalan":"Català";	
		case "ky":
			return english ? "Kyrgyz":"кыргызча";	
		case "zh":
			return english ? "Chinese":"中文";
		case "ko":
			return english ? "Korean":"한국어";
		case "lv":
			return english ? "Latvian":"Latviešu";	
		case "lt":
			return english ? "Lithuanian":"Lietuvių";	
		case "mg":
			return english ? "Malagasy":"Malagasy";	
		case "ms":
			return english ? "Malay":"Bahasa Melayu";
		case "mt":
			return english ? "Maltese":"Malti";	
		case "mk":
			return english ? "Macedonian":"Македонски";	
		case "mn":
			return english ? "Mongolian":"Монгол";	
		case "de":
			return english ? "German":"Deutsch";
		case "no":
			return english ? "Norwegian":"Norsk";
		case "fa":
			return english ? "Persian":"فارسی";	
		case "pl":
			return english ? "Polish":"Polski";
		case "pt":
			return english ? "Portuguese":"Português";		
		case "ro":
			return english ? "Romanian":"Română";	
		case "ru":
			return english ? "Russian":"Русский";		
		case "sr":
			return english ? "Serbian":"Српски";	
		case "sk":
			return english ? "Slovak":"Slovenčina";	
		case "sl":
			return english ? "Slovenian":"Slovenščina";	
		case "sw":
			return english ? "Swahili":"Kiswahili";	
		case "tg":
			return english ? "Tajik":"Тоҷикӣ";	
		case "th":
			return english ? "Thai":"ภาษาไทย";	
		case "tl":
			return english ? "Tagalog":"Tagalog";	
		case "tt":
			return english ? "Tatar":"Tatar";
		case "tr":
			return english ? "Turkish":"Türkçe";
		case "uz":
			return english ? "Uzbek":"O'zbek";	
		case "uk":
			return english ? "Ukrainian":"Українська";	
		case "fi":
			return english ? "Finnish":"Suomi";
		case "fr":
			return english ? "French":"Français";	
		case "hr":
			return english ? "Croatian":"Hrvatski";	
		case "cs":
			return english ? "Czech":"Čeština";	
		case "sv":
			return english ? "Swedish":"Svenska";	
		case "et":
			return english ? "Estonian":"Eesti";	
		case "ja":
			return english ? "Japanese":"日本語";	
	}
}

});