<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja.
     * Route: GET /cart
     */
    public function index()
    {
        $cart = $this->getCartData();
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

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

        // 1. Jika User Sedang Login: Simpan ke Database
        if (Auth::check()) {
            $cartItem = CartItem::firstOrNew([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
            ]);

            $newQty = ($cartItem->exists ? $cartItem->quantity : 0) + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Jumlah barang melebihi stok yang tersedia.');
            }

            $cartItem->quantity = $newQty;
            $cartItem->save();
        }

        // 2. Simpan juga ke Session untuk kompatibilitas dan tamu
        $sessionCart = session()->get('cart', []);
        if (isset($sessionCart[$product->id])) {
            $sessionCart[$product->id]['quantity'] += $request->quantity;
        } else {
            $sessionCart[$product->id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => $request->quantity,
            ];
        }
        session()->put('cart', $sessionCart);

        return back()->with('success', "'{$product->name}' berhasil ditambahkan ke keranjang!");
    }

    /**
     * Hapus produk dari keranjang.
     * Route: DELETE /cart/remove/{id}
     */
    public function remove($id)
    {
        // 1. Hapus dari Database jika user login
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->delete();
        }

        // 2. Hapus dari Session
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Helper mengambil isi keranjang secara konsisten:
     * Jika login -> utamakan dari Database.
     * Jika tamu -> ambil dari Session.
     */
    public static function getCartData(): array
    {
        if (Auth::check()) {
            $items = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get();

            $cart = [];
            foreach ($items as $item) {
                if ($item->product) {
                    $cart[$item->product_id] = [
                        'id'       => $item->product->id,
                        'name'     => $item->product->name,
                        'price'    => $item->product->price,
                        'image'    => $item->product->image,
                        'quantity' => $item->quantity,
                    ];
                }
            }

            // Sync kembali ke session
            session()->put('cart', $cart);
            return $cart;
        }

        return session()->get('cart', []);
    }
}
