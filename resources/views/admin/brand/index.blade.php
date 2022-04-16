<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Brand
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{session('success')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">Registered Brands</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Icon</th>
                                    <th scope="col">CreatedAt</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($brands as $brand)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{ $brand->title }}</td>
                                        <td>

                                            @if($brand->image)
                                                <img src="{{Storage::url('image/brand/'.$brand->image)}}"
                                                     style="height: 48px;width: 48px" alt="logo">
                                            @else
                                                -
                                            @endif

                                        </td>
                                        <td>{{ $brand->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ url('brand/'.$brand->id.'/edit') }}"> Edit</a> |
                                            <form action="{{ route('brand.destroy', $brand->id) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure, you want to delete brand.');"
                                                  style="display: inline-block;">
                                                @method('delete')
                                                @csrf
                                                <input type="submit" class="btn btn-xs btn-danger"
                                                       value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $brands->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Brand</div>
                        <div class="card-body">

                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Brand title</label>
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror " id="title"
                                           aria-describedby="emailHelp">
                                    @error('title')
                                    {{ $message }}
                                    @enderror
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

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
