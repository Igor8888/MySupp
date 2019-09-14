<?php

namespace App;

use DB, Session, Cart;
use Illuminate\Database\Eloquent\Model;
use App\Categorie;
use Illuminate\Http\UploadedFile;



class product extends Model
{
    static public function getProduct($curl, &$data , $request)
    {
        //sort method
        $item = 'p_name';
        $sortby = '';
        if (!empty($request['sortProduct'])){
            $item = 'price';
            $sortby =$request['sortProduct'];
        }

        //products
        $products = DB::table('products AS p')
            ->join('categories AS c', 'c.id', '=', 'p.c_id')
            ->select('p.*', 'c.c_url', 'c.c_name')
            ->where('c.c_url', '=', $curl)
            ->orderby($item , $sortby)
            ->paginate(3);
        $products_array = $products;
        $products_array = $products_array->toArray();
        //recent items
        $recent = DB::table('products AS p')
            ->join('categories AS c', 'c.id', '=', 'p.c_id')
            ->select('p.*', 'c.*')
            ->orderBy('p_name', 'desc')
            ->limit(3)
            ->offset(0)
            ->get()
            ->toArray();
        if ($recent) {
            $data['recent'] = $recent;
        }
        if (empty($products_array['data'])) {
            abort(404);
        }
        if ($products_array) {
            $data['products'] = $products;
            $data['products_array'] = $products_array;
            $data['title'] = $products_array['data'][0]->c_name;

        } else {

            $categories = DB::table('categories AS c')
                ->select('c.*')
                ->where('c.c_url', '=', $curl)
                ->get()->toArray();
            if ($categories) {
                $data['title'] = $categories[0]->c_name;
            }

        }


    }

    //get each item info
    static public function getSingle($purl, &$data)
    {
        $single = DB::table('products AS p')
            ->join('categories AS c', 'c.id', '=', 'p.c_id')
            ->join('product-images AS pi', 'pi.p_id', '=', 'p.id')
            ->select('p.*', 'c.c_url', 'c.c_name', 'pi.*')
            ->where('p.p_url', '=', $purl)
            ->get()->toArray();

        if ($single && $single['0']) {
            $data['single'] = $single;
            $data['title'] = $single[0]->p_name;
        } else {


            $single = DB::table('products AS p')
                ->join('categories AS c', 'c.id', '=', 'p.c_id')
                ->select('p.*', 'c.c_url', 'c.c_name')
                ->where('p.p_url', '=', $purl)
                ->get()->toArray();
            if (!empty($single)) {
                $data['single'] = $single;
                $data['title'] = $single[0]->p_name;
            } else {
                abort(404);
            }
        }


    }

    static public function addToCart($pid, $qty)
    {
        if (!empty($pid) && is_numeric($pid)) {
            if (!empty($qty) && is_numeric($qty) && $qty > 0) {
                if ($product = self::find($pid)) {
                    $product = $product->toArray();
                    $main_image =explode(',', $product['p_image']);
                    $main_image = !empty($main_image) ? $main_image[0] : '';

                    Cart::add($pid, $product['p_name'], $product['price'], $qty, ['content' => $product['p_content'], 'image' => $main_image]);
                    Session::flash('sm', $product['p_name'] . ' added to cart');
                    Session::flash('sb', 'Good choice');
                    Session::flash('type', 'success');


                }
            }
        }
    }

    static public function updateCart($pid, $qty)
    {
        if (!empty($pid) && is_numeric($pid)) {
            if ($product = self::find($pid)) {
                $product = $product->toArray();
                Cart::update($pid, array(
                    'quantity' => array(
                        'relative' => false,
                        'value' => $qty
                    ),
                ));
                Session::flash('sm', $product['p_name'] . ' added to cart');
                Session::flash('sb', 'Good choice');


            }

        }
    }

    //manage the products at the cpanel
    static public function ManageProducts(&$data)
    {


            $data['products'] =  DB::table('products AS p')
                ->join('categories AS c', 'c.id', '=', 'p.c_id')
                ->select('c.c_name' , 'p.*')
                ->get()
                ->toArray();

    }

    //save new product
    static public function save_new($request){

        $image_name = 'noimage.png';


        if($files=$request->file('image')){
            $image_name=array();
            foreach($files as $file){
                $name=date('Y.m.d.H.i.s') . '-' . $file->getClientOriginalName();

                $image_name[]=$name;
                $file->move(public_path() . '/images/' , $name);
            }
            $image_name = implode(',',$image_name);


        }


        $product = new self();
        $product->c_id = $request['category'];
        $product->p_name = $request['name'];
        $product->p_content = $request['description'];
        $product->p_url = $request['url'];
        $product->p_image = $image_name;
        $product->price = $request['price'];
        $product->save();
        Session::flash('sm' , 'Product added succcessfuly');
        Session::flash('type' , 'success');
    }

    //update product cpanel
    public static function update_item($request , $id){
        $image_name = 'noimage.png';


        if($files=$request->file('image')){
            $image_name=array();
            foreach($files as $file){
                $name=date('Y.m.d.H.i.s') . '-' . $file->getClientOriginalName();

                $image_name[]=$name;
                $file->move(public_path() . '/images/',$name);
            }
            $image_name = implode(',',$image_name);


        }


        $product = self::find($id);
        $product->c_id = $request['category'];
        $product->p_name = $request['name'];
        $product->p_content = $request['description'];
        $product->p_url = $request['url'];
        $product->p_image = $image_name;
        $product->price = $request['price'];
        $product->save();
        Session::flash('sm' , 'Product updated succcessfuly');
        Session::flash('type' , 'success');
    }




}



