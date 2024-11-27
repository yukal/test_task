@extends('layout')
@section('title', 'Edit Genre')

@section('menu')
    <div class="collapse navbar-collapse" id="navbarContent">
        @include('genres.menu')
        <button type="button" class="btn btn-primary btn-sm" onclick="history.back()"><i class="fa fa-arrow-left"></i> Back</button>
    </div>
@endsection

@section('content')
    <form action="{{ route('genres.update', $genre->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="inputName" class="form-label"><strong>Name:</strong></label>
            <input type="text" id="inputName" name="name" placeholder="Name" value="{{ $genre->name }}"
                class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
    </form>
@endsection
