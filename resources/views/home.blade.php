@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if(session()->has('error'))
                            <div class="alert alert-danger text-center">{{ session('error') }}</div>
                        @elseif(session()->has('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif

                        <button id="clone-ele" class="btn btn-primary">+</button>

                        <form action="{{ route('store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Table Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="column">
                                <div class="row mb-3">
                                    <label for="columns[0]" class="col-md-4 col-form-label text-md-end">{{ __('Column 1') }}</label>

                                    <div class="col-md-6">
                                        <input id="columns[0]" type="text" class="form-control @error('columns.0') is-invalid @enderror" name="columns[0]" value="{{ old('columns.0') }}">

                                        @error('columns.0')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="attributes[0][]" class="col-md-4 col-form-label text-md-end">{{ __('Attributes') }}</label>
                                    <div class="col-md-6">
                                        <select id="attributes[0][]" multiple class="form-control" name="attributes[0][]">
                                            <option value="string">String</option>
                                            <option value="unique">Unique</option>
                                            <option value="nullable">Nullable</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            let clone_btn = $('#clone-ele');

            let column = $('.column');

            let index = 1;

            function decrement(number)
            {
                return number--;
            }

            function createNewColumn(number)
            {
                column.append(`
                    <div id="column-field-row-${number}">
                        <button type="button" data-index="${number}" onclick="decrement('${number}');" class="btn btn-danger removeBtn" style="font-weight: bold;">-</button>
                        <div class="row mb-3">
                            <label for="columns[${number}]" class="col-md-4 col-form-label text-md-end">Column</label>

                            <div class="col-md-6">
                                <input id="columns[${number}]" type="text" class="form-control" name="columns[${number}]">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="attributes[${number}][]" class="col-md-4 col-form-label text-md-end">Attributes</label>
                            <div class="col-md-6">
                                <select id="attributes[${number}][]" multiple class="form-control" name="attributes[${number}][]">
                                    <option value="string">String</option>
                                    <option value="unique">Unique</option>
                                    <option value="nullable">Nullable</option>
                                </select>
                            </div>
                        </div>
                    </div
               `);
            }

            clone_btn.on('click', () => createNewColumn(index++));

            $(document).on('click', '.removeBtn', function (){
                $('#column-field-row-' + $(this).data('index')).remove();
            });
        });
    </script>
@stop


