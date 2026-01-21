@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">{{ isset($blog) ? 'Edit Blog' : 'Create Blog' }}</h5>
        </div>
        <form action="{{ isset($blog) ? route('blogs.update', $blog) : route('blogs.store') }}" id="form" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($blog))
            @method('PUT')
        @endif
        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Content</label>
                    <div id="quill-editor" style="height: 400px;"></div>
                    <input type="hidden" name="content" id="content">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Upload Image/Video [Recommended Size : Width = 880px, Height = 495px]</label>
                    <input type="file" name="media" class="form-control" accept="image/png, image/jpeg, image/jpg, video/mp4, video/mov, video/avi">
                </div>
                @if (isset($blog) && $blog->media)
                    @if (Str::endsWith($blog->media, ['.jpg', '.jpeg', '.png']))
                        <div class="image-item" style="width: 500px; height: 350px; margin: 10px; position: relative;">
                            <img
                                src="{{ $blog->media }}"
                                alt="Image"
                                class="img-fluid"
                                style="width: 100%; height: 100%;">
                            <button
                                class="btn soft-danger remove-button shadow-sm"
                                style="position: absolute; top: 5px; right: 5px;"
                                data-id="{{ $blog->id }}"><i class="bi bi-trash"></i></button>
                        </div>
                    @else
                        @if(Str::contains($blog->media, 'youtube.com') || Str::contains($blog->media, 'youtu.be'))
                            <div class="image-item" style="width: 500px; height: 350px; margin: 10px; position: relative;">
                            <iframe width="500" height="350"
                                    src="https://www.youtube.com/embed/{{ Str::afterLast($blog->media, 'v=') }}"
                                    frameborder="0" allowfullscreen class="mt-2">
                            </iframe>
                            <button
                                class="btn soft-danger remove-button shadow-sm"
                                style="position: absolute; top: 5px; right: 5px;"
                                data-id="{{ $blog->id }}"><i class="bi bi-trash"></i></button>
                            </div>
                        @else
                            <div class="image-item" style="width: 500px; height: 350px; margin: 10px; position: relative;">
                                <video width="500" height="350" controls class="mt-2">
                                    <source src="{{ $blog->media }}" type="video/mp4">
                                </video>
                                <button
                                    class="btn soft-danger remove-button shadow-sm"
                                    style="position: absolute; top: 5px; right: 5px;"
                                    data-id="{{ $blog->id }}"><i class="bi bi-trash"></i></button>
                            </div>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            <div class="card-footer bg-white">
                <div class="text-end">
                    <button class="btn btn-primary">
                        {{ isset($blog) ? 'Update' : 'Create' }}
                    </button>
                </div>
            </div>
        </div>
        </form>
    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {

            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Write your content here...',
                modules: {
                    toolbar: [
                        [{ 'header': '1' }, { 'header': '2' }, { 'font': [] }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['bold', 'italic', 'underline'],
                        [{ 'align': [] }],
                        ['link'],
                        ['image'],
                        [{ 'color': [] }, { 'background': [] }]
                    ]
                }
            });


            // Set the initial value (if editing)
            quill.root.innerHTML = `{!! isset($blog) ? addslashes($blog->content) : '' !!}`;

            // Update hidden input on form submit
            $('#form').on('submit', function (e) {
                document.getElementById('content').value = quill.root.innerHTML;
            });

            //Remove Media
            $('body').on('click', '.remove-button', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('blogs.media.delete', {id: id}),
                    confirmationMessage: 'Do you really want to delete this media ?',
                    onComplete: () => {
                        window.location.reload();
                    }
                })
            });

        });
    </script>
@endpush
