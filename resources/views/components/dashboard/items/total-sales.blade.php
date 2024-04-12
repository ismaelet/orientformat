@php
    use App\Models\Ecommerce\Order;

    $newSales = Order::join('ecommerce_carts', 'ecommerce_orders.cartId', '=', 'ecommerce_carts.id')
        ->where('ecommerce_carts.statusId', '>', 0)
        ->where('ecommerce_orders.time', '>=', now()->subMonth())
        ->where('ecommerce_orders.time', '<=', now())
        ->count();

    $oldSales = Order::join('ecommerce_carts', 'ecommerce_orders.cartId', '=', 'ecommerce_carts.id')
        ->where('ecommerce_carts.statusId', '>', 0)
        ->where('ecommerce_orders.time', '>=', now()->subMonth()->subMonth())
        ->where('ecommerce_orders.time', '<', now()->subMonth())
        ->count();

    $difference = $newSales - $oldSales;
    $differencePercentage = $oldSales > 0 ? ($difference / $oldSales) * 100 : 0;
    $formattedDifferencePercentage = number_format($differencePercentage, 2, ',', '.');
@endphp

<x-dashboard.item title="Vendite Totali" subtitle="negli ultimi 30 giorni" icon="credit-card">

    <x-slot name="value">
        {{ $newSales > 0 ? '+' . $newSales : 0 }}
    </x-slot>

    <x-slot name="footerNotes">
        <span class="{{ $difference >= 0 ? 'text-success' : 'text-error' }}">
            {{ $difference >= 0 ? '+' . $formattedDifferencePercentage : $formattedDifferencePercentage }}%
        </span>

        rispetto al mese precedente
    </x-slot>

</x-dashboard.item>
