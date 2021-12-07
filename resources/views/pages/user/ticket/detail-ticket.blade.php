@extends('layout.side-menu')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
       .d-none {
         display: none;
       }
    </style>
@endsection
@section('subcontent')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Detail Ticket</h2>
    </div>
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
      <a href="{{route('myTicket')}}" class="text-lg font-medium mr-auto btn btn-primary">Kembali</a>
    </div>
    <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Post Content -->
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="post intro-y overflow-hidden box mt-5">
                <div class="post__content tab-content">
                    <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">

                        <div class="intro-y col-span-12 lg:col-span-8">
                          <div class="mt-5 mb-5">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="{{$ticket->title}}" class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13" placeholder="Title" readonly disabled>
                          </div>

                          <div class="mt-5 mb-5">
                            <label for="priority">Priority</label>
                            <input type="text" value="{{$ticket->priority_badge}}" class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13" placeholder="Title" readonly disabled>
                          </div>
                          
                          <div class="mt-5 mb-5">
                            <label for="desc">Kendala</label>
                            <textarea id="editor" name="content"></textarea> 
                          </div>

                          <div id="text_area_data" class="d-none">
                            {!! $ticket->content !!}
                          </div>
                        </div>
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
    var textareaValue = $("#text_area_data").html();
    $('#editor').summernote('disable');
    $('#editor').summernote('code', textareaValue);
  </script>
@endsection