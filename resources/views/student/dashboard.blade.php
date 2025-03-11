@extends('layouts.student')

@section('content')
<div class="dashboard-background">
    <div class="dashboard-overlay">
        <div class="dashboard-content">
            <h1>Halo, {{ Auth::user()->nama_lengkap }}!</h1>
            <p class="tagline">Siapkan diri dengan wawasan nyata dari dunia kerja</p>
        </div>
    </div>
</div>
@endsection

<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .dashboard-background {
        background-image: url('{{ asset("img/students-photo.jpg") }}');
        background-size: cover;
        background-position: center;
        height: 100%;
        width: 100%;
        position: relative;
    }

    .dashboard-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .dashboard-content h1 {
        font-size: 4rem;
        color: #fff;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .dashboard-content .tagline {
        font-size: 1.5rem;
        color: #fff;
        max-width: 600px;
        margin: 0 auto;
    }
</style>