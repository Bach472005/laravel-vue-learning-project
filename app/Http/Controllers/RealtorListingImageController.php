<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing)
    {  
        $listing->load(['images']);
        return Inertia(
            'Realtor/ListingImage/Create',
            ['listing' => $listing]
        );
    }
    public function store(Listing $listing, Request $request)
    {
        if($request->hasFile('images')){
            $request->validate([
                'images.*' => 'mimes:png,jpg,jpeg|max:5000'
            ], [
                'images.*.mimes' => 'The file should be in one of the formats: jpg, png, jpeg'
            ]);
            foreach ($request->file('images') as $file){
                $path = $file->store('images', 'public');

                $listing->images()->save(new ListingImage([
                    'filename' => $path
                ]));
            }
        }

        return redirect()->back()->with('success', 'Images uploaded');
    }

    // Take the $image bcs in route its {image}
    // $listing bcs we just need a parameter not whole Listing in db
    public function destroy ($listing, ListingImage $image)
    {
        Storage::disk('public')->delete($image->filename);

        $image->delete();
        
        return redirect()->back()->with('success', 'Images was deleted');
    }
}
