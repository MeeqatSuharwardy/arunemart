<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['title', 'slug', 'summary', 'photo', 'status', 'is_parent', 'parent_id', 'added_by'];

    public function parent_info()
    {
        return $this->hasOne('App\Models\Room', 'id', 'parent_id');
    }
    public static function getAllRoom()
    {
        return  Room::orderBy('id', 'DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id)
    {
        return Room::whereIn('id', $cat_id)->update(['is_parent' => 1]);
    }
    public static function getChildByParentID($id)
    {
        return Room::where('parent_id', $id)->orderBy('id', 'ASC')->pluck('title', 'id');
    }

    public function child_cat()
    {
        return $this->hasMany('App\Models\Room', 'parent_id', 'id')->where('status', 'active');
    }
    public static function getAllParentWithChild()
    {
        return Room::with('child_cat')->where('is_parent', 1)->where('status', 'active')->orderBy('title', 'ASC')->get();
    }
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'cat_id', 'id')->where('status', 'active');
    }
    public function sub_products()
    {
        return $this->hasMany('App\Models\Product', 'child_cat_id', 'id')->where('status', 'active');
    }
    public static function getProductByCat($slug)
    {
        // dd($slug);
        return Room::with('products')->where('slug', $slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    public static function getProductBySubCat($slug)
    {
        // return $slug;
        return Room::with('sub_products')->where('slug', $slug)->first();
    }
    public static function countActiveRoom()
    {
        $data = Room::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }
}