<?php

/*
 * This file is part of the PiFact package.
 *
 * (c) Programari Enginyeria Informàtica SL
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Programari\SyliusPifactPlugin\Entity;

class PiFactResponse
{
    public $status;
    public $message;
    public $number;
    public $pdfUrl;


    public function fromArray(array $data)
    {
        $this->status = $data['status'];
        $this->message = $data['message'];
        $this->number = $data['number']??'';
        //$this->issuedAt = new \DateTime($data['issuedAt']??null);
        $this->pdfUrl = $data['pdfUrl']??'';
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getPdfUrl()
    {
        return $this->pdfUrl;
    }

    /**
     * @param mixed $pdfUrl
     */
    public function setPdfUrl($pdfUrl): void
    {
        $this->pdfUrl = $pdfUrl;
    }


}
