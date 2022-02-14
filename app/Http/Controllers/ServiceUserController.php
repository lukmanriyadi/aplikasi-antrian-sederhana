<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceUser;
use App\Models\ServiceUser;
use Illuminate\Http\Request;

class ServiceUserController extends Controller
{
    public function store(StoreServiceUser $request)
    {
       ServiceUser::create($request->validated());
       return redirect()->to('/officer')->with('status', 'New Service Successfully Added');
    }
    
    public function destroy(ServiceUser $serviceUser)
    {
        $serviceUser->delete();
        return redirect()->to('/officer')->with('status', 'Service Successfully Deleted');
    }
}