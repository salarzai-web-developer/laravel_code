<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class ProductController extends Controller
{


     public function index(Request $request){




              return view('product');
     }


     public function store(Request $request){



                   $image= $request->file('image');
                    $name=time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('images'), $name);
                   $insert=Product::create([

                    'product_name'=> $request->product,
                    'product_image'=>$name,

                 ]);


                 if($insert){



                        return response()->json([  'message'=>"Record inserted successfully!",'status'=>true]);

                 }else{


                    return response()->json([  'message'=>"Recored not inserted successfully!",'status'=>false]);


                 }
     }


         public function getData(){


               $products=Product::all();


               return response()->json(['status'=>true,'data'=>$products]);
         }



         public function deletemethod($id){

              $product=Product::find($id);

            // Attempt to delete the product
              $result = $product->delete();

            // Check if the deletion was successful
            if ($result) {
                return response()->json(['status' => 1, 'message' => 'Product deleted successfully']);
            } else {
                return response()->json(['status' => 0, 'message' => 'Failed to delete product']);
            }
        }


        public function edit($id){


                  $products=Product::find($id);

                return response( )->json(['status'=>1,'data'=>$products]);
        }


        public function update(Request $request,$id)
{


    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $name);
    }

    $update = Product::where('id', $id)->update([
        'product_name' => $request->product,
        'product_image' => $name,
    ]);

    if ($update) {
        return response()->json([
            'message' => "Record updated successfully!",
            'status' => true
        ]);
    } else {
        return response()->json([
            'message' => "Record not updated successfully!",
            'status' => false
        ]);
    }
}

         }



