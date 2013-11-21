<?php
/**
 * jQuery Picasa Gallery Extension for Bolt, by Daniele Conca <conca.daniele@gmail.com>
 *
 * @copyright Daniele Conca 2013 - Picasa extension for Bolt
 * @author Daniele Conca <conca.daniele@gmail.com>
 */
namespace CrpPicasaGallery;

class Extension extends \Bolt\BaseExtension
{

    /**
     * Info block for jQuery Picasa Gallery Extension.
     */
    function info()
    {
        $data = array(
            'name' => "jQuery Picasa Gallery",
            'description' => "A small Bolt extension that that displays your public picasa web albums on your website in a photo gallery",
            'keywords' => "Bolt,Picasa,jQuery",
            'author' => "Daniele Conca",
            'link' => "https://github.com/jamiroconca",
            'version' => "0.1",
            'required_bolt_version' => "1.2.1",
            'highest_bolt_version' => "1.2.1",
            'type' => "General",
            'first_releasedate' => "2013-10-26",
            'latest_releasedate' => "2013-10-26",
            'dependencies' => "",
            'priority' => 10
        );

        return $data;
    }

    /**
     * Initialize jQuery Picasa Gallery.
     * Called during bootstrap phase.
     */
    function initialize()
    {

        // If yourextension has a 'config.yml', it is automatically loaded.
        // $foo = $this->config['bar'];

        // Make sure jQuery is included
        $this->addJquery();

        // Add javascript file
        $this->addJavascript("assets/jquery.crppicasagallery.js");

        // Add CSS file
        $this->addCSS("assets/jquery.crppicasagallery.css");

        $this->addTwigFunction('picasaalbums', 'picasaAlbums');
    }

    public function picasaAlbums()
    {

        // code from: https://twitter.com/about/resources/buttons#tweet
        $html = <<< EOM
    <div class="picasagallery row-fluid"></div>
    <script>
    $(document).ready( function() {
    $('.picasagallery').picasagallery(
        {
            username: '%username%', // Your Picasa public username
            hide_albums: %hide_albums%, // hidden album names
            link_to_picasa: %link_to_picasa%, // true to display link to original album on Google Picasa
            thumbnail_width: %thumbnail_width%, // width of album and photo thumbnails
            title: '%title%', // title shown above album list
            inline: %inline%, // true to display photos inline instead of using the fancybox plugin
            auto_open: %auto_open%, // true to automatically open first image in fancybox after user clicks an album
    } );
} );</script>
EOM;

        $html = str_replace("%username%", $this->config['username'], $html);

        $str_hide_albums = "['";
        $str_hide_albums .= implode("','", $this->config['hide_albums']);
        $str_hide_albums .= "']";

        $html = str_replace("%hide_albums%", $str_hide_albums, $html);
        $html = str_replace("%link_to_picasa%", $this->config['link_to_picasa'], $html);
        $html = str_replace("%thumbnail_width%", $this->config['thumbnail_width'], $html);
        $html = str_replace("%title%", $this->config['title'], $html);
        $html = str_replace("%inline%", $this->config['inline'], $html);
        $html = str_replace("%auto_open%", $this->config['auto_open'], $html);

        return new \Twig_Markup($html, 'UTF-8');
    }
}


