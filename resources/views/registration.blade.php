<!DOCTYPE html>
<html>
<head>
    <title>Register Startup</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; }
        .container { width: 450px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        label { font-weight: bold; margin-top: 10px; display: block; }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; background: #28a745; color: white; border: none; padding: 12px; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Startup Registration</h2>

        @if(session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif

        <form action="{{ route('startups.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if(!empty($startupNames))
                <select name="startup_name" required>
                    <option value="">Select Startup</option>
                    @foreach($startupOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                    <option value="__new__">Other (Enter Manually)</option>
                </select>

                <input type="text" name="custom_startup_name" id="customStartupName" placeholder="Enter Startup Name" style="display:none; margin-top:10px;" />
            @else
                <input type="text" name="startup_name" placeholder="Enter Startup Name" required>
            @endif

            </select>

            <label for="founder_name">Founder Name</label>
            <input type="text" name="founder_name" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="phone">Phone</label>
            <input type="text" name="phone" required>

            <label for="website">Website</label>
            <input type="url" name="website">

            <label for="sector">Sector</label>
            <select name="sector" required>
                <option value="">Select Sector</option>
                @foreach($sectors as $sector)
                    <option value="{{ $sector }}">{{ $sector }}</option>
                @endforeach
            </select>

            <label for="deck">Upload Pitch Deck (PDF)</label>
            <input type="file" name="deck" accept="application/pdf" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
