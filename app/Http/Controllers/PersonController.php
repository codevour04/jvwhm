<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\People;
use App\Http\Requests\AddNewPersonRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Insertable;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $person = Person::find(2);
        // dd($person->full_name);
        return response()->json(Person::latest('created_at')->get());
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
    public function store(AddNewPersonRequest $request)
    {

        $person = new Person([
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'lastname' => $request->input('lastname'),
            'birthdate' => $request->input('birthdate'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'contact_number' => $request->input('contact_number')
        ]);

        $person->save();

        if ($request->input('leader')) {

            $leader = Person::find($request->input('leader'));

            $leader->insertables()->create([
                'person_id' => $person->id

            ]);
        }


        return response()->json($person);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 

        return view('profile.index', ['person' => Person::find($id), 'person_id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('edit.index', [
            'person' => Person::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddNewPersonRequest $request, $id)
    {
        $person = Person::find($id);
        $person->firstname = $request['firstname'];
        $person->lastname = $request['lastname'];
        $person->middlename = $request['middlename'];
        $person->birthdate = $request['birthdate'];
        $person->address = $request['address'];
        $person->city = $request['city'];
        $person->contact_number = $request['contact_number'];
        $person->save();

         if ($request['leader']) {

            $person->leader()->create([
                'person_id' => $request->input('leader')

            ]);
        }
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

    }
}
