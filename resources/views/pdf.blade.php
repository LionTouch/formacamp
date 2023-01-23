<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="app">

<head>
    <base href="/">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/css/bootstrap.min.css')}}">
<style>

    .page-break {
        page-break-after: always;
    }


    @if($pdf !== 'certificat')
     @page {
        margin: 150px 25px;
    }
        body {
            line-height: 16px;
            font-size: 12px;
        }
    header {
        position: fixed;
        top: -140px;
        left: 0px;
        right: 0px;
        height: 150px;
        text-align: left;
        line-height: 2px;
    }
    footer {
        position: fixed;
        bottom: -150px;
        left: 0px;
        right: 0px;
        height: 50px;
        text-align: left;
    }
    @else
     @page {
        margin: 0px 0px;
    }
    footer {
        position: fixed;
        bottom: 30px;
        left: 20px;
        right: 20px;
        height: 50px;
        text-align: center;
    }
     body{
        background: url("{{ asset('resources/assets/images/certif.png') }}");
        /*background-size: 100% 100%;*/
        background-repeat: no-repeat;
        background-size: cover;

            line-height: 22px;
            font-size: 24px;
        }
    @endif
</style>
</head>

<body>
@if($pdf !== 'certificat')
<header>
    <div class="row">
        <div class="col text-left">
            <h5>{{$NOM_ORGANISME}}</h5>
            <p>{{$NOM_LIEU_FORMATION}}</p>
            <p>{{$EMAIL_ORGANISME}}</p>
            <p>{{$TELEPHONE_ORGANISME}}</p>
        </div>
        <div class="col text-right" >
            <img style="height: 100px" src="{{asset('resources/assets/images/logo.png')}}">
        </div>
    </div>

</header>

<footer>
    <p>{{$NOM_ORGANISME}} | {{$NOM_LIEU_FORMATION}} | Numéro SIRET: {{$SIRET_ORGANISME}} | N° TVA: {{$NUM_TVA_ORGANISME}} | Numéro de
    déclaration d'activité: {{$NUM_DEC_ORGANISME}}</p>
</footer>
@else

    <footer>
        <div class="row" style="font-size: 18px; line-height: 18px;display: inline-flex">
            <div class="col" style="text-align: left">
                <p>.............................</p>
                <p style="padding-left: 20px">Le formateur</p>
            </div>
            <div class="col text-center font-weight-bold" style="color: #2294ad">
                <p>Identifiant:{{$REF}}</p>
                <p>FormaCamp</p>
            </div>
            <div class="col" style="text-align: right">
                <p>.............................</p>
                <p style="padding-right: 20px">La direction</p>
            </div>
        </div>
    </footer>
@endif
@if($pdf === 'emargement')
    @foreach($apprenants as $apprenant)
        <div class='iq-card'>
            <div class='iq-card-body'>
                <h4 class='font-weight-bold text-center'>Feuille d'émargement</h4>
                                <div class='col-md-12 border'>
                                       <p>Nom du stagiaire: {{$apprenant->NOM}} {{$apprenant->PRENOM}} </p>
                                       <p>Nom de la formation: {{$NOM}}</p>
                                       <p>Date de la formation: Du {{strftime('%A le %e %B, %Y', strtotime($DEBUT))}} au {{strftime('%A le %e %B, %Y', strtotime($FIN))}}</p>
                                       <p>Lieu de la formation: {{$NOM_LIEU_FORMATION}}</p>
                                       <p>Durée: {{$DUREE_TOTALE}}h</p>
                                       <p>Prestataire de la formation: {{$NOM_ORGANISME}}</p>
                                       <p>Client de la formation: {{$NOM_CLIENT}}</p>
                                       <p>Formateurs:
                                           @foreach($intervenants as $intervenant)
                                               {{$intervenant['NOM']}} {{$intervenant['PRENOM']}},
                                           @endforeach
                                       </p>
                                    </div>
                                 <div class='col-md-12 mt-3'>
                                        <table class='table mb-0 table-bordered'>
                                                <thead>
                                                <tr>
                                                        <th scope='col text-center'>N°</th>
                                                        <th scope='col'>Date</th>
                                                        <th scope='col'>Durée</th>
                                                        <th scope='col'>Signature apprenant</th>
                                                        <th scope='col'>Signature intervenant</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($seances as $key=>$seance)
                                                        <tr>
                                                           <td class='text-center'>{{$key+1}}</td>
                                                           <td>{{strftime('%e %B %Y', strtotime($seance['DATE']))}} -
                                                               {{$seance['NOM_TYPE_SEANCE']}}</td>
                                                           <td>{{$seance['DUREE_TIME']}}h <br>{{$seance['HD']}} à {{$seance['HF']}}</td>
                                                           <td></td>
                                                           <td></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                     </div>
                                <p class='mt-1'>Signature et tampon de l'organisme</p>
                                <p class='mt-1'>Fait à {{$NOM_ORGANISME}} -{{$NOM_LIEU_FORMATION}}, le </p>
                            </div>
        </div>
        @if($loop->iteration<count($apprenants))
            <div class="page-break"></div>
        @endif
    @endforeach
