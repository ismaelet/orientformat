@php
    use App\Models\Ecommerce\Order;

    $newRevenue = Order::join('ecommerce_carts', 'ecommerce_orders.cartId', '=', 'ecommerce_carts.id')
        ->where('ecommerce_carts.statusId', '>', 0)
        ->where('ecommerce_orders.time', '>=', now()->subMonth())
        ->where('ecommerce_orders.time', '<=', now())
        ->sum('ecommerce_orders.staticFullPrice');

    $oldRevenue = Order::join('ecommerce_carts', 'ecommerce_orders.cartId', '=', 'ecommerce_carts.id')
        ->where('ecommerce_carts.statusId', '>', 0)
        ->where('ecommerce_orders.time', '>=', now()->subMonth()->subMonth())
        ->where('ecommerce_orders.time', '<', now()->subMonth())
        ->sum('ecommerce_orders.staticFullPrice');

    $difference = $newRevenue - $oldRevenue;
    $differencePercentage = $oldRevenue > 0 ? ($difference / $oldRevenue) * 100 : 0;
    $formattedNewRevenue = number_format($newRevenue, 2, ',', '.');
    $formattedDifferencePercentage = number_format($differencePercentage, 2, ',', '.');
@endphp

<x-dashboard.item title="Fatturato Totale" subtitle="degli ultimi 30 giorni" icon="money">

    <x-slot name="value">
        € {{ $formattedNewRevenue }}
    </x-slot>

    <x-slot name="footerNotes">
        <span class="{{ $difference >= 0 ? 'text-success' : 'text-error' }}">
            {{ $difference >= 0 ? '+' . $formattedDifferencePercentage : $formattedDifferencePercentage }}%
        </span>

        rispetto al mese precedente
    </x-slot>

</x-dashboard.item>
