<?php

namespace App\Http\Livewire;
use \App\Models\shoppingCart as Cart;
use Livewire\Component;

class Shoppingcart extends Component
{
    public $cartitems, $sub_total, $total, $tax;
    public function render()
    {
        $this->cartitems = Cart::with('product')->where(['user_id'=>auth()->user()->id])->get();
        $this->sub_total = 0;
        $this->total = 0;
        $this->tax = 0;

        foreach($this->cartitems as $item)
            {
                $this->sub_total += $item->product->price * $item->quantity;
            }
        $this->total = $this->sub_total - $this->tax;
        return view('livewire.shoppingcart');
    }
    public function incrementQty($id)
    {
        $cart = Cart::whereId($id)->first();
        $cart->quantity += 1;
        $cart->save();

        session()->flash('success', 'Product Quality Updated !!!');

    }
    public function decrementQty($id)
    {
        $cart = Cart::whereId($id)->first();
        if($cart->quantity > 1)
        {
            $cart->quantity -= 1;
            $cart->save();
            $this->emit('updateCartCount');
            session()->flash('success', 'Product Quality Updated !!!');
        }
        else{
            session()->flash('info', 'You cannot have less then 1 Quantity');
        }
    }

    public function removeItem($id)
    {
        $cart = Cart::whereId($id)->first();
        if($cart)
        {
            $cart->delete();
            $this->emit('updateCartCount');

        }
        session()->flash('sussess', 'Item Removed Successfully !!!');
    }

}
