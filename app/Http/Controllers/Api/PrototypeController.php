<?php

namespace App\Http\Controllers\Api;

use App\Models\Prototype;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Created;

class PrototypeController extends Controller
{
    /**
     *  Get all prototypes
     * 
     * @return array<string>
     */
    public function index()
    {
        return response()->json([
            'prototypes' => Prototype::latest()->filter(request(['tag', 'search']))->paginate(10)
        ]);
    }


    /**
     * Get all prototypes (gallery)
     * 
     * @return array<string>
     */
    public function gallery()
    {
        return response()->json([
            'prototypes' => Prototype::all(),
            'heading' => 'Gallery'
        ]);
    }


    /**
     * Get single prototype
     * 
     * 
     */
    public function show(Prototype $prototype)
    {
        // dd($prototype);
        return response()->json([
            'prototype' => $prototype
        ]);
    }


    # Store prototype form data
    public function store(Request $request)
    {
        # Validate form input data (note that nullable 'logo' is excluded) 
        # 'image' (not nullable) is also excluded
        $formFields = $request->validate([
            'title' => ['required', Rule::unique('prototypes', 'title')],
            'company' => 'required',
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);
        // $request->validate([
        //     'title' => ['required', Rule::unique('prototypes', 'title')],
        //     'image' => '',
        //     'company' => 'required',
        //     'location' => 'required',
        //     'email' => ['required', 'email'],
        //     'logo' => '',
        //     'website' => 'required',
        //     'tags' => 'required',
        //     'description' => 'required'
        // ]);

        # Now, check to see if image was uploaded
        if($request->hasFile('image'))
        {
            # If true, create a form field for the image file and store in
            # public/images
            $formFields['image'] = $request->file('image')->store('images', 'public');

            // $prototype = new Prototype;
            // $prototype->image = $request->file->hasName();
            // $prototype->save9();
            // $formFields['image'] = $request->file('image')->hasName();
        } else {
            $formFields['image'] = "No image file received";
        }

        # Also check to see if logo was uploaded
        if($request->hasFile('logo'))
        {
            # If true, create a form field for the logo file and store in
            # public/logos
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');


            // $formFields['logo'] = $request->file('logo')->hasName();
        } else {
            $formFields['logo'] = "No logo file received";
        }

        # Set the currently logged in user to user_id field 
        # in prototype table in the database
        $formFields['user_id'] = 2; //auth()->id();

        # Create all the form data in the database 
        Prototype::create($formFields);
        // $prototype = Prototype::create([
        //     'title' => $request->title,
        //     'image' => $request->image,
        //     'company' => $request->company,
        //     'location' => $request->location,
        //     'email' => $request->email,
        //     'logo' => $request->logo,
        //     'website' => $request->website,
        //     'tags' => $request->tags,
        //     'description' => $request->description
        // ]);
        // event(new Created($prototype));

        # Redirect to home page with flash message
        return response()->json([
            'success' => 'Prototype created successfully'
        ], 201);
        // return response()->noContent();
    }
}
