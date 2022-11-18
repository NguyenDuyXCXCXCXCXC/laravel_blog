<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\services\categories\CategoriesServices;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    protected $categoriesServices;

    public function __construct(CategoriesServices $categoriesServices)
    {
        $this->categoriesServices = $categoriesServices;
    }

    public function index(Request $request)
    {
//        $search = '';
//        if($request->input('search') != null)
//        {
//            $search = $request->input('search');
//        }
//        $categories = $this->categoriesServices->getAll($request);
//        if ($request->input('search')) {
//            $search = $request->input('search');
//        }
//        $products = Categories::where('name', 'like', "%{$keyword}%")

        $search = $request->input('search');
        if($search != null)
        {
            $categories = Categories::where('name', 'LIKE', "%{$search}%")
                ->orderByDesc('id')->paginate(7);
        }else{
            $categories = Categories::orderByDesc('id')->paginate(7);
        }

        $user = Auth::user();

        return view('admin.categories.index', [
            'title' => 'Trang quản trị danh sách user',
            'user' => $user,
            'categories' => $categories,
            'search' => $search
        ]) ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
}
