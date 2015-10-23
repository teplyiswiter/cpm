=== Auto Image Resizer ===
Contributors: Dennis Hoppe
Tags: picture, pictures, photo, photos, resize, resample, reduce,       widget,Post,plugin,admin,posts,sidebar,comments,google,images,page,image,links
Requires at least: 3.2
Tested up to: 3.6.1
Stable tag: trunk

This Plugin reduces all uploaded images to the maximal used image dimensions of your WordPress website.

== Description ==
The "[Auto Image Resizer](http://dennishoppe.de/en/wordpress-plugins/auto-image-resizer)" is a state of the art [WordPress Plugin](http://dennishoppe.de/en/wordpress-plugins/auto-image-resizer) which reduces your uploaded images to the maximal used image dimensions of your WordPress website.

If the uploaders (author, member, whoever) browsers supports HTML5, Gears, Flash or Silverlight the images will be resized directly on the client otherwise the server will do that. So the [Auto Image Resizer](http://dennishoppe.de/en/wordpress-plugins/auto-image-resizer) plugin works in every case regardless of the clients browser or OS.

In this version of [Auto Image Resizer](http://dennishoppe.de/en/wordpress-plugins/auto-image-resizer) some features are not available. You will find notices on several places in the backend that the described feature is part of the [Pro Version](http://dennishoppe.de/en/wordpress-plugins/auto-image-resizer).


= How it works =
1. Download the plugin and install it on your WordPress website or blog
1. Configure the plugin in the WordPress backend (or use the default options)
1. If a user uploads a new image to the media library, to a post or a page (or a custom post type) the plugin analyses the image dimensions automatically and unnoticeable.
1. If the uploaded image is bigger than the defined maximal image dimensions it will be reduced to the maximal height and width without cropping or deforming it.
1. If the uploaders browsers supports html5, gears, flash or silverlight the images will be resized directly on the client before uploading them.
1. Then the reduced version of the uploaded image will replace the "large size" version of the image.


= Settings =
You can find the options page in WP Admin Panel &raquo; Settings &raquo; [Auto Image Resizer](http://dennishoppe.de/en/wordpress-plugins/auto-image-resizer).


= Questions =
I know you have many questions – my mailbox is the proof. ;) But unfortunately I cannot give support for this free plugin. There is a separate support package available for the [Pro Version](http://dennishoppe.de/en/wordpress-plugins/auto-image-resizer) of this plugin. Please use it. Of course you can hire me for consulting, support, programming and customizations at any time.


= Notices =
Some themes and plugins register custom image sizes with "endless" width or height. For example TwentyTen registers a banner size with a maximal width of 9999px. This results in a maximal image size of 9999px for your reduced images.


= Language =
* This Plugin is available in English.
* Diese Erweiterung ist in Deutsch verfügbar. ([Dennis Hoppe](http://DennisHoppe.de/))
* এই প্লাগইনটি বাংলা ভাষাতেও পাওয়া যাচ্ছ।  ([S. M. Mehdi Akram](http://www.shamokaldarpon.com/))
* Dette plugin er tilgængelig på Dansk. ([Thomas Jensen](http://artikelforlaget.dk/))
* 这个插件有中文版 ([Stella Hu](http://prowordpresser.com/))
* Plugin disponible en Español. (Carlos Freijo)
* Ovaj plugin je dostupan na Srpskom jeziku. ([Milan Budimkic](http://mbseoservice.com/))


= Translate this plugin =
If you have translated this plugin in your language feel free to send me the language file (.po file) via E-Mail with your name and this translated sentence: "This plug-in is available in %YOUR_LANGUAGE_NAME%." So i can add it to the plugin.

You can find the *Translation.pot* file in the *language/* folder in the plugin directory.

* Copy it.
* Rename it (to your language code).
* Translate everything.
* Send it via E-Mail to &lt;Mail [@t] [DennisHoppe](http://DennisHoppe.de/) [dot] de&gt;.
* Thats it. Thank you! =)


= Frequently Asked Questions =
I am still collecting frequently asked questions. ;)


== Screenshots ==
1. Media Settings page
2. Auto Image Resizer options page


== Changelog ==

= 1.0.8 =
* Added serbian translation file by [Milan Budimkic](http://mbseoservice.com/)

= 1.0.7 =
* Added spanish translation file by Carlos Freijo.

= 1.0.6 =
* Added Chinese translation file by [Stella Hu](http://prowordpresser.com/)

= 1.0.5 =
* Improved backend Javascript

= 1.0.4 =
* Changed Base URL (faster)
* Added Danish translation by [Thomas Jensen](http://artikelforlaget.dk/)

= 1.0.3 =
* Plugin sets max upload size now

= 1.0.2 =
* Updated the uploader patch for WP 3.5
* Added support for Windows Machines

= 1.0.1
* Fixed the image-increase-bug

= 1.0 =
* Everything works fine.