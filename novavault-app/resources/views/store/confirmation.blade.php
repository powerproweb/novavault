<x-app-layout>
    <div class="py-16 max-w-2xl mx-auto px-4 text-center">
        <div class="text-6xl mb-4">&#10003;</div>
        <h2 class="text-2xl font-bold text-gold">Order Confirmed!</h2>
        <p class="text-gray-400 mt-2">Order #{{ $order->id }} at {{ $vendor->business_name }}</p>

        <div class="mt-8 bg-surface border border-stroke rounded-nv p-6 text-left">
            <table class="w-full text-sm">
                @foreach($order->items as $item)
                    <tr class="border-b border-stroke">
                        <td class="py-2">{{ $item->product->title }} &times; {{ $item->qty }}</td>
                        <td class="py-2 text-right text-gold">${{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="py-3 font-bold">Total</td>
                    <td class="py-3 text-right font-bold text-gold text-lg">${{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="mt-6 bg-nv-blue/10 border border-nv-blue/30 rounded-nv-sm p-4 text-nv-blue text-sm">
            Tokens have been credited to your wallet!
        </div>

        <div class="mt-8">
            <a href="{{ route('store.show', $vendor->slug) }}" class="text-nv-blue hover:underline">Continue Shopping</a>
        </div>
    </div>
</x-app-layout>
