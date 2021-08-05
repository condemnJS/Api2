<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserList extends TodoModel
{
    protected $fillable = [
        'list_id',
        'user_id'
    ];

    public static function rules(): array
    {
        return [
            'user_id' => 'required',
            'list_id' => 'required'
        ];
    }
}
