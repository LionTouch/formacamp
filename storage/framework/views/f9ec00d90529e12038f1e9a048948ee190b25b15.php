<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" ng-app="app">

<head>
    <base href="/">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('resources/assets/css/bootstrap.min.css')); ?>">
<style>

    .page-break {
        page-break-after: always;
    }


    <?php if($pdf !== 'certificat'): ?>
     @page  {
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
    <?php else: ?>
     @page  {
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
        background: url("<?php echo e(asset('resources/assets/images/certif.png')); ?>");
        /*background-size: 100% 100%;*/
        background-repeat: no-repeat;
        background-size: cover;

            line-height: 22px;
            font-size: 24px;
        }
    <?php endif; ?>
</style>
</head>

<body>
<?php if($pdf !== 'certificat'): ?>
<header>
    <div class="row">
        <div class="col text-left">
            <h5><?php echo e($NOM_ORGANISME); ?></h5>
            <p><?php echo e($NOM_LIEU_FORMATION); ?></p>
            <p><?php echo e($EMAIL_ORGANISME); ?></p>
            <p><?php echo e($TELEPHONE_ORGANISME); ?></p>
        </div>
        <div class="col text-right" >
            <img style="height: 100px" src="<?php echo e(asset('resources/assets/images/logo.png')); ?>">
        </div>
    </div>

</header>

<footer>
    <p><?php echo e($NOM_ORGANISME); ?> | <?php echo e($NOM_LIEU_FORMATION); ?> | Numéro SIRET: <?php echo e($SIRET_ORGANISME); ?> | N° TVA: <?php echo e($NUM_TVA_ORGANISME); ?> | Numéro de
    déclaration d'activité: <?php echo e($NUM_DEC_ORGANISME); ?></p>
</footer>
<?php else: ?>

    <footer>
        <div class="row" style="font-size: 18px; line-height: 18px;display: inline-flex">
            <div class="col" style="text-align: left">
                <p>.............................</p>
                <p style="padding-left: 20px">Le formateur</p>
            </div>
            <div class="col text-center font-weight-bold" style="color: #2294ad">
                <p>Identifiant:<?php echo e($REF); ?></p>
                <p>FormaCamp</p>
            </div>
            <div class="col" style="text-align: right">
                <p>.............................</p>
                <p style="padding-right: 20px">La direction</p>
            </div>
        </div>
    </footer>
<?php endif; ?>
<?php if($pdf === 'emargement'): ?>
    <?php $__currentLoopData = $apprenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apprenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class='iq-card'>
            <div class='iq-card-body'>
                <h4 class='font-weight-bold text-center'>Feuille d'émargement</h4>
                                <div class='col-md-12 border'>
                                       <p>Nom du stagiaire: <?php echo e($apprenant->NOM); ?> <?php echo e($apprenant->PRENOM); ?> </p>
                                       <p>Nom de la formation: <?php echo e($NOM); ?></p>
                                       <p>Date de la formation: Du <?php echo e(strftime('%A le %e %B, %Y', strtotime($DEBUT))); ?> au <?php echo e(strftime('%A le %e %B, %Y', strtotime($FIN))); ?></p>
                                       <p>Lieu de la formation: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                                       <p>Durée: <?php echo e($DUREE_TOTALE); ?>h</p>
                                       <p>Prestataire de la formation: <?php echo e($NOM_ORGANISME); ?></p>
                                       <p>Client de la formation: <?php echo e($NOM_CLIENT); ?></p>
                                       <p>Formateurs:
                                           <?php $__currentLoopData = $intervenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intervenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <?php echo e($intervenant['NOM']); ?> <?php echo e($intervenant['PRENOM']); ?>,
                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                    <?php $__currentLoopData = $seances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$seance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                           <td class='text-center'><?php echo e($key+1); ?></td>
                                                           <td><?php echo e(strftime('%e %B %Y', strtotime($seance['DATE']))); ?> -
                                                               <?php echo e($seance['NOM_TYPE_SEANCE']); ?></td>
                                                           <td><?php echo e($seance['DUREE_TIME']); ?>h <br><?php echo e($seance['HD']); ?> à <?php echo e($seance['HF']); ?></td>
                                                           <td></td>
                                                           <td></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                     </div>
                                <p class='mt-1'>Signature et tampon de l'organisme</p>
                                <p class='mt-1'>Fait à <?php echo e($NOM_ORGANISME); ?> -<?php echo e($NOM_LIEU_FORMATION); ?>, le </p>
                            </div>
        </div>
        <?php if($loop->iteration<count($apprenants)): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php elseif($pdf === 'devis'): ?>

    <div class="iq-card prevent-split">

        <div class="iq-card-body">
            <h4 class="font-weight-bold text-center">Devis de formation professionnelle</h4>
            <p class="col-md-12  text-right">Date du devis: <b><?php echo e(strftime('%e %B %Y', strtotime($DATE))); ?></b></p>
            <div class="col-md-12" style="line-height: 10px;">
                <p>Devis de Formation Professionnelle n°<?php echo e($REF); ?></p>
                <p>Destinataire: <?php echo e($NOM_CLIENT); ?></p>
                <p>Situé: <?php echo e($ADRESSE_CLIENT); ?></p>

                <p>Organisateur de la formation: <?php echo e($NOM_ORGANISME); ?></p>
                <p>Situé: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                <p>Numéro SIRET: <?php echo e($SIRET_ORGANISME); ?></p>
                <p>Représenté par: <?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?></p>
                <h6 class="font-weight-bold">1. Objet, nature et durée de la formation</h6>
                <ul>
                    <li> Intitulé de la formation: <?php echo e($NOM); ?></li>
                    <li> Type d’action de formation (au sens de l’article L6313-1 du code du travail): <?php echo e($NOM_ACTION); ?></li>
                    <li> Durée: <?php echo e($DUREE_TOTALE); ?>h (<?php echo e($DUREE_TOTALE_J); ?> jours)</li>
                    <li> Dates de la formation: du <?php echo e(strftime('%e %B %Y', strtotime($DEBUT))); ?> au <?php echo e(strftime('%e %B %Y', strtotime($FIN))); ?></li>
                    <li> Lieu de la formation: <?php echo e($NOM_LIEU_FORMATION); ?></li>
                    <li> Effectifs formés du bénéficiaire: <?php echo e(count($apprenants)); ?></li>
                </ul>
                <h6 class="font-weight-bold">2. Programme de la formation et formateur</h6>
                <p>La description détaillée du programme de formation et du formateur est fournie en annexe.</p>
                <h6 class="font-weight-bold">3. Prix de la formation</h6>
                <div class="row">
                    <table class="table mb-0 table-bordered">
                        <tbody>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center align-middle">Module: <?php echo e($module['NOM']); ?> <br>Durée:<?php echo e(count($module['prix'])>0?$module['prix'][0]['NBR_HEURE']:0); ?>h (<?php echo e(count($module['prix'])>0?$module['prix'][0]['NBR_JOUR']:0); ?> jours)</td>
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
                                        <?php $__currentLoopData = $module['prix']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prix): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($prix['NOM_TYPE_PRIX']); ?> :(<?php echo e($prix['NOM_TARIF']); ?>)</td>
                                                <td><?php echo e($prix['PRIX']); ?>€</td>
                                                <td><?php echo e($prix['PRIX_HT']); ?>€</td>
                                                <td><?php echo e($prix['TVA']); ?>%</td>
                                                <td><?php echo e($prix['PRIX_TVA']); ?>€</td>
                                                <td><?php echo e($prix['PRIX_TTC']); ?>€</td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right">Prix total module TTC:</td>
                                                <td><?php echo e(collect($module['prix'])->sum('PRIX_TTC')); ?>€</td>
                                            </tr>
                                        </tfoot>
                                        </tbody>
                                    </table>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right">
                                    <h6 class="font-weight-bold">
                                        Prix total formation TTC: <?php echo e(collect($modules)->pluck('prix')->flatten(1)->sum('PRIX_TTC')); ?>€
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
                        <p><?php echo e($NOM_ORGANISME); ?>,</p>
                        <p><?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?></p>
                    </div>
                    <div class="col text-right">
                        <p>Pour le bénéficiaire, bon pour accord</p>
                        <p><?php echo e($NOM_CLIENT); ?></p>
                    </div>
                </div>


            </div>
        </div>
    </div>


