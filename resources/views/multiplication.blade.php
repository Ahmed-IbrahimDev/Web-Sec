@extends('app')

@section('title', 'Multiplication Table')

@section('content')
<div class="container">
    <h1>Multiplication Table Generator</h1>
    
    <div class="card">
        <div class="card-header">Generate Multiplication Table</div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('multiplication.generate') }}">
                @csrf
                
                <div class="form-group row">
                    <label for="number" class="col-md-4 col-form-label text-md-right">Number</label>
                    <div class="col-md-6">
                        <input id="number" type="number" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ old('number', 5) }}" required>
                        
                        @error('number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="limit" class="col-md-4 col-form-label text-md-right">Up to</label>
                    <div class="col-md-6">
                        <input id="limit" type="number" class="form-control @error('limit') is-invalid @enderror" name="limit" value="{{ old('limit', 10) }}" required>
                        
                        @error('limit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Generate
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    @if(isset($table))
        <div class="card mt-4">
            <div class="card-header">Multiplication Table for {{ $number }}</div>
            
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Operation</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($table as $row)
                            <tr>
                                <td>{{ $row['operation'] }}</td>
                                <td>{{ $row['result'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection