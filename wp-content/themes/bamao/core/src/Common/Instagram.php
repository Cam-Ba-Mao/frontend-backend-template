<?php
namespace BM\Core\Common;

class Instagram
{
    const API_URL = 'https://graph.instagram.com/';
    const CACHE_PATH = WP_CONTENT_DIR . '/uploads/rt-instagram/';
    const CACHE_HOURS = 5;
    const THUMB_SIZE = 'instagram_image';
    const LIMIT = 10;
    private $token;

    public function __construct($token)
    {
        $refreshAccessToken = $this->getRefreshAccessTokenCache();

        if ($refreshAccessToken && count($refreshAccessToken) > 0) {

            if (time() < $refreshAccessToken['expires_in']) {
                $this->token = $refreshAccessToken['access_token'];
            } else {
                $result = $this->callRefreshAccessToken($refreshAccessToken['access_token']);

                if (isset($result['access_token']) && $result['access_token']) {
                    $this->token = $result['access_token'];
                }
            }
        } else {
            $result = $this->callRefreshAccessToken($token);

            if ($result) {
                $this->token = $result['access_token'];
            }
        }
    }

    /**
     * Url parser
     *
     * @param $url
     * @param $params
     * @return string
     */
    private function urlParser($url, $params = array())
    {
        $params = array_merge($params, ['access_token' => $this->token]);
        return self::API_URL . $url . '?' . http_build_query($params);
    }

    /**
     * Get user id
     * @return bool|mixed
     */
    public function getMeId()
    {
        $cacheId = $this->getCacheMeId();
        if ($cacheId) {
            return $cacheId;
        }

        $url = $this->urlParser('me');

        $response = wp_remote_get($url);
        $result = !is_wp_error($response) && isset($response['body']) ? json_decode($response['body'], true) : [];

        if ($result['id']) {
            $this->writeCacheMeId($result['id']);
            return $result['id'];
        }

        return false;
    }

    /**
     * Get recent media
     *
     * @param int $userId
     * @return array|mixed
     *
     * media array
     *   (
     *       [id] => 18136275154034469
     *       [media_url] => https://...... use this if media type = IMAGE
     *       [thumbnail_url] => https://.... use this if media type = VIDEO
     *       [media_type] => IMAGE
     *       [permalink] => https://www.instagram.com/p/..../
     *       [timestamp] => 2020-04-07T10:07:17+0000
     *   )
     */
    public function getRecentMedia($userId = 0)
    {
        $userId = $userId ? $userId : $this->getMeId();

        $cacheMedia = $this->getCacheMedia($userId);
        if ($cacheMedia) {
            return $cacheMedia;
        }

        if ($userId) {
            $params = [
                'limit' => self::LIMIT,
                'fields' => 'id,media_url,media_type,permalink,thumbnail_url,timestamp,caption',
            ];
            $url = $this->urlParser($userId . '/media', $params);
            $response = wp_remote_get($url);
            $result = !is_wp_error($response) && isset($response['body']) ? json_decode($response['body'], true) : [];
            if (isset($result['data']) && !empty($result['data'])) {
                return $this->writeCacheMedia($result['data'], $userId);
            }
        }

        return [];
    }

