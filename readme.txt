=== My Photon ===
Contributors: mboynes
Tags: photon, images, cdn
Requires at least: 3.9
Tested up to: 4.0
Stable tag: 0.1

Integrate a self-hosted version of Photon with your WordPress site.

== Description ==

[Photon](http://code.trac.wordpress.org/browser/photon) is an open-source
program which allows you to "magically resize and transform images". The
[Jetpack plugin by WordPress.com](http://wordpress.org/extend/plugins/jetpack/)
depends on this software to power the image CDN used by its Photon module. For
one reason or another, you might want or need to run your own image server
outside of WordPress.com. Once you have your Photon server up-and-running,
this plugin will replace URLs in your content to use that server.

Read more about Photon at http://developer.wordpress.com/docs/photon/

== Installation ==

1. Upload the plugin to the \`/wp-content/plugins/\` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress as normal.
3. Install the Photon software ([SVN](http://code.svn.wordpress.org/photon/)/
[Trac](http://code.trac.wordpress.org/browser/photon)) on your image server.
    * Note that in order to run this, you may have to install other
    dependencies like Gmagick and cURL.
4. Go to Settings &rarr; My Photon Settings and set the base URL for your image
server and set the plugin to active.

== Frequently Asked Questions ==

= How do I get an image server? =

You need to run it yourself and install the
[Photon software](http://code.svn.wordpress.org/photon/) on it.

= Can I use the WordPress.com CDN with this plugin? =

No. From the [WordPress.com docs](http://developer.wordpress.com/docs/photon/),

> Use of this service is for users of the Jetpack by WordPress.com plugin only,
> and may be used by sites hosted on WordPress.com, or on Jetpack-connected
> WordPress sites. If you move to another platform, or disconnect Jetpack from
> your site, we can't promise it will continue to work.

== Changelog ==

= 0.1 =

* Initial release