@extends('movies.layout')
@section('content')

<div class="card mt-5">
    <h2 class="card-header">Edit Movie</h2>
    <div class="card-body">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('movies.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>

        <form action="{{ route('movies.update',$movie->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="inputName" class="form-label"><strong>Name:</strong></label>
                <input type="text" name="name" id="inputName" placeholder="Name"
                    value="{{ $movie->name }}"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="inputLink" class="form-label"><strong>Link:</strong></label>
                <input type="text" name="link" id="inputLink" placeholder="Link"
                    value="{{ $movie->link }}"
                    class="form-control @error('link') is-invalid @enderror">
                @error('link')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-sm-6 col-md-4">
                <label for="inputStatus" class="form-label">
                    <strong>Status:</strong>
                </label>

                <div class="form-floating">
                    <select class="form-select @error('status') is-invalid @enderror" id="inputStatus" name="status" aria-label="status">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ $movie->status === $label ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <label for="inputStatus">Status</label>
                </div>

                @error('status')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <br>
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
        </form>

    </div>
</div>
@endsection