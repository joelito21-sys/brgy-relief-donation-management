@extends('admin.layouts.app')

@section('title', 'Activity Logs - ' . $reliefRequest->request_number)

@push('styles')
<style>
    .activity-item {
        position: relative;
        padding-left: 2rem;
        padding-bottom: 1.5rem;
        border-left: 2px solid #e9ecef;
    }
    
    .activity-item:last-child {
        border-left-color: transparent;
    }
    
    .activity-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 0;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background-color: #0d6efd;
        border: 2px solid #fff;
    }
    
    .activity-item .activity-content {
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        padding: 1rem;
        position: relative;
    }
    
    .activity-item .activity-content::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 12px;
        width: 8px;
        height: 8px;
        background-color: #f8f9fa;
        transform: rotate(45deg);
    }
    
    .activity-item .activity-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }
    
    .activity-item .activity-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .activity-item .activity-time {
        color: #6c757d;
        font-size: 0.8rem;
    }
    
    .activity-item .activity-details {
        font-size: 0.9rem;
    }
    
    .activity-item .activity-details table {
        width: 100%;
        font-size: 0.85rem;
    }
    
    .activity-item .activity-details th {
        width: 30%;
        padding: 0.25rem 0;
        vertical-align: top;
        color: #6c757d;
    }
    
    .activity-item .activity-details td {
        padding: 0.25rem 0;
    }
    
    .badge-created { background-color: #198754; }
    .badge-updated { background-color: #0d6efd; }
    .badge-deleted { background-color: #dc3545; }
    .badge-activity { background-color: #6f42c1; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Activity Logs</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.relief-requests.index') }}">Relief Requests</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.relief-requests.show', $reliefRequest->id) }}">#{{ $reliefRequest->request_number }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Activity Logs</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.relief-requests.show', $reliefRequest->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Request
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Request #{{ $reliefRequest->request_number }} - Activity Logs</h5>
                <div class="text-muted">
                    <span class="badge bg-primary">{{ $activities->total() }} activities found</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($activities->isEmpty())
                <div class="text-center py-5">
                    <div class="text-muted mb-3">
                        <i class="fas fa-history fa-3x"></i>
                    </div>
                    <h5>No activity logs found</h5>
                    <p class="text-muted">There is no activity to display for this request yet.</p>
                </div>
            @else
                <div class="timeline">
                    @foreach($activities as $activity)
                        <div class="activity-item">
                            <div class="activity-content">
                                <div class="activity-header">
                                    <div>
                                        <span class="badge 
                                            @if($activity->event === 'created') bg-success
                                            @elseif($activity->event === 'updated') bg-primary
                                            @elseif($activity->event === 'deleted') bg-danger
                                            @else bg-purple @endif">
                                            {{ ucfirst($activity->event) }}
                                        </span>
                                        <span class="ms-2">
                                            @if($activity->causer)
                                                {{ $activity->causer->name }}
                                            @else
                                                System
                                            @endif
                                        </span>
                                    </div>
                                    <div class="text-muted small">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                
                                @if($activity->description === 'Bulk action' && $activity->properties->has('action'))
                                    <div class="activity-title">
                                        {{ ucfirst(str_replace('_', ' ', $activity->properties->get('action'))) }}
                                    </div>
                                    <div class="activity-details mt-2">
                                        <table>
                                            @if($activity->properties->has('ip'))
                                                <tr>
                                                    <th>IP Address:</th>
                                                    <td>{{ $activity->properties->get('ip') }}</td>
                                                </tr>
                                            @endif
                                            @if($activity->properties->has('user_agent'))
                                                <tr>
                                                    <th>User Agent:</th>
                                                    <td>{{ $activity->properties->get('user_agent') }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                @elseif($activity->description === 'updated' && $activity->properties->has('attributes'))
                                    <div class="activity-details mt-2">
                                        <table>
                                            @php
                                                $old = $activity->properties->get('old', []);
                                                $new = $activity->properties->get('attributes', []);
                                                $ignored = ['updated_at'];
                                                $changed = [];
                                                
                                                foreach ($new as $key => $value) {
                                                    if (in_array($key, $ignored)) continue;
                                                    
                                                    $oldValue = $old[$key] ?? null;
                                                    
                                                    if ($oldValue != $value) {
                                                        $changed[$key] = [
                                                            'old' => $oldValue,
                                                            'new' => $value
                                                        ];
                                                    }
                                                }
                                            @endphp
                                            
                                            @if(count($changed) > 0)
                                                @foreach($changed as $field => $values)
                                                    <tr>
                                                        <th>{{ ucwords(str_replace('_', ' ', $field)) }}:</th>
                                                        <td>
                                                            @if(is_array($values['old']) || is_object($values['old']))
                                                                <span class="text-danger">{{ json_encode($values['old']) }}</span> 
                                                                <i class="fas fa-arrow-right mx-2 text-muted"></i> 
                                                                <span class="text-success">{{ json_encode($values['new']) }}</span>
                                                            @else
                                                                @if($values['old'] === null || $values['old'] === '')
                                                                    <span class="text-success">{{ $values['new'] ?? 'N/A' }}</span>
                                                                @elseif($values['new'] === null || $values['new'] === '')
                                                                    <span class="text-danger">{{ $values['old'] ?? 'N/A' }}</span>
                                                                    <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                                                    <span class="text-muted">(removed)</span>
                                                                @else
                                                                    <span class="text-danger">{{ $values['old'] ?? 'N/A' }}</span> 
                                                                    <i class="fas fa-arrow-right mx-2 text-muted"></i> 
                                                                    <span class="text-success">{{ $values['new'] ?? 'N/A' }}</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="2">No changes detected</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                @else
                                    <div class="activity-details mt-2">
                                        <table>
                                            <tr>
                                                <th>Action:</th>
                                                <td>{{ $activity->description }}</td>
                                            </tr>
                                            @if($activity->properties->count() > 0)
                                                @foreach($activity->properties as $key => $value)
                                                    @if(!in_array($key, ['old', 'attributes']))
                                                        <tr>
                                                            <th>{{ ucfirst($key) }}:</th>
                                                            <td>
                                                                @if(is_array($value) || is_object($value))
                                                                    {{ json_encode($value) }}
                                                                @else
                                                                    {{ $value }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $activities->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format JSON properties for better display
        document.querySelectorAll('.json-property').forEach(function(element) {
            try {
                const json = JSON.parse(element.textContent);
                element.textContent = JSON.stringify(json, null, 2);
            } catch (e) {
                // Not valid JSON, leave as is
            }
        });
    });
</script>
@endpush
