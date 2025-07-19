@extends('layouts.app', ['page' => __('Cost Calculation'), 'pageSlug' => 'calculation'])

@section('content')
<div class="col-md-12">
  <div class="card-body">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <!-- Card for file upload -->
          <div class="card">
            <div class="card-header text-center">
              <h4>Cost Calculation</h4>
            </div>
            <div class="card-body">
              <!-- File upload form -->
              <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- <div class="form-group mt-4">
                  <label for="startDateTime" class="form-label">Device</label>
                  <input type="text" name="device"  class="form-control" placeholder="Select start date and time">
                </div> --}}

                <div class="form-group mt-4">
                  <label for="startDateTime" class="form-label">Start Date & Time</label>
                  <input type="text" name="start_datetime" id="startDateTime" class="form-control flatpickr" placeholder="Select start date and time" required>
                </div>

                <div class="form-group mt-3">
                  <label for="endDateTime" class="form-label">End Date & Time</label>
                  <input type="text" name="end_datetime" id="endDateTime" class="form-control flatpickr" placeholder="Select end date and time" required>
                </div>

                <div class="form-group mt-4">
                  <label for="startDateTime" class="form-label">Cost per unit</label>
                  <input type="text" name="cost"  class="form-control" placeholder="Select start date and time">
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
<div class="col-md-12">
  <div class="card card-plain">
    <div class="card-header text-center">
      <h3 class="card-title center"> Caculation Table</h3>
      <p class="category"> Cost for the time period </p>
    </div>
    <div class="card-body">
      <div class="table-responsive text-center" id="resultTable">
        <!-- Table data will be dynamically inserted here -->
      </div>
    </div>
  </div>
</div>

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
            let tableData = '<table class="table"><thead><tr><th>Device ID</th><th>Satrt Time</th><th>End Time</th><th>Total Energy</th><th>Total Current</th><th>Total Cost</th></tr></thead><tbody>';
            tableData += `<tr>
              <td>${response.device_id}</td>
              <td>${response.start_time}</td>
              <td>${response.end_time}</td>
              <td>${response.total_energy}</td>
              <td>${response.total_current}</td>
              <td>${response.total_cost}</td>
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
@endsection
