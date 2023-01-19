@extends('admin.index', ['elementActive' => 'visit'])

@section('content')
    <div class="col-md-12 col-lg-12 mb-3">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="card-title">{{ $entity->getAttribute('label')->getAttribute('name') }}</h5>
                </div>

                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.visit.edit', ['visit' => $entity->getKey()]) }}" class="card-link">Редагувати</a>
                    <div class="ms-3 float-end">
                        <a id="closeLink" class="btn rounded-pill btn-primary" href="{{ route('admin.visit.close', ['visit' => $entity->getKey()]) }}">
                            Закрити <span id="numberToClose" class="badge bg-white text-primary"></span>
                        </a>
                    </div>
                    @role('admin')
                    <div class="ms-3 float-end">
                        <form class="d-inline-block ml-2" method="POST" action="{{ route('admin.visit.delete', ['visit' => $entity->getKey()]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </div>
                    @endrole
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Номер</th>
                            <th>Час початку</th>
                            <th>Час закінчення</th>
                            <th>Знижка</th>
                            <th>Дії</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($entity->getAttribute('visitors') as $key => $visitor)
                            <tr>
                                <td>
                                    <div class="form-check form-check-inline mt-3">
                                        <input
                                            class="form-check-input visitor"
                                            type="checkbox"
                                            name="visitors"
                                            value="{{ $visitor->getKey() }}"
                                        />
                                    </div>
                                </td>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $visitor->formatDateTime($entity->getAttribute('start_time')) }}</td>
                                <td>
                                    @if ($visitor->getAttribute('end_time'))
                                        {{ $visitor->formatDateTime($visitor->getAttribute('end_time')) }}
                                    @else
                                        <span class="badge bg-label-secondary">-</span>
                                    @endif
                                </td>
                                @php
                                    $discount = $visitor->getAttribute('discount');
                                @endphp
                                <td>
                                    @if ($discount)
                                        {{ $discount->getAttribute('amount').' '.$discount->getAttribute('unit') }}
                                    @else
                                        <span class="badge bg-label-secondary">-</span>
                                    @endif
                                </td>
                                <td>
{{--                                    <a href="{{ route('admin.visit.show', ['visit' => $entity->getKey()]) }}">--}}
                                        <i class="bi bi-pencil fs-4"></i>
{{--                                    </a>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const $visitorsCheckbox = $('input.visitor');
        const $visitorsNumberBadge = $('#numberToClose');
        const visitorsNumber = $visitorsCheckbox.length;

        // Set all visitor number
        $visitorsNumberBadge.text(visitorsNumber);

        // Update visitors number
        $visitorsCheckbox.click(function() {
            const newLength = $('.visitor:checked').length;
            $visitorsNumberBadge.text(newLength ? newLength : visitorsNumber);
        });

        // TODO add ids to href
        // $('a#closeLink').click(function (a) {
        //     a.prepend();
        //
        //     const url = new URL($(this).attr('href'));
        //     const params = url.searchParams;
        //     //Add a second foo parameter.
        //     params.append('foo', 4);
        //
        // });
    </script>
@endpush
