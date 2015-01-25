=== Side Content ===
Contributors: alfaguru
Donate link: http://figure-w.co.uk/
Tags: widget, sidebar, page
Requires at least: 2.5
Tested up to: 4.1.0
Stable tag: trunk

Side Content enables you to create widgets which have different content on different pages.

== Description ==

This plugin provides similar functionality to the [Drupal Side Content module](http://drupal.org/project/sidecontent).

It enables you to define a set of widgets which are effectively placeholders. Each one is empty until you assign content
to it when editing a page.
This enables you to extend the content of the page into the sidebar.

Suppose, for example, you have a set of pages about people in your company. You could use a side content
widget to add a biography for each of them, or a photo, or to list their favourite pizza toppings.

You can use the plugin without any template changes at all, but it does provide a simple API so you can test for the presence of side content widgets and adjust your templates accordingly.

As of release 0.7 of the plugin, it supports the [WP shortcode API](http://codex.wordpress.org/Shortcode_API). There is also an extra add-on plugin which provides the same support for [NextGEN Gallery](http://alexrabe.boelinger.com/wordpress-plugins/nextgen-gallery/) shortcodes (development sponsored by [Comunicrea s. n. c.](http://www.comunicrea.com/)).

Release 0.75 fixes a bug affecting side content widgets with names containing characters other than lowercase alphanumerics. A new contributed extension provides integration with the qTranslate plugin.

Release 0.8 adds no new functionality but makes the plugin compatible with WP 2.7.
Release 0.9 adds no new functionality but makes the plugin compatible with WP 2.8.1.
Release 1.0 adds no new functionality but makes the plugin compatible with WP 4.1.0.

== Installation ==

1. Unzip into your `/wp-content/plugins/` directory. If you're uploading it make sure to upload
the top-level folder. Don't just upload all the php files and put them in `/wp-content/plugins/`.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the settings page (*Options - Side Content*) and create widgets by typing names for them into the box (one per line).
1. You can optionally have side content on individual blog posts as well. Tick the checkbox if you want that option.
1. If you want to use shortcodes in your widget, tick the checkbox if you want that option. (Not needed for NextGEN Gallery shortcodes: see the next step).
1. If you want to use NextGen Gallery shortcodes in your widget, go to the Plugins panel and enable Side Content NextGEN Integration.
1. Assign your widgets to positions in your sidebars (*Design - Widgets*). Note that until you give them content they won't appear anywhere.
1. Edit a page (or post) for which you want one or more sidebar content widgets. The widget entry areas will be found in a sub panel headed "Side Content Widgets". In each area enter the HTML (including any heading) you wish to appear. The widget content will be saved along with the rest of the page or post.

== Frequently Asked Questions ==

= Why do I get an error when I enable the plugin? =

If you see an error message like "Parse error: parse error, unexpected T\_STRING, expecting T\_OLD_FUNCTION or T\_FUNCTION or T\_VAR ..." it is because you are running under PHP4. The plugin requires PHP5.

= Is this plugin WordPress-MU compatible? =

As of release 0.6, yes, it should work under WP-MU, although it has only been tested with the 2.6.3 release, and not very extensively.

= Does the plugin allow side content for blog posts? =

Yes. There's an option on the settings page (*Options - Side Content*) for this.

= My widget content also appears in the custom fields subpanel on the editor page. Why? =

The plugin uses custom fields to store the widget code, but has its own subpanel for editing to improve ease of use. You can use either to edit your widgets but it is best to stick to one or the other.

= Why does the widget does not recognise shortcodes for some plugins? =

Not all plugins use the new WP Shortcode API yet. If you need particular shortcodes to be recognised it may be possible to have an addon developed for that purpose. Contact the author for more details.

= Will you add the facility to execute PHP code? =

There are no plans to add PHP execution support to the plugin. In my opinion this would not be a good way to use it. Most of those who have requested the feature are actually looking for what is offered by the [Widget Logic](http://wordpress.org/extend/plugins/widget-logic/) plugin, the ability to hide or display content conditionally.

== Screenshots ==

There are no screenshots for this plugin.

== API ==

Use the following code to test for the presence of side content widgets:

`<?php if(function_exists('the_side_content') && the_side_content()->has_widgets() :?>`

Use the following code to test for the presence of a particular side content widget called 'widget name':

`<?php if(function_exists('the_side_content') && the_side_content()->has_widgets('widget name') :?>`

The plugin defines a filter, 'side_content', which can be used to preprocess side content widgets before display.