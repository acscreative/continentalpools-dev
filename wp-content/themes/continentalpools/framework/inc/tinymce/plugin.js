(function($) {
"use strict";   

			//Shortcodes
			tinymce.PluginManager.add( 'mintiShortcodes', function( editor, url ) {
			
			editor.addCommand("mintiPopup", function ( a, params )
			{
				var popup = params.identifier;
				tb_show("Minti Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
			});
 
            editor.addButton( 'minti_button', {
                type: 'menubutton',
				title:  'Minti Shortcodes',
				onclick : function(e) {},
				menu: [
				/* ################################## */
					{text: 'Alert',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Alert',identifier: 'minti_alert'})
					}},
					{text: 'Blockquote',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Blockquote',identifier: 'minti_blockquote'})
					}},
					{text: 'Button',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Button',identifier: 'minti_button'})
					}},
					{text: 'Clear',onclick:function(){
					    editor.execCommand("mceInsertContent", false, '[minti_clear]')
					}},
					{text: 'Divider',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Divider',identifier: 'minti_divider'})
					}},
					{text: 'Dropcap',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Dropcap',identifier: 'minti_dropcap'})
					}},
					// {text: 'Google Font',onclick:function(){
					// 	editor.execCommand("mintiPopup", false, {title: 'Google Font',identifier: 'minti_googlefont'})
					// }},
					{text: 'Icon',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Icon',identifier: 'minti_icon'})
					}},
					{text: 'List',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'List',identifier: 'minti_list'})
					}},
					{text: 'Pullquote',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Pullquote',identifier: 'minti_pullquote'})
					}},
					{text: 'Social',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Social',identifier: 'minti_social'})
					}},
					{text: 'Spacer',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Spacer',identifier: 'minti_spacer'})
					}},
					{text: 'Table',onclick:function(){
					    editor.execCommand("mceInsertContent", false, '[minti_table style="1"]Add your Table Here[/minti_table]')
					}},
					{text: 'Tooltip',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Tooltip',identifier: 'minti_tooltip'})
					}},
					{text: 'Visibility',onclick:function(){
						editor.execCommand("mintiPopup", false, {title: 'Visibility',identifier: 'minti_visibility'})
					}},
                /* ################################## */
				] // End of Main Shortcode Button
    	  	}); // end of Addbutton

      });

})(jQuery);