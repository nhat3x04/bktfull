<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods=Food::paginate(8);
        return view('food.webfood',compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $foods=Food::all();
        return view('food.food_create',compact('foods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
            "name"  => "required",
            "price" => "required",
            "price_sale"  => "required",
            'image_file'=>'mimes:jpeg,jpg,png,gif|max:10000 '
        ]);

        if ($validation->fails()){
            return redirect('foods/create')->withErrors($validation)->withInput();
        }
        $name = null;
        if($request->hasfile('image_file'))
        {
            $file = $request->file('image_file');
            $name=time().'_'.$file->getClientOriginalName();
            $destinationPath=public_path('image'); //project\public\images, //public_path(): trả về đường dẫn tới thư mục public
            $file->move($destinationPath, $name); //lưu hình ảnh vào thư mục public/images/
        }
     
        $food=new food();
        $food->name=$request->input('name');
        $food->price=$request->input('price');
        $food->price_sale=$request->input('price_sale');
        $food->image=$name ?? '';
        $food->save();
        return redirect('foods')->with('message','Thêm sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food=Food::find($id);
        //tương đương select* from where
        return view('food.food_show',compact('food'));
        $foods=Food::paginate(4);
        return view('food.food_show',compact('foods'));
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
    public function postSearch(Request $request)
{
    $query = $request->input('query');

    // Tìm kiếm chỉ trong bảng 'car' với các trường 'model' và 'description'
    $foods = Food::where('name', 'LIKE', '%' . $query . '%')
                ->paginate(3);

    return view('food.webfood', compact('foods',))->with('search_query', $query);
}

}
