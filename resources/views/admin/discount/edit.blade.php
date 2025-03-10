@extends('admin.index', ['elementActive' => 'discount'])

@section('content')
    <h4 class="fw-bold py-3 mb-4">Редагувати знижку</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.discount.update', ['discount' => $entity->getKey()]) }}">
                        @csrf
                        @method('patch')
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Назва</label>
                            <input name="name" type="text" class="form-control" id="basic-default-fullname" value="{{ $entity->getAttribute('name') }}" />
                            @if ($errors->has('name'))
                                @foreach ($errors->get('name') as $error)
                                    <div class="form-text text-danger">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Опис</label>
                            <input name="description" type="text" class="form-control" id="basic-default-fullname" value="{{ $entity->getAttribute('description') ?? old('description') }}" />
                            @if ($errors->has('description'))
                                @foreach ($errors->get('description') as $error)
                                    <div class="form-text text-danger">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Зберегти</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