@elseif($pdf === 'devis')

    <div class="iq-card prevent-split">

        <div class="iq-card-body">
            <h4 class="font-weight-bold text-center">Devis de formation professionnelle</h4>
            <p class="col-md-12  text-right">Date du devis: <b>{{strftime('%e %B %Y', strtotime($DATE))}}</b></p>
            <div class="col-md-12" style="line-height: 10px;">
                <p>Devis de Formation Professionnelle n°{{$REF}}</p>
                <p>Destinataire: {{$NOM_CLIENT}}</p>
                <p>Situé: {{$ADRESSE_CLIENT}}</p>

                <p>Organisateur de la formation: {{$NOM_ORGANISME}}</p>
                <p>Situé: {{$NOM_LIEU_FORMATION}}</p>
                <p>Numéro SIRET: {{$SIRET_ORGANISME}}</p>
                <p>Représenté par: {{$NOM_ADMIN}} {{$PRENOM_ADMIN}}</p>
                <h6 class="font-weight-bold">1. Objet, nature et durée de la formation</h6>
                <ul>
                    <li> Intitulé de la formation: {{$NOM}}</li>
                    <li> Type d’action de formation (au sens de l’article L6313-1 du code du travail): {{$NOM_ACTION}}</li>
                    <li> Durée: {{$DUREE_TOTALE}}h ({{$DUREE_TOTALE_J}} jours)</li>
                    <li> Dates de la formation: du {{strftime('%e %B %Y', strtotime($DEBUT))}} au {{strftime('%e %B %Y', strtotime($FIN))}}</li>
                    <li> Lieu de la formation: {{$NOM_LIEU_FORMATION}}</li>
                    <li> Effectifs formés du bénéficiaire: {{count($apprenants)}}</li>
                </ul>
                <h6 class="font-weight-bold">2. Programme de la formation et formateur</h6>
                <p>La description détaillée du programme de formation et du formateur est fournie en annexe.</p>
                <h6 class="font-weight-bold">3. Prix de la formation</h6>
                <div class="row">
                    <table class="table mb-0 table-bordered">
                        <tbody>
                        @foreach($modules as $module)
                            <tr>
                                <td class="text-center align-middle">Module: {{$module['NOM']}} <br>Durée:{{count($module['prix'])>0?$module['prix'][0]['NBR_HEURE']:0}}h ({{count($module['prix'])>0?$module['prix'][0]['NBR_JOUR']:0}} jours)</td>
                                <td class="p-0">
                                    <table class="table mb-0 table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Prix unitaire HT</th>
                                                <th>Prix total HT</th>
                                                <th>Taux de TVA</th>
                                                <th>TVA</th>
                                                <th>Prix total TTC</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($module['prix'] as $prix)
                                            <tr>
                                                <td>{{$prix['NOM_TYPE_PRIX']}} :({{$prix['NOM_TARIF']}})</td>
                                                <td>{{$prix['PRIX']}}€</td>
                                                <td>{{$prix['PRIX_HT']}}€</td>
                                                <td>{{$prix['TVA']}}%</td>
                                                <td>{{$prix['PRIX_TVA']}}€</td>
                                                <td>{{$prix['PRIX_TTC']}}€</td>
                                            </tr>
                                        @endforeach
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right">Prix total module TTC:</td>
                                                <td>{{collect($module['prix'])->sum('PRIX_TTC')}}€</td>
                                            </tr>
                                        </tfoot>
                                        </tbody>
                                    </table>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right">
                                    <h6 class="font-weight-bold">
                                        Prix total formation TTC: {{collect($modules)->pluck('prix')->flatten(1)->sum('PRIX_TTC')}}€
                                    </h6>
                                </td>

                            </tr>
                        </tfoot>
                    </table>


                </div>
                <h6 class="font-weight-bold">4. Durée de validité du devis</h6>
                <p>Ce devis sera valable pour une durée de 30 jours.</p>

                <div class="row">
                    <div class="col text-left">
                        <p>Pour l'organisme de formation,</p>
                        <p>{{$NOM_ORGANISME}},</p>
                        <p>{{$NOM_ADMIN}} {{$PRENOM_ADMIN}}</p>
                    </div>
                    <div class="col text-right">
                        <p>Pour le bénéficiaire, bon pour accord</p>
                        <p>{{$NOM_CLIENT}}</p>
                    </div>
                </div>


            </div>
        </div>
    </div>


