@extends('admin.reports.pdf.layout')

@section('content')
<h2 class="mb-20">Donation Records</h2>

@if(isset($donations) && count($donations) > 0)
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Donor</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donations as $donation)
        <tr>
            <td>{{ $donation->id }}</td>
            <td>{{ $donation->donor->name ?? 'N/A' }}</td>
            <td>₱{{ number_format($donation->amount, 2) }}</td>
            <td>{{ $donation->created_at->format('M d, Y') }}</td>
            <td>{{ ucfirst($donation->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="report-info">
    <p><strong>Total Donations:</strong> ₱{{ number_format($total_amount ?? 0, 2) }}</p>
    <p><strong>Total Records:</strong> {{ count($donations) }}</p>
</div>
@else
<p>No donation records found for the selected date range.</p>
@endif
@endsection