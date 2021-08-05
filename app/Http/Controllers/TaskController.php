<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Listt;

class TaskController extends Controller
{
    public function create(Request $request) {
        if(!$request['attributes']) return response(['message' => 'None Attributes'], 422);
        $request = $request->all()['attributes'];
        if(isset($request['executor_user_id'])) {
            return response()->json(['Error Params'], 422);
        }
        $request['executor_user_id'] = Auth::id();
        return Task::createEntity($request);
    }

    public function getItems(Request $request) {
        return Task::getItemsEntity($request);
    }

    public function getItem(Request $request, $id) {
        return Task::getItemEntity($request, $id);
    }

    public function update(Request $request, $id) {
        $request = $request->all()['attributes'];
        return Task::updateEntity($request, $id);
    }

    public function destroy(Request $request, $id) {
        return Task::destroyEntity($id);
    }
}
