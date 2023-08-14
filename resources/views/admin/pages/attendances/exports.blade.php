@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Advanced Export Options</div>
                <div class="card-body" id="search_advanced_export">
                    <form action="{{ route('exports.export') }}" method="POST">
                        @csrf
                        <div class="form-group m-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group m-3">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="form-group m-3">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                        <div class="form-group form-check m-3">
                            <input type="checkbox" class="form-check-input" id="include_check_in" name="include_check_in">
                            <label class="form-check-label" for="include_check_in">Include Check-In Data</label>
                        </div>
                        <div class="form-group form-check m-3">
                            <input type="checkbox" class="form-check-input" id="include_check_out" name="include_check_out">
                            <label class="form-check-label" for="include_check_out">Include Check-Out Data</label>
                        </div>
                        <div class="form-group form-check m-3">
                            <input type="checkbox" class="form-check-input" id="include_records" name="include_records">
                            <label class="form-check-label" for="include_records">Include Records Table</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Export Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
        var route = "{{ url('admin/attendance/export/search/user') }}";

        $('#name').typeahead({
    source: function (query, process) {
        return $.get(route, { query: query }, function (data) {
            console.log(data); // Debugging
            var names = data.map(item => item.nama);
            return process(names);
        });
    }
});
    </script>   
@endsection



