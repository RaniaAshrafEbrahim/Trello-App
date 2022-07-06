<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TrelloController extends Controller
{
    const baseURL='https://api.trello.com/1/';
    const userURL='members/me';

    public function getUser()
    {
        $response=Http::get(self::baseURL.self::userURL.'/?key=74354e92f041d4d7ae61c6b6dcce7cde&token=b4a7af9071d61298a2e08c49148a77d836663cf2c716febb6d2f275a92b97e33');
        return $response->object();
    }
    public function createBoarad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'key' => 'required|',
            'token' => 'required',
        ]);

        if ($validator->fails())
        {
            return $this->showOneFail(null,$validator->errors()->first(),false);
        }
        $response=Http::post(self::baseURL.'boards/?name='.$request->name.'&key='.$request->key.'&token='.$request->token);
        $board=json_decode($response);
        return $board;

    }
    public function getLists(Request $request,$id)
    {
        $response=Http::get(self::baseURL.'boards/'.$id.'/lists?key='.$request->key.'&token='.$request->token);
        return json_decode($response);
    }

}
