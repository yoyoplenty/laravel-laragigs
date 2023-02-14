<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller {

    //Get ALL Listings
    public function index() {
        return view('listings.index', [
            'heading' => 'Latest listings',
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    //Store Listing Data
    public function store(Request $request) {
        /**
         * //Request()->file()
         * This is the request helper methdod if we are not using dependency injection
         */
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo'))
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully');
    }

    /**
     * Get Manage LIstings
     */
    public function manage() {

        /**
         * Here we want to get all currently logged in users listings
         */
        return view(
            'listings.manage',
            ['listings' => auth()->user()->listings()->get()]
        );
    }

    //Get single Listing
    /**
     * This right here is what we call the Route model finder
     */
    public function show(Listing $listing) {
        return view('listings.show', [
            'heading' => 'listing Details',
            'listing' => $listing
        ]);
    }

    //Get the show create form
    public function create() {
        return view('listings.create');
    }

    //Get the Edit form
    /**
     * We are using Route model finder here too
     */
    public function edit(Listing $listing) {
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }


    //Store Listing Data
    public function update(Request $request, Listing $listing) {

        //Make Logged in User is listing owner
        if ($listing->user_id != auth()->id())
            abort(403, 'Unauthorized Action');

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo'))
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');

        //We use this to update the listing the route model finder gets us
        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully');
    }

    public function destroy(Listing $listing) {

        //Make Logged in User is listing owner
        if ($listing->user_id != auth()->id())
            abort(403, 'Unauthorized Action');

        $listing->delete();

        return redirect('/')->with('message', 'Listing deleted successfully');
    }
}
