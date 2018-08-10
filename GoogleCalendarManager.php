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

    private static $instance = null;
    private $client = null;
    private $searchParams = [];
    private $calendarId = null;

    private function __construct()
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
        echo "Caught Exception: credentials.json is missing, please enable Google Calendar API and create one <a href='https://developers.google.com/calendar/quickstart/php'>here</a>.<br>";
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

    private function isJson($string) {
     json_decode($string);
     return (json_last_error() == JSON_ERROR_NONE);
    }

    public function obtainAuthUrl()
    {
      $authUrl = $this->client->createAuthUrl();
      return $authUrl;
    }

    public function obtainAccessToken($authCode)
    {
      $access_token = $this->client->fetchAccessTokenWithAuthCode($authCode);
      return $access_token;
    }

    public function setAccessToken($accessToken)
    {
      try{
        $this->client->setAccessToken($accessToken);
        return Array(
          'status' => 'OK',
          'status_description' => 'Set access token succeed',
          'access_token_set' => $accessToken
        );
      } catch (Google_Service_Exception $e) {
        return Array(
          'error' => 'bad_request',
          'error_description' => json_decode($e->getMessage())->error->message
        );
      } catch (Exception $e) {
        return Array(
          'error' => 'invalid_argument',
          'error_description' => $e->getMessage()
        );
      }
    }

    public function setSearchParams($searchParams)
    {
      $this->searchParams = $searchParams;
      return Array(
        'status' => 'OK',
        'status_description' => 'Set search params succeed',
        'search_params_set' => $searchParams
      );
    }

    public function setCalendarId($calendarId)
    {
      $this->calendarId = $calendarId;
      return Array(
        'status' => 'OK',
        'status_description' => 'Set calendar id succeed',
        'calendar_id_set' => $calendarId
      );
    }

    public function retrieveCalendar()
    {
      try {
        $service = new Google_Service_Calendar($this->client);
        $results = $service->events->listEvents($this->calendarId, $this->searchParams);
        $events = $results->getItems();
        return $events;
      } catch (Google_Service_Exception $e) {
        $error_desc = $e->getMessage();
        if(isset(json_decode($error_desc)->error_description))
        {
          $error_desc = json_decode($error_desc)->error_description;
        }
        else if ($this->isJson($e->getMessage()))
        {
          $error_desc = json_decode($e->getMessage())->error->message;
        }
        else
        {
          $error_desc = $e->getMessage();
        }
        return Array(
          'error' => 'invalid_grant',
          'error_description' => $error_desc
        );
      } catch (Exception $e) {
        return Array(
          'error' => 'invalid_argument',
          'error_description' => $e->getMessage()
        );
      }
    }

    public function addCalendarEvent($event_details)
    {
      try {
        $service = new Google_Service_Calendar($this->client);
        $event = new Google_Service_Calendar_Event($event_details);
        $event = $service->events->insert($this->calendarId, $event);
        return $event['id'];
      } catch (Google_Service_Exception $e) {
        $error_desc = $e->getMessage();
        if(isset(json_decode($error_desc)->error_description))
        {
          $error_desc = json_decode($error_desc)->error_description;
        }
        else if ($this->isJson($e->getMessage()))
        {
          $error_desc = json_decode($e->getMessage())->error->message;
        }
        else
        {
          $error_desc = $e->getMessage();
        }
        return Array(
          'error' => 'invalid_grant',
          'error_description' => $error_desc
        );
      } catch (Exception $e) {
        return Array(
          'error' => 'invalid_argument',
          'error_description' => $e->getMessage()
        );
      }
    }

  }
?>
