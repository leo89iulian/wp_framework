<?php 
class Img {

    public function get($type = "", $id = "", $size = "", $attr = array()) {
        if (is_array($id) && $id["id"]) {
            $id = $id["id"];
        }
        if (!$id) {
            $id = get_post_thumbnail_id(get_the_ID());
        }
        if (!$id) {
            $id = get_field('image', get_the_ID());
            $id = $id["id"];
        }
        if (!$id) {
            $id = get_field('placeholder', 'options');
        }
        if (!$id) {
            return;
        }
        if ($type == "html") {
            return wp_get_attachment_image($id, $size);
        } else if ($type == "url") {
            return reset(wp_get_attachment_image_src($id, $size));
        } else if ($type == "") {
            return wp_get_attachment_metadata($id);
        } else {
            $res = wp_get_attachment_metadata($id);
            return $res[$type];
        }
    }

    public function def($args) {
        list($id, $size, $attr) = $args;
        return $this->get("html", $id, $size, $attr);
    }

}