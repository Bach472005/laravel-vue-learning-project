<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RealtorListingController extends Controller
{
    public function __construct()
    {
        // Setting this will force every one want to see listing have to login
        // $this->middleware('auth');
        $this->authorizeResource(Listing::class, 'listing');
    }
    public function index(Request $request)
    {
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];
        return Inertia(
        'Realtor/Index',
        [
                'filters' => $filters,
                'listings' => Auth::user()
                    ->listings()
                    ->filter($filters)
                    ->withCount('images')
                    ->withCount('offers')
                    ->paginate(5)
                    ->withQueryString()
                    // ->get()
            ]
        );
    }

    public function show (Listing $listing)
    {
        return inertia(
            'Realtor/Show',
            ['listing' => $listing->load('offers', 'offers.bidder')]
        );
    }

    public function create()
    {
        // $this->authorize('create', Listing::class);
        return Inertia('Realtor/Create');
    }

    public function store(Request $request)
    {
        $request->user()->listings()->create($request->validate([
            'beds' => 'required|integer|min:0|max:20',
            'baths' => 'required|integer|min:0|max:20',
            'area' => 'required|integer|min:15|max:1500',
            'city' => 'required',
            'code' => 'required',
            'street' => 'required',
            'street_nr' => 'required|integer|min:1|max:1000',
            'price' => 'required|integer|min:1|max:2000000',
        ]));

        return redirect()->route('realtor.listing.index')
            ->with('success', 'Listing was created');
    }

    public function edit(Listing $listing)
    {
        return Inertia('Realtor/Edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing)
    {
        $listing->update($request->validate([
            'beds' => 'required|integer|min:0|max:20',
            'baths' => 'required|integer|min:0|max:20',
            'area' => 'required|integer|min:15|max:1500',
            'city' => 'required',
            'code' => 'required',
            'street' => 'required',
            'street_nr' => 'required|integer|min:1|max:1000',
            'price' => 'required|integer|min:1|max:2000000',
        ]));

        return redirect()->route('realtor.listing.index')
            ->with('success', 'Listing was updated');
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();
        return redirect()->route('realtor.listing.index')
                ->with('success', 'Listing was deleted');
    }
    public function restore(Listing $listing){
        $listing->restore();

        return redirect()->back()
            ->with('success', 'Listing was restored');
    }
}
