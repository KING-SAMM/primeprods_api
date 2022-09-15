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

        # Now, check to see if image was uploaded
        if($request->hasFile('image'))
        {
            # If true, create a form field for the image file and store in
            # public/images
            $formFields['image'] = $request->file('image')->store('images', 'public');
        }

        # Also check to see if logo was uploaded
        if($request->hasFile('logo'))
        {
            # If true, create a form field for the logo file and store in
            # public/logos
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        # Set the currently logged in user to user_id field 
        # in prototype table in the database
        $formFields['user_id'] = auth()->id();

        # Create all the form data in the database 
        Prototype::create($formFields);

        # Redirect to home page with flash message
        return response()->json([
            'success' => 'Prototype created successfully'
        ], 201);
    }


    # To update, pass the $prototype object as additional parameter
    public function update(Request $request, Prototype $prototype)
    {
        # First ensure the logged in user is the owner
        if($prototype->user_id != auth()->id())
        {
            abort(403, 'Unauthorized action');
        }

        $formFields = $request->validate([
            'title' => ['required', Rule::unique('prototypes', 'title')],
            'company' => 'required',
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);

        # Check for image upload as before
        if($request->hasFile('image'))
        {
            $formFields['image'] = $request->file('image')->store('images', 'public');
        }

        # Check for logo upload as before
        if($request->hasFile('logo'))
        {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        # Create data with the current prototype object instead of static method
        $prototype->update($formFields);

        # Redirect back to current page with flash message
        return response()->json([
            'success' => 'Prototype updated successfully'
        ], 201);
        // return back()->with('message', 'Prototype updated successfully');
    }
}
