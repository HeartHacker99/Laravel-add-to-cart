<?php

namespace App\Http\Livewire;

use App\Models\products;
use App\Models\shoppingCart;
use Livewire\Component;


class Productlist extends Component
{
    public $products;
    public function render()
    {
        $this->products = products::get();
        return view('livewire.productlist');
    }

    public function addToCart($id)
    {
        if(auth()->user())
        {
            // Add to cart
            $data = [
                'product_id' => $id,
                'user_id' => auth()->user()->id
            ];

            shoppingCart::updateOrCreate($data);

//            Elequant Standart Method

//           $shopping = new shoppingCart();
//            $shopping->product_id = $id;
//            $shopping->user_id = auth()->user()->id;
//            $shopping->save();


                $this->emit('updateCartCount');

            session()->flash('success', 'Product added to the cart successfully.');
        }
        else
        {
            return $this->redirect(route('login'));
        }
    }


}
