@extends('layouts.app', ['page' => __('Add Device'), 'pageSlug' => 'device'])

@section('content')
<div class="col-md-12">
  <div class="card-body">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <!-- Card for file upload -->
          <div class="card">
            <div class="card-header text-center">
              <h4>Add Device</h4>
            </div>
            <div class="card-body">
              <!-- File upload form -->
              <form action="{{ route('add.device') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-4">
                  <label for="device_id" class="form-label">Device Id</label>
                  <input type="text" name="device_id"  class="form-control" placeholder="Add Device Id">
                </div>
                <div class="form-group mt-4">
                  <label for="device_api" class="form-label">Device Api</label>
                  <input type="text" name="device_api"  class="form-control" placeholder="Add Device Api">
                </div>

                <div class="form-group text-center mt-4">
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
