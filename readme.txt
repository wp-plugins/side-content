=== Plugin Name ===
Contributors: alfaguru
Donate link: http://likemind.co.uk/
Tags: widget, sidebar, page
Requires at least: 2.5
Tested up to: 2.5.1
Stable tag: trunk

Side Content enables you to create widgets which have different content on different pages.

== Description ==

This plugin provides similar functionality to the [Drupal Side Content module](http://drupal.org/project/sidecontent).

It enables you to define a set of widgets which are effectively placeholders. Each one is empty until you assign content
to it when editing a page.
This enables you to effectively extend the content of the page into the sidebar.

Suppose, for example, you have a set of pages about people in your company. You could use a side content
widget to add a biography for each of them, or a photo, or to list their favourite pizza toppings.

You can use the plugin without any template changes at all, but it does provide a simple API so you can test for the presence of side content widgets and adjust your templates accordingly.

== Installation ==

1. Unzip into your `/wp-content/plugins/` directory. If you're uploading it make sure to upload
the top-level folder. Don't just upload all the php files and put them in `/wp-content/plugins/`.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the settings page (*Options - Side Content*) and create widgets by typing names for them into the box (one per line).
1. Assign your widgets to positions in your sidebars (*Design - Widgets*). Note that until you give them content they won't appear anywhere.
1. Edit a page for which you want one or more sidebar content widgets. Create a custom field for each widget. The name of the field must be exactly the same as the name of the widget, The content of the field should be the HTML (including any heading) you wish to appear.

== Frequently Asked Questions ==

= Does the plugin allow side content for blog posts? =

Not right now, but it may do so in the future.

== Screenshots ==

There are no screenshots for this plugin.

== API ==

Use the following code to test for the presence of side content widgets:

`<?php if(function_exists('the_side_content') && the_side_content()->has_widgets() :?>`

Use the following code to test for the presence of a particular side content widget called 'widget name':

`<?php if(function_exists('the_side_content') && the_side_content()->has_widgets('widget name') :?>`
