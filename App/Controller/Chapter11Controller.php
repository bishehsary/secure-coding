<?php

namespace App\Controller;

class Chapter11Controller extends Chapter
{
    protected function code69()// Structured exception handling – Try, Catch, Finally
    {
        $this->getCode(__FILE__, 'code69');
        $this->view->set('link', [
            ['error_reporting', 'http://php.net/manual/en/function.error-reporting.php'],
            ['Error Functions', 'http://php.net/manual/en/ref.errorfunc.php']
        ]);
        //<code69>
        $this->view->set('levels', [
            1 => ['E_ERROR', '	Fatal run-time errors'],
            2 => ['E_WARNING', 'Run-time warnings (non-fatal errors)'],
            8 => ['E_NOTICE', 'Run-time notices'],
            2048 => ['E_STRICT', 'Enable to have PHP suggest changes to your code (Since PHP 5 but not included in E_ALL until PHP 5.4.0)'],
            8192 => ['E_DEPRECATED', 'Run-time notices (Since PHP 5.3.0)'],
            32767 => ['E_ALL', 'All errors and warnings (except of level E_STRICT prior to PHP 5.4.0)']
        ]);
        //</code69>
        $this->view->set('result', $this->view->render('sample/code69'));
    }

    protected function code70()// Creating custom error pages
    {
        $this->getCode(__FILE__, 'code70');
        //<code70>
        //</code70>
        $this->view->set('result', $this->view->render('sample/code70'));
    }

    protected function code71()// HTTP error codes
    {
        $this->getCode(__FILE__, 'code71');
        $this->view->set('link', [
            ['HTTP Status Codes', 'https://en.wikipedia.org/wiki/List_of_HTTP_status_codes']
        ]);
        //<code71>
        $this->view->set('codes', [
            ['1xx', 'Informational Responses', [
                '100' => 'Continue',
                '101' => 'Switching Protocols',
                '102' => 'Processing'
            ]], ['2xx', 'Success', [
                '200' => 'OK',
                '201' => 'Created',
                '202' => 'Accepted',
                '204' => 'No Content'
            ]], ['3xx', 'Redirection', [
                '301' => 'Moved Permanently',
                '302' => 'Found',
                '304' => 'Not Modified',
                '307' => 'Temporary Redirect',
                '308' => 'Permanent Redirect',
            ]], ['4xx', 'Client Error', [
                '400' => 'Bad Request',
                '401' => 'Unauthorized',
                '402' => 'Payment Required',
                '403' => 'Forbidden',
                '404' => 'Not Found',
                '405' => ' Method Not Allowed'
            ]], ['5xx', 'Server Error', [
                '500' => 'Internal Server Error',
                '501' => 'Not Implemented',
                '502' => 'Bad Gateway',
                '505' => 'HTTP Version Not Supported'
            ]]
        ]);
        //</code71>
        $this->view->set('result', $this->view->render('sample/code71'));
    }

    protected function code72()// Error handling strategies
    {
        $this->getCode(__FILE__, 'code72');
        //<code72>
        //</code72>
        $this->view->set('result', $this->view->render('sample/code72'));
    }
}