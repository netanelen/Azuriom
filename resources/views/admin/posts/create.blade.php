@extends('admin.layouts.admin')

@section('title', 'Add news')

@include('admin.elements.editor')
@include('admin.elements.date-picker')

@push('footer-scripts')
    <script>
        const images = (@json($imagesUrl));

        document.addEventListener('DOMContentLoaded', function () {
            const imageSelect = $('#imageSelect');
            const imagePreview = $('#imagePreview');

            imageSelect.on('change', function (e) {
                if (imageSelect.val().length === 0) {
                    imagePreview.parent().addClass('d-none');
                } else {
                    imagePreview.parent().removeClass('d-none');
                    imagePreview.attr('src', images[imageSelect.val()]);
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.posts.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="titleInput">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" value="{{ old('title') }}" required>

                    @error('title')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descriptionInput">Description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="descriptionInput" name="description" value="{{ old('description') }}" required>

                    @error('description')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="imageSelect">Image</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-outline-success" href="{{ route('admin.images.create') }}" target="_blank"><i class="fas fa-upload"></i></a>
                        </div>
                        <select class="custom-select @error('image_id') is-invalid @enderror" id="imageSelect" name="image_id">
                            <option value="" selected>None</option>
                            @foreach($images as $image)
                                <option value="{{ $image->id }}">{{ $image->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3 d-none">
                        <img src="#" class="img-fluid rounded img-preview" alt="{{ $image->name }}" id="imagePreview">
                    </div>

                    @error('image_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slugInput">Slug</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ route('posts.index') }}/</div>
                        </div>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slugInput" name="slug" value="{{ old('slug') }}" required>

                        @error('slug')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="textArea">Content</label>
                    <textarea class="form-control html-editor @error('content') is-invalid @enderror" id="textArea" name="content" rows="5">{{ old('content') }}</textarea>

                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="publishedInput">Published At</label>
                    <input type="text" class="form-control date-picker @error('published_at') is-invalid @enderror" id="publishedInput" name="published_at" value="{{ old('published_at', now()) }}" required>

                    @error('published_at')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="pinnedSwitch" name="is_pinned">
                    <label class="custom-control-label" for="pinnedSwitch">Pin the news</label>
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@endsection
