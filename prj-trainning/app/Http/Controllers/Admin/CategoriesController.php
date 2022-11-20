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

        $categories = $this->categoriesServices->getAll($request);
        $user = Auth::user();

        return view('admin.categories.index', [
            'title' => 'Trang quản trị danh sách user',
            'user' => $user,
            'categories' => $categories,
        ]) ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $user = Auth::user();
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
        $categories = $this->categoriesServices->create($request);
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
    public function edit(Categories $categories)
    {
        $user = Auth::user();
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
        $result = $this->categoriesServices->update($request, $categories);
        if ($result){
            Session::flash('mySuccess', 'Danh mục ' . $request->categories .' đã được chỉnh sửa' );
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
        $result = $this->categoriesServices->destroy($id);
        if ($result)
        {
            return response()->json([
                'message' => 'Record deleted successfully!'
            ]);
        }
    }
}
