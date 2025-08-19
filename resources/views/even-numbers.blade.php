@extends('app')

@section('title', 'Even Numbers')

@section('content')
<div class="container">
    <h1>Even Numbers Generator</h1>
    
    <div class="card">
        <div class="card-header">Generate Even Numbers</div>
        
        <div class="card-body">
            <form method="POST" action="{{ route('even-numbers.generate') }}">
                @csrf
                
                <div class="form-group row">
                    <label for="start" class="col-md-4 col-form-label text-md-right">Start Number</label>
                    <div class="col-md-6">
                        <input id="start" type="number" class="form-control @error('start') is-invalid @enderror" name="start" value="{{ old('start', 0) }}" required>
                        
                        @error('start')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="end" class="col-md-4 col-form-label text-md-right">End Number</label>
                    <div class="col-md-6">
                        <input id="end" type="number" class="form-control @error('end') is-invalid @enderror" name="end" value="{{ old('end', 100) }}" required>
                        
                        @error('end')
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
    
    @if(isset($evenNumbers))
        <div class="card mt-4">
            <div class="card-header">Results</div>
            
            <div class="card-body">
                <h5>Even numbers between {{ $start }} and {{ $end }}:</h5>
                
                <div class="row">
                    @foreach($evenNumbers as $number)
                        <div class="col-md-2 mb-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    <strong>{{ $number }}</strong>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection