@extends('admin.layouts.master')
@section('content')
@if(session()->has('admin'))
  @php $prefix = 'admin'; @endphp
    @elseif(session()->has('branch'))
  @php $prefix = 'branch'; @endphp
    @elseif(session()->has('team')) 
  @php $prefix = 'team';@endphp
@endif

<div class="content-body">
    <div class="container-fluid">
      <div class="row">

      @if(session()->has('team') && session()->get('team')->department=='6790b8df2ef8f2064c61d079' || session()->get('team')->department=='67bd6d68d4de44c0093ea46f')
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Learning Management System (LMS)</h4>
            </div>
            <div class="card-body">
              <form id="formSubmit" method="post" action="{{ route($prefix. '.trainingDevelopment.lmsSave') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="id" value="{{ !empty($singleData) ? $singleData->_id : '' }}">
              <div class="form-validation">
                  <div class="row">
                      <div class="col-xl-4">
                        <div class="mb-3">
                          <label class="form-label">Training Name <span class="red">*</span></label>
                          <input type="text" class="form-control" name="trainingName" value="{{ !empty($singleData) ? $singleData->trainingName : old('trainingName') }}" required>
                        </div>
                      </div>
                      <div class="col-xl-12">
                        <div class="mb-3">
                          <label class="form-label">Training Material <span class="red">*</span></label>
                          <textarea class="form-control" id="editor" style="min-height: 300px;" name="trainingMaterial" required>{{ !empty($singleData) ? $singleData->trainingMaterial : '' }}</textarea>
                        </div>
                      </div>
                      <div class="col-xl-12"></div>

                      <div class="col-xl-4">
                        <div class="mb-3">
                          <label class="form-label">Upload PDF <span class="red">*</span>
                          @if(!empty($singleData))
                            <a href="{{ url('/') }}/{{ $singleData->uploadPDF }}" target="_blank">View</a>
                          @endif
                        </label>
                          <input type="file" class="form-control" accept=".pdf" name="uploadPDF"  id="uploadPDF">
                          <p id="pdfError" style="color:red; display:none;"></p>
                        </div>
                      </div>
                      <div class="col-xl-4">
                        <div class="mb-3">
                          <label class="form-label">Upload Image <span class="red">*</span>
                          @if(!empty($singleData))
                            <a href="{{ url('/') }}/{{ $singleData->uploadImage }}" target="_blank">View</a>
                          @endif
                        </label>
                          <input type="file" class="form-control" accept=".jpg,.png" name="uploadImage" id="uploadImage">
                          <p id="imageError" style="color:red; display:none;"></p>
                          </div>
                      </div>
                      <div class="col-xl-4">                        
                        <div class="mb-3">
                          <label class="form-label">Upload Video <span class="red">*</span></label>
                          <input type="text" class="form-control" placeholder="Enter Youtube Video URL" name="uploadVideo" value="{{ !empty($singleData) ? $singleData->uploadVideo : '' }}" required>
                        </div>
                      </div>
                    
                      <div class="col-xl-12">
                        <div class="mt-4">
                          <input type="checkbox" id="status" name="status" value="1" {{ !empty($singleData) && $singleData->status=='1' ? 'checked' : '' }}>
                          <label for="status" > Active/Deactive</label>
                        </div>
                        <div class="mt-4 text-end">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      @endif
        <!-- end -->
        
        <div class="col-lg-12">
          <div class="card">
            <!-- <div class="card-header">
              <h4 class="card-title">View All Lead</h4>
            </div> -->

            
            <div class="col-lg-12">
          <div class="card">
           
            @if(empty($singleData))
            <div class="card-body"> 
              <h5>Learning Management System (LMS) List</h5><hr>
              
              <div class="table-responsive">
                   <table class="table table-bordered table-styling table-hover table-striped table-primary">
                      <thead>
                        <tr>
                          <th width="50">SN.</th>
                          <th>Training Name</th>
                          <th width="100">Upload PDF</th>
                          <th width="200">Upload Image</th>
                          <th width="200">Upload Video</th>
                          @if(session()->has('team') && session()->get('team')->department1=='6790b8df2ef8f2064c61d079' || session()->get('team')->department1=='67bd6d68d4de44c0093ea46f')
                          <th width="50">Action</th>
                        
                          <th width="50">Status</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($List as $key=>$val)
                        <tr>
                          <td>{{ $List->firstItem() }}.</td>
                         <td valign="top">{{ $val->trainingName }}</td>
                          <td valign="top"><a href="{{ url('/') }}/{{ $val->uploadPDF }}" target="_blank">View PDF</a></td>
                          <td valign="top"><a href="{{ url('/') }}/{{ $val->uploadImage }}">View Image</a></td>
                          <td>{{ $val->uploadVideo }}</td>
                          @if(session()->has('team') && session()->get('team')->department1=='6790b8df2ef8f2064c61d079' || session()->get('team')->department1=='67bd6d68d4de44c0093ea46f')
                          <td valign="top">
                            <a href="{{ route($prefix.'.trainingDevelopment.lmsGet', $val->_id) }}"> <i class="ri-edit-line"></i></a> 
                            <a href="{{ route($prefix.'.trainingDevelopment.lmsDelete',$val->_id) }}" onclick="return confirm('Are you sure delete this item!')"> <i class="ri-close-line"></i> </a>
                          </td>
                          <td>
                            @if(!empty($val->status=='1'))
                               <a  style="color: green">Active</a>
                            @else 
                            <a  style="color: red">Deactive</a>
                            @endif
                          </td>
                          @endif
                        </tr>
                        @endforeach
                      </tbody>
                      {!! $List->links() !!}
                    </table>
              </div>
              
            </div>
            @endif
          </div>
        </div>

          </div>
        </div>
        <!-- end --> 
        
      </div>
    </div>
  </div>
  
@endsection
@section('javascript')
<script>
  $(function () {
    $('#formSubmit').parsley().on('field:validated', function () {
      var ok = $('.parsley-error').length === 0;
      $('.bs-callout-info').toggleClass('hidden', !ok);
      $('.bs-callout-warning').toggleClass('hidden', ok);
    })
      .on('form:submit', function () {
        $('#spiner').css('display', 'flex');
      });
  });
</script>
<!-- Include CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
      console.error(error);
    });
</script>
<script>
  document.getElementById('uploadPDF').addEventListener('change', function () {
    validateFile(this, 'pdfError', ['pdf'], 5); // Only .pdf, Max 5MB
  });

  document.getElementById('uploadImage').addEventListener('change', function () {
    validateFile(this, 'imageError', ['jpg', 'jpeg', 'png'], 2); // Only .jpg, .jpeg, .png, Max 2MB
  });

  function validateFile(input, errorElementId, allowedExtensions, maxSizeMB) {
    let file = input.files[0];
    let errorElement = document.getElementById(errorElementId);
    errorElement.style.display = 'none';

    if (file) {
      let fileSizeMB = file.size / (1024 * 1024); // Convert to MB
      let fileExtension = file.name.split('.').pop().toLowerCase();

      // Check file extension
      if (!allowedExtensions.includes(fileExtension)) {
        errorElement.textContent = `Invalid file type! Allowed: ${allowedExtensions.join(', ')}`;
        errorElement.style.display = 'block';
        input.value = ''; // Clear invalid file
        return false;
      }

      // Check file size
      if (fileSizeMB > maxSizeMB) {
        errorElement.textContent = `File size exceeds ${maxSizeMB}MB limit!`;
        errorElement.style.display = 'block';
        input.value = ''; // Clear invalid file
        return false;
      }
    }
  }
</script>
@endsection