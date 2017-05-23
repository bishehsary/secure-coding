<?php


namespace App\Controller;


use FW\App\Controller;
use FW\Util\Util;
use GuzzleHttp\Client;

class GitHubController extends Controller
{

    function indexAction()
    {
        $state = $this->request->get('state');
        $gitHub = $this->config->gitHub;
        if ($state == $gitHub['state']) {
            $code = $this->request->get('code');
            $client = new Client();
            $res = $client->request('POST', 'https://github.com/login/oauth/access_token', [
                'body' => "client_id={$gitHub['client']}&client_secret={$gitHub['secret']}&code={$code}&redirect_uri={$gitHub['redirect']}&state=${gitHub['state']}",
                'headers' => ['Accept' => 'application/json']
            ]);
            $data = json_decode($res->getBody()->getContents(), true);
            $this->session->set('gitHubToken', $data['access_token']);
            $this->response->redirect(Util::genUrl('chapter2') . "&code=25");
        } else {
            $this->view->text('Key does not match');
        }
    }
}