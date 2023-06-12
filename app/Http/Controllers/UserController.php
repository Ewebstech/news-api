<?php

namespace App\Http\Controllers;

use Exception;
use App\Model\User;
use App\Model\Article;
use Illuminate\Http\Request;
use App\Model\UserPreference;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function savePreferences(Request $request) {
        try {
            $fields = $request->validate([
                'sources' => 'array',
                'authors' => 'array',
                'categories' => 'array',
            ]);

            $userId = auth()->user()->id;
            $data = UserPreference::updateOrCreate(['user_id' => $userId], 
            [
                'sources' => implode(",", $fields['sources']),
                'authors' => implode(",", $fields['authors']),
                'categories' => implode(",", $fields['categories']),
                'user_id' => $userId
            ]);

            if($data){
                return $this->okResponse('Preferences saved successfully', $data);
            } else {
                return $this->clientErrorResponse('Failed to save preferences');
            }

        } catch(Exception $e) {
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        }
    }

    public function getPreferences(Request $request){
        try{
            $data = UserPreference::where('user_id', auth()->user()->id)->first()->toArray();
            $data['sources'] = explode(',', $data['sources']);
            $data['authors'] = explode(',', $data['authors']);
            $data['categories'] = explode(',', $data['categories']);

            return $this->okResponse('Preferences fetched successfully', $data);

        } catch(Exception $e){
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        }
    }
}