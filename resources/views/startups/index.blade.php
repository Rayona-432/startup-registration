```blade
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Startup Registrations</h2>
    <div class="text-end mb-3">
        <a href="{{ route('startups.create') }}" class="btn btn-primary">+ Register New Startup</a>
    </div>
    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Startup Name</th>
                <th>Founder</th>
                <th>Email</th>
                <th>Sector</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($startups as $startup)
                <tr>
                    <td>{{ $startup->id }}</td>
                    <td>{{ $startup->startup_name }}</td>
                    <td>{{ $startup->founder_name }}</td>
                    <td>{{ $startup->email }}</td>
                    <td>{{ $startup->sector }}</td>
                    <td>
                        <span class="badge bg-{{ $startup->payment_status == 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($startup->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('startups.show', $startup->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('startups.edit', $startup->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('startups.destroy', $startup->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this startup?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-muted">No startups registered yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
```
