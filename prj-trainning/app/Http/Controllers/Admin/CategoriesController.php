<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoriesRequest;
use App\Http\services\categories\CategoriesServices;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{
    protected $categoriesServices;

    public function __construct(CategoriesServices $categoriesServices)
    {
        $this->categoriesServices = $categoriesServices;
    }

    public function index(Request $request)
    {
        $result = $this->categoriesServices->getCategoriesByParams($request);
        $categories = $result[0];
        $selected_option = $result[1];
        $user = Auth::guard('admin')->user();
        $search = $result[2];

        return view('admin.categories.index', [
            'title' => 'Trang quản trị danh sách danh mục',
            'user' => $user,
            'categories' => $categories,
            'search' => $search
        ]) ->with('i', (request()->input('page', 1) - 1) * $selected_option);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.categories.add', [
            'title' => 'Thêm mới categories',
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriesRequest $request)
    {
        $categories = $this->categoriesServices->createCategory($request);
        return redirect()->route('admin.categories.list');

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
    public function edit(Request $request,  Categories $categories)
    {
        $user = Auth::guard('admin')->user();
        return view('admin.categories.edit', [
            'title' => 'Sửa danh mục: '.$categories->name,
            'user' => $user,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoriesRequest $request, Categories $categories)
    {
        $categoriesName = $categories->name;
        $result = $this->categoriesServices->update($request, $categories);
        if ($result){
            Session::flash('mySuccess', 'Danh mục ' . $categoriesName .' đã được chỉnh sửa' );
        }
        return redirect()->route('admin.categories.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Categories::where('id', $id)->first();
        $result = $this->categoriesServices->destroy($id);
        if ($result)
        {
            Session::flash('mySuccess', 'Danh mục ' . $categories->name .' đã được xóa' );
            return redirect()->back();
        }
    }
}
