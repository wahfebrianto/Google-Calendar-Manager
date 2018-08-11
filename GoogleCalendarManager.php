<?php
  require __DIR__ . '/vendor/autoload.php';

  interface GoogleCalendarManagerInterface
  {
    public static function getInstance();
    public function obtainAuthUrl();
    public function obtainAccessToken($authCode);
    public function setAccessToken($accessToken);
    public function setSearchParams($searchParams);
    public function setCalendarId($calendarId);
    public function retrieveCalendar();
    public function addCalendarEvent($event_details);
  }

  class GoogleCalendarManager implements GoogleCalendarManagerInterface {

    protected static $instance = null;
    protected $client = null;
    protected $searchParams = [];
    protected $calendarId = null;

    protected function __construct()
    {
      try
      {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Google Calendar Manager');
        $this->client->setScopes(Google_Service_Calendar::CALENDAR);
        $this->client->setAuthConfig('credentials.json');
        $this->client->setAccessType('offline');
      }
      catch (Exception $e)
      {
        throw $e;
      }
    }

    public static function getInstance()
    {
      if (self::$instance === null)
      {
        self::$instance = new Self();
      }

      return self::$instance;
    }

    public function obtainAuthUrl()
    {
      if (!isset($this->client))
      {
        throw new Exception("Client hasn't initiated");
      }
      try
      {
        $authUrl = $this->client->createAuthUrl();
      }
      catch (Exception $e)
      {
        throw $e;
      }
      return $authUrl;
    }

    public function obtainAccessToken($authCode)
    {
      if (!isset($this->client))
      {
        throw new Exception("Client hasn't initiated");
      }
      try
      {
        $access_token = $this->client->fetchAccessTokenWithAuthCode($authCode);
      }
      catch (Exception $e)
      {
        throw $e;
      }
      if (array_key_exists('error_description', $access_token))
      {
        throw new Exception($access_token['error_description']);
      }
      return $access_token;
    }

    public function setAccessToken($accessToken)
    {
      if (!isset($this->client))
      {
        throw new Exception("Client hasn't initiated");
      }
      if(!is_array($accessToken))
      {
        throw new Exception("accessToken must be an array with keys and values are the access token returned by API");
      }
      try
      {
        $this->client->setAccessToken($accessToken);
      }
      catch (Exception $e)
      {
        throw $e;
      }
    }

    public function setSearchParams($searchParams)
    {
      if(!is_array($searchParams))
      {
        throw new Exception("searchParams must be an array with keys and values are the API query parameters");
      }
      $this->searchParams = $searchParams;
    }

    public function setCalendarId($calendarId)
    {
      if(!is_string($calendarId))
      {
        throw new Exception("calendarId must be a string of calendar identifier or 'primary'");
      }
      $this->calendarId = $calendarId;
    }

    public function retrieveCalendar()
    {
      $events = [];
      if (!isset($this->client))
      {
        throw new Exception("Client hasn't initiated");
      }
      if(!isset($this->calendarId) || empty($this->calendarId))
      {
        throw new Exception("Please set the calendarId first");
      }
      try
      {
        $service = new Google_Service_Calendar($this->client);
        $results = $service->events->listEvents($this->calendarId, $this->searchParams);
        $events = $results->getItems();
      }
      catch (Exception $e)
      {
        throw $e;
      }
      return $events;
    }

    public function addCalendarEvent($event_details)
    {
      $event = [];
      if (!isset($this->client))
      {
        throw new Exception("Client hasn't initiated");
      }
      if(!isset($this->calendarId) || empty($this->calendarId))
      {
        throw new Exception("Please set the calendarId first");
      }
      if(!is_array($event_details))
      {
        throw new Exception("event_details must be an array with keys and values are the event properties");
      }
      if(!array_key_exists('start', $event_details))
      {
        throw new Exception("Missing 'start' property in event_details");
      }
      if(!array_key_exists('end', $event_details))
      {
        throw new Exception("Missing 'end' property in event_details");
      }
      try
      {
        $service = new Google_Service_Calendar($this->client);
        $event = new Google_Service_Calendar_Event($event_details);
        $event = $service->events->insert($this->calendarId, $event);
      }
      catch (Exception $e)
      {
        throw $e;
      }
      return $event['id'];
    }

  }
?>
