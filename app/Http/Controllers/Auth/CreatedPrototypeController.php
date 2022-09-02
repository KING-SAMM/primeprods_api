<?php

namespace App\Http\Controllers\Auth;

use App\Models\Prototype;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Created;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;

class CreatedPrototypeController extends Controller
{
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
        // return response()->json([
        //     'message' => 'Prototype created successfully'
        // ]);
        return response()->noContent();
    }
}
