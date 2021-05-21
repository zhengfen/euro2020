@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvenu(e)</div>
                <div class="card-body">
                    <h2>R&eacute;glement des pronostics de Foot</h2>
                    <strong>Principes:</strong>
                    <ul>
                        <li>1 feuille de pronostic par personne</li>
                        <li>Il n'y a pas de date limite pour l'inscription.</li>
                        <li><strong>Les r&eacute;sultats peuvent &ecirc;tre modifi&eacute;s jusqu'&agrave; un jour avant le premier match</strong></li>
                    </ul>
                    <strong>D&eacute;compte des points</strong>
                    <ol>
                        <li><strong>Premier tour (poules)</strong>
                            <ul>
                                <li>2 points pour avoir choisi la bonne &eacute;quipe gagnante (ou match nul)</li>
                                <li>1 point suppl&eacute;ntaire pour le score d'une &eacute;quipe du match correct</li>
                            </ul>
                        </li>
                        <li><strong>Huiti&egrave;es de finale</strong>
                            <ul>
                                <li>4 points pour avoir choisi la bonne &eacute;quipe qualifi&eacute;e>
                            </ul>
                        </li>
                        <li><strong>Quart de finale</strong>
                            <ul>
                                <li>6 points pour avoir choisi la bonne &eacute;quipe qualifi&eacute;e</li>
                            </ul>
                        </li>
                        <li><strong>Semi-finale</strong>
                            <ul>
                                <li>8 points pour avoir choisi la bonne &eacute;quipe qualifi&eacute;e</li>
                            </ul>
                        </li>
                        <li><strong>Finale</strong>
                            <ul>
                                <li>10 points pour avoir choisi la bonne &eacute;quipe qualifi&eacute;e</li>
                                <li>20 points pour avoir choisi le bon champion</li>
                            </ul>
                        </li>
                    </ol>
                    <a href="https://github.com/lsv/fifa-worldcup-2018-jsfrontend">Based on : lsv/fifa-worldcup-2018-jsfrontend</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection