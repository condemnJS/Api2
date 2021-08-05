<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends TodoModel
{
    protected $fillable = [
        'id',
        'name',
        'list_id',
        'executor_user_id',
        'is_completed',
        'description',
        'urgency'
    ];

    public static function rules(): array
    {
        return [
            'name' => 'required',
            'list_id' => 'required',
            'is_completed' => 'required|boolean',
            'urgency' => 'required|integer'
        ];
    }

    public function users() {
        return $this->belongsTo('App\Models\User', 'executor_user_id');
    }

    public function lists() {
        return $this->belongsTo('App\Models\Listt', 'list_id', 'id');
    }
}
