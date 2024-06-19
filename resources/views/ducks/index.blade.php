@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h1>Living, Breathing, Walking Duck</h1>
        <div class="row">
            <!-- Ducks List -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ducks</h4>
                    </div>
                    <div class="card-body">
                        @if($ducks->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Health</th>
                                        <th>Status</th>
                                        <th>Last Fed Time</th>
                                        <th>Behaviors</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ducks as $duck)
                                        <tr id="duck-{{ $duck->id }}">
                                            <td>{{ $duck->name }}</td>
                                            <td>{{ $duck->age }}</td>
                                            <td>{{ $duck->health }} %</td>
                                            <td>{{ $duck->status }}</td>
                                            <td>{{ $duck->last_fed_time }}</td>
                                            <td>
                                                @if($duck->behaviors)
                                                    @if(isset($duck->behaviors['walking']['is_walking']) && $duck->behaviors['walking']['is_walking'])
                                                        <div class="small">Moving with speed {{$duck->behaviors['walking']['speed']}} m/s</div>
                                                    @endif
                                                    @if(isset($duck->behaviors['breathing']['is_breathing']) && $duck->behaviors['breathing']['is_breathing'])
                                                        <div class="small">{{$duck->behaviors['breathing']['rate']}} breaths per minute</div>
                                                    @endif
                                                    @if(isset($duck->behaviors['quacking']['is_quacking']) && $duck->behaviors['quacking']['is_quacking'])
                                                        <div class="small">{{$duck->behaviors['quacking']['volume']}} quacking</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('ducks.edit', $duck->id) }}" class="btn btn-outline-info btn-sm">Edit</a>
                                                <button class="btn btn-outline-danger btn-sm delete-duck" data-id="{{ $duck->id }}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div>{{$ducks->links()}}</div>
                            </div>
                        @else
                            <div>No Data.</div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Search Form -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title>">Search</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="searchName">Name:</label>
                            <input type="text" id="searchName" class="form-control" placeholder="Type Name">
                        </div>
                        <div class="form-group">
                            <label for="searchAge">Age:</label>
                            <select id="searchAge" class="form-control">
                                <option value="">Select Age</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="searchStatus">Status:</label>
                            <select id="searchStatus" class="form-control">
                                <option value="">Select Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <button class="btn btn-primary" onclick="searchDucks()">Search</button>
                        </div>
                        <div id="ducksList" class="mt-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/ages', {
                method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    const ageSelect = document.getElementById('searchAge');
                    data.forEach(age => {
                        let option = document.createElement('option');
                        option.value = age;
                        option.text = age;
                        ageSelect.appendChild(option);
                    });
                });

            document.querySelectorAll('.delete-duck').forEach(button => {
                button.addEventListener('click', function() {
                    const duckId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this duck?')) {
                        fetch(`/destroy/${duckId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Duck deleted successfully.');
                                    document.getElementById(`duck-${duckId}`).remove();
                                } else {
                                    alert('Failed to delete duck.');
                                }
                            })
                            .catch(error => {
                                alert('An error occurred while trying to delete the duck.');
                            });
                    }
                });
            });

        });

        function searchDucks() {
            var name = document.getElementById('searchName').value.trim();
            var age = document.getElementById('searchAge').value.trim();
            var status = document.getElementById('searchStatus').value.trim();
            if (name === '' && age === '' && status === '') {
                document.getElementById('ducksList').innerHTML = '<div class="alert alert-info">Please enter a parameter for searching.</div>';
                return;
            }
            fetch(`/search`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: name, age: age, status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    document.getElementById('ducksList').innerHTML = '<div class="alert alert-success">No ducks found. Try different search criteria.</div>';
                } else {
                    let ducks = data.map(duck => `<div>${duck.name} - Age: ${duck.age}</div>`);
                    document.getElementById('ducksList').innerHTML = ducks.join('');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('ducksList').innerHTML = '<div class="alert alert-danger">'+error+'</div>';
            });
        }
    </script>
@endsection
