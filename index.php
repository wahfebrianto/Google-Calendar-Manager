<?php
  require __DIR__ . '/GoogleCalendarManager.php';

  $gcmInstance = new GoogleCalendarManager();

  /* Program segment to test the Auth Url function (Task 1)

  // $authUrl = $gcmInstance->obtainAuthUrl();
  // echo $authUrl;
  // echo "<br>";

  End of program segment */


  /* Program segment to test the Access Token function (Task 1)

  // $accessToken = $gcmInstance->obtainAccessToken('4/NgAYJ9tTDVo-D8_p4wYHfj_0yGVu4Bhi5F0hPAPOyOkaFKrTSiPQHHo');
  // print_r($accessToken);

  End of program segment */

  //============================================================================================//

  /* Program segment to test the Retrieve Events function (Task 2)

  // $gcmInstance->setAccessToken(array(
  //   'access_token' => 'ya29.Glv0BfZTxnAYNqwUBdvvYOx4eOKVR6wn2joGfW-Uwbb2ZankFgfLgY5tEkKGoirwmzLLqSsdp-A6GK6HPBO6zffiyA6vlALgFIwr2En2Sy8kuGvv9yygNiYq1_75',
  //   'token_type' => 'Bearer',
  //   'expires_in' => 3600,
  //   'refresh_token' => '1/nxXoP-PSAoNFMroEHY8A8Bmmy25k1p2dLckjwixzbQY',
  //   'scope' => 'https://www.googleapis.com/auth/calendar',
  //   'created' => '1533822448'
  // ));
  //
  // $gcmInstance->setSearchParams(array(
  //   'maxResults' => 2,
  //   'orderBy' => 'startTime',
  //   'singleEvents' => true,
  //   'timeMin' => date('c')
  // ));
  //
  // $gcmInstance->setCalendarId('primary');

  // $events = $gcmInstance->retrieveCalendar();
  //
  // echo "<pre>";
  // print_r($events);
  // echo "</pre>";

  End of program segment */

//============================================================================================//

  /* Program segment to test the Add Calendar Event function (Task 3)

  // $gcmInstance->setAccessToken(array(
  //   'access_token' => 'ya29.Glv0BfZTxnAYNqwUBdvvYOx4eOKVR6wn2joGfW-Uwbb2ZankFgfLgY5tEkKGoirwmzLLqSsdp-A6GK6HPBO6zffiyA6vlALgFIwr2En2Sy8kuGvv9yygNiYq1_75',
  //   'token_type' => 'Bearer',
  //   'expires_in' => 3600,
  //   'refresh_token' => '1/nxXoP-PSAoNFMroEHY8A8Bmmy25k1p2dLckjwixzbQY',
  //   'scope' => 'https://www.googleapis.com/auth/calendar',
  //   'created' => '1533822448'
  // ));
  //
  // $gcmInstance->setCalendarId('primary');
  //
  // $event_details = array(
  //   'summary' => 'Google I/O 2018',
  //   'location' => '800 Howard St., San Francisco, CA 94103',
  //   'description' => 'A chance to hear more about Google\'s developer products.',
  //   'start' => array(
  //     'dateTime' => '2018-08-11T09:00:00-07:00',
  //     'timeZone' => 'America/Los_Angeles',
  //   ),
  //   'end' => array(
  //     'dateTime' => '2018-08-12T17:00:00-07:00',
  //     'timeZone' => 'America/Los_Angeles',
  //   ),
  //   'recurrence' => array(
  //     'RRULE:FREQ=DAILY;COUNT=2'
  //   ),
  //   'attendees' => array(
  //     array('email' => 'lpage@example.com'),
  //     array('email' => 'sbrin@example.com'),
  //   ),
  //   'reminders' => array(
  //     'useDefault' => FALSE,
  //     'overrides' => array(
  //       array('method' => 'email', 'minutes' => 24 * 60),
  //       array('method' => 'popup', 'minutes' => 10),
  //     ),
  //   ),
  // );

  // $events = $gcmInstance->addCalendarEvent($event_details);
  // echo "<pre>";
  // print_r($events);
  // echo "</pre>";

  End of program segment */
?>
