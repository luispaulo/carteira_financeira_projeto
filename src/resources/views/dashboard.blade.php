@extends('layouts.app')

@section('content')
<style>
    .page-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1e293b;
    }

    .page-header p {
        font-size: 0.9rem;
        color: #94a3b8;
        margin-top: 0.2rem;
    }

    /* GRID PRINCIPAL */
    .main-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 900px) {
        .main-grid { grid-template-columns: 1fr; }
    }

    /* CARDS */
    .card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.75rem;
    }

    .card-label {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .card-label svg {
        flex-shrink: 0;
    }

    /* SALDO */
    .balance-card {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border: none;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .balance-card::after {
        content: '';
        position: absolute;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
        bottom: -60px;
        right: -40px;
        pointer-events: none;
    }

    .balance-card .card-label {
        color: rgba(255,255,255,0.65);
    }

    .balance-amount {
        font-size: 2.4rem;
        font-weight: 700;
        letter-spacing: -0.03em;
        line-height: 1;
        margin-bottom: 0.3rem;
    }

    .balance-amount span {
        font-size: 1.1rem;
        font-weight: 500;
        margin-right: 0.2rem;
        opacity: 0.8;
    }

    .balance-hint {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.5);
        margin-top: 1rem;
    }

    /* FORMULÁRIOS */
    .field {
        margin-bottom: 1rem;
    }

    .field label {
        display: block;
        font-size: 0.82rem;
        font-weight: 500;
        color: #475569;
        margin-bottom: 0.35rem;
    }

    .field input,
    .field select {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.92rem;
        color: #1e293b;
        background: #f8fafc;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        appearance: none;
    }

    .field input:focus,
    .field select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        background: #fff;
    }

    .field input::placeholder {
        color: #cbd5e1;
    }

    .input-error {
        display: block;
        font-size: 0.78rem;
        color: #ef4444;
        margin-top: 0.3rem;
    }

    .btn-submit {
        width: 100%;
        padding: 0.72rem;
        border: none;
        border-radius: 10px;
        font-size: 0.92rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.15s;
        margin-top: 0.25rem;
    }

    .btn-submit:hover {
        opacity: 0.88;
        transform: translateY(-1px);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-deposit {
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
    }

    .btn-transfer {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
    }

    /* ALERTAS */
    .alert {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
    }

    /* HISTÓRICO */
    .history-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.75rem;
    }

    .history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .history-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    /* FILTROS */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: flex-end;
        padding: 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 1.25rem;
    }

    .filter-bar .field {
        margin-bottom: 0;
        flex: 1;
        min-width: 130px;
    }

    .filter-bar .field input,
    .filter-bar .field select {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
    }

    .btn-filter {
        padding: 0.5rem 1.1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: opacity 0.2s;
    }

    .btn-filter:hover { opacity: 0.85; }

    .btn-filter-apply {
        background: #6366f1;
        color: #fff;
    }

    .btn-filter-clear {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    /* TABELA */
    .table-wrap { overflow-x: auto; }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    thead th {
        text-align: left;
        padding: 0.6rem 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
        border-bottom: 1px solid #f1f5f9;
    }

    tbody td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid #f8fafc;
        color: #334155;
        vertical-align: middle;
    }

    tbody tr:last-child td { border-bottom: none; }

    tbody tr:hover td { background: #fafafa; }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.2rem 0.6rem;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .badge-deposit  { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .badge-transfer { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .badge-reversal { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }

    .tx-positive { color: #16a34a; font-weight: 600; }
    .tx-negative { color: #dc2626; font-weight: 600; }
    .tx-reversal { color: #d97706; font-weight: 600; }

    .status-completed { color: #16a34a; }
    .status-reversed  { color: #d97706; }
    .status-failed    { color: #dc2626; }

    .btn-reverse {
        font-size: 0.78rem;
        padding: 0.3rem 0.7rem;
        border-radius: 6px;
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #dc2626;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-reverse:hover { background: #fee2e2; }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #94a3b8;
        font-size: 0.9rem;
    }
</style>

<div class="page-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <h1>Olá, {{ Auth::user()->name }} 👋</h1>
        <p>{{ now()->format('l, d \d\e F \d\e Y') }}</p>
    </div>

    {{-- Alertas --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- Grid 3 colunas --}}
    <div class="main-grid">

        {{-- Saldo --}}
        <div class="card balance-card">
            <div class="card-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                Saldo disponível
            </div>
            <div class="balance-amount">
                <span>R$</span>{{ number_format((float) $wallet->balance, 2, ',', '.') }}
            </div>
            <p class="balance-hint">Atualizado agora</p>
        </div>

        {{-- Depósito --}}
        <div class="card">
            <div class="card-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                Depositar
            </div>
            <form action="{{ route('deposit') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="deposit_amount">Valor (R$)</label>
                    <input
                        type="number"
                        step="0.01"
                        min="0.01"
                        name="amount"
                        id="deposit_amount"
                        placeholder="0,00"
                        required
                    >
                    @error('amount') <span class="input-error">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn-submit btn-deposit">Depositar</button>
            </form>
        </div>

        {{-- Transferência --}}
        <div class="card">
            <div class="card-label">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                Transferir
            </div>
            <form action="{{ route('transfer') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="receiver_id">Destinatário</label>
                    <select name="receiver_id" id="receiver_id" required>
                        <option value="" disabled selected>Selecione...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('receiver_id') <span class="input-error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="transfer_amount">Valor (R$)</label>
                    <input
                        type="number"
                        step="0.01"
                        min="0.01"
                        name="amount"
                        id="transfer_amount"
                        placeholder="0,00"
                        required
                    >
                    @error('amount') <span class="input-error">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn-submit btn-transfer">Transferir</button>
            </form>
        </div>

    </div>

    {{-- Histórico --}}
    <div class="history-card">
        <div class="history-header">
            <span class="history-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                Histórico de transações
            </span>
        </div>

        {{-- Filtros --}}
        <form action="{{ route('dashboard') }}" method="GET">
            <div class="filter-bar">
                <div class="field">
                    <label>Tipo</label>
                    <select name="type">
                        <option value="">Todos</option>
                        <option value="deposit"  {{ ($filters['type'] ?? '') === 'deposit'  ? 'selected' : '' }}>Depósito</option>
                        <option value="transfer" {{ ($filters['type'] ?? '') === 'transfer' ? 'selected' : '' }}>Transferência</option>
                        <option value="reversal" {{ ($filters['type'] ?? '') === 'reversal' ? 'selected' : '' }}>Reversão</option>
                    </select>
                </div>
                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Todos</option>
                        <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Concluída</option>
                        <option value="reversed"  {{ ($filters['status'] ?? '') === 'reversed'  ? 'selected' : '' }}>Revertida</option>
                        <option value="failed"    {{ ($filters['status'] ?? '') === 'failed'    ? 'selected' : '' }}>Falhada</option>
                    </select>
                </div>
                <div class="field">
                    <label>De</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="field">
                    <label>Até</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div style="display:flex; gap:0.5rem; align-items:flex-end;">
                    <button type="submit" class="btn-filter btn-filter-apply">Filtrar</button>
                    @if (!empty(array_filter($filters ?? [])))
                        <a href="{{ route('dashboard') }}" class="btn-filter btn-filter-clear">Limpar</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Tabela --}}
        <div class="table-wrap">
            @if ($transactions->isEmpty())
                <div class="empty-state">Nenhuma movimentação encontrada.</div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                            <th>Partes</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $tx)
                            @php
                                $isSender   = $tx->sender_id   === auth()->id();
                                $isReceiver = $tx->receiver_id  === auth()->id();
                            @endphp
                            <tr>
                                <td style="color:#94a3b8; font-size:0.82rem;">
                                    {{ $tx->created_at->format('d/m/Y') }}<br>
                                    <span style="font-size:0.75rem;">{{ $tx->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $tx->type }}">
                                        @if ($tx->type === 'deposit') Depósito
                                        @elseif ($tx->type === 'transfer') Transferência
                                        @else Reversão @endif
                                    </span>
                                </td>
                                <td>
                                    @if ($tx->type === 'deposit')
                                        <span class="tx-positive">+ R$ {{ number_format($tx->amount, 2, ',', '.') }}</span>
                                    @elseif ($tx->type === 'reversal')
                                        <span class="tx-reversal">{{ $isReceiver ? '+' : '-' }} R$ {{ number_format($tx->amount, 2, ',', '.') }}</span>
                                    @else
                                        @if ($isSender)
                                            <span class="tx-negative">- R$ {{ number_format($tx->amount, 2, ',', '.') }}</span>
                                        @else
                                            <span class="tx-positive">+ R$ {{ number_format($tx->amount, 2, ',', '.') }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td style="font-size:0.83rem; color:#64748b;">
                                    @if ($tx->type === 'deposit') —
                                    @elseif ($tx->type === 'transfer')
                                        @if ($isSender) Para: <strong>{{ $tx->receiver?->name }}</strong>
                                        @else De: <strong>{{ $tx->sender?->name }}</strong> @endif
                                    @else
                                        Estorno @if($tx->reversedTransaction) #{{ $tx->reversed_transaction_id }} @endif
                                    @endif
                                </td>
                                <td>
                                    <span class="status-{{ $tx->status }}">
                                        @if ($tx->status === 'completed') Concluída
                                        @elseif ($tx->status === 'reversed') Revertida
                                        @else Falhada @endif
                                    </span>
                                </td>
                                <td>
                                    @if ($tx->status === 'completed' && $tx->type !== 'reversal')
                                        <form action="{{ route('reverse', $tx->id) }}" method="POST" onsubmit="return confirm('Reverter esta transação?')">
                                            @csrf
                                            <button type="submit" class="btn-reverse">Reverter</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top:1.25rem;">
                    {{ $transactions->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection