<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of item.
     *@param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $query= Item::where('id','>',0);
        if($request->search){
            $query->where('title','LIKE','%'.$request->search.'%');
        }
        if($request->from){
            $query->where('date','>=',$request->from);
        }
        if($request->to){
            $query->where('date','<=',$request->to);
        }
        $items= $query->paginate(10);
        if($request->ajax()){
            $view = view('ajax_result_list',['items'=>$items])->render();
            return response()->json(['result' => $view]);
        }

       return view('list',['items'=>$items]);
    }
    /**
     * Save a Item.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveItem(Request $request)
    {
        $request->validate([
            'img.*'=>'required|mimes:png,jpg,jpeg,gif,svg|max:2000',
            'title.*'=>'required',
            'description.*'=>'required',
            'qty.*'=>'required',
            'price.*'=>'required',
            'date.*'=>'required',
        ]);
        // dd($request->all());
        foreach($request->img as $key=> $input){
            $item= new Item();
            if($request->hasFile("img.$key")){

                $attr_image=$request->file("img.$key");
                $ext=$attr_image->extension();
                $image_name=Rand(1111111,9999999).".".$ext;
                $request->file("img.$key")->storeAs('/public/media/items/',$image_name);
                $item->file=$image_name;
            }
            $item->title= $request->title[$key];
            $item->description= $request->description[$key];
            $item->price= $request->price[$key];
            $item->qty= $request->qty[$key];
            $item->date= $request->date[$key];

            $item->save();



        }
        $request->session()->flash('success','Record Save Successfully');
       return redirect()->route('index');
    }


}
