@extends('layouts.master')

@section('title', 'Détails de l’agence')

@section('content')
<div class="dashboard">
    @include('partials.sidebar')
    <main class="main-content">
        @include('partials.navbar')
        <section class="content-area">
            <div class="card">
                <div class="card-header">
                    <h3>Détails de l’agence</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>ID :</strong> {{ $agency->id }}</li>
                        <li class="list-group-item"><strong>Nom :</strong> {{ $agency->name_agency }}</li>
                        <li class="list-group-item"><strong>Ligne :</strong> {{ $agency->line->name_line ?? '—' }}</li>
                        <li class="list-group-item"><strong>Adresse :</strong> {{ $agency->adress_agency }}</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('agencies.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection
