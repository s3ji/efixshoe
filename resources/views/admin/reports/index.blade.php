@extends('layouts.admin.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Reports</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Generate</li>
                    </ol>
                </nav>
            </div>

            <div class="col-md-6 col-md-span-3">

                <form method="POST" action="{{ route('admin.reports.generate') }}">
                    @csrf

                    @if($errors->any())
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    @endif

                    <div class="row">
                        <div class="form-group col-md-12 p-2">
                            <label for="count">Reports:</label>
                            <select name="report" id="report" class="form-select">
                                <option value="bookings">Bookings</option>
                                <option value="" disabled>Vouchers</option>
                            </select>

                            @if ($errors->has('count'))
                                <small class="help-block text-danger">
                                    <strong>{{ $errors->first('count') }}</strong>
                                </small>
                            @endif
                        </div>

                        <br>
                        <div class="form-group col-md-12 p-2">
                            <label for="count">Status:</label>
                            <select name="status" id="status" class="form-select">
                                @foreach ($bookingStatuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <br>

                        <div class="form-group col-md-12 p-2">
                            <label for="date_range">Date Range</label>

                            <select name="date_range" id="date_range" class="form-select">
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="range">This Month</option>
                                <option value="year">This Year</option>
                                <option value="custom">Custom Range</option>
                            </select>

                        </div>

                        <br>

                        <div class="form-group col-md-6 p-2" id="custom_date_range_from_div">
                            <label for="date_range">From</label>
                            <input type="date" class="form-control" name="custom_date_range_from" id="custom_date_range_from" max="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group col-md-6 p-2" id="custom_date_range_to_div">
                            <label for="date_range">To</label>
                            <input type="date" class="form-control" name="custom_date_range_to" id="custom_date_range_to" max="{{ date('Y-m-d') }}" disabled>
                        </div>

                    </div>

                    <br>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right">
                            {{ __('Generate') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #custom_date_range_from_div {
            display:none;
        }
        #custom_date_range_to_div {
            display:none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let custom_from = document.getElementById('custom_date_range_from');
        let custom_to = document.getElementById('custom_date_range_to');

        document.getElementById('date_range').addEventListener('change', function() {
            if(this.value == 'custom') {
                custom_to.value = ''
                custom_to.value = ''
                document.getElementById('custom_date_range_from_div').style.display = 'block';
                document.getElementById('custom_date_range_to_div').style.display = 'block';
            } else {
                document.getElementById('custom_date_range_from_div').style.display = 'none';
                document.getElementById('custom_date_range_to_div').style.display = 'none';
            }
        });

        custom_from.addEventListener('change', function() {
            custom_to.setAttribute('min', this.value)
            custom_to.disabled = false
            custom_to.value = ''
        });

        custom_from.addEventListener('change', function() {
            custom_to.setAttribute('min', this.value)
            custom_to.disabled = false
            custom_to.value = ''
            custom_to.focus()
        });
    </script>
@endpush