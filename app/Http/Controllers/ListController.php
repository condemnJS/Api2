<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ListController extends Controller
{
    public function create(Request $request) {
        if(!$request['attributes']) return response(['message' => 'None Attributes'], 422);
        $request = $request->all()['attributes'];
        return Listt::createEntity($request);
    }

    public function getItems(Request $request) {
        return Listt::getItemsEntity($request);
    }

    public function getItem(Request $request, $id) {
        return Listt::getItemEntity($request, $id);
    }

    public function update(Request $request, $id) {
        $request = $request->all()['attributes'];
        return Listt::updateEntity($request, $id);
    }

    public function destroy(Request $request, $id) {
        return Listt::destroyEntity($id);
    }
}

