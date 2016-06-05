<?php
// Sursa: http://99webtools.com/blog/read-rssatom-feed-using-php/
include("../user/session.php");

$grupa= $_SESSION['grupa'];

error_reporting(E_ERROR);
include_once('../simplepie/autoloader.php');

$url="http://localhost/Prognosix/atom_feed/syndication.php";

$feed= new SimplePie();
$feed->set_feed_url($url);
$feed->set_output_encoding('Windows-1252');
$feed->enable_cache(false);
$feed->init();

$items=$feed->get_items();

foreach($items as $item)
{

    if ( $item->get_category())
        if( $item->get_category()->get_label()==$grupa ||$item->get_category()->get_label()=='ALL' ){
            $title=$item->get_title();

            $content= $item->get_content();

            echo"
                <div class='feed_item'>
                    <div class='feed_item_title'>".$title."</div>".

                    "<div class='feed_item_content'>".html_entity_decode($content)."</div>
                </div>";

        }

}?>

