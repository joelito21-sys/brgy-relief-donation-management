@extends('admin.reports.pdf.layout')

@section('content')
<h2 class="mb-20">Relief Request Records</h2>

@if(isset($requests) && count($requests) > 0)
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Resident</th>
            <th>Family Members</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($requests as $request)
        <tr>
            <td>{{ $request->id }}</td>
            <td>{{ $request->resident->name ?? 'N/A' }}</td>
            <td>{{ $request->family_members }}</td>
            <td>{{ $request->created_at->format('M d, Y') }}</td>
            <td>{{ ucfirst(str_replace('_', ' ', $request->status)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="report-info">
    <p><strong>Total Records:</strong> {{ count($requests) }}</p>
</div>
@else
<p>No relief request records found for the selected date range.</p>
@endif
@endsection