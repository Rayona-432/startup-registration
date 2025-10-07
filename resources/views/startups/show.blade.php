```blade
@extends('layouts.app')


@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Startup Details</h2>

    <div class="card shadow p-4">
        <h4>{{ $startup->startup_name }}</h4>
        <p><strong>Founder:</strong> {{ $startup->founder_name }}</p>
        <p><strong>Email:</strong> {{ $startup->email }}</p>
        <p><strong>Phone:</strong> {{ $startup->phone }}</p>
        <p><strong>Website:</strong> {{ $startup->website ?? 'N/A' }}</p>
        <p><strong>Sector:</strong> {{ $startup->sector }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $startup->payment_status == 'paid' ? 'success' : 'warning' }}">
                {{ ucfirst($startup->payment_status) }}
            </span>
        </p>
        <p><strong>Pitch Deck:</strong>
            <a href="{{ asset('storage/'.$startup->pitch_deck_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm">View PDF</a>
        </p>

        <div class="mt-4">
            <a href="{{ route('startups.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('startups.edit', $startup->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
</div>
@endsection
```
