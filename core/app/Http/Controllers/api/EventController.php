<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use App\Event;
use App\Event_image;
use App\DetailEvent;

class EventController extends Controller
{
    public function read(Request $request){
        $event_joined = DetailEvent::where("user_id",$request->user_id)->groupBy("event_id")->get('event_id');
        
        $events = Event::query("user_id","!=",$request->user_id);
        
        if(!empty($event_joined->first())){
            $events = $events->whereNotIn("id",$event_joined)->get();
        }else{
            $events = $events->get();
        }
        
        foreach ($events as $event => $value) {
                $events[$event]->image = $events[$event]->EventFirstImage();
                $events[$event]->member = $events[$event]->countMember();
                $events[$event]->creator = $events[$event]->eventCreator();
        }
        
        return response()->json($events);
        
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            "user_id" => "required|numeric",
            "event_name" => "required|max:100",
            "description" => "required",
            "tanggal_mulai" => "required|date|before_or_equal:".$request->tanggal_selesai,
            "tanggal_selesai" => "required|date|after_or_equal:".$request->tanggal_mulai,
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:4096',
            "status" => Rule::in(["open","close","ongoing","done"])
        ]);

        if($validator->fails()){
            return response()->json(['status' => 403]);
        }
            // MENYIMPAN GAMBAR
                $simpan = Storage::putFile('public/EventImages',$request->file('image'));
                $name_file = basename($simpan);
            // AKHIR

            $event = new Event;
            $event->user_id = $request->user_id;
            $event->nama = $request->event_name;
            $event->deskripsi = $request->description;
            $event->tanggal_mulai = $request->tanggal_mulai;
            $event->maximal_member = $request->maximal_member;
            $event->tanggal_selesai = $request->tanggal_selesai;
            $event->status = $request->status;
            $event->save();

            $event_image = new Event_image;
            $event_image->event_id = $event->id;
            $event_image->image_name = $name_file;
            $event_image->save();

            return response()->json(['status' => 200,"event_id" => $event->id]);
    }
    
    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            "user_id" => "required|numeric",
            "event_name" => "required|max:100",
            "description" => "required|max:200",
            "tanggal_mulai" => "required|date|before_or_equal:".$request->tanggal_selesai,
            "tanggal_selesai" => "required|date|after_or_equal:".$request->tanggal_mulai,
            "status" => Rule::in(["open","close","ongoing","done"]),
            "event_id" => "required|numeric"
        ]);

        if($validator->fails()){
            return response()->json(['status' => 403]);
        }

            $event = Event::find($request->event_id);
            
    }

    public function delete(Request $request){
      $event = Event::find($request->event_id);
      $event->delete();

      return response()->json(['status' => 200,'messages' => 'oke','errors' => 'nothing'],200);
    }

    public function myEvent(Request $request){
        $events = Event::where("user_id",$request->user_id)->get();

        foreach ($events as $event => $value) {
            $events[$event]->image = $events[$event]->EventFirstImage();
            $events[$event]->member = $events[$event]->countMember();
            $events[$event]->creator = $events[$event]->eventCreator();
        }

        return response()->json($events);
    }

}
