@if (!empty($history))
<table class="w-100">
    <thead>
        <tr>
            <th>Order Id</th>
            <th>Type</th>
            <th>Order Amount</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Expiry Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($history as $item)
            @php
                $c = $item['transaction_type'] == 'debit' ? 'alert-danger' : 'alert-success';
                $order = !empty($item['transaction_order']) ? App\Models\Web\Order::find($item['transaction_order']) : null;
            @endphp
            <tr class="{{ $c }}">
                <td><p class="m-0">{{ $item['transaction_order'] }}</p></td>
                <td><p class="m-0 {{ strtolower($item['transaction_type']) === 'debit' ? 'debit' : 'credit' }}">{{ ucfirst($item['transaction_type']) }}</p></td>
                <td><p class="m-0">{{ $order ? $order->currency . ' ' . number_format($order->order_total, 2) : '-' }}</p></td>
                <td><p class="m-0">{{ strtolower($item['transaction_type']) === 'debit' ? '-' : '+' }} {{ $order ? $order->currency : '' }} {{ number_format($item['transaction_points'], 2) }}</p></td>
                <td><p class="m-0">{{ \Carbon\Carbon::parse($item['created_at'])->format('d M, Y') }}</p></td>
                <td>
                    <p class="m-0">
                        @if($item['transaction_type'] === 'debit')
                            (No Expiry)
                        @else
                            {{ \Carbon\Carbon::parse($item['expiry_date'])->format('d M, Y') }}
                            {{ \Carbon\Carbon::parse($item['expiry_date'])->isPast() ? '(Expired)' : '' }}
                        @endif
                    </p>
                </td>
                <td><p class="m-0">{{ $item['transaction_status'] === 'pending_payment' ? 'Pending' : ucfirst($item['transaction_status']) }}</p></td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <p>No transactions found.</p>
@endif
