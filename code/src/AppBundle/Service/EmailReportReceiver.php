<?php

namespace AppBundle\Service;

use Google_Service_Drive;
use ArrayIterator;

class EmailReportReceiver
{
    const END_TAG = '</html>';

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
        $response = $this->googleDriveService->files->export(
            $this->fileId,
            'text/csv',
            array(
                'alt' => 'media'
            ));
        $content = $response->getBody()->getContents();
        $result = new ArrayIterator();

        while ($content) {
            $endPos = strpos($content, self::END_TAG) + strlen(self::END_TAG);
            $email = substr($content, 0, $endPos);
            $email = str_replace('""', '"', $email);
            strlen($email) > 10 && $result->append($email);
            $content = substr($content, $endPos);
        }

        return $result;
    }
}