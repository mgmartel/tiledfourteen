<?php
/**
 * Contains all CSS for setting the theme base color
 * Only called if base color is different from default.
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

$props = shortcode_atts( array(
    'primary_color' => '#24890d',
    'hover_color'   => '#41a62a',
    'active_color'  => '#55d737',
), $props );

return <<<CSS
a,
.content-sidebar .widget a {
	color: {$props['primary_color']};
}

.hentry .mejs-controls .mejs-time-rail .mejs-time-current {
    background: {$props['primary_color']};
}

.paging-navigation .page-numbers.current {
	border-top: 5px solid {$props['primary_color']};
}

button,
.button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.search-toggle,
.widget button,
.widget .button,
.widget input[type="button"],
.widget input[type="reset"],
.widget input[type="submit"],
.widget_calendar tbody a,
.content-sidebar .widget input[type="button"],
.content-sidebar .widget input[type="reset"],
.content-sidebar .widget input[type="submit"],
.slider-control-paging .slider-active:before,
.slider-control-paging .slider-active:hover:before,
.slider-direction-nav a:hover {
    background-color: {$props['primary_color']};
}

::selection {
	background: {$props['primary_color']};
}

::-moz-selection {
	background: {$props['primary_color']};
}

a:active,
a:hover,
.site-navigation a:hover,
.entry-title a:hover,
.entry-meta a:hover,
.cat-links a:hover,
.entry-content .edit-link a:hover,
.post-navigation a:hover,
.image-navigation a:hover,
.comment-author a:hover,
.comment-list .pingback a:hover,
.comment-list .trackback a:hover,
.comment-metadata a:hover,
.comment-reply-title small a:hover,
.widget a:hover,
.widget-title a:hover,
.widget_twentyfourteen_ephemera .entry-meta a:hover,
.content-sidebar .widget a:hover,
.content-sidebar .widget .widget-title a:hover,
.content-sidebar .widget_twentyfourteen_ephemera .entry-meta a:hover,
.site-info a:hover,
.featured-content a:hover,
.slider-control-paging a:hover:before {
	color: {$props['hover_color']};
}

button:hover,
button:focus,
.button:hover,
.button:focus,
.widget button:hover,
.widget button:focus,
.widget .button:hover,
.widget .button:focus,
input[type="button"]:hover,
input[type="button"]:focus,
input[type="reset"]:hover,
input[type="reset"]:focus,
input[type="submit"]:hover,
input[type="submit"]:focus,
.search-toggle:hover,
.search-toggle.active,
.search-box,
.entry-meta .tag-links a:hover,
.widget input[type="button"]:hover,
.widget input[type="button"]:focus,
.widget input[type="reset"]:hover,
.widget input[type="reset"]:focus,
.widget input[type="submit"]:hover,
.widget input[type="submit"]:focus,
.widget_calendar tbody a:hover,
.content-sidebar .widget input[type="button"]:hover,
.content-sidebar .widget input[type="button"]:focus,
.content-sidebar .widget input[type="reset"]:hover,
.content-sidebar .widget input[type="reset"]:focus,
.content-sidebar .widget input[type="submit"]:hover,
.content-sidebar .widget input[type="submit"]:focus
{
	background-color: {$props['hover_color']};
    color: #fff;
}

.entry-meta .tag-links a:hover:before {
	border-right-color: {$props['hover_color']};
}

.page-links a:hover {
	background: {$props['hover_color']};
	border: 1px solid {$props['hover_color']};
}

.paging-navigation a:hover {
	border-top: 5px solid {$props['hover_color']};
}

button:active,
.button:active,
input[type="button"]:active,
input[type="reset"]:active,
input[type="submit"]:active,
.widget input[type="button"]:active,
.widget input[type="reset"]:active,
.widget input[type="submit"]:active,
.content-sidebar .widget input[type="button"]:active,
.content-sidebar .widget input[type="reset"]:active,
.content-sidebar .widget input[type="submit"]:active {
	background-color: {$props['active_color']};
}

.site-navigation .current_page_item > a,
.site-navigation .current_page_ancestor > a,
.site-navigation .current-menu-item > a,
.site-navigation .current-menu-ancestor > a {
	color: {$props['active_color']};
}

@media screen and (min-width: 783px) {

    .primary-navigation ul ul,
    .primary-navigation li:hover > a,
	.primary-navigation li.focus > a
    {
        background-color: {$props['primary_color']};
    }

    .primary-navigation ul ul a:hover,
    .primary-navigation ul ul li.focus > a {
        background-color: {$props['hover_color']};
    }
}

@media screen and (min-width: 1008px) {

    .secondary-navigation ul ul,
    .secondary-navigation li:hover > a,
	.secondary-navigation li.focus > a
    {
        background-color: {$props['primary_color']};
    }

	.secondary-navigation ul ul a:hover,
	.secondary-navigation ul ul li.focus > a {
		background-color: {$props['hover_color']};
	}
}
CSS;
