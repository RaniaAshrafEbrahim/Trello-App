<?php
namespace App\Helper;

use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Void_;

trait Trello
{

    public function __construct()
    {
        parent::__construct($this);
        $this->variables=[
            'key' => '74354e92f041d4d7ae61c6b6dcce7cde',
            'token' =>'b4a7af9071d61298a2e08c49148a77d836663cf2c716febb6d2f275a92b97e33'
        ];
    }
    public function getUser()
    {
        $url= $this->URL('members/me');
        return $this->httpRequest('get',$url,[]);
    }

       public function getBoards($id)
       {
         $url= $this->URL('members',$id,'boards');
               return $this->httpRequest('get',$url);
       }
    public function getCards($board_id)
    {
        $url= $this->URL('boards',$board_id,'cards','closed');

            return $this->httpRequest('get',$url);
    }
    public function deleteCard($card_id)
    {
        $url = $this->URL('cards',$card_id);

        return $this->httpRequest('delete',$url);

    }
    public function deleteArchiveCards()
    {
        $userId=$this->getUser()['id'];
        $boards= $this->getBoards($userId);
        foreach ($boards as $board){
            $cards=$this->getCards($board['id']);
            if($cards){
                foreach ($cards as $card)
                {
                    $this->deleteCard($card['id']);
                }
            }

        }
    }

    protected function URL($key,$id=null,$relatedData=null,$filter=null)
    {
        return "https://api.trello.com/1/".implode('/',array_filter([$key,$id,$relatedData,$filter]));

    }
    protected function httpRequest($method,$url,$data=[],$type = null)
    {

       $data=array_merge($this->variables,$data);

       $response=Http::$method($url,$data)->throw();

       if($type=="object"){

           $response->object();
       }
    return $response->json();


    }
}
