<?php

namespace App\Models;

use App\Events\TaskProcessed;
use App\Models\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Listt;

abstract class TodoModel extends Model
{

    use ResponseTrait;

    abstract static public function rules():array;

    static public function createEntity($request) {
        $validator = Validator::make($request, static::rules());

        if($validator->fails()) {
            return response()->json($validator->errors());
        }
        $list = static::create($request);
        if(new static instanceof Task) {
            $listModel = Listt::find($list->list_id);
            $counter = count(Task::where('list_id', $listModel->id)->get());
            $counterCompleted = count(Task::where('list_id', $listModel->id)->where('is_completed', true)->get());
            $listModel->count_tasks = $counter;
            if($counter === $counterCompleted) {
                $listModel->is_completed = true;
            }
            $listModel->save();
//            event(new TaskProcessed($list));
        }
        return static::responseJson(["attributes" => $list], "Created!", 201);
    }

    static public function destroyEntity($id) {
        if(!$model = static::find($id)) return response()->json(['message' => 'Unprocessable Entity'], 422);
        $model->delete();
        return static::responseJson(null, 'Deleted!', 200);
    }

    static public function updateEntity($request, $id) {
        $list = static::findOrFail($id);
        $list->update($request);
        return static::responseJson(['attributes' => $list], 'Updated!', 200);
    }

    static public function getItemEntity($request, $id) {
        if(!is_numeric($id)) return response()->json(['message' => 'Not Found'], 404);
        if(!$list = static::find($id)) return response()->json(['message' => 'Unprocessable Entity'], 422);
        if($request->withs) {
            $list = $list->with($request->withs);
        }
        return static::responseJson(['attributes' => $list], 'Received!', 200);
    }

    static public function getItemsEntity($request) {
        $lists = static::where('id', '<>', '-1');
        if($request->filter) {
            foreach ($request->filter as $item) {
//                $item = json_decode($item);
                $lists = $lists->where($item[0], $item[1], $item[2]);
            }
        }

        if($request->order) {
            foreach ($request->order as $item) {
//                $item = json_decode($item);
                $lists->orderBy($item[0], $item[1]);
            }
        }
        if($request->withs) {
            $lists = $lists->with($request->withs);
        }

        if($request->per_page) {
            $lists->paginate($request->per_page);
        }
        return static::responseJson(['items' => $lists->get()], 'Received!', 200);
    }
}
