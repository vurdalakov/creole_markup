<?php
/*
Plugin Name: Creole Wiki Markup
Description: Allows to use Creole 1.0 wiki markup instead of HTML in page content
Version: 0.1
Author: Vurdalakov
Author URI: http://www.vurdalakov.net/
Author email: vurdalakov@gmail.com
Source code: https://github.com/vurdalakov/creole_markup
*/

/*
The MIT License (MIT)

Copyright (c) 2013 Vurdalakov

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

require_once(dirname(__FILE__) . '/creole_markup/creole.php');

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# register plugin
register_plugin(
	$thisfile,
	'Creole Wiki Markup',
	'0.1',
	'Vurdalakov',
	'http://www.vurdalakov.net/',
	'Allows to use Creole 1.0 wiki markup instead of HTML in page content',
	'plugins',
	''
);

# activate filter
add_filter('content', 'parse_content');

# parse page content
function parse_content($content) {

    global $SITEURL;

    $content = str_ireplace('<p>', '', $content);
    $content = str_ireplace('</p>', "\r\n", $content);
    $content = preg_replace('/<br ?\/?>/', '', $content);
    $content = str_ireplace('&nbsp;', ' ', $content);
    $content = str_replace("\n\t", "\n", $content);

    $options = array(
        'link_format' => parse_url($SITEURL, PHP_URL_PATH) . '%s',
        'interwiki' => array(
            'Wikipedia' => 'http://ru.wikipedia.org/wiki/%s',
        ),
    );

    $creole = new creole($options);

    return $creole->parse($content);
}
?>