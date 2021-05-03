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
    public function store(AddNewPersonRequest $request)
    {

        $filename = request('avatar') ? hash( 'sha256', false).request('avatar')->getClientOriginalName() : 'default.jpg';


        if ($filename !== "default.jpg") {
            request('avatar')->storeAs('avatars', $filename, 'public_uploads');
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

        if (request('leader')) {
            $leader = Person::find(request('leader'));
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
    public function show(Person $person)
    { 
        $people = $person->insertables;
        if ($people) {
            $peopleIds = $people->pluck('person_id');
            $people = Person::whereIn('id', $peopleIds)->get();
        }

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

        $person = Person::find($id);

        if ($person->avatar !== request('avatar')) {
            $filename = hash( 'sha256', false).request('avatar')->getClientOriginalName();
            request('avatar')->storeAs('avatars', $filename, 'public_uploads');
            $person->avatar = $filename;
        }
        
        $person->firstname = request('firstname');
        $person->middlename = request('middlename');
        $person->lastname = request('lastname');
        $person->birthdate = request('birthdate');
        $person->address = request('address');
        $person->city = request('city');
        $person->contact_number = request('contact_number');
        $person->save();

        $id = $person->id;

        

if (request('leader')) {

    $comments = Insertable::whereHasMorph(
    'insertable',
    ['App\Person'],
    function (Builder $query) use ($id) {
        $query->where('person_id', $id);
    }
)->get();
    
    if ($comments->isNotEmpty()) {
        $comments[0]->insertable_id = request('leader');
        $comments[0]->save();
    }else{
        $leader = Person::find(request('leader'));
        $leader->insertables()->create([
            'person_id' => $person->id
        ]);
    }
        
}


        // if ($leader->insertables) {
        //     dd("!!!");
        // }else{
        //     dd("?/");
        // }


        // $Insertable->insertables()->save(request('leader'));
        // dd($person->insertables);

        // if ($person->insertables) {
        //     if (request('leader') !== $person->leader) {
        //         $leader = Person::find(request('leader'));
        //         $leader->insertables()->updateOrCreate([
        //             'person_id' => $person->id
        //         ]);
        //     }
        // }

        

        // return response()->json($person);
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
