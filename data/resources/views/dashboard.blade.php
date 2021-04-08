@extends('layouts.app')
@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            @if (!$isAdmin)
                <div class="row justify-content-end mb-4 mr-1">
                    {{ Form::open(['url' => route('schedule-active-change')]) }}
                    <div class="custom-control custom-switch d-flex align-items-center">
                        {{ Form::checkbox('switch_schedule_active', 1, $userScheduleActive, ['class' => 'custom-control-input', 'id'=> 'switch']) }}
                        {{ Form::label('switch', 'Active', ['class' => 'custom-control-label']) }}
                        {{ Form::submit('保存', ['class'=>'btn btn-primary btn-block ml-3']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            @endif
            {{ $Calendar->render() }}
        </div>
        {{-- .content --}}
    </div>
@endsection
