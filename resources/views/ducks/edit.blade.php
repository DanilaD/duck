@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h1>Edit Duck</h1>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title>">Form</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('ducks.update', $duck->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Duck Information -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $duck->name }}">
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" name="age" id="age" class="form-control" value="{{ $duck->age }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="health">Health</label>
                                <input type="number" name="health" id="health" class="form-control" value="{{ $duck->health }}">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" name="status" id="status" class="form-control" value="{{ $duck->status }}">
                            </div>
                        </div>
                        <!-- Last Fed Time -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="last_fed_time">Last Fed Time</label>
                                <input type="datetime-local" name="last_fed_time" id="last_fed_time" class="form-control" value="{{ \Carbon\Carbon::parse($duck->last_fed_time)->format('Y-m-d\TH:i') }}">
                            </div>
                        </div>
                        <!-- Behaviors -->
                        <div class="col-md-12">
                            <h3>Behaviors</h3>
                        </div>
                        <!-- Walking Behavior -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="walking_is_walking">Is Walking</label>
                                <input type="checkbox" name="behaviors[walking][is_walking]" id="walking_is_walking" class="form-check" value="1" {{ isset($duck->behaviors['walking']['is_walking']) && $duck->behaviors['walking']['is_walking'] ? 'checked' : '' }}>
                                <label for="walking_speed">Speed</label>
                                <input type="number" step="0.01" name="behaviors[walking][speed]" id="walking_speed" class="form-control" value="{{ $duck->behaviors['walking']['speed'] }}">
                            </div>
                        </div>
                        <!-- Breathing Behavior -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="breathing_is_breathing">Is Breathing</label>
                                <input type="checkbox" name="behaviors[breathing][is_breathing]" id="breathing_is_breathing" class="form-check" value="1" {{ isset($duck->behaviors['breathing']['is_breathing']) && $duck->behaviors['breathing']['is_breathing'] ? 'checked' : '' }}>
                                <label for="breathing_rate">Rate</label>
                                <input type="number" name="behaviors[breathing][rate]" id="breathing_rate" class="form-control" value="{{ $duck->behaviors['breathing']['rate'] }}">
                            </div>
                        </div>
                        <!-- Quacking Behavior -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quacking_is_quacking">Is Quacking</label>
                                <input type="checkbox" name="behaviors[quacking][is_quacking]" id="quacking_is_quacking" class="form-check" value="1" {{ isset($duck->behaviors['quacking']['is_quacking']) && $duck->behaviors['quacking']['is_quacking'] ? 'checked' : '' }}>
                                <label for="quacking_volume">Volume</label>
                                <select name="behaviors[quacking][volume]" id="quacking_volume" class="form-control">
                                    <option value="low" {{ $duck->behaviors['quacking']['volume'] == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ $duck->behaviors['quacking']['volume'] == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ $duck->behaviors['quacking']['volume'] == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
    </div>
@endsection
