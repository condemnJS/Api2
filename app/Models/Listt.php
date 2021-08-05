<?php

namespace App\Models;


class Listt extends TodoModel
{
    protected $table = "lists";
//    protected $guarded = [];

    protected $fillable = [
        'name',
        'count_tasks',
        'is_completed',
        'is_closed',
    ];

    static public function rules(): array
    {
        return [
            'name' => 'required',
            'count_tasks' => 'required|integer',
            'is_completed' => 'required|boolean',
            'is_closed' => 'required|boolean'
        ];
    }

    public function tasks() {
        return $this->hasMany('App\Models\Task', 'list_id', 'id');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_lists', 'list_id', 'user_id');
    }

}
