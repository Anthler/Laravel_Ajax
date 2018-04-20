<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ListController extends Controller
{
    public function index(){

    	$items = Item::orderBy('created_at','desc')->get();
    	return view('index', ['items'=>$items]);
    }

    public function create(Request $request){
    	
    	$item = new Item;
    	$item->item = $request->text;
    	$item->save();
    	return 'done';
    }

    public function delete(Request $request){

    	Item::where('id',$request->id)->delete();
    	return $request->all();

    }

    public function update(Request $request){
    	
    	$item = Item::find($request->id);

    	$item->item = $request->item;
    	$item->save();

    }

    public function search(Request $request){
    	

    	$term = $request->term;
    	$items = Item::where('item', 'LIKE', '%'.$term.'%')->get();
    	if(count($items)==0){
    		 $searchResult[] = 'No data found';
    	}else{
    		foreach($items as $item){
    			$searchResult[] = $item->item;
    		}
    	}
    	return $searchResult;
    }
}
