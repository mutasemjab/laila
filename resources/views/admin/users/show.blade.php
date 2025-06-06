@extends('layouts.admin')
@section('title')
    {{ __('messages.Show') }} {{ __('messages.Customers') }}
@endsection

@section('css')
<style>
    /* Normal view styling */
    .visitor-badge-container {
        max-width: 380px;
        margin: 0 auto;
    }

    .visitor-badge {
        border: 1px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        background-color: white;
    }

    .badge-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
    }

    .logo img {
        max-height: 50px;
    }

    .event-name h2 {
        margin: 0;
        font-size: 18px;
        color: #333;
        text-align: center;
    }

    .badge-category {
        text-align: center;
        padding: 8px;
        font-weight: bold;
        color: white;
        font-size: 16px;
    }

    .badge-category-speaker {
        background-color: #dc3545;
    }

    .badge-category-participant {
        background-color: #007bff;
    }

    .badge-category-exhibition {
        background-color: #28a745;
    }

    .badge-body {
        padding: 20px;
    }

    .attendee-name h3 {
        margin: 0 0 10px 0;
        font-size: 22px;
        color: #333;
    }

    .attendee-company h4 {
        margin: 0 0 5px 0;
        font-size: 18px;
        color: #555;
    }

    .attendee-country h5 {
        margin: 0 0 15px 0;
        font-size: 16px;
        color: #777;
    }

    .attendee-contact {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }

    .badge-barcode {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed #ccc;
    }

    .simple-barcode {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        height: 70px;
        margin: 10px 0;
    }

    .barcode-line {
        width: 2px;
        background-color: #000;
        margin: 0 1px;
    }

    .barcode-text {
        margin-top: 5px;
        font-size: 14px;
        letter-spacing: 1px;
    }

    /* Print-specific styles */
    @media print {
        body * {
            visibility: hidden;
        }

        .visitor-badge-container, .visitor-badge-container * {
            visibility: visible;
        }

        .visitor-badge-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .visitor-badge {
            width: 3.5in; /* Standard badge width */
            height: 5in; /* Standard badge height */
            box-shadow: none;
            border: 1px solid #000;
        }

        .badge-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: calc(100% - 120px); /* Adjust based on header height */
        }
    }
</style>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4>User Details</h4>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>User Information</h5>
                            <p><strong>ID:</strong> {{ $user->id }}</p>
                            <p><strong>Title:</strong> {{ $user->title }}</p>
                            <p><strong>Name:</strong> {{ $user->first_name }} {{ $user->second_name }} {{ $user->last_name }}</p>
                            <p><strong>Company:</strong> {{ $user->company }}</p>
                            <p><strong>Country:</strong> {{ $user->country }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Category:</strong>
                                @if($user->category == 1)
                                    Speaker
                                @elseif($user->category == 2)
                                    Participant
                                @else
                                    Exhibition
                                @endif
                            </p>
                            <p><strong>Created At:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</p>

                            <div class="mt-3">
                                {{-- <a href="{{ route('attendance.user.logs', $user->id) }}" class="btn btn-info">View Attendance Logs</a> --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-center">Preview Visitor Badge</h5>
                            <div class="mt-3">
                                <button class="btn btn-success w-100 mb-3" onclick="window.print()">Print Visitor Badge</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visitor Badge Design (Hidden in normal view, visible when printing) -->
    <div class="row mt-4 justify-content-center">
        <div class="col-md-8">
            <div class="visitor-badge-container">
                <div class="visitor-badge">
                    <div class="badge-header">
                        <div class="logo">
                            <img src="{{ asset('logo.png') }}" alt="Company Logo" onerror="this.style.display='none'">
                        </div>
                        <div class="event-name">
                            <h2>EVENT NAME 2025</h2>
                        </div>
                    </div>

                    <div class="badge-category
                        @if($user->category == 1)
                            badge-category-speaker
                        @elseif($user->category == 2)
                            badge-category-participant
                        @else
                            badge-category-exhibition
                        @endif
                    ">
                        @if($user->category == 1)
                            SPEAKER
                        @elseif($user->category == 2)
                            PARTICIPANT
                        @else
                            EXHIBITION
                        @endif
                    </div>

                    <div class="badge-body text-center">
                        <div class="attendee-name">
                            <h3>{{ $user->title }} {{ $user->first_name }} {{ $user->second_name }} {{ $user->last_name }}</h3>
                        </div>
                        <div class="attendee-company">
                            <h4>{{ $user->company }}</h4>
                        </div>
                        <div class="attendee-country">
                            <h5>{{ $user->country }}</h5>
                        </div>
                        <div class="attendee-contact">
                            <p>{{ $user->phone }}</p>
                        </div>
                        <div class="badge-barcode text-center">
                            <svg id="barcode"></svg>
                            <p class="barcode-text">{{ $user->barcode }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<!-- Add this before your closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        JsBarcode("#barcode", "{{ $user->barcode }}", {
            format: "CODE128",
            lineColor: "#000",
            width: 2,
            height: 60,
            displayValue: false
        });
    });
</script>
@endsection
