<?php

namespace AppBundle\Service;

use Google_Service_Drive;

class EmailReportReceiver
{
    /** @var Google_Service_Drive */
    private $googleDriveService;

    /** @var string */
    private $fileId;

    /**
     * EmailReportReceiver constructor.
     * @param Google_Service_Drive $googleDriveService
     * @param string $fileId
     */
    public function __construct(Google_Service_Drive $googleDriveService, $fileId)
    {
        $this->googleDriveService = $googleDriveService;
        $this->fileId = $fileId;
    }

    public function receive()
    {
        $optParams = array(
            'pageSize' => 10,
            'fields' => 'nextPageToken, files(id, name)'
        );

        $response = $this->googleDriveService->files->export(
            $this->fileId,
            'text/csv',
            array(
                'alt' => 'media'
            ));
        $content = $response->getBody()->getContents();

        var_dump($content);
    }
}