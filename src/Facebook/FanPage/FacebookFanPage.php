<?php

namespace FacebookFanPage;

use Carbon\Carbon;
use GuzzleHttp\Client;

class FacebookFanPage
{

    public $version;

    public $pageID;

    public $pageToken;

    public $utc;

    /**
     * __construct
     * 
     * @param [type] $options [description]
     */
    public function __construct($options)
    {
        $this->version = $options['version'];

        $this->pageID = $options['pageID'];

        $this->pageToken = $options['pageToken'];

        $this->utc = $options['utc'];
    }

    /**
     * 日期時間物件
     *
     * @param string $tz
     * @return object
     */
    private function nowDatetime($tz = 'Asia/Taipei')
    {
        return Carbon::now($tz);
    }

    /**
     * 日期時間字串轉日期時間物件
     *
     * @param string $datetime
     * @param string $tz
     * @return object
     */
    private function datetimeObject($datetime = '1970-01-01 00:00:00',$tz = 'Asia/Taipei')
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$datetime,$tz);
    }

    /**
     * 日期時間字串轉unix timestamp
     *
     * @param string $datetime
     * @return int
     */
    private function timeStamp($datetime = '1970-01-01 00:00:00')
    {
        return Carbon::parse($datetime)->getTimestamp();
    }

    /**
     * 排程發佈時間(起始)
     *
     * @return String
     */
    private function startScheduledPublishTime()
    {
        return $this->nowDatetime()->subHour($this->utc)->addMinute(10)->addSecond(30)->toDateTimeString();
    }

    /**
     * 排程發佈時間(結束)
     *
     * @return String
     */
    private function endScheduledPublishTime()
    {
        return $this->nowDatetime()->subHour($this->utc)->addMonth(6)->addSecond(30)->toDateTimeString();
    }

    /**
     * 排程發佈時間(預計)
     *
     * @param $publish_datetime
     * @return String
     */
    private function scheduledPublishTime($publish_datetime)
    {
        return $this->datetimeObject($publish_datetime)->subHour(8)->addSecond(30)->toDateTimeString();
    }

    /**
     * 是否在排程發佈時間範圍內
     * 介於發佈後 10 分鐘至 6 個月之間的 UNIX 時間戳記
     *
     * @param $publish_datetime
     * @return bool
     */
    private function inScheduledPublishTimeRange($publish_datetime)
    {
        $startTimestamp = $this->timeStamp($this->startScheduledPublishTime());

        $endTimestamp = $this->timeStamp($this->endScheduledPublishTime());

        $publishTimestamp = $this->timeStamp($publish_datetime);

        if($startTimestamp <= $publishTimestamp && $publishTimestamp <= $endTimestamp){
            return true;
        }

        return false;
    }

    /**
     * 發布貼文
     *
     * @param $message
     * @return String
     */
    public function publish($message)
    {
        $targetUrl = 'https://graph.facebook.com/'.$this->version.'/'.$this->pageID.'/feed';

        $formParams = [
            'access_token' => $this->pageToken,
            'message' => $message
        ];

        $response = $this->sendRequest('POST',$targetUrl,$formParams);

        return $response->getBody();
    }

    /**
     * 發佈排程貼文
     *
     * @param $message
     * @param null $scheduled_publish_datetime
     * @return bool|String
     */
    public function publishScheduled($message,$scheduled_publish_datetime = null)
    {
        $publish_datetime = $this->scheduledPublishTime($scheduled_publish_datetime);

        if(!$this->inScheduledPublishTimeRange($publish_datetime)){
            return response()->json(['error' => 'publish time invalid']);
        }

        $targetUrl = 'https://graph.facebook.com/'.$this->version.'/'.$this->pageID.'/feed';

        $formParams = [
            'access_token' => $this->pageToken,
            'message' => $message,
            'published' => false,
            'scheduled_publish_time' => $this->timeStamp($publish_datetime)
        ];

        $response = $this->sendRequest('POST',$targetUrl,$formParams);

        return $response->getBody();
    }

    /**
     * 刪除貼文
     *
     * @param string $postID
     * @return String
     */
    public function delete($postID = '')
    {
        $targetUrl = 'https://graph.facebook.com/'.$this->version.'/'.$postID;

        $formParams = [
            'access_token' => $this->pageToken
        ];

        $response = $this->sendRequest('DELETE',$targetUrl,$formParams);

        return $response->getBody();
    }

    /**
     * 發送請求
     *
     * @param $method
     * @param $uri
     * @param $formParams
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    private function sendRequest($method,$uri,$formParams)
    {
        $client = new Client();

        return $client->request($method,$uri,[
            'form_params' => $formParams,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }

}