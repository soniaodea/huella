<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GithubWebhoockController extends Controller
{
    public function __construct()
    {
        $this->secret = env('GITHUB_SECRET', '');
    }

    public function pull(Request $request)
    {
        if (!$this->validCall()) {
            header($_SERVER['SERVER_PROTOCOL'].' 403 Not Allowed');
            die();
        }

        shell_exec('git pull');
    }

    private function validCall()
    {
        return !empty($this->secret) && $this->verifySignature(file_get_contents('php://input'));
    }

    private function verifySignature($body)
    {
        $githubSha1 = $_SERVER['HTTP_'.str_replace('-', '_', strtoupper('X-Hub-Signature'))];
        $signature = 'sha1='.hash_hmac('sha1', $body, $this->secret);

        return hash_equals($signature, $githubSha1);
    }
}
