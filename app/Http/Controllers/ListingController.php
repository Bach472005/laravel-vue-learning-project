<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use function Psy\debug;

class ListingController extends Controller
{
    
    public function __construct()
    {
        // Setting this will force every one want to see listing have to login
        // $this->middleware('auth');
        $this->authorizeResource(Listing::class, 'listing');
    }
    public function index(Request $request)
    {
        $filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);
        return Inertia(
        'List/Index', 
        [
                'filters' =>$filters,
                'listings' => Listing::mostRecent()
                ->filter($filters)
                ->paginate(10)
                ->withQueryString()
            ]
        );
    }

    

    public function show(Listing $listing)
    {
        // if (Auth::user()->cannot('view', $listing)){
        //     abort(403);
        // }
        // $this->authorize('view', $listing);
        $listing->load('images');
        $offer = !Auth::user() ? 
            null : $listing->offers()->byMe()->first();

        return Inertia('List/Show', [
            'listing' => $listing,
            'offerMade' => $offer
        ]);
    }
}
