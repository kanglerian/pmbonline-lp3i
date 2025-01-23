<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Contracts\View\View
    */

    public function index(): \Illuminate\Contracts\View\View {
        $titleVal = request('title');

        $event_query = Event::query();

        $appends = [];
        
        if($titleVal) {
            $event_query->where('title', 'like', '%' . $titleVal . '%');
            $appends['title'] = $titleVal;
        }

        $events = $event_query->paginate( 10 );
        return view( 'pages.menu.event.index', compact( 'events' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'pages.menu.event.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store_event(Request $request){
        return response()->json([
            'message' => 'siapp'
        ]);
    }

    public function store( Request $request ): \Illuminate\Http\RedirectResponse {
        $request->validate( [
            'pmb' => [ 'required', 'integer' ],
            'code' => [ 'required', 'max:10', 'min:3'],
            'title' => [ 'required', 'string', 'max:255' ],
            'description' => [ 'required', 'string' ],
        ],[
            'pmb.required' => 'PMB is required',
            'code.required' => 'Code is required',
            'code.max' => 'Code is too long',
            'code.min' => 'Code is too short',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ]);

        $data = [
            'pmb' => $request->pmb,
            'code' => $request->code,
            'title' => $request->title,
            'description' => $request->description,
            'is_scholarship' => false,
            'is_files' => false,
            'is_status' => true,
        ];

        try {
            Event::create( $data );
            return redirect()->route( 'event.index' )->with( 'message', 'Event created successfully' );
        } catch (\Throwable $th) {
            return redirect()->route( 'event.index' )->with( 'error', $th->getMessage() );  
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $code ): \Illuminate\Contracts\View\View {
        $event = Event::where([
            'code' => $code,
            'is_status' => true
        ])->firstOrFail();
        $schools = School::all();
        $informations = User::where([
            'role' => 'P',
            'status' => true
        ])->get();
        return view( 'pages.menu.event.show', compact( 'event','schools', 'informations' ) );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Contracts\View\View
    */

    public function edit( $id ): \Illuminate\Contracts\View\View {
        $event = Event::findOrFail( $id );
        return view( 'pages.menu.event.edit', compact( 'event' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ): \Illuminate\Http\RedirectResponse {

        $request->validate( [
            'pmb' => [ 'required', 'integer' ],
            'code' => [ 'required', 'max:10', 'min:3'],
            'title' => [ 'required', 'string', 'max:255' ],
            'description' => [ 'required', 'string' ],
        ],[
            'pmb.required' => 'PMB is required',
            'code.required' => 'Code is required',
            'code.max' => 'Code is too long',
            'code.min' => 'Code is too short',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ]);

        $data = [
            'pmb' => $request->pmb,
            'code' => $request->code,
            'title' => $request->title,
            'description' => $request->description,
            'is_scholarship' => false,
            'is_files' => false,
            'is_status' => true,
        ];

        try {
            $event = Event::findOrFail( $id );
            $event->update($data);
            return redirect()->route( 'event.index' )->with( 'message', 'Event updated successfully' );
        } catch (\Throwable $th) {
            return redirect()->route( 'event.index' )->with( 'error', $th->getMessage() );  
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ): \Illuminate\Http\RedirectResponse {
        try {
            $event = Event::findOrFail( $id );
            $event->delete();
            return redirect()->route( 'event.index' )->with( 'message', 'Event deleted successfully' );
        } catch (\Throwable $th) {
            return redirect()->route( 'event.index' )->with( 'error', $th->getMessage() );  
        }
    }

    public function scholarship($id): \Illuminate\Http\RedirectResponse {
        $event = Event::findOrFail($id);
        $event->update(
            [
                'is_scholarship' => !$event->is_scholarship
            ]   
        );
        return redirect()->route('event.index')->with('message', 'Event scholarship updated successfully');
    }

    public function files($id): \Illuminate\Http\RedirectResponse {
        $event = Event::findOrFail($id);
        $event->update(
            [
                'is_files' => !$event->is_files
            ]   
        );
        return redirect()->route('event.index')->with('message', 'Event files updated successfully');
    }

    public function status($id): \Illuminate\Http\RedirectResponse {
        $event = Event::findOrFail($id);
        $event->update(
            [
                'is_status' => !$event->is_status
            ]   
        );
        return redirect()->route('event.index')->with('message', 'Event status updated successfully');
    }
}
