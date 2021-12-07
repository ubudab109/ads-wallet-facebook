@extends('layout.side-menu')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
       ul {
        list-style: disc !important;
        padding: revert !important;
      }
      ol {
        list-style: auto !important;
        padding: revert !important;
      }
      .note-modal.open {
        display: contents !important;
      }

      .note-modal-backdrop {
        display: contents !important;
      }
    </style>
@endsection
@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Buat Ticket</h2>
    </div>
    <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Post Content -->
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="post intro-y overflow-hidden box mt-5">
                <div class="post__content tab-content">
                    <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">
                      <form method="post" action="{{route('storeTicket')}}" enctype="multipart/form-data"> 
                        @csrf
                        <div class="intro-y col-span-12 lg:col-span-8">
                          <div class="mt-5 mb-5">
                            <input type="text" name="title" class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13" placeholder="Title">
                          </div>

                          <div class="mt-5 mb-5">
                            <select name="priority" id="" class="form-select form-select-md sm:mt-2 sm:mr-2">
                              <option selected disabled>Pilih Prioritas</option>
                              @foreach (TicketPriority() as $key => $item)
                                  <option value="{{$key}}">{{$item}}</option>
                              @endforeach
                            </select>
                          </div>
                          
                          <div class="mt-5 mb-5">
                            <textarea id="editor" name="content"></textarea> 
                          </div>
                          <div class="mt-5 mb-5">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
  {{-- <script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  <script>
    $('#editor').summernote({
        placeholder: 'Deskripsikan kendala Anda disini....',
        tabsize: 2,
        height: 500,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });

      previewInput()
      {
        $("#preview_text").removeClass('d-none');
      }
  </script>
@endsection