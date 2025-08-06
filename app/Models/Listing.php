<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price', 'by_user_id',
    ];
    protected $sortable = [
        'price', 'created_at'
    ];
    public function images()
    {
        return $this->hasMany(
            ListingImage::class,
        );
    }
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'by_user_id'
        );
    }
    public function offers()
    {
        return $this->hasMany(
            Offer::class,
            'listing_id'
        );
    }
    
    public function scopeMostRecent(EloquentBuilder $query)
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeWithoutSold(EloquentBuilder $query)
    {
        // return $query->doesntHave('offers')
        //     ->orWhereHas(
        //     'offers',
        //     fn(EloquentBuilder $query) => $query->whereNull('accepted_at')
        //                 ->whereNull('rejected_at')
        //         );
        return $query->whereNull('sold_at');
    }

    public function scopeFilter (EloquentBuilder $query, array $filters){
        // when -> value is like if clause
        //      -> callback is a function doing sth when if clause is right
        return $query->when(
            $filters['priceFrom'] ?? false,
            fn ($query, $value) => $query->where('price', '>=', $value)
        )->when(
            $filters['priceTo'] ?? false,
            fn ($query, $value) => $query->where('price', '<=', $value)
        )->when(
            $filters['beds'] ?? false,
            fn ($query, $value) => $query->where('beds', (int)$value ? '=' : '>=' , $value)
        )->when(
            $filters['baths'] ?? false,
            fn ($query, $value) => $query->where('baths',(int)$value ? '=' : '>=', $value)
        )->when(
            $filters['area'] ?? false,
            fn ($query, $value) => $query->where('area', '>=', $value)
        )->when(
            $filters['area'] ?? false,
            fn ($query, $value) => $query->where('area', '>=', $value)
        )->when(
            $filters['deleted'] ?? false,
            fn ($query, $value) => $query->withTrashed()
        )->when(
            $filters['by'] ?? false,
            fn ($query, $value) =>
            !in_array($value, $this->sortable)
            ? $query : $query->orderBy($value, $filters['order'] ?? 'desc'),
        );
    }   
}
