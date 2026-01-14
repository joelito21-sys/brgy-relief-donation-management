@extends('admin.reports.pdf.layout')

@section('content')
<h2 class="mb-20">Distribution Records</h2>

@if(isset($distributions) && count($distributions) > 0)
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Request ID</th>
            <th>Distributed By</th>
            <th>Distribution Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($distributions as $distribution)
        <tr>
            <td>{{ $distribution->id }}</td>
            <td>{{ $distribution->relief_request_id ?? 'N/A' }}</td>
            <td>{{ $distribution->distributedBy->name ?? 'N/A' }}</td>
            <td>{{ $distribution->distribution_date->format('M d, Y') }}</td>
            <td>{{ ucfirst($distribution->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="report-info">
    <p><strong>Total Records:</strong> {{ count($distributions) }}</p>
</div>
@else
<p>No distribution records found for the selected date range.</p>
@endif
@endsection