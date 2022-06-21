<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use DataTables;
use \Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    
    public function index()
    {
        return view('dashboard.categories.index');
    }


    public function getCategoriesDatatable()
    {
        $data = Category::select('*')->with('parents');
        return  Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                if (auth()->user()->can('viewAny', $this->setting)) {
                    return $btn = '
                        <a href="' . Route('dashboard.category.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>
                        <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"  data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
                }
            })

            ->addColumn('parent', function ($row) {
                return ($row->parent ==  0) ? trans('words.main category') :   $row->parents->translate(app()->getLocale())->title;
            })


            ->addColumn('title', function ($row) {
                return $row->translate(app()->getLocale())->title;
            })
            ->addColumn('status', function ($row) {
                return $row->status == null ? __('words.not activated') : __('words.' . $row->status);
            })
            ->rawColumns(['action', 'status', 'title'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('viewAny', $this->setting);
        $categories = Category::whereNull('parent')->orWhere('parent', 0)->get();
        return view('dashboard.categories.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('viewAny', $this->setting);
        $category =  Category::create($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;
            $category->update(['image' => $path]);
        }
        return redirect()->route('dashboard.category.index');
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
    public function edit(Category $category)
    {
        $this->authorize('viewAny', $this->setting);
        $categories = Category::whereNull('parent')->orWhere('parent', 0)->get();
        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('viewAny', $this->setting);
        $category->update($request->except('image', '_token'));
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $path = 'images/' . $filename;

            $category->update(['image' => $path]);
        }
        return redirect()->route('dashboard.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        $this->authorize('viewAny', $this->setting);
        if (is_numeric($request->id)) {
            Category::where('parent', $request->id)->delete();
            Category::where('id', $request->id)->delete();
        }

        return redirect()->route('dashboard.category.index');
    }
}
