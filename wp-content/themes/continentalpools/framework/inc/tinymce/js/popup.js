// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {
    var mintis = {
        loadVals: function()
        {
            var shortcode = $('#_minti_shortcode').text(),
                uShortcode = shortcode;
            
            // fill in the gaps eg {{param}}
            $('.minti-input').each(function() {
                var input = $(this),
                    id = input.attr('id'),
                    id = id.replace('minti_', ''),      // gets rid of the minti_ prefix
                    re = new RegExp("{{"+id+"}}","g");
                    
                uShortcode = uShortcode.replace(re, input.val());
            });
            
            // adds the filled-in shortcode as hidden input
            $('#_minti_ushortcode').remove();
            $('#minti-sc-form-table').prepend('<div id="_minti_ushortcode" class="hidden">' + uShortcode + '</div>');
        },
        cLoadVals: function()
        {
            var shortcode = $('#_minti_cshortcode').text(),
                pShortcode = '';
                shortcodes = '';
            
            // fill in the gaps eg {{param}}
            $('.child-clone-row').each(function() {
                var row = $(this),
                    rShortcode = shortcode;
                
                $('.minti-cinput', this).each(function() {
                    var input = $(this),
                        id = input.attr('id'),
                        id = id.replace('minti_', '')       // gets rid of the minti_ prefix
                        re = new RegExp("{{"+id+"}}","g");
                        
                    rShortcode = rShortcode.replace(re, input.val());
                });
        
                shortcodes = shortcodes + rShortcode + "\n";
            });
            
            // adds the filled-in shortcode as hidden input
            $('#_minti_cshortcodes').remove();
            $('.child-clone-rows').prepend('<div id="_minti_cshortcodes" class="hidden">' + shortcodes + '</div>');
            
            // add to parent shortcode
            this.loadVals();
            pShortcode = $('#_minti_ushortcode').text().replace('{{child_shortcode}}', shortcodes);
            
            // add updated parent shortcode
            $('#_minti_ushortcode').remove();
            $('#minti-sc-form-table').prepend('<div id="_minti_ushortcode" class="hidden">' + pShortcode + '</div>');
        },
        children: function()
        {
            // assign the cloning plugin
            $('.child-clone-rows').appendo({
                subSelect: '> div.child-clone-row:last-child',
                allowDelete: false,
                focusFirst: false
            });
            
            // remove button
            $('.child-clone-row-remove').live('click', function() {
                var btn = $(this),
                    row = btn.parent();
                
                if( $('.child-clone-row').size() > 1 )
                {
                    row.remove();
                }
                else
                {
                    alert('You need a minimum of one row');
                }
                
                return false;
            });
            
            // assign jUI sortable
            $( ".child-clone-rows" ).sortable({
                placeholder: "sortable-placeholder",
                items: '.child-clone-row'
                
            });
        },
        resizeTB: function()
        {
            var ajaxCont = $('#TB_ajaxContent'),
                tbWindow = $('#TB_window'),
                mintiPopup = $('#minti-popup');

            tbWindow.css({
                height: mintiPopup.outerHeight() + 50,
                width: mintiPopup.outerWidth(),
                marginLeft: -(mintiPopup.outerWidth()/2)
            });

            ajaxCont.css({
                paddingTop: 0,
                paddingLeft: 0,
                paddingRight: 0,
                height: (tbWindow.outerHeight()-47),
                overflow: 'auto', // IMPORTANT
                width: mintiPopup.outerWidth()
            });
            
            $('#minti-popup').addClass('no_preview');
        },
        load: function()
        {
            var mintis = this,
                popup = $('#minti-popup'),
                form = $('#minti-sc-form', popup),
                shortcode = $('#_minti_shortcode', form).text(),
                popupType = $('#_minti_popup', form).text(),
                uShortcode = '';
            
            // resize TB
            mintis.resizeTB();
            $(window).resize(function() { mintis.resizeTB() });
            
            // initialise
            mintis.loadVals();
            mintis.children();
            mintis.cLoadVals();
            
            // update on children value change
            $('.minti-cinput', form).live('change', function() {
                mintis.cLoadVals();
            });
            
            // update on value change
            $('.minti-input', form).change(function() {
                mintis.loadVals();
            });
            
            // when insert is clicked
            $('.minti-insert', form).click(function() {                     
                if(parent.tinymce){
                    parent.tinymce.activeEditor.execCommand('mceInsertContent',false,$('#_minti_ushortcode', form).html());
                    tb_remove();
                }
            });
        }
    }
    
    // run
    $('#minti-popup').livequery( function() { mintis.load(); } );
});