<?
/**
 * get youtube video ID from URL
 *
 * @param string $url
 * @return string Youtube video id or FALSE if none found.
 */
function youtube_id_from_url($url) {
    $pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[7];
    }
    return false;
}