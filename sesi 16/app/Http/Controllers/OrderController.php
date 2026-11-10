<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman checkout.
     * Route: GET /checkout
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        if (!view()->exists('checkout.index')) {
            return response()->json([
                'route'       => '/checkout',
                'page'        => 'Checkout / Form Pemesanan',
                'message'     => 'Route /checkout berhasil berjalan!',
                'keranjang'   => empty($cart) ? 'Keranjang masih kosong' : $cart,
                'total_bayar' => 'Rp ' . number_format($total, 0, ',', '.')
            ]);
        }

        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('warning', 'Keranjang belanja kosong. Silakan pilih produk terlebih dahulu.');
        }

        return view('checkout.index', compact('cart', 'total'));
    }

    /**
     * Proses checkout dan simpan ke tabel orders sesi sebelumnya.
     * Route: POST /checkout/process
     */
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        DB::beginTransaction();
        try {
            $lastOrderId = null;

            foreach ($cart as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok produk '{$product->name}' tidak mencukupi.");
                }

                $order = Order::create([
                    'user_id'    => auth()->id() ?? 1,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'total'      => $item['price'] * $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
                $lastOrderId = $order->order_id;
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('checkout.success', $lastOrderId)
                ->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman detail konfirmasi order berhasil.
     * Route: GET /checkout/success/{order}
     */
    public function success($orderId)
    {
        $order = Order::with(['product', 'user'])->findOrFail($orderId);

        if (!view()->exists('checkout.success')) {
            return response()->json([
                'route'   => "/checkout/success/{$orderId}",
                'message' => 'Order berhasil diproses!',
                'data'    => $order
            ]);
        }

        return view('checkout.success', compact('order'));
    }
}
