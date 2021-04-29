<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Http\Requests\AddNewPersonRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Insertable;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Person::latest('created_at')->paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $filename = request('avatar') ? hash( 'sha256', false).request('avatar')->getClientOriginalName() : 'default.jpg';

        if (request('leader')) {
            $leader = Person::find(request('leader'));
            $leader->insertables()->sync([
                'person_id' => $person->id
            ]);
        }

        if ($filename !== "default.jpg") {
            request('avatar')->storeAs('avatars', $hash.$filename, 'public_uploads');
        }

        $person = Person::create([   
            'avatar' => $filename,
            'firstname' => request('firstname'),
            'middlename' => request('middlename'),
            'lastname' => request('lastname'),
            'birthdate' => request('birthdate'),
            'address' => request('address'),
            'city' => request('city'),
            'contact_number' => request('contact_number')
        ]);


        return response()->json($person);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    { 

        $people = $person->insertables;
        $peopleIds = $people->pluck('person_id');
        $people = Person::whereIn('id', $peopleIds)->get();
        $person = Person::find($person->id);
        return view('profile.index', compact('person', 'people'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        $person = Person::find($person->id);
        return view('edit.index', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        $filename = request('avatar');

        if (request('avatar') != 'default.png') {
            $filename = request('avatar') ? hash( 'sha256', false).request('avatar')->getClientOriginalName();
        }
        

        if ($filename) {
            request('avatar')->storeAs('avatars', $hash.$filename, 'public_uploads');
        }

        $person = Person::find($id);

        $person->avatar = $filename;
        $person->firstname = request('firstname');
        $person->middlename = request('middlename');
        $person->lastname = request('lastname');
        $person->birthdate = request('birthdate');
        $person->address = request('address');
        $person->city = request('city');
        $person->contact_number = request('contact_number');
        $person->save();

        if (request('leader')) {
            $leader = Person::find(request('leader'));
            $leader->insertables()->sync([
                'person_id' => $person->id
            ]);
        }


        return response()->json($person);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = Person::find($id);
        $person->delete();
    }

    public function getPeople(Request $request) 
    {
        $people = Person::find($request['id'])->insertables;
        $peopleIds = $people->pluck('person_id');
        return response()->json(Person::whereIn('id', $peopleIds)->get());
    }

    public function suggestions($search) {
        $result = Person::select("firstname")->where("firstname", "LIKE", "%{$request->search}%" )->get();
        return response()->json($result);
    }

    public function search(Request $request) 
    {
        return response()->json(Person::latest('created_at')->where("firstname", "LIKE", "%{$request['search']}%" )->paginate(20));
    }

}
