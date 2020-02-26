<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\request_to_be_owner as OwnerRequest;

class RequestController extends Controller
{
    

    public function makeRequest()
    {
        $documents = request()->only('documents');
        $documents = $documents['documents'];
        
        $ownerID = auth()->user()->id;
        OwnerRequest::create([
            'documents'=> $documents,
            'owner_id' => $ownerID,
        ]);
        // return response()->json(['success'=>'request is gonna to chheked'], 200);
        // OwnerRequest::create[]
    }
}
