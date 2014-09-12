<?php
class api {

    public function facebook($type = "", $data = array(), $return_all = 0, $cache = "+24 hours") {
        $k = array("api", "facebook", $type, $data);
        if (!$r = vc::cache($k, $cache)) {
            if ($type == "nr_likes") {
                if (!$data["link"]) {
                    $data["link"] = get_permalink();
                }
                $r = vc::get_url("http://graph.facebook.com/?id=" . urlencode($data["link"]));
                vc::cache($k, "", $r);
                if (!$return_all) {
                    $r = (int) $r["shares"];
                }
            }
        }
        return $r;
    }

    public function youtube($type = "", $data = array(), $return_all = 0, $cache = "+24 hours") {
        $k = array("api", "youtube", $type, $data);
        if (!$r = vc::cache($k, $cache)) {
            if ($type == "subscribers") {
                if (!$data["user"]) {
                    return;
                }
                $r = vc::get_url("https://gdata.youtube.com/feeds/api/users/" . $data["user"] . "?v=2&alt=json");
                $r = (array) $r->entry;
                vc::cache($k, "", $r);
                if (!$return_all) {
                    $r = $r['yt$statistics']->subscriberCount;
                }
            }
        }
        return $r;
    }

}
