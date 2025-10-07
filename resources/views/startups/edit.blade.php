```blade
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Edit Startup Details</h2>

    <form action="{{ route('startups.update', $startup->id) }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        @csrf @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Startup Name</label>
                <input type="text" name="startup_name" class="form-control" value="{{ $startup->startup_name }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Founder Name</label>
                <input type="text" name="founder_name" class="form-control" value="{{ $startup->founder_name }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $startup->email }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $startup->phone }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Website</label>
                <input type="url" name="website" class="form-control" value="{{ $startup->website }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Sector</label>
                <input type="text" name="sector" class="form-control" value="{{ $startup->sector }}" required>
            </div>

            <div class="col-12">
                <label class="form-label">Pitch Deck (optional)</label>
                <input type="file" name="pitch_deck" accept="application/pdf" class="form-control">
                @if($startup->pitch_deck_path)
                    <small class="text-muted d-block mt-1">Current: {{ basename($startup->pitch_deck_path) }}</small>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">Update</button>
        </div>
    </form>
</div>
@endsection
```