@elseif($pdf === 'contrat')
    <div class='iq-card'>

        <div class='iq-card-body'>
            <h4 class='font-weight-bold text-center'>Contrat de formation professionnelle</h4>
            <div class='col-md-12'>
                <p>Entre l'organisme de formation: {{$NOM_ORGANISME}}</p>
                <p>(ci-après nommé l'organisme de formation)</p>
                <p>Situé: {{$NOM_LIEU_FORMATION}}</p>
                <p>Déclaration d'activité n° {{$NUM_DEC_ORGANISME}} ({{$REGION_ACQUISITON_ORGANISME}})</p>
                <p>Numéro SIRET: {{$SIRET_ORGANISME}}</p>
                <p>Représenté par: {{$NOM_ADMIN}} {{$PRENOM_ADMIN}}</p>


                <p>Client de la formation: {{$NOM_CLIENT}}</p>
                <p>(ci-après nommé le bénéficiaire)</p>
                <p>Situé: {{$ADRESSE_CLIENT}}</p>
                <p>Est conclue la convention suivante en application des dispositions du livre III de la sixième partie du code du travail portant sur l'organisation de la formation professionnelle. </p>

                <h6 class="font-weight-bold">1. Objet, nature et durée de la formation</h6>
                <p>Le bénéficiaire entend participer à l’action de formation suivante organisée par l’organisme de formation.</p>
                <div class="col-md-12 iq-bg-secondary text-center font-weight-bold">Ma session de formation</div>
                <p>Type d’action de formation (art. L6313-1 du code du travail): {{$NOM_ACTION}}</p>
                <p>Diplôme visé: {{$TITRE_VISE}}</p>
                <p>Durée: {{$DUREE_TOTALE}}h ({{$DUREE_TOTALE_J}} jours) </p>
                <p>Lieu de la formation: {{$NOM_LIEU_FORMATION}}</p>
                <p>Dates de formation: {{$NOM_LIEU_FORMATION}}</p>
                <ul>
                    @foreach($seances_dates as $key=>$seance)
                    <li> {{strftime(' %e %B %Y', strtotime($key))}} -
                        @if($seance->where('ID_TYPE_SEANCE',1)->count()>0 && $seance->where('ID_TYPE_SEANCE',2)->count()>0)
                            matin et après-midi
                        @elseif($seance->where('ID_TYPE_SEANCE',1)->count()>0)
                            matin
                        @elseif($seance->where('ID_TYPE_SEANCE',2)->count()>0)
                            après-midi
                        @endif
                    </li>
                    @endforeach
                </ul>

                <h6 class="font-weight-bold">2. Programme de la formation et formateur</h6>
                <p>La description détaillée du programme de formation et du formateur est fournie en annexe. Le niveau de connaissances préalables requis pour suivre la formation et obtenir les qualifications auxquelles elle prépare est détaillé dans ce programme.</p>

                <h6 class="font-weight-bold">3. Engagement de participation à l'action de formation</h6>
                <p>Le bénéficiaire s’engage à assurer sa présence aux dates et lieux prévus ci-dessus.</p>

                <h6 class="font-weight-bold">4. Prix de la formation</h6>
                <p>En contrepartie de cette action de formation, le bénéficiaire s'acquittera des coûts suivants qui couvrent l'intégralité des frais engagés par l'organisme de formation pour cette session:
                </p>

                <div class='col-md-12 mt-3'>
                    <table class="table mb-0 table-bordered">
                        <tbody>
                        @foreach($modules as $module)
                            <tr>
                                <td class="text-center align-middle">Module: {{$module['NOM']}} <br>Durée:{{count($module['prix'])>0?$module['prix'][0]['NBR_HEURE']:0}}h ({{count($module['prix'])>0?$module['prix'][0]['NBR_JOUR']:0}} jours)</td>
                                <td class="p-0">
                                    <table class="table mb-0 table-bordered">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Prix unitaire HT</th>
                                            <th>Prix total HT</th>
                                            <th>Taux de TVA</th>
                                            <th>TVA</th>
                                            <th>Prix total TTC</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($module['prix'] as $prix)
                                            <tr>
                                                <td>{{$prix['NOM_TYPE_PRIX']}} :({{$prix['NOM_TARIF']}}) </td>
                                                <td>{{$prix['PRIX']}}€ </td>
                                                <td>{{$prix['PRIX_HT']}}€</td>
                                                <td>{{$prix['TVA']}}%</td>
                                                <td>{{$prix['PRIX_TVA']}}€</td>
                                                <td>{{$prix['PRIX_TTC']}}€</td>
                                            </tr>

                                        @endforeach
                                        <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right">Prix total module TTC:</td>
                                            <td>{{collect($module['prix'])->sum('PRIX_TTC')}}€</td>
                                        </tr>
                                        </tfoot>
                                        </tbody>
                                    </table>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2" class="text-right">
                                <h6 class="font-weight-bold">
                                    Prix total formation TTC: {{collect($modules)->pluck('prix')->flatten(1)->sum('PRIX_TTC')}}€
                                </h6>
                            </td>

                        </tr>
                        </tfoot>
                    </table>
                </div>

                <h6 class="font-weight-bold">5. Modalités de règlement</h6>
                <p>Le paiement sera dû à réception d'une facture émise par l'organisme de formation à destination du bénéficiaire.</p>
                <p>Le bénéficiaire s’engage à verser la somme due selon les modalités de paiement suivantes:</p>
                <ul>
                    <li> Après un délai de rétractation mentionné à l’article 9 du présent contrat, le stagiaire effectue un premier versement d’un montant de 30% du total.</li>
                    <li> Le paiement du solde, à la charge du bénéficiaire, devra être fait le lendemain du dernier jour de l'action de formation.</li>
                </ul>


                <h6 class="font-weight-bold">6. Moyens pédagogiques et techniques mis en œuvre</h6>
                <p>Voir le programme de formation en annexe détaillant les moyens mis en œuvre pour réaliser techniquement l'action, suivre son exécution et apprécier ses résultats. Une feuille d’émargement signée par le(s) stagiaire(s) et le formateur, par demi-journée de formation, permettra de justifier de la réalisation de la prestation.</p>

                <h6 class="font-weight-bold">7. Sanction de la formation</h6>
                <p>En application de l’article L.6353-1 du Code du Travail, une attestation mentionnant les objectifs, la nature et la durée de l’action et les résultats de l’évaluation des acquis de la formation sera remise au(x) stagiaire(s) à l’issue de la formation.</p>

                <h6 class="font-weight-bold">8. Non réalisation de la prestation de formation</h6>
                <p>En application de l’article L6354-1 du Code du travail, il est convenu entre les signataires de la présente convention, que faute de réalisation totale ou partielle de la prestation de formation, l’organisme prestataire doit rembourser au cocontractant les sommes indûment perçues de ce fait.
                </p>

                <h6 class="font-weight-bold">9. Dédommagement, réparation ou dédit</h6>
                <p>A compter de la date de signature du présent contrat, le bénéficiaire a un délai de 10 jours pour se rétracter. Le délai de rétractation est porté à 14 jours (article L.121-16 du Code de la consommation) pour les contrats conclus « à distance » et les contrats conclus « hors établissement ». Il en informe l’organisme de formation par lettre recommandée avec accusé de réception. Dans ce cas, aucune somme ne peut être exigée du bénéficiaire.
                </p>
                <p>Si le bénéficiaire est empêché de suivre la formation par suite de force majeure dûment reconnue, le contrat de formation professionnelle est résilié. Dans ce cas, seules les prestations effectivement dispensées sont dues au prorata temporis de leur valeur prévue au présent contrat.
                </p>
                <p>En cas de renoncement par le bénéficiaire avant le début du programme de formation</p>
                <ul>
                    <li> Dans un délai supérieur à 1 mois avant le début de la formation : 50% du coût de la formation est dû.</li>
                    <li> Dans un délai compris entre 1 mois et 2 semaines avant le début de la formation : 70 % du coût de la formation est dû.</li>
                    <li> Dans un délai inférieur à 2 semaines avant le début de la formation : 100 % du coût de la formation est dû.</li>
                </ul>
                <p>Le coût ne pourra faire l’objet d’une demande de remboursement ou de prise en charge par l'OPCA</p>


                <h6 class="font-weight-bold">10. Litiges</h6>
                <p>Si une contestation ou un différent ne peuvent pas être réglés à l’amiable, le Tribunal de SENLIS sera seul compétent pour régler le litige.</p>
                <p>Document réalisé en 2 exemplaires à MONTATAIRE , le 28 octobre 2021.</p>

            </div>
            <div class="row">
                <div class="col text-left">
                    <p>Pour l'organisme de formation,</p>
                    <p>{{$NOM_ORGANISME}},</p>
                    <p>{{$NOM_ADMIN}} {{$PRENOM_ADMIN}}</p>
                </div>
                <div class="col text-right">
                    <p>Pour le bénéficiaire, bon pour accord</p>
                    <p>{{$NOM_CLIENT}}</p>
                </div>
            </div>

        </div>
    </div>

@elseif($pdf === 'attestation')
    @foreach($apprenants as $apprenant)
        <div class='iq-card'>
            <div class='iq-card-body'>
                <h4 class='font-weight-bold text-center'>Attestation d'assiduité</h4>
                <div class='col-md-12'>
                    <p>Je, soussigné: {{$NOM_ADMIN}} {{$PRENOM_ADMIN}}, représentant de l'organisme de formation {{$NOM_ORGANISME}},</p>
                    <p>atteste que: {{$apprenant->NOM}} {{$apprenant->PRENOM}}</p>
                    <p>a suivi la formation:</p>
                    <div class="col-md-12 iq-bg-secondary text-center" style="background: #f1f2f1 ">
                        <h2>{{$NOM}}</h2>
                    </div>

                    <p>Lieu de la formation: {{$NOM_LIEU_FORMATION}}</p>
                    <p>Dates de la formation: du {{strftime('%e %B %Y', strtotime($DEBUT))}} au {{strftime('%e %B %Y', strtotime($FIN))}}</p>
                    <p>Durée de la formation: {{$DUREE_TOTALE}}h ({{$DUREE_TOTALE_J}} jours)</p>
                    <p>Type d'action de formation: {{$NOM_ACTION}}</p>


                    <h5>Assiduité du stagiaire</h5>
                    <p>Durée effectivement suivie par le/la stagiaire:{{$apprenant->DUREE_TOTALE}}h</p>
                    <p>soit un taux de réalisation de {{$apprenant->PERCENT}}%</p>



                </div>
                <div class="row">
                    <div class="col text-left">
                        <p>fait à, le {{strftime('%e %B %Y', strtotime(date('Y-m-d H:i:s')))}}</p>
                    </div>
                    <div class="col text-right">

                    </div>
                </div>

            </div>
        </div>
        @if($loop->iteration<count($apprenants))
            <div class="page-break"></div>
        @endif
    @endforeach
@elseif($pdf === 'certificat')
    @foreach($apprenants as $apprenant)
        <div class='iq-card'>

        <div class='iq-card-body'>
            <div class='col-md-12' style="padding: 300px 120px 0 100px">
                <p class='font-weight-bold text-center'>Je soussignée {{$NOM_ADMIN}} {{$PRENOM_ADMIN}}, Directeur de {{$NOM_ORGANISME}}, certifie que </p>
                <p class='text-center'>{{$apprenant->CIVILITE===1?'Mr':'Mme'}}.{{$apprenant->NOM}} {{$apprenant->PRENOM}}, {{$apprenant->DATE_NAISS!== null?' Né le '.strftime('%d/%m/%Y', strtotime(date($apprenant->DATE_NAISS))).', ':''}}CIN: {{$apprenant->NUM_SEC}}</p>
                <p class='font-weight-bold text-center'>A validé la session de certification:</p>
                <h3 class='font-weight-bold text-center' style="color: #d9896a">{{$NOM}}</h3>
            </div>

        </div>
    </div>
        @if($loop->iteration<count($apprenants))
            <div class="page-break"></div>
        @endif
    @endforeach
@endif

</body>

</html>
