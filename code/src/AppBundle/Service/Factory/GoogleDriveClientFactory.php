<?php

namespace AppBundle\Service\Factory;

use Google_Service_Drive;

class GoogleDriveClientFactory
{
    public function createReadOnly($credentialsFile)
    {
        return $this->create($credentialsFile, [Google_Service_Drive::DRIVE_READONLY]);
    }

    public function create($credentialsFile, $permissions)
    {
        $permisionsToken = md5(serialize($permissions));

        $client = new \Google_Client();
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setScopes($permissions);
        $client->setAuthConfig($credentialsFile);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $tokenPath = $permisionsToken .'_token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }
        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));
                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new \Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }
}