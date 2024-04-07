<?php 

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/*
*   GPT Flow
*   1. Create a thread
*   2. Send a message to the thread
*   3. Run the GPT
*   4. Receive the response
*   ...
*/
class GptService
{
    private $urlBase='https://api.openai.com/';
    private $assistant='asst_qLAljZx3H8bqfv09g5DGvnSp';
    private $apiKey;
    private ?string $threadId;
    private $client;
    private ?string $lastMessage;

    public function __construct($api_key,HttpClientInterface $client)
    {
        $this->apiKey = $api_key;
        $this->client = $client;
    }

    public function simpleMessage($msg)
    {
        $url = $this->urlBase.'v1/chat/completions';
        $body = '{
                    "model": "gpt-4-1106-preview",
                    "messages": [
                      {
                        "role": "system",
                        "content": "faça contas simples"
                      },
                      {
                        "role": "user",
                        "content": "'.$msg.'"
                      }
                    ]
                }';
        $response = $this->client->request('POST', $url, [
            'body' => $body,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'OpenAI-Beta' => 'assistants=v1'
            ]
        ]);
        $data = $response->toArray();
        $return = $data['choices'][0]['message']['content'];
        if(isset($return)){
            $return = strstr($return, '<');
            return $return;
        } else {
            dd($data);
            return '';
        }
    }

    //TO DO: THE FUNCTIONS AFTER HERE ARE NOT WORKING

    public function createThread($metadata=[])
    {
      $url = $this->urlBase.'v1/threads';
      $body = '{"metadata": '.json_encode($metadata).'}';
      $response = $this->client->request('POST', $url, [
        'body' => $body,
        'headers' => [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'OpenAI-Beta' => 'assistants=v1'
        ]
      ]);
      $data = $response->toArray();
      dd($data);
    }

    public function threadMessage($msg)
    {
      $url = $this->urlBase.'v1/threads/'.$this->threadId.'/messages';
      $body = '{ "role": "user", "content": "'.$msg.'" }';
      
      $response = $this->client->request('POST', $url, [
        'body' => $body,
        'headers' => [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'OpenAI-Beta' => 'assistants=v1'
        ]
      ]);
      $data = $response->toArray();
      dd($data);
    }

    public function run()
    {
        $url = $this->urlBase.'v1/threads/'.$this->threadId.'/runs';
        $body = '{ "assistant_id": "'.$this->assistant.'" }';
        $response = $this->client->request('POST', $url, [
            'body' => $body,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'OpenAI-Beta' => 'assistants=v1'
            ]
        ]);
        $data = $response->toArray();
        dd($data);
    }

    public function getReply()
    {
        $url = $this->urlBase.'v1/threads/'.$this->threadId.'/messages?before='.$this->lastMessage.'&limit=10';
        $response = $this->client->request('GET', $url);
        $data = $response->toArray();
        dd($data);
    }
}