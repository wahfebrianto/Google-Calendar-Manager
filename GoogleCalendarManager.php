<?php
  require __DIR__ . '/vendor/autoload.php';

  class GoogleCalendarManager {

    function __construct()
    {
      $this->client = new Google_Client();
      $this->client->setApplicationName('Google Calendar Manager');
      $this->client->setScopes(Google_Service_Calendar::CALENDAR);
      $this->client->setAuthConfig('credentials.json');
      $this->client->setAccessType('offline');
    }

    function obtainAuthUrl()
    {
      $authUrl = $this->client->createAuthUrl();
      return $authUrl;
    }

    function obtainAccessToken($authCode)
    {
      $access_token = $this->client->fetchAccessTokenWithAuthCode($authCode);
      return $access_token;
    }

    function setAccessToken($accessToken)
    {
      $this->client->setAccessToken($accessToken);
    }

    function setSearchParams($searchParams)
    {
      $this->searchParams = $searchParams;
    }

    function setCalendarId($calendarId)
    {
      $this->calendarId = $calendarId;
    }

    function retrieveCalendar()
    {
      $service = new Google_Service_Calendar($this->client);
      $results = $service->events->listEvents($this->calendarId, $this->searchParams);
      $events = $results->getItems();
      return $events;
    }

    function addCalendarEvent($event_details)
    {
      $service = new Google_Service_Calendar($this->client);
      $event = new Google_Service_Calendar_Event($event_details);
      $event = $service->events->insert($this->calendarId, $event);
      return $event['id'];
    }

  }
?>
