=== Side Content ===
Contributors: alfaguru
Donate link: http://likemind.co.uk/
Tags: widget, sidebar, page
Requires at least: 2.5
Tested up to: 2.6
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

== Installation ==

1. Unzip into your `/wp-content/plugins/` directory. If you're uploading it make sure to upload
the top-level folder. Don't just upload all the php files and put them in `/wp-content/plugins/`.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the settings page (*Options - Side Content*) and create widgets by typing names for them into the box (one per line).
1. You can optionally have side content on individual blog posts as well. Tick the checkbox if you want that option.
1. Assign your widgets to positions in your sidebars (*Design - Widgets*). Note that until you give them content they won't appear anywhere.
1. Edit a page (or post) for which you want one or more sidebar content widgets. The widget entry areas will be found in a sub panel headed "Side Content Widgets". In each area enter the HTML (including any heading) you wish to appear. The widget content will be saved along with the rest of the page or post.

== Frequently Asked Questions ==

= Why do I get an error when I enable the plugin? =

If you see an error message like "Parse error: parse error, unexpected T_STRING, expecting T_OLD_FUNCTION or T_FUNCTION or T_VAR ..." it is because you are running under PHP4. The plugin requires PHP5.

= Is this plugin WordPress-MU compatible? =

As of release 0.6, yes, it should work under WP-MU, although it has only been tested with the 2.6.3 release, and not very extensively.

= Does the plugin allow side content for blog posts? =

Yes. There's an option on the settings page (*Options - Side Content*) for this.

= My widget content also appears in the custom fields subpanel on the editor page. Why? =

The plugin uses custom fields to store the widget code, but has its own subpanel for editing to improve ease of use. You can use either to edit your widgets but it is best to stick to one or the other.

== Screenshots ==

There are no screenshots for this plugin.

== API ==

Use the following code to test for the presence of side content widgets:

`<?php if(function_exists('the_side_content') && the_side_content()->has_widgets() :?>`

Use the following code to test for the presence of a particular side content widget called 'widget name':

`<?php if(function_exists('the_side_content') && the_side_content()->has_widgets('widget name') :?>`
