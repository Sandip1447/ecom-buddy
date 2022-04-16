<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Category
        </h2>
    </x-slot>


    <div class="py-12">

        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="card">
                        <div class="card-header">Edit Category</div>
                        <div class="card-body">

                            <form action="{{ url('category/update/'.$category->id) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="required" for="title">Category Name</label>
                                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                           type="text" name="title"
                                           id="title" value="{{ old('title', $category->title) }}" required>
                                    @if($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</x-app-layout>
