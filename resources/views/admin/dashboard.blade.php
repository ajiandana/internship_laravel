@extends('layouts.administrator')

@section('content')
<div class="dashboard-background">
    <div class="container pt-4 mt-5">
        <h1>Halo, {{ Auth::user()->nama_lengkap }}</h1>
    </div>
</div>
@endsection

<style>
    .dashboard-background {
        background-image: url('{{ asset("img/background_admin.jpg") }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        width: 100vw;
        position: fixed;
        top: 0;
        left: 0;
    }
</style>