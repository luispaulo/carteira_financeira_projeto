@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <header class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="text-xl font-bold">💰 Sistema Financeiro</h1>

    </header>

    <main class="flex-1 flex items-center justify-center">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-700">Bem-vindo!</h2>
            <p class="text-gray-500 mt-2">Você está no painel do Sistema Financeiro.</p>
        </div>
    </main>

    <div class="form-group">
        <label for="receiver_id" class="form-label">Destinatário</label>
        <select name="receiver_id" id="receiver_id" class="form-control" required style="background-image: none; cursor: pointer;">
            <option value="" disabled selected>Selecione um usuário...</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
        @error('receiver_id')
            <span class="input-error">{{ $message }}</span>
        @enderror
    </div>
</body>
</html>
@endsection