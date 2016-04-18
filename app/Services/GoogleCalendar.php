<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class GoogleCalendar {

    protected $client;

    protected $service;

    function __construct() {
        /* Get config variables */
        $client_id = Config::get('google.client_id');
        $service_account_name = Config::get('google.service_account_name');
        $key_file_location = base_path() . Config::get('google.key_file_location');

        $this->client = new \Google_Client();
        $this->client->setApplicationName("Your Application Name");
        $this->service = new \Google_Service_Calendar($this->client);

        /* If we have an access token */
        if (Cache::has('service_token')) {
          $this->client->setAccessToken(Cache::get('service_token'));
        }

        $key = file_get_contents($key_file_location);
        /* Add the scopes you need */
        $scopes = array('https://www.googleapis.com/auth/calendar');
        $cred = new \Google_Auth_AssertionCredentials(
            $service_account_name,
            $scopes,
            $key
        );

        $this->client->setAssertionCredentials($cred);
        if ($this->client->getAuth()->isAccessTokenExpired()) {
          $this->client->getAuth()->refreshTokenWithAssertion($cred);
        }
        Cache::forever('service_token', $this->client->getAccessToken());
    }

    public function addEvent($calendarId)
    {
      $event = new \Google_Service_Calendar_Event(array(
        'summary' => 'Google I/O 2015',
        'location' => 'A1E 1K9',
        'description' => 'Sample',
        'start' => array(
          'dateTime' => '2016-04-14T10:00:00-02:30',
          'timeZone' => 'Canada/Newfoundland',
        ),
        'end' => array(
          'dateTime' => '2016-04-14T11:00:00-02:30',
          'timeZone' => 'Canada/Newfoundland',
        ),
      ));
      $event = $this->service->events->insert($calendarId, $event);
      dd($event);
    }

    public function getEvents($calendarId)
    {
      $events = $this->service->events->listEvents($calendarId);
      foreach($events as $event) {
        echo "Description: " . $event->description . '<br />';
        echo "Start: " . $event->start->dateTime . '<br />';
      }
      dd('done');
    }

    public function get($calendarId)
    {
        $results = $this->service->calendars->get($calendarId);
        dd($results);
    }
}
