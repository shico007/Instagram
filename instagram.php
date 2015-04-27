<?php

class Instagram {
    public $url;
    public $urls = array();

    public function __construct($anchor) {
        $this->url = 'https://instagram.com/p/'.$anchor;
        $this->fetchUrls();
    }

    public function fetchUrls() {
        $html = file_get_contents($this->url) or die();
        if ($html === false) die();
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $tags = $doc->getElementsByTagName('meta');

        $tagx = array();

        $i = 0;
        foreach ($tags as $tag) {
            foreach ($tag->attributes as $attr) {
                $i++;
                $image_condition = strcmp(strtolower($attr->value), "og:image");
                //$video_condition = strcmp(strtolower($attr->value), "og:video");
                $video_condition = strcmp(strtolower($attr->value), "og:video:secure_url");

                if ($image_condition === 0) {
                    array_push($tagx, $tag);
                    continue;
                }

                if ($video_condition === 0) {
                    array_push($tagx, $tag);
                    break;
                }

            }
        }

        foreach ($tagx as $tag) {
            foreach ($tag->attributes as $attr) {
                if (strlen($attr->value) > 50)
                    array_push($this->urls, $attr->value);
            }
        }

    }


}

?>