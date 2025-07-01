<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header, .footer {
            background-color: #1e3a8a;
            color: white;
            padding: 15px;
        }
        .section {
            padding: 15px;
            border-bottom: 1px solid #ccc;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f0f0f0;
            text-align: left;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: bold;
        }
        .green { background: #d1fae5; color: #065f46; }
        .red { background: #fee2e2; color: #991b1b; }
        .yellow { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div style="float: left;">
                <div class="title">Facture de Pharmacie</div>
                <div>Commande n° {{ $commande->reference }}</div>
            </div>
            <div style="float: right; text-align: right;">
                <div>Date : {{ $commande->created_at->format('d/m/Y') }}</div>
                <div>
                    Statut :
                    <span class="badge
                        @if($commande->status == 'validee') green
                        @elseif($commande->status == 'rejetee') red
                        @else yellow @endif">
                        {{ ucfirst($commande->status) }}
                    </span>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>

        <!-- Infos pharmacie et client -->
        <div class="section">
            <div style="width: 48%; float: left;">
                <strong>Pharmacie</strong><br>
                {{ $commande->pharmacy->name }}<br>
                {{ $commande->pharmacy->address }}<br>
                {{ $commande->pharmacy->phone }}
            </div>
            <div style="width: 48%; float: right;">
                <strong>Client</strong><br>
                {{ $commande->user->name }}<br>
                {{ $commande->user->email }}
            </div>
            <div style="clear: both;"></div>
        </div>

        <!-- Détails de la commande -->
        <div class="section">
            <strong>Détails de la commande</strong>
            <table class="table">
                <thead>
                    <tr>
                        <th>Médicament</th>
                        <th>Dosage</th>
                        <th>Quantité</th>
                        <th>Prix</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->medications as $med)
                    <tr>
                        <td>
                            {{ $med->name }}<br>
                            <small>{{ $med->generic_name }}</small>
                        </td>
                        <td>{{ $med->strength }} {{ $med->dosage_form }}</td>
                        <td>{{ $med->pivot->quantity }}</td>
                        <td>{{ number_format($med->price, 2) }} MRU</td>
                        <td>{{ number_format($med->pivot->total_price, 2) }} MRU</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Résumé -->
        <div class="section" style="text-align: right;">
            <strong>Total :</strong>
            {{ number_format($commande->medications->sum('pivot.total_price'), 2) }} MRU
        </div>

        <!-- Motif rejet -->
        @if($commande->status == 'rejetee' && $commande->reject_reason)
        <div class="section" style="background-color: #fee2e2; color: #991b1b;">
            <strong>Motif du rejet :</strong><br>
            {{ $commande->reject_reason }}
        </div>
        @endif

        <!-- Footer -->
        <div class="footer" style="text-align: center;">
            Merci pour votre commande ! Pour toute question, contactez notre pharmacie.<br>
            © {{ date('Y') }} {{ $commande->pharmacy->name }}
        </div>
    </div>
</body>
</html>
