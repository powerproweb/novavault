<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Cart — {{ $vendor->business_name }}</h2></x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4">
        @if(count($items))
            <div class="bg-surface border border-stroke rounded-nv overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-navy-800 text-gray-400 text-left">
                        <tr><th class="p-3">Product</th><th class="p-3">Price</th><th class="p-3">Qty</th><th class="p-3">Subtotal</th><th class="p-3"></th></tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr class="border-t border-stroke">
                                <td class="p-3 font-medium">{{ $item['product']->title }}</td>
                                <td class="p-3">${{ number_format($item['product']->price, 2) }}</td>
                                <td class="p-3">{{ $item['qty'] }}</td>
                                <td class="p-3 text-gold">${{ number_format($item['line_total'], 2) }}</td>
                                <td class="p-3">
                                    <form method="POST" action="{{ route('store.cart.remove', [$vendor->slug, $item['product']]) }}">@csrf @method('DELETE')
                                        <button class="text-red-400 hover:underline text-xs">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-stroke bg-navy-800">
                            <td colspan="3" class="p-3 font-semibold text-right">Total</td>
                            <td class="p-3 font-bold text-gold text-lg">${{ number_format($total, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <a href="{{ route('store.show', $vendor->slug) }}" class="text-nv-blue hover:underline text-sm">&larr; Continue Shopping</a>
                <form method="POST" action="{{ route('store.checkout', $vendor->slug) }}">
                    @csrf
                    <button class="bg-gold text-navy-950 px-8 py-3 rounded-nv-sm font-bold hover:bg-gold-dark">Place Order</button>
                </form>
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <p>Your cart is empty.</p>
                <a href="{{ route('store.show', $vendor->slug) }}" class="text-nv-blue hover:underline mt-2 inline-block">Browse Products</a>
            </div>
        @endif
    </div>
</x-app-layout>
