@extends('admin.reports.pdf.layout')

@section('content')
<h2 class="mb-20">Donor Records</h2>

@if(isset($donors) && count($donors) > 0)
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donors as $donor)
        <tr>
            <td>{{ $donor->id }}</td>
            <td>{{ $donor->name }}</td>
            <td>{{ $donor->email ?? 'N/A' }}</td>
            <td>{{ $donor->phone ?? 'N/A' }}</td>
            <td>{{ $donor->created_at->format('M d, Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="report-info">
    <p><strong>Total Records:</strong> {{ count($donors) }}</p>
</div>
@else
<p>No donor records found for the selected date range.</p>
@endif
@endsection