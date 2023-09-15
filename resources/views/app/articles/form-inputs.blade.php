@php $editing = isset($article) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="title" label="Judul" :value="old('title', $editing ? $article->title : '')" maxlength="255" placeholder="Judul"
            required></x-inputs.text>
    </x-inputs.group>


    <x-inputs.group class="col-sm-12">
        <div x-data="imageViewer('{{ $editing && $article->banner ? \Storage::url($article->banner) : '' }}')">
            <x-inputs.partials.label name="banner" label="Gambar Banner"></x-inputs.partials.label><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img :src="imageUrl" class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;" />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div class="border rounded border-gray-200 bg-gray-100" style="width: 100px; height: 100px;"></div>
            </template>

            <div class="mt-2">
                <input type="file" name="banner" id="banner" @change="fileChosen" />
            </div>

            @error('banner')
                @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <label for="summernote">Konten Artikel</label>
        <textarea name="content" class="form-control" required id="summernote"> {{ old('content', $editing ? $article->content : '') }}</textarea>
    </x-inputs.group>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'video']],
                ],
                height: 400,
                popitmouse: true
            });
        });
    </script>
@endpush
