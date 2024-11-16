<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class getresponse_lib {
    protected $CI;
    protected $apiURL;
    protected $appKey;
    protected $creds;
    public function __construct($params = array()){
        $this->CI =& get_instance();
        $this->creds=$this->CI->config->item('getresponse');
        $this->appKey=$this->creds['key'];
        $this->apiURL='https://api.getresponse.com/v3';
    }

    public function createContact($contact, $campaign){
        $url=$this->apiURL."/contacts";
        $data=[
            'name'=> $contact['name'],
            'email'=> $contact['email'],
            'campaign'=>[
                'campaignId'=>$this->creds[$campaign]
            ]
        ];
        $payload=json_encode($data);

        $headers=[
            "X-Auth-Token: api-key ".$this->appKey,
            "Content-Type: application/json"
        ];
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $payload);
        $output = curl_exec($handle);
        $status = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        curl_close($handle);
        // var_dump($status);
        // var_dump($output);
        if($status==202){
            // Success
        }
    }

    public function getGRID($email, $campaign){
        $url=$this->apiURL."/contacts";
        $data=[
            'query[email]'=> $email,
            'query[campaignId]'=>$this->creds[$campaign]
        ];

        $headers=[
            "X-Auth-Token: api-key ".$this->appKey,
            "Content-Type: application/json"
        ];
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url."?".http_build_query($data));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($handle);
        $status = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        curl_close($handle);
        // var_dump($status);
        // var_dump($output);
        if($status==200){
            $contacts=json_decode($output);
            if(!empty($contacts)){
                return $contacts[0]->contactId;
            }            
        }
        return false;
    }

    public function send_newsletter($data){
        if(isset($data['fromName']) && isset($data['fromNameDefault'])){
            $fromID=$this->getFromField($data['from'], $data['fromName'], $data['fromNameDefault']);
        }else{
            $fromID=$this->getFromField($data['from']);
        }
        
        if(!$fromID){
            log_message('error', "GetResponse Email Failed: From ID not found => ".$data['subject']);
            return false;
        }
        $payload=[
            'subject'=>$data['subject'],
            'fromField'=>[
                'fromFieldId'=>$fromID
            ],
            'campaign'=>[
                'campaignId'=>$this->creds[$data['campaign']]
            ],
            'content'=>$data['content'],
            'flags'=>[
                'openrate',
                'clicktrack'
            ],
            'sendSettings'=>[
                'selectedContacts'=>$data['contacts']
            ]
        ];
        // var_dump($payload);exit;
        if(isset($data['attachments'])){
            $payload['attachments']=$data['attachments'];
        }
        $url=$this->apiURL."/newsletters";
        $payload=json_encode($payload);
        $headers=[
            "X-Auth-Token: api-key ".$this->appKey,
            "Content-Type: application/json"
        ];
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $payload);
        $output = curl_exec($handle);
        $status = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        curl_close($handle);
        // var_dump($status);
        // var_dump($output);
        if($status==201){
            return true;
        }else{            
            log_message('error', "GetResponse Email Failed | Status: ".$status." | Subject: ".$data['subject']);
        }
        return false;
    }

    private function getFromField($email, $name=null, $name_default=null){
        $url=$this->apiURL."/from-fields";
        $data=[
            'query[email]'=> $email
        ];
        if($name!=null){
            $data['query[name]']=$name;
        }

        $headers=[
            "X-Auth-Token: api-key ".$this->appKey,
            "Content-Type: application/json"
        ];
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url."?".http_build_query($data));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($handle);
        $status = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        curl_close($handle);
        // var_dump($status);
        // var_dump($output);
        if($status==200){
            $fromFields=json_decode($output);
            // var_dump($fromFields);
            if(!empty($fromFields)){
                return $fromFields[0]->fromFieldId;
            }else{
                if($name!=null && $name_default!=null){
                    return $this->getFromField($email, $name_default);
                }
            }
        }
        return false;
    }

    

}