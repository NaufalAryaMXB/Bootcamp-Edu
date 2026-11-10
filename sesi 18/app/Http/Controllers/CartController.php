<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja.
     * Route: GET /cart
     */
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        if (!view()->exists('cart.index')) {
            return response()->json([
                'route'       => '/cart',
                'page'        => 'Keranjang Belanja',
                'message'     => 'Route /cart berhasil berjalan!',
                'total_item'  => count($cart),
                'total_harga' => 'Rp ' . number_format($total, 0, ',', '.'),
                'items'       => $cart
            ]);
        }

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Tambahkan produk ke keranjang belanja.
     * Route: POST /cart/add
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', "'{$product->name}' berhasil ditambahkan ke keranjang!");
    }

    /**
     * Hapus produk dari keranjang.
     * Route: DELETE /cart/remove/{id}
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
