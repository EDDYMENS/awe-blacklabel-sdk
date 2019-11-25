<?php

namespace Awe\Blacklabel;

class SDK
{
    private $applicationSecret;
    private $clientIP;
    private $userAgent;
    private $whiteLabel;
    private $language;
    private $sessionId;
    private $debug;

    public function __construct($config)
    {
        if (!isset($config['applicationSecret'], $config['userAgent'], $config['clientIP'], $config['whiteLabelURL'])) {
            throw new \exception('Please be sure to set the 
          `applicationSecret`, `userAgent`, `clientIP`,
           `whiteLabelURL`
         ');
        }
        $this->applicationSecret = $config['applicationSecret'];
        $this->clientIP = $config['clientIP'];
        $this->userAgent = $config['userAgent'];
        $this->whiteLabelURL = $config['whiteLabelURL'];
        $this->language = $config['language'] ? $config['language'] : 'en';
    }

    /**
     * Get list of performers.
     *
     * @param array $params
     *
     * @return array
     */
    public function getPerformers($params)
    {
        return $this->requestProcessor('performers', 'GET', $params);
    }

    /**
     * Performer list pagination.
     *
     * @param string $listPageId
     *
     * @return array
     */
    public function getMorePerformers($listPageId)
    {
        return $this->requestProcessor('show-more', 'GET', ['listPageId' => $listPageId]);
    }

    /**
     * Get details of specific performer.
     *
     * @param string $name
     *
     * @return array
     */
    public function getPerformerDetailsByName($name)
    {
        return $this->requestProcessor('performers/'.$name, 'GET', []);
    }

    /**
     * Performer list pagination.
     *
     * @param string $name
     * @param array  $params
     *
     * @return array
     */
    public function getPerformerAlbum($name, $params)
    {
        return $this->requestProcessor('performers/'.$name.'/albums', 'GET', $params);
    }

    /**
     * Get videos of performer.
     *
     * @param string $name
     * @param string $privacyType
     *
     * @return array
     */
    public function getPerformerVideos($name, $privacyType)
    {
        return $this->requestProcessor('performers/'.$name.'/videos', 'GET', ['privacy' => $privacyType]);
    }

    /**
     * Performer list pagination.
     *
     * @param string $performerName
     * @param string $albumID
     *
     * @return array
     */
    public function getAlbumItem($performerName, $albumID)
    {
        return $this->requestProcessor('performers/'.$performerName.'/albums/'.$albumID.'/items', 'GET', []);
    }

    /**
     * Search for performers.
     *
     * @param string            $category
     * @param string (optional) $searchText
     *
     * @return array
     */
    public function generalSearch($category, $searchText = '')
    {
        return $this->requestProcessor('auto-suggest', 'GET', ['category' => $category, 'searchText' => $category]);
    }

    /**
     * Purchase exclusive performer albums.
     *
     * @param string $performerNick
     * @param string $albumID
     *
     * @return array
     */
    public function purchaseAlbum($performerNick, $albumID)
    {
        return $this->requestProcessor('purchases/video', 'POST', ['performerNick' => $performerNick, 'id' => $albumID]);
    }

    /**
     * Get the entire filter list for sorting performers.
     *
     * @return array
     */
    public function getFilterList()
    {
        return $this->requestProcessor('filters', 'GET');
    }

    /**
     * Refresh an expired user session ID.
     *
     * @param string $session
     *
     * @return array
     */
    public function refreshSession($session)
    {
        return $this->requestProcessor('keep-alive', 'GET', [], $session);
    }

    /**
     * Get recommended performers based on a performer.
     *
     * @param string            $category
     * @param string (optional) $performerName
     * @param string (optional) $itemCount
     *
     * @return array
     */
    public function getPerformerRecommendations($category, $performerName = '', $itemCount = 4)
    {
        return $this->requestProcessor('recommendations', 'GET', ['category' => $category, 'performerNick' => $performerName, 'itemCount' => $itemCount]);
    }

    /**
     * Login user.
     *
     * @param array $payload
     *
     * @return array
     */
    public function authenticateUser($payload)
    {
        return $this->requestProcessor('users', 'POST', $payload);
    }

    /**
     * update user.
     *
     * @param array $payload
     *
     * @return array
     */
    public function updateUser($payload)
    {
        $partnerUserId = $payload['partnerUserId'];

        return $this->requestProcessor('users/'.$partnerUserId, 'PATCH', $payload);
    }

    public function getLanguages()
    {
        return $this->requestProcessor('languages', 'GET');
    }

    /**
     * Get chatScript.
     *
<<<<<<< HEAD
     * @param  string  $performerName
     * @param  string  $containerId
     * @param  string  (optional) $primaryButtonBg
     * @param  string  (optional) $primaryButtonColor
     * @param  string  (optional) $inputBg
     * @param  string  (optional) $inputColor
=======
     * @param string             $performerName
     * @param string             $containerId
     * @param string  (optional) $primaryButtonBg
     * @param string  (optional) $primaryButtonColor
     * @param string (optional)  $inputBg
     * @param string (optional)  $inputColor
     *
>>>>>>> 477bb0eaf51d6f570c7dfef79b5776f29c526465
     * @return array
     */
    public function getChatScript($performerName, $containerId, $primaryButtonBg = null, $primaryButtonColor = null, $inputBg = null, $inputColor = null)
    {
        $params = ['performerNick' => $performerName, 'containerId' => $containerId, 'session' => $sessionId,

        ];

        return $this->requestProcessor('scripts/chat', 'GET', $params);
    }

    /**
     * Set user session.
     *
     * @param string $session
     *
     * @return array
     */
    public function setSession($session)
    {
        return $this->sessionId = $session;
    }

    /**
     * Set language.
     *
     * @param string $lang
     *
     * @return array
     */
    public function setLanguage($lang)
    {
        $this->language = $lang;

        return $this;
    }

    private function requestProcessor($urlPartial, $method, $params = [], $sessionId = null)
    {
        $finalSessionId = ($sessionId) ? $sessionId : $this->sessionId;
        $curl = curl_init();

        $queryParams = '';
        if ('GET' == strtoupper($method)) {
            $queryParams = http_build_query($params);
        }
        $headers = ["X-Application-Secret: $this->applicationSecret", "X-Client-Ip: $this->clientIP", "X-User-Agent: $this->userAgent"];
        $userType = 'g';
        if ($finalSessionId) {
            $headers[] = 'X-Session-Id: '.$finalSessionId;
            $userType = substr($finalSessionId, 0, 1);
        }
        $memberRoute = ($userType == 'm') ? '/member' : '';
        $lang = $this->language;
        $URL = "$this->whiteLabelURL/$lang$memberRoute/api/v1/$urlPartial?".$queryParams;
        curl_setopt_array($curl, [CURLOPT_URL => $URL, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => '', CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_POSTFIELDS => json_encode($params), CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => strtoupper($method), CURLOPT_HTTPHEADER => $headers, CURLOPT_HEADER => 1]);
        $response = curl_exec($curl);
        list($headers, $payload) = explode("\r\n\r\n", $response, 2);
        $err = curl_error($curl);

        if ($err) {
            throw new \Exception('Unable to perform CURL request '.$err);
        } else {
            $sessionId = explode(': ', explode("\r\n", $headers)[6])[1];
            $responseObj = json_decode($payload, true);
            $responseObj['sessionId'] = $sessionId;

            return $responseObj;
        }
        curl_close($curl);
    }
}
