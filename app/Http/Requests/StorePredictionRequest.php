<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StorePredictionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Implement logic for this
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Eventually add rules for only admin to create predictions for other users.

        // Deferring in favor of validation in observers for rapid development

//        $user_id = Request::get('user_id', null);
//        $game_id = Request::get('game_id', null);
//
//        // Replacement for validate win logic
//        $home_score = Request::get('home_score', null);
//        $away_score = Request::get('away_score', null);
//
//        $result = ['h', 'a', 'd'];
//
//        if ($home_score > $away_score) {
//            unset($result[1]);
//            unset($result[2]);
//        } else if ($home_score < $away_score) {
//            unset($result[0]);
//            unset($result[2]);
//        }
//
//        return [
//            // Composite unique key rule
//            'user_id => required | unique:predictions, user_id, NULL, id, game_id' . $game_id,
//            'game_id => required | unique:predictions, game_id, NULL, id, user_id' . $user_id,
//            'home_score => required',
//            'away_score => required',
//            'result' => [
//                'required',
//                Rule::in($result)
//            ],
//        ];
    }

}
