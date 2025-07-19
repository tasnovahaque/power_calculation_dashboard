@extends('layouts.app', ['page' => __('History'), 'pageSlug' => 'history'])

@section('content')
<div class="col-md-12">
  <div class="card-body">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <!-- Card for file upload -->
          <div class="card">
            <div class="card-header text-center">
              <h4>View History</h4>
            </div>
            <div class="card-body">
              <!-- File upload form -->
              <form method="POST" action="{{route('get.history.data')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-4">
                  <label for="startDateTime" class="form-label">Start Date & Time</label>
                  <input type="text" name="start_datetime" id="startDateTime" class="form-control flatpickr" placeholder="Select start date and time" required>
                </div>

                <div class="form-group mt-3">
                  <label for="endDateTime" class="form-label">End Date & Time</label>
                  <input type="text" name="end_datetime" id="endDateTime" class="form-control flatpickr" placeholder="Select end date and time" required>
                </div>

                <div class="form-group text-center mt-4">
                  <button type="submit" class="btn btn-primary">Calculate</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bottom Table -->
@if($monthly != null)
  <div class="row">
  <div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">
                    <h5 class="card-category">Monthly Average</h5>
                    <h2 class="card-title">Energy</h2>
                    <input type="hidden" id='weekly' value="{{$weekly}}">
                    <input type="hidden" id='monthly' value="{{$monthly}}">
                </div>
                <div class="col-sm-6">
                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                    <label class="btn btn-sm btn-primary btn-simple active" id="0">
                        <input type="radio" name="options" checked>
                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Energy</span>
                        <span class="d-block d-sm-none">
                            <i class="tim-icons icon-single-02"></i>
                        </span>
                    </label>
                    {{-- <label class="btn btn-sm btn-primary btn-simple" id="1">
                        <input type="radio" class="d-none d-sm-none" name="options">
                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Purchases</span>
                        <span class="d-block d-sm-none">
                            <i class="tim-icons icon-gift-2"></i>
                        </span>
                    </label>
                    <label class="btn btn-sm btn-primary btn-simple" id="2">
                        <input type="radio" class="d-none" name="options">
                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Sessions</span>
                        <span class="d-block d-sm-none">
                            <i class="tim-icons icon-tap-02"></i>
                        </span>
                    </label> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="chartBig1"></canvas>
            </div>
        </div>
    </div>
  </div>
  </div>
  <div class="row">
  <div class="col-lg-4">
    <div class="card card-chart">
        <div class="card-header">
            <h5 class="card-category">Average Energy</h5>
            <h3 class="card-title"><i class="tim-icons icon-calendar-60 text-primary"></i> Weekly</h3>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="chartLinePurple"></canvas>
            </div>
        </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card card-chart">
        <div class="card-header">
            <h5 class="card-category">Average Current</h5>
            <h3 class="card-title"><i class="tim-icons icon-calendar-60 text-info"></i> Weekly</h3>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="CountryChart"></canvas>
            </div>
        </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card card-chart">
        <div class="card-header">
            <h5 class="card-category">Average Cost</h5>
            <h3 class="card-title"><i class="tim-icons icon-calendar-60 text-info"></i> Cost Per Unit (8 BDT)</h3>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="chartLineGreen"></canvas>
            </div>
        </div>
    </div>
  </div>
  </div>
@endif

@push('js')
    <!-- Flatpickr Integration -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        flatpickr('.flatpickr', {
          enableTime: true,
          dateFormat: "Y-m-d H:i",
        });
    
        $('#uploadForm').on('submit', function (e) {
          e.preventDefault();
    
          let formData = new FormData(this);
          $.ajax({
            url: '/get-data', // Replace with your endpoint
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              if(response){
                let tableData = '<table class="table"><thead><tr><th>Device ID</th><th>Satrt Time</th><th>End Time</th><th>Total Energy</th><th>Total Current</th></tr></thead><tbody>';
                tableData += `<tr>
                  <td>${response.device_id}</td>
                  <td>${response.start_time}</td>
                  <td>${response.end_time}</td>
                  <td>${response.total_energy}</td>
                  <td>${response.total_current}</td>
                </tr>`;
                tableData += '</tbody></table>';
                $('#resultTable').html(tableData);
              }else{
                let tableData = '<h1 class="text-danger"> No Data Found </h1>';
                $('#resultTable').html(tableData);
              }
            },
            error: function (error) {
              alert('Error uploading file or fetching data!');
            }
          });
        });
      });
    </script>
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
          demo.initHistoryPageCharts();
        });
    </script>
@endpush
@endsection
