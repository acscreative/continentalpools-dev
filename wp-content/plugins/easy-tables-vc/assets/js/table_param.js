/* =========================================================
 * table_param.js v1.0.0
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Settings API table_param javascript
 * ========================================================= */
(function ($) {
	_.extend(vc.atts, vcTable.param);
    var template_options = {
        evaluate:/<#([\s\S]+?)#>/g,
        interpolate:/\{\{\{([\s\S]+?)\}\}\}/g,
        escape:/\{\{([^\}]+?)\}\}(?!\})/g
    };
    var VcTableParamToolbar = Backbone.View.extend({
        tagName:'div',
        initialization:false,
        events:{
            'change select,input':'updateValue',
            'click input':'updateValue',
            'click [data-selector-name]':'updateSelectorValue',
            'mousedown a.wp-color-result': 'colorPickerCheck'
        },
        initialize:function () {
            _.bindAll(this, 'updateColorPicker', 'clearColorPicker');
        },
        attr:{},
        className:'vc_table_header',
		template: vc.template( $( '#vc_table_param_toolbar' ).html(), template_options ),
        parent_view:false,
        setParentView:function (parent_view) {
            this.parent_view = parent_view;
            return this;
        },
        render:function () {
            if (this.parent_view === false) return this;
            this.$el.html(this.template());
            $('.vc_table_color_picker', this.$el).wpColorPicker({
                change:this.updateColorPicker,
                clear: this.clearColorPicker
            });
            return this;
        },
        afterAppend: function() {
            $('.dropdown-toggle', this.$el).dropdown();
        },
        /**
         * Build attr settings list
         * @param attr
         */
        build:function (attr) {

            this.initialization = true;
            this.disableAll();
            this.attr = attr;
            _.each(this.attr, function (value, key) {
                var $control = $('[data-name=' + key + ']', this.$el);
                if ($control.is(':checkbox')) {
                    $control.prop('checked', true);
                } else if ($control.hasClass('vc_table_color_picker')) {
                    $control.wpColorPicker('color', value);
                } else if ($control.data('type') === 'selector') {
                    this.setSelectorValue($control, value);
                } else {
                    $control.val(value);
                }
            }, this);
            this.initialization = false;
        },
        disableAll:function () {
            this.$el.find('[type=checkbox]').attr('checked', false);
            this.$el.find('select').val('');
            $('.vc_table_color_picker', this.$el).each(function () {
                $(this).val('').trigger('change');
            });
            $('.dropdown-toggle', this.$el).each(function () {
                var $this = $(this);
                if ($this.data('content-type') === 'icons') {
                    $this.html('<span class="' + $this.data('icon-class') + '-' +
                        $this.data('default') +
                        '"></span><span class="caret"></span>');
                } else {
                    $this.html($this.data('default') + ' <span class="caret"></span>');
                }
            });
        },
        setSelectorValue:function ($control, value) {
            var $dropdown_toggle = $control.find('.dropdown-toggle'),
                icon_class_key;
            if ($dropdown_toggle.data('content-type') === 'icons' && !_.isEmpty(value)) {
                icon_class_key = $dropdown_toggle.data('icon-class');
                $dropdown_toggle.html('<span class="' + icon_class_key + '-' +
                    value +
                    '"></span><span class="caret"></span>');

            } else if (!_.isEmpty(value)) {
                $dropdown_toggle.html(value + '<span class="caret"></span>');
            }
        },
        updateValue:function (e) {
            if (this.initialization) return false;
            var $control = $(e.currentTarget),
                name = $control.data('name'),
                value;
            if ($control.is(':checkbox')) {
                value = $control.is(':checked') ? $control.val() : false;
            } else {
                value = $control.val();
            }
            this.save(name, value);
        },
        colorPickerCheck: function(e) {
            var $control = $(e.currentTarget);
            if(!$control.hasClass('wp-picker-open')) {
                $('.wp-color-result.wp-picker-open', this.$el).click();
            }
        },
        updateColorPicker:function (e, ui) {
            var name = $(e.target).data('name'),
                value = ui ? ui.color.toString() : '';
            this.save(name, value);
        },
        clearColorPicker: function(e) {
            var name = $(e.target).prev().data('name');
            this.save(name, '');
        },
        updateSelectorValue:function (e) {
            e.preventDefault();
            var $option = $(e.currentTarget),
                name = $option.data('selector-name'),
                $control = $('[data-name=' + name + ']', this.$el),
                $dropdown_toggle = $control.find('.dropdown-toggle'),
                icon_class_key,
                value = $option.data('value');
            if ($dropdown_toggle.data('content-type') === 'icons') {
                icon_class_key = $dropdown_toggle.data('icon-class');
                $dropdown_toggle.html('<span class="' + icon_class_key + '-' +
                    (_.isEmpty(value) ? $dropdown_toggle.data('default') : value) +
                    '"></span><span class="caret"></span>');
            } else {
                $dropdown_toggle.html((_.isEmpty(value) ? $dropdown_toggle.data('default') : value) +
                    ' <span class="caret"></span>');
            }
            this.save(name, value);
        },
        save:function (name, value) {
            if (this.initialization) return false;
            this.parent_view.updateSelected(name, value);
        }
    });

    var VcTableParamField = Backbone.View.extend({
        events:{
        },
        first: false,
        data:[
            ['A', 'B', 'C']
        ],
        styles:[],
        selection:false,
        cols_to_add: 1,
        rows_to_add: 1,
        current_theme_class: '',
        initialize:function () {
            _.bindAll(this, 'save', 'setSelection', 'unsetSelection', 'createCol', 'removeCol', 'createRow', 'removeRow', 'customContextMenuCallback', 'buildStyle');
            this.$input = this.$el.find('.wpb_vc_param_value');
            this.$table = this.$el.find('.vc-table');
            this.parseData();
            this.render();
        },
        render:function () {
            this.$table.handsontable({
                data:this.data,
                outsideClickDeselects:false,
                contextMenu:{
                    callback:this.customContextMenuCallback,
                    items:{
                        row_above_extend:{
                            name: 'Insert rows above'
                        },
                        row_below_extend:{
                            name: 'Insert rows below'
                        },
                        hsep1:"---------",
                        col_left_extend:{
                            name: 'Insert columns on the left'
                        },
                        col_right_extend:{
                            name: 'Insert columns on the right'
                        },
                        hsep2:"---------",
                        remove_row:{},
                        remove_col:{},
                        hsep3:"---------",
                        clone_row:{
                            name:'Duplicate this row'
                        },
                        clone_col:{
                            name:'Duplicate this column'
                        }
                    }
                },
                afterChange:this.save,
                afterCreateCol:this.createCol,
                afterCreateRow:this.createRow,
                afterRemoveRow:this.removeRow,
                afterRemoveCol:this.removeCol,
                afterSelectionEnd:this.setSelection,
                afterDeselect:this.unsetSelection,
                afterRender: this.buildStyle
            });
            this.toolbar = new VcTableParamToolbar().setParentView(this).render();
            this.$el.prepend(this.toolbar.$el);
            this.toolbar.afterAppend();
            this.hot = this.$table.handsontable('getInstance');
            this.setHandsontableOuterHeight(this.hot);
            this.buildStyle();
            this.setupThemeControl();
            return this;
        },
        setupThemeControl: function() {
            var $theme_control = this.$el.closest('.wpb_el_type_table_param').prev().find('[name=vc_table_theme]'),
                current_value = $theme_control.val();
            if(!_.isEmpty(current_value)) {
                this.current_theme_class = 'vc-table-plugin-theme-' + current_value;
                $('table', this.$el).addClass(this.current_theme_class);
            }
            $theme_control.change($.proxy(function(e){
                var $table = $('table', this.$el),
                    current_value = $(e.target).val();
                if(this.current_theme_class.length) $table.removeClass(this.current_theme_class);
                if(!_.isEmpty(current_value)) {
                    this.current_theme_class = 'vc-table-plugin-theme-' + $(e.target).val();
                    $table.addClass(this.current_theme_class);
                } else {
                    this.current_theme_class = '';
                }
                this.hot.render();
            }, this));
            this.hot.render();

        },
        setHandsontableOuterHeight: function (hot) {
            _.extend(hot.view.wt.wtDom, {
                outerHeight: function(elem) {
                    var prefix_count = elem.tagName === 'TABLE' ? 5 : 0;
                    if (this.hasCaptionProblem() && elem.firstChild && elem.firstChild.nodeName === 'CAPTION') {
                        return elem.offsetHeight + elem.firstChild.offsetHeight + prefix_count;
                    } else {
                        return elem.offsetHeight + prefix_count;
                    }
                }
            });
        },
        parseData:function () {
            var data = this.$input.val();
            if (data.length) {
                this.data = window.vc_table_param_parse_value(data);
            }
            _.each(this.data, function (raw) {
                var attr_raw = _.map(raw, function (cell) {
                    return _.isUndefined(cell.cell_attributes) ? {} : this.parseAttr(cell.cell_attributes);
                }, this);
                this.styles.push(attr_raw);
            }, this);
        },
        saveData:function (returnValue) {
            var data_string = _.map(this.data,function (value, raw_index) {
                return _.map(value,function (v, col_index) {
                    var attr = this.styles[raw_index][col_index],
                        attr_string = _.isEmpty(attr) ? '' : '[' + this.compactAttr(attr) + ']';
                    return attr_string + (_.isNull(v) ? '' : window.encodeURIComponent(v));
                }, this).join(',');
            }, this).join('|');
            if(true !== returnValue) {
                this.$input.val(data_string);
            }
            return data_string;
        },
        setCellStyle:function (raw_index, col_index) {

            var $td = $(this.hot.getCell(raw_index, col_index)),
                text = $td.text();
                settings = this.buildCssStyles(this.styles[raw_index][col_index]);
            if(raw_index === 0) $td.parent().addClass('vc-th');
            $td.html('<div class="vc_table_content">' +  + '</div>').find('.vc_table_content').text(text);
            $td.attr({
                style:settings.css_style.join(''),
                class:settings.css_class.join(' ')
            });
        },
        buildStyle:function () {
            if(this.hot) {
                _.each(this.data, function (raw, raw_index) {
                    _.each(raw, function (cell, col_index) {
                        this.setCellStyle(raw_index, col_index);
                    }, this);
                }, this);
            }
        },
        buildCssStyles:function (attr) {
            var css_style = [],
                css_class = ['vc_table_cell'];
            _.each(attr, function (value, key) {
                if (key === 'b' && value === 'b') {
                    css_style.push('font-weight: bold;');
                } else if (key === 'u' && value === 'u') {
                    css_style.push('text-decoration: underline;');
                } else if (key === 'i' && value === 'i') {
                    css_style.push('font-style: italic;');
                } else if (key === 's' && value === 's') {
                    css_class.push('vc_stroked');
                } else if (key === 'font') {
                    css_style.push('font-size:' + value + ';');
                    css_style.push('line-height:' + value + ';');
                } else if (key === 'color') {
                    css_style.push('color: ' + value + ';');
                } else if (key === 'bgcolor') {
                    css_style.push('background-color:' + value + ';');
                } else if (key === 'borders') {
                    css_class.push(value.join(' '));
                } else if (key === 'align') {
                    css_style.push('text-align:' + value + ';');
                } else if (key === 'valign') {
                    css_style.push('vertical-align:' + value + ';');
                }
            }, this);
            return {
                css_class:css_class,
                css_style:css_style
            };
        },
        compactAttr:function (atts) {
            var return_attr = _.compact(_.map(atts, function (value, key) {
                if ((key === 'b' || key === 'u' || key === 'i' || key === 's') && value !== false) {
                    return value;
                } else if (key === 'font') {
                    return value;
                } else if (key === 'color') {
                    return 'c' + value;
                } else if (key === 'bgcolor') {
                    return 'bg' + value;
                } else if (key === 'align') {
                    return 'align-' + value;
                } else if (key === 'valign') {
                    return 'valign-' + value;
                } else if (key === 'borders') {
                    return value.join(';');
                }
            }));
            return return_attr.join(';');
        },
        parseAttr:function (settings) {
            var attr = {},
                border_styles = ['border_left', 'border_right', 'border_top', 'border_bottom', 'borders_all'];
            _.each(settings, function (value) {
                if (value === 'b') {
                    attr[value] = value;
                } else if (value === 'u') {
                    attr[value] = value;
                } else if (value === 'i') {
                    attr[value] = value;
                } else if (value === 's') {
                    attr[value] = value;
                } else if (value.match(/px$/)) {
                    attr.font = value;
                } else if (value.match(/^c/)) {
                    attr.color = value.replace(/^c/, '');
                } else if (value.match(/^bg/)) {
                    attr.bgcolor = value.replace(/^bg/, '');
                } else if (value.match(/^align\-/)) {
                    attr.align = value.replace(/^align\-/, '');
                } else if (value.match(/^valign\-/)) {
                    attr.valign = value.replace(/^valign\-/, '');
                } else if (_.indexOf(border_styles, value) > -1) {
                    if (_.isUndefined(attr.borders)) attr.borders = [];
                    attr.borders.push(value);
                }
            });
            return attr;
        },
        setSelection:function () {
            this.selection = this.hot.getSelected();
            var settings = this.styles[this.selection[0]][this.selection[1]];
            this.toolbar.build(settings || {});
        },
        unsetSelection:function () {
            return false;
        },
        createCol:function (index) {
            var params = [index, 0];
            for(var i=0; i< this.cols_to_add;i++) {
                params.push({});
            }
            this.styles = _.map(this.styles, function (row) {
                Array.prototype.splice.apply(row, params);
                return row;
            }, this);
            this.saveData();
        },
        createColRight: function() {
            var cols_count = window.prompt(i18nVcTable.enter_cols_count, 1),
                current_col_index = this.selection[1];
            if(parseInt(cols_count) > 0 && parseInt(cols_count) <= 10) {
                this.cols_to_add = parseInt(cols_count);
                this.hot.alter('insert_col', current_col_index +1, this.cols_to_add, null, true);
            } else if(parseInt(cols_count) > 10) {
                alert(i18nVcTable.max_cols_count);
            }
        },
        createColLeft: function() {
            var cols_count = window.prompt(i18nVcTable.enter_cols_count, 1),
                current_col_index = this.selection[1];
            if(parseInt(cols_count) > 0 && parseInt(cols_count) <= 10) {
                this.cols_to_add = parseInt(cols_count);
                this.hot.alter('insert_col', current_col_index, this.cols_to_add, null, true);
            } else if(parseInt(cols_count) > 10) {
                alert(i18nVcTable.max_cols_count);
            }
        },
        removeCol:function (index) {
            this.styles = _.map(this.styles, function (row) {
                row.splice(index, 1);
                return row;
            });
            this.saveData();
        },
        createRow:function (index) {
            var params = [index, 0];
            for(var i=0;i<this.rows_to_add;i++) {
                params.push(new Array(this.styles.length ? this.styles[0].length : 0));
            }
            Array.prototype.splice.apply(this.styles, params);
            this.saveData();
        },
        createRowAbove: function() {
            var rows_count = window.prompt(i18nVcTable.enter_rows_count, 1),
                current_row_index = this.selection[0];
            if(parseInt(rows_count) > 0 && parseInt(rows_count) <= 10) {
                this.rows_to_add = parseInt(rows_count);
                this.hot.alter('insert_row', current_row_index, this.rows_to_add, null, true);
            } else if(parseInt(rows_count) > 10) {
                alert(i18nVcTable.max_rows_count);
            }
        },
        createRowBelow: function() {
            var rows_count = window.prompt(i18nVcTable.enter_rows_count, 1),
                current_row_index = this.selection[0];
            if(parseInt(rows_count) > 0 && parseInt(rows_count) <= 10) {
                this.rows_to_add = parseInt(rows_count);
                this.hot.alter('insert_row', current_row_index+1, this.rows_to_add, null, true);
            } else if(parseInt(rows_count) > 10) {
                alert(i18nVcTable.max_rows_count);
            }
        },
        removeRow:function (index) {
            this.styles.splice(index, 1);
            this.saveData();
            return true;
        },
        customContextMenuCallback:function (key) {
            if (key === 'clone_row') {
                this.cloneRow(1);
            } else if (key === 'clone_col') {
                this.cloneCol(1);
            } else if(key === 'row_above_extend') {
                this.createRowAbove();
            } else if(key === 'row_below_extend') {
                this.createRowBelow();
            } else if(key === 'col_right_extend') {
                this.createColRight();
            } else if(key === 'col_left_extend') {
                this.createColLeft();
            }
        },
        cloneRow:function (index_change) {
            var current_row_index = this.selection[0],
                new_row_index = current_row_index + index_change;
            this.hot.alter('insert_row', new_row_index, 1, null, true);
            this.data[new_row_index] = _.extend([], this.data[current_row_index]);
            this.styles[new_row_index] = _.extend([], this.styles[current_row_index]);
            this.hot.loadData(this.data);
            this.saveData();
        },
        cloneCol:function (index_change) {
            var current_col_index = this.selection[1],
                new_col_index = current_col_index + index_change;
            this.hot.alter('insert_col', new_col_index, 1, null, true);
            this.data = _.map(this.data, function (row) {
                row[new_col_index] = '' + row[current_col_index];
                return row;
            });
            this.styles = _.map(this.styles, function (row) {
                row[new_col_index] = _.extend({}, row[current_col_index]);
                return row;
            });
            this.hot.loadData(this.data);
            this.saveData();
        },
        save:function (changes, source) {
            if (source === 'loadData') {
                return; //don't save this change
            }
            this.saveData();
        },
        updateSelected:function (name, value) {
            var row = 0,
                col;
            for (var r = this.selection[0]; r <= this.selection[2]; r++) {
                col = 0;
                for(var c = this.selection[1]; c <= this.selection[3]; c++) {
                    if(name === 'border') {
                        var current_borders_settings = !_.isUndefined(this.styles[r]) &&
                                                       _.isObject(this.styles[r][c]) &&
                                                       _.isArray(this.styles[r][c].borders) ?
                                                       this.styles[r][c].borders : [],
                            borders = this.setBorders(row, col, (_.isString(value) ? value : ''), current_borders_settings); // getter
                        this.styles[r][c] = _.extend({}, this.styles[r][c], {borders: borders});
                    } else {
                        var new_attr = {};
                        new_attr[name] = value;
                        this.styles[r][c] = _.extend({}, this.styles[r][c], new_attr);
                    }
                    this.setCellStyle(r, c);
                    col++;
                }
                row++;
            }
            this.saveData();
        },
        setBorders:function (row, col, border, borders) {
            if (border === 'left' || border === 'right' || border === 'top' || border === 'bottom') {
                borders.push('border_' + border);
            } else if (border === 'vert') {
                borders.push('border_left');
                borders.push('border_right');
            } else if (border === 'hor') {
                borders.push('border_top');
                borders.push('border_bottom');
            } else if (border === 'all') {
                borders.push('borders_all');
            } else if (border === 'inner') {
                if (col > 0) {
                    borders.push('border_left');
                }
                if (row < this.selection[2] - this.selection[0]) {
                    borders.push('border_bottom');
                }
            } else if (border === 'outer') {
                if (col === 0) {
                    borders.push('border_left');
                }
                if (col <= this.selection[3] - this.selection[1]) {
                    borders.push('border_right');
                }
                if (row === 0) {
                    borders.push('border_top');
                }
                if (row <= this.selection[2] - this.selection[0]) {
                    borders.push('border_bottom');
                }
            } else {
                borders = [];
            }

            return borders;
        }
    });
    /*
    $('.vc-table-param').each(function () {
        new VcTableParamField({el:this});
    });
    */
    $('.vc-theme-selector [data-value]').click(function(e){
        e.preventDefault();
        var $this = $(this),
            val = $this.data('value'),
            selector_name = $this.data('selector-name'),
            $dropdown = $('[data-name=' + selector_name + ']'),
            $dropdown_toggle = $dropdown.find('.dropdown-toggle');
        $dropdown_toggle.html('<span class="' +  $dropdown_toggle.data('icon-class') + '-' + val +'"></span><span class="caret"></span>');
        $('[name=' + selector_name +']').val(val).trigger('change');
    });
    _.extend(vc.atts.table_param, {
            parse: function (param) {
                var $field, tableManager, $tableManager;
                $field = this.content().find('input.wpb_vc_param_value[name="' + param.param_name + '"]' );

                tableManager = $field.data('vcFieldManager');
                return tableManager.saveData();
            },
            init: function (param, $field) {
                /**
                 * Find all fields with css_editor type and initialize.
                 */
                var that = this;
                // @todo change with version
                if(!_.isUndefined(vc.edit_element_block_view.ajax)) {
                    vc.edit_element_block_view.$el.off('vcPanel.shown.tableParam').on('vcPanel.shown.tableParam', function(){
                        $('.vc-table-param', that.content()).each(function () {
                            var tableManager = new VcTableParamField({el:this});
                            tableManager.$input.data('vcFieldManager', tableManager);
                        });
                    });
                } else {
                    $('.vc-table-param', that.content()).each(function () {
                        var tableManager = new VcTableParamField({el:this});
                        tableManager.$input.data('vcFieldManager', tableManager);
                    });
                }
            }
    });
    $('.dropdown-toggle').dropdown();

})(window.jQuery);