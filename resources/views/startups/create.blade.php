```blade
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Register Your Startup</h2>

    <form action="{{ route('startups.store') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Startup Name</label>
                <input type="text" name="startup_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Founder Name</label>
                <input type="text" name="founder_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Website (optional)</label>
                <input type="url" name="website" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Sector</label>
                <input type="text" name="sector" class="form-control" required>
            </div>

            <div class="col-12">
                <label class="form-label">Pitch Deck (PDF only)</label>
                <input type="file" name="pitch_deck" accept="application/pdf" class="form-control" required>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success px-4">Proceed to Payment ₹499</button>
        </div>
    </form>
</div>
@endsection
```
