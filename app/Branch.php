<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function country_obj()
    {
    	return $this->belongsTo('App\Country', 'country', 'country_code');
    }

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }


    public static function getDropDownList($prepend=true)
    {
        $query = Branch::query();

        if(!isSuperAdmin()) {
            $query->whereCompanyId(\Auth::user()->company_id);
        }

        $branches = $query->pluck('title', 'id');
        if($prepend) {
            $branches = $branches->prepend('Select a Branch', '');
        }
        $branches = $branches->all();

        return $branches;
    }

    /**
     * Get the branch's created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return \Carbon::parse($value)->format(getOption('date_format') ? getOption('date_format') : session('date_format','Y-m-d'));
    }

    /**
    * Deleting relational model
    */
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function($company) {
    //         $branch->person()->delete();
    //         $branch->user_metas()->delete();
    //         $branch->contact_requests()->forceDelete();
    //         $branch->companies()->forceDelete();
    //         $branch->categories()->forceDelete();
    //         $products = $branch->products;
    //         if(!$products->isEmpty()) {
    //             foreach($products as $product) {
    //                 $product->categories()->detach();
    //                 $product->tags()->detach();
    //                 $product_images = $product->product_images;
    //                 if($product_images) {
    //                     $image_folder = 'uploads/products/';
    //                     foreach($product_images as $image){
    //                         if(file_exists($image_folder . basename($image->image_path))){
    //                             File::delete($image_folder . basename($image->image_path));
    //                             File::delete($image_folder . 'thumbnail/' . basename($image->image_path));
    //                         }
    //                     }
    //                     $product->product_images()->forceDelete();
    //                 }
    //                 $product->product_prices()->delete();
    //                 $product->review_ratings()->forceDelete();
    //                 $product->wishlists()->delete();
    //             }
    //         }
    //         $branch->products()->forceDelete();
    //         $branch->review_ratings()->forceDelete();
    //         $branch->senders()->forceDelete();
    //         $branch->receivers()->forceDelete();
    //         $branch->wishlists()->delete();
    //     });
    // }
}