<?php elseif($pdf === 'contrat'): ?>
    <div class='iq-card'>

        <div class='iq-card-body'>
            <h4 class='font-weight-bold text-center'>Contrat de formation professionnelle</h4>
            <div class='col-md-12'>
                <p>Entre l'organisme de formation: <?php echo e($NOM_ORGANISME); ?></p>
                <p>(ci-après nommé l'organisme de formation)</p>
                <p>Situé: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                <p>Déclaration d'activité n° <?php echo e($NUM_DEC_ORGANISME); ?> (<?php echo e($REGION_ACQUISITON_ORGANISME); ?>)</p>
                <p>Numéro SIRET: <?php echo e($SIRET_ORGANISME); ?></p>
                <p>Représenté par: <?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?></p>


                <p>Client de la formation: <?php echo e($NOM_CLIENT); ?></p>
                <p>(ci-après nommé le bénéficiaire)</p>
                <p>Situé: <?php echo e($ADRESSE_CLIENT); ?></p>
                <p>Est conclue la convention suivante en application des dispositions du livre III de la sixième partie du code du travail portant sur l'organisation de la formation professionnelle. </p>

                <h6 class="font-weight-bold">1. Objet, nature et durée de la formation</h6>
                <p>Le bénéficiaire entend participer à l’action de formation suivante organisée par l’organisme de formation.</p>
                <div class="col-md-12 iq-bg-secondary text-center font-weight-bold">Ma session de formation</div>
                <p>Type d’action de formation (art. L6313-1 du code du travail): <?php echo e($NOM_ACTION); ?></p>
                <p>Diplôme visé: <?php echo e($TITRE_VISE); ?></p>
                <p>Durée: <?php echo e($DUREE_TOTALE); ?>h (<?php echo e($DUREE_TOTALE_J); ?> jours) </p>
                <p>Lieu de la formation: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                <p>Dates de formation: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                <ul>
                    <?php $__currentLoopData = $seances_dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$seance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li> <?php echo e(strftime(' %e %B %Y', strtotime($key))); ?> -
                        <?php if($seance->where('ID_TYPE_SEANCE',1)->count()>0 && $seance->where('ID_TYPE_SEANCE',2)->count()>0): ?>
                            matin et après-midi
                        <?php elseif($seance->where('ID_TYPE_SEANCE',1)->count()>0): ?>
                            matin
                        <?php elseif($seance->where('ID_TYPE_SEANCE',2)->count()>0): ?>
                            après-midi
                        <?php endif; ?>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center align-middle">Module: <?php echo e($module['NOM']); ?> <br>Durée:<?php echo e(count($module['prix'])>0?$module['prix'][0]['NBR_HEURE']:0); ?>h (<?php echo e(count($module['prix'])>0?$module['prix'][0]['NBR_JOUR']:0); ?> jours)</td>
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
                                        <?php $__currentLoopData = $module['prix']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prix): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($prix['NOM_TYPE_PRIX']); ?> :(<?php echo e($prix['NOM_TARIF']); ?>) </td>
                                                <td><?php echo e($prix['PRIX']); ?>€ </td>
                                                <td><?php echo e($prix['PRIX_HT']); ?>€</td>
                                                <td><?php echo e($prix['TVA']); ?>%</td>
                                                <td><?php echo e($prix['PRIX_TVA']); ?>€</td>
                                                <td><?php echo e($prix['PRIX_TTC']); ?>€</td>
                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right">Prix total module TTC:</td>
                                            <td><?php echo e(collect($module['prix'])->sum('PRIX_TTC')); ?>€</td>
                                        </tr>
                                        </tfoot>
                                        </tbody>
                                    </table>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2" class="text-right">
                                <h6 class="font-weight-bold">
                                    Prix total formation TTC: <?php echo e(collect($modules)->pluck('prix')->flatten(1)->sum('PRIX_TTC')); ?>€
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
                    <p><?php echo e($NOM_ORGANISME); ?>,</p>
                    <p><?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?></p>
                </div>
                <div class="col text-right">
                    <p>Pour le bénéficiaire, bon pour accord</p>
                    <p><?php echo e($NOM_CLIENT); ?></p>
                </div>
            </div>

        </div>
    </div>

