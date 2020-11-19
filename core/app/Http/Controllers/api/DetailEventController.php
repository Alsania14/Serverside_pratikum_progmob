<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\DetailEvent;
use App\User;
class DetailEventController extends Controller
{
    public function read(Request $request){

        $detailevents = DetailEvent::where('event_id',$request->id)->get('user_id');
        $users = User::whereIn('id',$detailevents)->get();

        return response()->json(['status' => 200,'result' => $users],200);
    }

    public function joinEvent(Request $request){
        $validator = Validator::make($request->all(),[
            'event_id' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status' => 403]);
        }

        $exist = DetailEvent::where('user_id',$request->user_id)->where('event_id',$request->event_id)->first();

        if($exist != null){
            return response()->json(['status' => 403,'errors' => 'sudah daftar','messages' => 'sudah daftar tadi']);
        }

        $eventDetail = new DetailEvent;
        $eventDetail->event_id = $request->event_id;
        $eventDetail->user_id = $request->user_id;
        $eventDetail->tanggal_masuk = date('Y-m-d');
        $eventDetail->status_member = 'pending';
        $eventDetail->save();

        return response()->json(['status' => 200],200);

    }

    public function cancelJoin(Request $request){
        $detailEvent = DetailEvent::find($request->id);

        $detailEvent->delete();

        return response()->json(['status' => 200],200);
    }

    public function accept(Request $request){
        $detailEvent = DetailEvent::find($request->id);
        $detailEvent->status_member = 'accept';
        $detailEvent->save();

        return response()->json(['status' => 200],200);
    }

    public function denied(Request $request){
        $detailEvent = DetailEvent::find($request->id);
        $detailEvent->status_member = 'denied';
        $detailEvent->save();

        return response()->json(['status' => 200],200);
    }

}