    /**
     * Write Cache User Me
     * @param $id
     */
    private function writeCacheMeId($id)
    {
        $data = [
            'me' => $id,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $cacheFile = self::CACHE_PATH . 'me.json';

        if (!file_exists(dirname($cacheFile))) {
            mkdir(dirname($cacheFile), 0777, true);
        }

        file_put_contents($cacheFile, json_encode($data));
    }

    /**
     * Get me id
     * @return bool
     */
    private function getCacheMeId()
    {
        $cacheFile = self::CACHE_PATH . 'me.json';

        if (file_exists($cacheFile)) {
            $user = json_decode(file_get_contents($cacheFile), true);
            $expired = false;
            if (isset($user['updated_at'])) {
                if ((time() - strtotime($user['updated_at'])) / (3600) > self::CACHE_HOURS) {
                    $expired = true;
                }
            }

            return isset($user['me']) && !empty($user['me']) && !$expired ? $user['me'] : false;
        }
        return false;
    }

    /**
     * Write cache media
     *
     * @param $media
     * @param $userId
     * @return array
     */
    private function writeCacheMedia($media, $userId)
    {
        $mediaOutput = [];
        $mediaLocalFiles = [];
        $mediaFilePath = self::CACHE_PATH . 'media.json';

        if (file_exists($mediaFilePath)) {
            $mediaLocalFiles = json_decode(file_get_contents($mediaFilePath), true);
        }

        if (!empty($media)) {
            $existAttachIds = !empty($mediaLocalFiles) ? array_keys($mediaLocalFiles) : [];
            $break = false;
            foreach ($media as $v) {
                if (!$break) {
                    if (in_array($v['id'],
                            $existAttachIds) && isset($mediaLocalFiles[$v['id']]['local_url']) && !empty($mediaLocalFiles[$v['id']]['local_url'])) {
                        $v['local_url'] = $mediaLocalFiles[$v['id']]['local_url'];
                    } else {
                        $url = $v['media_type'] === 'VIDEO' ? $v['thumbnail_url'] : $v['media_url'];
                        $attachId = uploadFromURL($url);
                        if ($attachId) {
                            $attachUrl = wp_get_attachment_image_url($attachId, self::THUMB_SIZE);
                            if (!empty($attachUrl)) {
                                $v['local_url'] = $attachUrl;
                                $mediaLocalFiles[$v['id']] = [
                                    'local_url' => $attachUrl,
                                    'ins_url' => $url
                                ];
                                $break = true;
                            }
                        }
                    }
                }
                $mediaOutput[] = $v;
            }
        }

        if (!empty($mediaLocalFiles)) {
            file_put_contents($mediaFilePath, json_encode($mediaLocalFiles));
        }

        //save media from Instagram
        $data = [
            'id' => $userId,
            'media' => $mediaOutput,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $cacheFile = self::CACHE_PATH . $userId . '.json';
        if (!file_exists(dirname($cacheFile))) {
            mkdir(dirname($cacheFile), 0777, true);
        }

        file_put_contents($cacheFile, json_encode($data));

        return $mediaOutput;
    }

    /**
     * Get Cache Media
     * @param $userId
     * @return bool
     */
    private function getCacheMedia($userId)
    {
        $cacheFile = self::CACHE_PATH . $userId . '.json';
        if (file_exists($cacheFile)) {
            $content = json_decode(file_get_contents($cacheFile), true);
            $expired = false;
            if (isset($content['updated_at'])) {
                if ((time() - strtotime($content['updated_at'])) / (3600) > self::CACHE_HOURS) {
                    $expired = true;
                }
            }

            return isset($content['media']) && !empty($content['media']) && !$expired ? $content['media'] : false;
        }
        return false;
    }

    private function getRefreshAccessTokenCache()
    {
        $accessTokenFile = self::CACHE_PATH . '/refresh_access_token.json';

        if (file_exists($accessTokenFile)) {
            $content = json_decode(file_get_contents($accessTokenFile), true);

            return (array)$content;
        }

        return false;
    }

    private function callRefreshAccessToken($token)
    {
        $this->token = $token;

        $url = $this->urlParser('refresh_access_token', ['grant_type' => 'ig_refresh_token']);
        $response = wp_remote_get($url);
        $result = !is_wp_error($response) && isset($response['body']) ? json_decode($response['body'], true) : [];

        if (isset($result['access_token']) && $result['access_token']) {
            $this->writeRefreshAccessToken($result['access_token'], $result['expires_in']);

            return $result;
        }

        return false;
    }

    private function writeRefreshAccessToken($refresh_access_token, $expires_in)
    {
        $data = [
            'access_token' => $refresh_access_token,
            'expires_in' => (time() + $expires_in) - (24 * 3600) // Refresh access token before 1 day expire
        ];
        $file = self::CACHE_PATH . 'refresh_access_token.json';

        if (!file_exists(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }

        file_put_contents($file, json_encode($data));
    }

}