<?php elseif($pdf === 'attestation'): ?>
    <?php $__currentLoopData = $apprenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apprenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class='iq-card'>
            <div class='iq-card-body'>
                <h4 class='font-weight-bold text-center'>Attestation d'assiduité</h4>
                <div class='col-md-12'>
                    <p>Je, soussigné: <?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?>, représentant de l'organisme de formation <?php echo e($NOM_ORGANISME); ?>,</p>
                    <p>atteste que: <?php echo e($apprenant->NOM); ?> <?php echo e($apprenant->PRENOM); ?></p>
                    <p>a suivi la formation:</p>
                    <div class="col-md-12 iq-bg-secondary text-center" style="background: #f1f2f1 ">
                        <h2><?php echo e($NOM); ?></h2>
                    </div>

                    <p>Lieu de la formation: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                    <p>Dates de la formation: du <?php echo e(strftime('%e %B %Y', strtotime($DEBUT))); ?> au <?php echo e(strftime('%e %B %Y', strtotime($FIN))); ?></p>
                    <p>Durée de la formation: <?php echo e($DUREE_TOTALE); ?>h (<?php echo e($DUREE_TOTALE_J); ?> jours)</p>
                    <p>Type d'action de formation: <?php echo e($NOM_ACTION); ?></p>


                    <h5>Assiduité du stagiaire</h5>
                    <p>Durée effectivement suivie par le/la stagiaire:<?php echo e($apprenant->DUREE_TOTALE); ?>h</p>
                    <p>soit un taux de réalisation de <?php echo e($apprenant->PERCENT); ?>%</p>



                </div>
                <div class="row">
                    <div class="col text-left">
                        <p>fait à, le <?php echo e(strftime('%e %B %Y', strtotime(date('Y-m-d H:i:s')))); ?></p>
                    </div>
                    <div class="col text-right">

                    </div>
                </div>

            </div>
        </div>
        <?php if($loop->iteration<count($apprenants)): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php elseif($pdf === 'certificat'): ?>
    <?php $__currentLoopData = $apprenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apprenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class='iq-card'>

        <div class='iq-card-body'>
            <div class='col-md-12' style="padding: 300px 120px 0 100px">
                <p class='font-weight-bold text-center'>Je soussignée <?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?>, Directeur de <?php echo e($NOM_ORGANISME); ?>, certifie que </p>
                <p class='text-center'><?php echo e($apprenant->CIVILITE===1?'Mr':'Mme'); ?>.<?php echo e($apprenant->NOM); ?> <?php echo e($apprenant->PRENOM); ?>, <?php echo e($apprenant->DATE_NAISS!== null?' Né le '.strftime('%d/%m/%Y', strtotime(date($apprenant->DATE_NAISS))).', ':''); ?>CIN: <?php echo e($apprenant->NUM_SEC); ?></p>
                <p class='font-weight-bold text-center'>A validé la session de certification:</p>
                <h3 class='font-weight-bold text-center' style="color: #d9896a"><?php echo e($NOM); ?></h3>
            </div>

        </div>
    </div>
        <?php if($loop->iteration<count($apprenants)): ?>
            <div class="page-break"></div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

</body>

</html>
<?php /**PATH /var/www/html/formacamp/resources/views/pdf.blade.php ENDPATH**/ ?>