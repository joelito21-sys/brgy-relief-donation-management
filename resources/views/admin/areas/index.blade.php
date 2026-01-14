@extends('admin.layouts.app')

@section('title', 'Areas Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 font-weight-bold text-primary">Areas Management</h5>
                    <a href="{{ route('admin.areas.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Add New Area
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($areas as $area)
                                    <tr>
                                        <td>
                                            <strong>{{ $area->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $area->code }}</span>
                                        </td>
                                        <td>{{ $area->description ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $area->is_active ? 'success' : 'secondary' }}">
                                                {{ $area->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $area->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.areas.edit', $area) }}" 
                                                   class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.areas.destroy', $area) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this area?')"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No areas found.</p>
                                            <a href="{{ route('admin.areas.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus mr-1"></i> Create First Area
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $areas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
