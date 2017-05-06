<?php

namespace App\Controller;

use Ramsey\Uuid\Uuid;

class Chapter8Controller extends Chapter
{
    private $uploadDirectory = '';
    private $uploadUrl = 'asset/upl';
    private $apiUploadUrl = 'chapter8/file';

    protected function init()
    {
        $this->uploadDirectory = "{$this->config->root}/asset/upl";
        @mkdir($this->uploadDirectory);
    }

    protected function code56()// Virtual path mapping
    {
        $this->getCode(__FILE__, 'code56');
        $directFiles = [];
        $apiFiles = [];
        $di = new \DirectoryIterator($this->uploadDirectory);
        foreach ($di as $item) {
            if ($item->isDot()) continue;
            if ($item->isDir()) continue;
            $fileName = $item->getFilename();
            $directFiles[] = [$fileName, "{$this->uploadUrl}/{$fileName}"];
            $apiFiles[] = $item->getBasename('.jpg');
        }
        $this->view->set('directFiles', $directFiles);
        $this->view->set('apiFiles', $apiFiles);
        $this->view->set('result', $this->view->render('sample/code56'));
    }

    function uploadAction()
    {
        //<code56>
        $image = $this->request->file('image');
        $imagePath = "{$this->uploadDirectory}/{$image['name']}";
        $url = false;
        if ($image) {
            if ($image['error']) {
                $this->response->json(['error' => $image['error']]);
            }
            $result = move_uploaded_file($image['tmp_name'], $imagePath);
            if ($result) {
                $url = "asset/upl/{$image['name']}";
            }
        }
        $this->response->json(['path' => $url]);
        //</code56>
    }

    function fileAction()
    {
//        $this->response->header('X-Content-Type-Options', 'nosniff');
//        $file = 'App/config/config.php';
//        $this->response->contentType('image/jpg');
        $path = pathinfo($this->request->server('REQUEST_URI'));
        if ($path['filename']) {
            $file = "{$this->uploadDirectory}/{$path['filename']}.jpg";
//            $mimeType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file);
//            $this->response->contentType($mimeType);
            if (file_exists($file)) {
//             todo: optimize
                $content = file_get_contents($file);
                $this->response->write($content);
//                $fh = fopen($file, 'rb');
//                while (($data = fread($fh, 1024))) {
//                    $this->response->write($data);
//                }
            }
        }
    }


    protected function code57()// Sanitizing file names
    {
        $this->getCode(__FILE__, 'code57');
        //<code57>
        if ($this->request->hasFile('image')) {
            $uid = Uuid::uuid4();
            $uplFile = $this->request->file('image');
            $path = pathinfo($uplFile['name']);
            $fileName = "{$uid->toString()}.{$path['extension']}";
            $file = "{$this->uploadDirectory}/{$fileName}";
            if (move_uploaded_file($uplFile['tmp_name'], $file)) {
                $this->view->set('file', "{$this->apiUploadUrl}/{$uid->toString()}");
            } else {
                $this->view->set('error', 'An error occurred while uploading file');
            }
        }
        //</code57>
        $this->view->set('result', $this->view->render('sample/code57'));
    }

    protected function code58()// File extension handling
    {
        $this->getCode(__FILE__, 'code58');
        //<code58>
        if ($this->request->hasFile('image')) {
            $uid = Uuid::uuid4();
            $uplFile = $this->request->file('image');
            $path = pathinfo($uplFile['name']);
            $fileName = "{$uid->toString()}.{$path['extension']}";
            $file = "{$this->uploadDirectory}/{$fileName}";
            $fileUrl = "{$this->uploadUrl}/{$fileName}";
            $type = $uplFile['type'];
//            $type = mime_content_type($uplFile['tmp_name']);
            if ($type == 'image/jpeg' /*&& $path['extension'] == 'jpg'*/) {
                move_uploaded_file($uplFile['tmp_name'], $file);
                $this->view->set('file', $fileUrl);
            } else {
                $this->view->set('error', 'An error occurred while trying to upload file');
            }
        }
        //</code58>
        $this->view->set('result', $this->view->render('sample/code58'));
    }

    protected function code59()// Directory listing
    {
        $this->getCode(__FILE__, 'code59');
        //<code59>
        //</code59>
        $this->view->set('result', $this->view->render('sample/code59'));
    }
}