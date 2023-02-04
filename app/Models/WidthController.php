<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Width;
use Illuminate\Support\Str;

class widthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $width = width::orderBy('id', 'DESC')->paginate();
        // return view('backend.width.index')->with('widths', $width);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.width.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
        ]);
        $data = $request->all();
        $slug = Str::slug($request->title);
        $count = width::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        // return $data;
        $status = width::create($data);
        if ($status) {
            request()->session()->flash('success', 'width successfully created');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('width.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $width = width::find($id);
        if (!$width) {
            request()->session()->flash('error', 'width not found');
        }
        return view('backend.width.edit')->with('width', $width);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $width = width::find($id);
        $this->validate($request, [
            'title' => 'string|required',
        ]);
        $data = $request->all();

        $status = $width->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'width successfully updated');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('width.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $width = width::find($id);
        if ($width) {
            $status = $width->delete();
            if ($status) {
                request()->session()->flash('success', 'width successfully deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('width.index');
        } else {
            request()->session()->flash('error', 'width not found');
            return redirect()->back();
        }
    }
}