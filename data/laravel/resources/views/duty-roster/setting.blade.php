@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add members to roster') }}</div>
                    <div class="card-body">
                        {{Form::model($items, ['route' => ['items.update', $items->id]])}}
                        <form method="POST" action="{{ route('duty-roster/setting') }}">
                            @csrf
                            <input type="text" name="name" />
                            <select name="exclude_week">
                                <option></option>
                            </select>
                            <input type="submit" name="add" value="{{ __('Update') }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
