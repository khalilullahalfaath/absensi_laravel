@extends('layout/app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Attendance Form</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="/attendance/create">
                        @csrf
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="time">Time</label>
                            <input type="time" name="time" id="time" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="attendance_type">Attendance Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="attendance_type" id="checkin" value="checkin" required>
                                <label class="form-check-label" for="checkin">Check-in</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="attendance_type" id="checkout" value="checkout" required>
                                <label class="form-check-label" for="checkout">Check-out</label>
                            </div>
                        </div>
                        <div class="text-center mt-3 mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
