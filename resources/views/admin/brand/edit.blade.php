<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Brand
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="card">
                        <div class="card-header">Edit Brands</div>
                        <div class="card-body">
                            <form action="{{  route("brand.update", [$brand]) }}" method="post"
                                  enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label class="required" for="title">Brand Name</label>
                                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                               type="text" name="title"
                                               id="title" value="{{ old('title', $brand->title) }}" required>
                                        @if($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label class="required" for="image">Brand icon</label>
                                        <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                               type="file" name="image" id="image">
                                        @if($errors->has('image'))
                                            <span class="text-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <input type="hidden" name="old_image" value="{{  $brand->image }}">

                                <div class="mb-3">
                                    @if($brand->image)

                                        <img src="{{Storage::url('image/brand/'.$brand->image)}}"
                                             style="height: 250px;width: 250px" alt="logo">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
