<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\shoppingCart;

class CartCounter extends Component
{
    public $this = 0;

    protected $listeners = ['updateCartCount' => 'getCartItemsCount'];

    public function render()
    {
        $this->getCartItemsCount();
        return view('livewire.cart-counter');
    }

    public function getCartItemsCount()
    {
        $this->total = shoppingCart::whereUserId(auth()->user()->id)->count();
    }
}
