<div>
    {{-- The whole world belongs to you. --}}
    @section('title', 'Orders')
    <div class="app-title">
        <div>
            <h1>Orders</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th> Order Number </th>
                            <th> Placed By </th>
                            <th class="text-center"> Total Amount </th>
                            <th class="text-center"> Items Qty </th>
                            <th class="text-center"> Payment Status </th>
                            <th class="text-center"> Status </th>
                            <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->user->fullName }}</td>
                                <td class="text-center">{{ config('settings.currency_symbol') }}{{ round($order->grand_total, 2) }}</td>
                                <td class="text-center">{{ $order->item_count }}</td>
                                <td class="text-center">
                                    @if ($order->payment_status == 1)
                                        <span class="badge badge-success">Completed</span>
                                    @else
                                        <span class="badge badge-danger">Not Completed</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success">{{ $order->status }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Second group">
                                        <a href="{{ route('admin.orders.show', $order->order_number) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
