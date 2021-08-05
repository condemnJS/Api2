<?php

namespace App\Http\Controllers;

use App\Models\UserList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserListController extends Controller
{
    public function create(Request $request) {
        $request = $request->all()['attributes'];
        return UserList::createEntity($request);
    }

    public function getItems(Request $request) {
        return UserList::getItemsEntity($request);
    }

    public function getItem(Request $request, $id) {
        return UserList::getItemEntity($request, $id);
    }

    public function update(Request $request, $id) {
        $request = $request->all()['attributes'];
        return UserList::updateEntity($request, $id);
    }

    public function destroy(Request $request, $id) {
        return UserList::destroyEntity($id);
    }
}
