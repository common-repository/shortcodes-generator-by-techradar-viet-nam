<?php
/**
 * @version    $Id$
 * @package    Shortcodes Generator By TechRadar Việt Nam
 * @author     TechRadar Việt Nam
 * @copyright  Copyright (C) 2018 TechRadar Việt Nam All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if(!function_exists('zf_do_shortcode_content')) {

    function zf_do_shortcode_content($content, $autop = false)
    {

        if ($autop) {
            $content = wpautop(preg_replace('/<\/?p\>/', "\n", $content) . "\n");
        }

        $content = trim(do_shortcode(shortcode_unautop($content)));
        $content = preg_replace('#^<\/p>|^<br>|^<br />|^<p>$#', '', $content);
        /* Remove '' from the start of the string. */
        if (substr($content, 0, 4) == '')
            $content = substr($content, 4);

        /* Remove '' from the end of the string. */
        if (substr($content, -3, 3) == '')
            $content = substr($content, 0, -3);

        /* Remove any instances of ''. */
        $content = str_replace(array('<p></p>', '<br>', '<br />'), '', $content);
        $content = str_replace(array('</p></p>'), '', $content);

        return $content;
    }

}
