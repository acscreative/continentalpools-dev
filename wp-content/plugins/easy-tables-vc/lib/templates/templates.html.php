<script type="text/html" id="vc_table_param_toolbar">
    <ul class="vc_table_param_toolbar">
        <li class="vc-font-control vc-selector">
            <div class="dropdown" data-name="font" data-type="selector">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" data-default="Px">
                    Px
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                        <li><a href="#" data-value="" data-selector-name="font"><?php _e('None', "vc_table_manager") ?></a></li>
                    <# var l = [6,7,8,9,10,11,12,14,18,24,36] #>
                    <# for(i in l) { #>
                        <li><a href="#" data-value="{{l[i]}}px" data-selector-name="font">{{l[i]}}px</a></li>
                    <# } #>
                </ul>
            </div>
        </li>
        <li>
            <div class="vc_table_checkbox_button vc_bold">
                <label>
                    <input type="checkbox" name="bold" data-name="b" value="b"><span></span>
                </label>
            </div>
        </li>
        <li>
            <div class="vc_table_checkbox_button vc_italic">
                <label>
                    <input type="checkbox" name="italic" data-name="i" value="i"><span></span>
                </label>
            </div>
        </li>
        <li>
            <div class="vc_table_checkbox_button vc_underline">
                <label>
                    <input type="checkbox" name="underline" data-name="u" value="u"><span></span>
                </label>
            </div>
        </li>
        <li>
            <div class="vc_table_checkbox_button vc_stroked">
                <label>
                    <input type="checkbox" name="stroked" data-name="s" value="s"><span></span>
                </label>
            </div>
        </li>
        <li>
            <input type="text" name="color" class="vc_table_color vc_table_color_picker" data-name="color">
        </li>
        <li>
            <div class="vc-bgcolor-control">
                <input type="text" name="background_color" class="vc_table_background_color vc_table_color_picker" data-name="bgcolor">
            </div>
        </li>
        <li class="vc-border-control vc-selector">
            <div class="dropdown" data-name="border" data-type="selector">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" data-default="none" data-content-type="icons" data-icon-class="vc-border-icons">
                    <span class="vc-border-icons-none"></span><span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#" data-value="all" data-selector-name="border" class="vc-border-icons-all"></a></li>
                    <li><a href="#" data-value="inner" data-selector-name="border" class="vc-border-icons-inner"></a></li>
                    <li><a href="#" data-value="hor" data-selector-name="border" class="vc-border-icons-hor"></a></li>
                    <li><a href="#" data-value="vert" data-selector-name="border" class="vc-border-icons-vert"></a></li>
                    <li><a href="#" data-value="outer" data-selector-name="border" class="vc-border-icons-outer"></a></li>
                    <li><a href="#" data-value="left" data-selector-name="border" class="vc-border-icons-left"></a></li>
                    <li><a href="#" data-value="top" data-selector-name="border" class="vc-border-icons-top"></a></li>
                    <li><a href="#" data-value="right" data-selector-name="border" class="vc-border-icons-right"></a></li>
                    <li><a href="#" data-value="bottom" data-selector-name="border" class="vc-border-icons-bottom"></a></li>
                    <li><a href="#" data-value="" data-selector-name="border" class="vc-border-icons-none"></a></li>
                </ul>
            </div>
        </li>
        <li class="vc-align-control vc-selector">
            <div class="dropdown" data-name="align" data-type="selector">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" data-default="none" data-content-type="icons" data-icon-class="vc-align-icons">
                    <span class="vc-align-icons-left"></span><span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#" data-value="left" data-selector-name="align" class="vc-align-icons-left"></a></li>
                    <li><a href="#" data-value="center" data-selector-name="align" class="vc-align-icons-center"></a></li>
                    <li><a href="#" data-value="right" data-selector-name="align" class="vc-align-icons-right"></a></li>
                </ul>
            </div>
        </li>
    </ul>
</script>