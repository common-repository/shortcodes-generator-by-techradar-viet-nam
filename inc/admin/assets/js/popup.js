/**
 * @author     TechRadar Việt Nam
 * @package  Shortcodes Generator
 */

(function ($) {

    'use strict';

    $.zfshortcode = $.zfshortcode || {};

    var zf_shortcode_popup = $('#zf-shortcode-popup');

    $.zfshortcode.init_popup = function () {

        $('.zf-insert-shortcode-button').magnificPopup({
            type: 'inline',
            removalDelay: 500, //delay removal by X to allow out-animation
            mainClass: 'mfp-zoom-out',
            fixedContentPos: 'auto',
            callbacks: {
                beforeOpen: function () {

                }
            },

            midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.

        });
        // tab elements
        $('.zf-shortcode-list ul li').click(function () {
            var tab_id = $(this).attr('data-tab');

            $('.zf-shortcode-list ul li').removeClass('sc-current');
            $('.zf-shortcode-content').removeClass('sc-current');

            $(this).addClass('sc-current');
            $("#" + tab_id).addClass('sc-current');
        });

        // toggle menu shortcodes
        $('.zf-menu-shortcodes').on('click', function () {
            $('.zf-popup-content').toggleClass('move-right');
        });
        $('.content-right').on('click', function (e) {
            $('.zf-popup-content').removeClass('move-right');
        });
        // Filter shortcode by type
        var col_left = $('.content-left', zf_shortcode_popup);

        $('#filter-by-type').on('change', function () {
            var type = $(this).val();
            if (type == 'all') {
                $('.zf-shortcode-list .zf-shortcode-tab', col_left).show();
            } else {
                $('.zf-shortcode-list .zf-shortcode-tab', col_left).each(function () {
                    if ($(this).attr('data-filter') == type) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }

                });
            }
        });

    };

    $.zfshortcode.resize_popup = function () {
        var height = $(window).height();
        $('.zf-popup-content .content-right', zf_shortcode_popup).css({
            height: height - 256
        });
    };

    $.zfshortcode.init_content = function () {

        $('.zf-shortcode-content').each(function () {
            var $this = $(this);

            var items = $("#items", $this);
            if (items.length) {
                var tabs = items.tabs(
                    {
                        closable: true
                    }
                );
                tabs.find(" > .ui-tabs-nav").sortable({
                    stop: function () {
                        tabs.tabs("refresh");
                    }
                });

                var index = 2;
                var panel_id = 2;
                $("#button-add-item", $this).on('click', function (e) {
                    e.preventDefault();
                    var active_li = items.find(' > .ui-tabs-nav .ui-tabs-active').first(),
                        active_panel_id = active_li.attr('aria-controls'),
                        tab_title = active_li.find(' > a').data('tab-title'),
                        tem_li = "<li><a href='#item-" + panel_id + "' data-tab-title='" + tab_title + "'>" + tab_title + "</a><span class='ui-icon ui-icon-close' role='presentation'></span></li>";

                    tabs.find(".zf-element-tabs").tabs("destroy");

                    var tem_li_ob = $(tem_li);
                    tem_li_ob.find('a').append('<span> #' + index + '</span>');
                    index++;
                    tabs.find("> .ui-tabs-nav").append(tem_li_ob);
                    var tab_content_cloned = $('<div></div>', {id: 'item-' + panel_id});
                    tab_content_cloned.append( $('#' + active_panel_id, $this).html());

                    // init again for new tab
                    // color fields
                    tab_content_cloned.find('.wp-picker-container').each(function () {
                        var parent_div = $(this).parent();
                        var color_clone = $(this).find('.zf-color-picker').clone();
                        parent_div.append(color_clone);
                        $(this).remove();
                        var $field_key = color_clone.attr('id');
                        $('#' + $field_key, parent_div).wpColorPicker();
                    });
                    // upload radio field
                    tab_content_cloned.find('.zf-radio-field').each(function () {
                        var field_name = $(this).attr('data-field');
                        var modify_name = field_name + $.now();
                        $(this).find('input[type="radio"]').attr('name', modify_name);
                    });
                    // upload media field
                    $.zfshortcode.init_element_media(tab_content_cloned);
                    $.zfshortcode.init_icon(tab_content_cloned);

                    tabs.append(tab_content_cloned);
                    tabs.tabs("refresh");
                    tabs.find(".zf-element-tabs").tabs();
                    panel_id++;
                });


                tabs.delegate("span.ui-icon-close", "click", function (e) {
                    e.preventDefault();
                    if (tabs.find("> .ui-tabs-nav li").length < 2) {
                        alert(zf_shortcode_var.remove_tab);
                        return false;
                    }
                    var panel_id = $(this).closest("li").remove().attr("aria-controls");
                    $("#" + panel_id).remove();
                    tabs.tabs("refresh");
                });

            }

            if ($('.zf-element-tabs', $this).length) {
                $('.zf-element-tabs', $this).tabs();
            }
        })

    };


    $.zfshortcode.send_to_editor = function () {

        $('#insert-shortcode', zf_shortcode_popup).click(function (e) {
            e.preventDefault();
            var attrs = [],
                childs = [],
                content = '',
                current_tab = $('.content-right .sc-current');


            $('#parent-shortcode .zf-field', current_tab).each(function () {
                var $this = $(this);
                if ($this.hasClass('is-content')) {
                    content = $this.val();
                } else if ($this.hasClass('zf-spacing-field')) {
                    var spacing_type = $this.find('#spacing-type').val();
                    var spacing_str = '';
                    $this.find('input[type="text"]').each(function () {
                        if ($(this).val() != '') {
                            spacing_str += $(this).attr('name').replace('spacing-', '') + ':' + $(this).val() + spacing_type + ' ';
                        }
                    });

                    spacing_str = spacing_str.trim().replace(/\s/g, '|');
                    if (spacing_str != '') {
                        attrs.push($this.attr('data-field') + '="' + spacing_str + '"');
                    }

                } else if ($this.hasClass('zf-radio-field')) {
                    var $radio = $this.find('input[type="radio"]:checked');
                    if ($radio.val() != '') {
                        attrs.push($this.attr('data-field') + '="' + $radio.val() + '"');
                    }
                } else if ($this.hasClass('zf-column-responsive-field')) {
                    var responsive = '';
                    $this.find('.zf-device-row').each(function () {
                        var device = $(this).attr('data-device'),
                            column_offset = $(this).find('.responsive-column-offset').val(),
                            column_hidden = $(this).find('.responsive-column-hidden').is(':checked');
                        var column_size = $(this).find('.responsive-column-size');
                        if (column_size.length > 0) {
                            column_size = column_size.val();
                        } else {
                            column_size = '';
                        }
                        var size = (column_size != '') ? ' col-' + device + '-' + column_size : '';
                        var offset = (column_offset != '') ? ' col-' + device + '-' + column_offset : '';
                        var hidden = (column_hidden) ? ' hidden-' + device : '';
                        responsive += size + offset + hidden;
                    });
                    if (responsive != '') {
                        attrs.push($this.attr('data-field') + '="' + responsive.trim() + '"');
                    }

                } else {
                    if ($this.val() != '') {
                        attrs.push($this.attr('name') + '="' + $this.val() + '"');
                    }
                }
            });


            var items = $('#child-shortcode #items', current_tab);
            if (items.length > 0) {
                var order_items = [];
                items.find('> ul > li a').each(function () {
                    var panel_id = $(this).parent().attr("aria-controls");
                    order_items.push(panel_id);
                });

                if (order_items.length > 0) {
                    $.each(order_items, function (i, value) {
                        var child_attrs = [];
                        var child_attrs_str = '';
                        var child_cotnent = '';
                        $('#' + value + ' .zf-field', current_tab).each(function () {
                            var $this = $(this);

                            if ($this.hasClass('is-content')) {
                                child_cotnent = $this.val();
                            } else if ($this.hasClass('zf-spacing-field')) {

                                var spacing_type = $this.find('#spacing-type').val();
                                var spacing_str = '';
                                $this.find('input[type="text"]').each(function () {
                                    if ($(this).val() != '') {
                                        spacing_str += $(this).attr('name').replace('spacing-', '') + ':' + $(this).val() + spacing_type + ' ';
                                    }
                                });
                                spacing_str = spacing_str.trim().replace(/\s/g, '|');
                                if (spacing_str != '') {
                                    child_attrs.push($this.attr('data-field') + '="' + spacing_str + '"');
                                }

                            } else if ($this.hasClass('zf-radio-field')) {
                                var $radio = $this.find('input[type="radio"]:checked');
                                if ($radio.val() != '') {
                                    child_attrs.push($this.attr('data-field') + '="' + $radio.val() + '"');
                                }
                            } else if ($this.hasClass('zf-column-responsive-field')) {

                                var responsive = '';
                                $this.find('.zf-device-row').each(function () {
                                    var device = $(this).attr('data-device'),
                                        column_offset = $(this).find('.responsive-column-offset').val(),
                                        column_hidden = $(this).find('.responsive-column-hidden').is(':checked');
                                    var column_size = $(this).find('.responsive-column-size');
                                    if (column_size.length > 0) {
                                        column_size = column_size.val();
                                    } else {
                                        column_size = '';
                                    }
                                    var size = (column_size != '') ? ' col-' + device + '-' + column_size : '';
                                    var offset = (column_offset != '') ? ' col-' + device + '-' + column_offset : '';
                                    var hidden = (column_hidden) ? ' hidden-' + device : '';
                                    responsive += size + offset + hidden;
                                });
                                if (responsive != '') {
                                    child_attrs.push($this.attr('data-field') + '="' + responsive.trim() + '"');
                                }

                            } else {
                                if ($this.val() != '') {
                                    child_attrs.push($this.attr('name') + '="' + $this.val() + '"');
                                }
                            }

                        });
                        if (child_attrs.length > 0) {
                            child_attrs_str = ' ' + child_attrs.join(' ').trim();
                        }
                        childs.push({attrs: child_attrs_str, content: child_cotnent});
                    });
                }

            }

            var shortcode_tem = $('#zf_shortcode', current_tab).val();
            var child_shortcode_tem = $('#zf_child_shortcode', current_tab).val();
            var has_child = $('#zf_has_child', current_tab).val();
            var final_shortcode_tem = '';
            var attrs_str = '';

            if (attrs.length > 0) {
                attrs_str = ' ' + attrs.join(' ').trim();
            }

            if (has_child) {
                var child_tem = '';
                if (childs.length > 0) {
                    $.each(childs, function (i, ob) {
                        var bk_tem = child_shortcode_tem;
                        child_tem += bk_tem.replace('{{attributes}}', ob.attrs).replace('{{content}}', ob.content) + "<br>";
                    });
                    content = "<br>" + child_tem;
                }

            }

            final_shortcode_tem = shortcode_tem.replace('{{attributes}}', attrs_str).replace('{{content}}', content);
            if (final_shortcode_tem != '') {
                $.magnificPopup.close();
                window.send_to_editor(final_shortcode_tem);

            }
        });
    };

    $.zfshortcode.reset_fields = function () {

        $('#reset-shortcode', zf_shortcode_popup).on('click', function (e) {
            e.preventDefault();
            $('.content-right .zf-field', zf_shortcode_popup).each(function () {
                var $this = $(this);
                if ($this.hasClass('zf-radio-field')) {
                    $this.find('input[value="' + $this.attr('data-reset') + '"]').attr('checked', true);
                } else if ($this.hasClass('zf-spacing-field')) {
                    $this.find('#spacing-top').val($this.attr('data-top'));
                    $this.find('#spacing-right').val($this.attr('data-right'));
                    $this.find('#spacing-bottom').val($this.attr('data-bottom'));
                    $this.find('#spacing-left').val($this.attr('data-left'));
                    $this.find('#spacing-type').val($this.attr('data-type'));
                } else {
                    var reset = $this.attr('data-reset');
                    if ($this.hasClass('zf-icon-field')) {
                        var icon_container = $this.parent();
                        icon_container.find('.zf-font-awesomefont').removeClass('selected');

                        if (reset != '') {
                            icon_container.find('.fa-' + reset).closest('.zf-font-awesomefont').addClass('selected');
                        }
                    }

                    $this.val(reset);
                }

            });

        });

    };

    $.zfshortcode.fields = function () {
        $('.zf-shortcode-content').each(function () {
            var $parent = $(this);
            $.zfshortcode.init_color($parent);
            $.zfshortcode.init_element_media($parent);
            $.zfshortcode.init_icon($parent);
        });
    };

    $.zfshortcode.init_icon = function (ob) {

        $('.zf-font-awesomefont a', ob).on('click', function (e) {
            e.preventDefault();
            var font_item = $(this).parent();
            var container = $(this).closest('.zf-icon-field-container');

            if (font_item.hasClass('selected')) {
                font_item.removeClass('selected');
                container.find('input[type="hidden"]').val('');
            } else {
                container.find('.zf-font-awesomefont').removeClass('selected');
                font_item.addClass('selected');
                container.find('input[type="hidden"]').val($(this).attr('href'));
            }
        });

        $('.zf-icon-field', ob).each(function () {
            var $this = $(this);
            if ($this.val() != '') {
                var icon_container = $this.parent();
                icon_container.find('.fa-' + $this.val()).closest('.zf-font-awesomefont').addClass('selected');
            }
        });
    };

    $.zfshortcode.init_color = function (ob) {

        $('.zf-color-picker', ob).each(function () {
            var $this = $(this);
            var $field_key = $this.attr('id');
            $('#' + $field_key, ob).wpColorPicker();
        });
    };

    // init elements media for a object
    $.zfshortcode.init_element_media = function (ob) {

        $('.zf-upload-image', ob).on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            var field_key = $this.attr('data-field');
            $.zfshortcode.upload_media(field_key, $this.parent());
        });
    }

    $.zfshortcode.upload_media = function (field_key, ob) {

        var media = wp.media({
            title: 'Insert a media',
            library: {type: 'image'},
            multiple: false,
            button: {text: 'Insert'}
        });

        media.on('select', function () {
            var first = media.state().get('selection').first().toJSON();
            $('#' + field_key, ob).val(first.url);
        });

        media.open();

        return false;

    };


    $(document).ready(function () {

        $.zfshortcode.init_popup();
        $.zfshortcode.resize_popup();
        $(window).on('resize', function () {
            $.zfshortcode.resize_popup();
        });
        $.zfshortcode.init_content();
        $.zfshortcode.fields();
        $.zfshortcode.send_to_editor();
        $.zfshortcode.reset_fields();

    });


})(jQuery);