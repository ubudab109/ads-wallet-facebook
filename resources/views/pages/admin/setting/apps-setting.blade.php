@extends('layout.side-menu')
@section('style')
    <style>
      .d-none {
        visibility: hidden;
      }
    </style>
@endsection
@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Apps Setting</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Button Groups -->
            <div class="intro-y box">
              <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                  <h2 class="font-medium text-base mr-auto">Apps Setting Form</h2>
              </div>
            </div>
            <!-- END: Input Groups -->
        </div>
        <div class="intro-y col-span-12 lg:col-span-12">
          @if (!empty($logo))
          <div class="intro-y items-center box mt-5 mb-5">
            <div id="single-file-upload" class="grid justify-items-center p-5">
              <img src="{{asset('company-logo/'.$logo)}}" width="200"/>
              <h4>Logo Anda Saat Ini</h4>
            </div>
          </div>
          @endif
          {{-- BEGIN: UPLOAD LOGO COMPANY --}}
          <div class="intro-y box mt-5 mb-5">
            <div id="single-file-upload" class="p-5">
              <form data-single="true" enctype="multipart/form-data" action="{{route('uploadLogo')}}" class="dropzone">
                  @csrf
                  <div class="fallback">
                    <input type="file" placeholder="0.00" name="file" value=""
                    id="file" ref="file" class="dropify"
                    @if(!empty($logo)) data-default-file="{{asset('company-logo/'.$logo)}}" @endif />
                  </div>
                  
                  <div class="dz-message" data-dz-message>
                      <div class="text-lg font-medium">Drop files here or click to upload.</div>
                      <div class="text-gray-600">
                          Silahkan Upload Logo Company Anda Disini.
                      </div>
                  </div>
              </form>
            </div>
          </div>
          
          {{-- END: UPLOAD LOGO COMPANY --}}
          <!-- BEGIN: Input Groups -->
          <div class="intro-y box mt-5">
              <form action="{{route('saveAppSetting')}}" method="POST">
                @csrf
                <div id="input-groups" class="p-5">
                    <div class="preview">
                        <input type="hidden" name="logo" id="logo">
                        <div class="mt-5 mb-5">
                          <label for="">Nama Aplikasi</label>
                            <div class="input-group mt-2"> 
                              <input type="text" class="form-control" value="{{$company_name}}" name="company_name" required placeholder="Nama Aplikasi" aria-label="Price" aria-describedby="input-group-price">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-24 mr-1 mb-2">Submit</button>
                    </div>
                </div>
              </form>
          </div>
          <!-- END: Input Groups -->
        </div>
    </div>    
@endsection
@section('script')
<script>
  var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
   Dropzone.autoDiscover = false;
   var myDropzone = new Dropzone(".dropzone",{
       maxFiles: 1,
       maxFilesize: 1, // 2 mb
       acceptedFiles: ".jpeg,.jpg,.png",
       addRemoveLinks: true,
       sending: function(file, xhr, formData) {
         formData.append("_token", CSRF_TOKEN);
       },
       success: function(file, response) {
         if(response.success == 0){ // Error
             alert(response.message);
         } else {
           alert(response.message)
         }
        //  console.log(file.name)
         $("#logo").val(file.name);
         console.log($("#logo").val())
       },
       removedfile: function(file) {
         var fileName = file.name; 
           
         $.ajax({
           type: 'POST',
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: '{{route("deleteLogo")}}',
           data: {file: fileName},
           sucess: function(data){
               alert(data.messages);
               $("#logo").val('');
           }
         });
   
         var _ref;
           return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
       },
       init: function() {
         this.on("maxfilesexceeded", function(file){
               alert("Anda hanya bisa upload gambar 1 kali. Silahkan hapus gambar sebelumnya terlebih dahulu");
               this.removeFile(file);
           });
       }
   });
</script>
@endsection