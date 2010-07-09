=== simple scrollbar gallery ===
Contributors: Thomas Schmidt, netAction
Tags: gallery, images, image, javascript, jquery, pictures, photos, scroll, scrollbar, slide, slideshow
Requires at least: 2.6
Tested up to: 3.0
Stable tag: trunk

simple scrollbar gallery for WordPress is an image gallery as a WordPress plugin.

The plugin uses the shortcode [gallery] and supports all the standard gallery attributes.

The plugin uses jQuery, and if your site doesn't already use jQuery, it'll add the script for you. 

== Description ==

This simple plugin shows a large size image in the page and below a scrollable row of thumbnails without scrollbar. You can scroll the thumbs while mouseover and choose an image for the big view.

Inspired by many other scripts.

== Installation ==

1. Unpack the plugin, put it in your "plugins" folder (`/wp-content/plugins/`).
2. Activate the plugin from the Plugins section.
3. Now you need all images of your gallery in the same size.

== Create Images ==

You need all images of your gallery in the same size and have to upload them in the same aspect ratio. Maybe you have landscape and portait photos and want a square gallery. Then you have to scale the images and compose a border around them. Landscape images get a top and bottom border, portraits right and left. With imagemagick you can create a gray image of the right dimensions and fit all images over it: `$ for file in *; do composite -gravity center $file background.png $file; done`

== Frequently Asked Questions ==

= What images appear in the gallery =
Simple attach the images you wish to appear in the gallery to the page or post where you will place the shortcode [gallery].

= How do I change the design =
You can use CSS to change the look and feel of the layout. You can also create custom images for the next and prev arrows.

= How do I change the image and thumbnail sizes =
Carousel Gallery uses the Wordpress Media settings for this (Settings -> Media Library).

= Which size have the images in the gallery =
Usually you want the gallery to have the full width of your site. If you make the images square or landscape depends on you. Portrait images are no good idea because the gallery will become too high. After choosing the right dimensions you have to scale all your images to the same aspect ration. See "Create Images" for more information.


== Screenshots ==

1. The size of the big image is the size of the first in the gallery. You should have all images in the gallery in the same width and heigth to avoid scaling.
2. When putting the mouse over the thumbnails they will scroll smoothly. You can go left and right by moving the mouse cursor.

== Changelog ==

* 0.1: First release June 2010
* 0.2: Some fixes June 2010
* 1.0 Minor fixes
* 1.7 Screenshots

