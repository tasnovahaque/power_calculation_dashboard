@extends('layouts.app', ['page' => __('Upload Data'), 'pageSlug' => 'upload'])

@section('content')
<div class="row">
  <div class="col-md-12">
      <div class="card-body">
        <div class="container mt-5">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <!-- Card for file upload -->
              <div class="card">
                <div class="card-header text-center">
                  <h4>Upload Excel File</h4>
                </div>
                <div class="card-body">
                  <!-- File upload form -->
                  <form action="/import-data" method="POST" enctype="multipart/form-data">
                    @csrf <!-- CSRF token for security in Laravel -->
        
                    <div class="form-group">
                      <label for="excelFile" class="form-label border border-primary rounded p-2">Select Excel File</label>
                      <input type="file" name="file" id="file" class="form-control-file" accept=".xls,.xlsx" required>
                    </div>
        
                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>        
    </div>
  </div>
</div>
@endsection
