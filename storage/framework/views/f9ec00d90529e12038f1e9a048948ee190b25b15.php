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
    <p><?php echo e($NOM_ORGANISME); ?> | <?php echo e($NOM_LIEU_FORMATION); ?> | Num??ro SIRET: <?php echo e($SIRET_ORGANISME); ?> | N?? TVA: <?php echo e($NUM_TVA_ORGANISME); ?> | Num??ro de
    d??claration d'activit??: <?php echo e($NUM_DEC_ORGANISME); ?></p>
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
                <h4 class='font-weight-bold text-center'>Feuille d'??margement</h4>
                                <div class='col-md-12 border'>
                                       <p>Nom du stagiaire: <?php echo e($apprenant->NOM); ?> <?php echo e($apprenant->PRENOM); ?> </p>
                                       <p>Nom de la formation: <?php echo e($NOM); ?></p>
                                       <p>Date de la formation: Du <?php echo e(strftime('%A le %e %B, %Y', strtotime($DEBUT))); ?> au <?php echo e(strftime('%A le %e %B, %Y', strtotime($FIN))); ?></p>
                                       <p>Lieu de la formation: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                                       <p>Dur??e: <?php echo e($DUREE_TOTALE); ?>h</p>
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
                                                        <th scope='col text-center'>N??</th>
                                                        <th scope='col'>Date</th>
                                                        <th scope='col'>Dur??e</th>
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
                                                           <td><?php echo e($seance['DUREE_TIME']); ?>h <br><?php echo e($seance['HD']); ?> ?? <?php echo e($seance['HF']); ?></td>
                                                           <td></td>
                                                           <td></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                     </div>
                                <p class='mt-1'>Signature et tampon de l'organisme</p>
                                <p class='mt-1'>Fait ?? <?php echo e($NOM_ORGANISME); ?> -<?php echo e($NOM_LIEU_FORMATION); ?>, le </p>
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
                <p>Devis de Formation Professionnelle n??<?php echo e($REF); ?></p>
                <p>Destinataire: <?php echo e($NOM_CLIENT); ?></p>
                <p>Situ??: <?php echo e($ADRESSE_CLIENT); ?></p>

                <p>Organisateur de la formation: <?php echo e($NOM_ORGANISME); ?></p>
                <p>Situ??: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                <p>Num??ro SIRET: <?php echo e($SIRET_ORGANISME); ?></p>
                <p>Repr??sent?? par: <?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?></p>
                <h6 class="font-weight-bold">1. Objet, nature et dur??e de la formation</h6>
                <ul>
                    <li> Intitul?? de la formation: <?php echo e($NOM); ?></li>
                    <li> Type d???action de formation (au sens de l???article L6313-1 du code du travail): <?php echo e($NOM_ACTION); ?></li>
                    <li> Dur??e: <?php echo e($DUREE_TOTALE); ?>h (<?php echo e($DUREE_TOTALE_J); ?> jours)</li>
                    <li> Dates de la formation: du <?php echo e(strftime('%e %B %Y', strtotime($DEBUT))); ?> au <?php echo e(strftime('%e %B %Y', strtotime($FIN))); ?></li>
                    <li> Lieu de la formation: <?php echo e($NOM_LIEU_FORMATION); ?></li>
                    <li> Effectifs form??s du b??n??ficiaire: <?php echo e(count($apprenants)); ?></li>
                </ul>
                <h6 class="font-weight-bold">2. Programme de la formation et formateur</h6>
                <p>La description d??taill??e du programme de formation et du formateur est fournie en annexe.</p>
                <h6 class="font-weight-bold">3. Prix de la formation</h6>
                <div class="row">
                    <table class="table mb-0 table-bordered">
                        <tbody>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center align-middle">Module: <?php echo e($module['NOM']); ?> <br>Dur??e:<?php echo e(count($module['prix'])>0?$module['prix'][0]['NBR_HEURE']:0); ?>h (<?php echo e(count($module['prix'])>0?$module['prix'][0]['NBR_JOUR']:0); ?> jours)</td>
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
                                                <td><?php echo e($prix['PRIX']); ?>???</td>
                                                <td><?php echo e($prix['PRIX_HT']); ?>???</td>
                                                <td><?php echo e($prix['TVA']); ?>%</td>
                                                <td><?php echo e($prix['PRIX_TVA']); ?>???</td>
                                                <td><?php echo e($prix['PRIX_TTC']); ?>???</td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right">Prix total module TTC:</td>
                                                <td><?php echo e(collect($module['prix'])->sum('PRIX_TTC')); ?>???</td>
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
                                        Prix total formation TTC: <?php echo e(collect($modules)->pluck('prix')->flatten(1)->sum('PRIX_TTC')); ?>???
                                    </h6>
                                </td>

                            </tr>
                        </tfoot>
                    </table>


                </div>
                <h6 class="font-weight-bold">4. Dur??e de validit?? du devis</h6>
                <p>Ce devis sera valable pour une dur??e de 30 jours.</p>

                <div class="row">
                    <div class="col text-left">
                        <p>Pour l'organisme de formation,</p>
                        <p><?php echo e($NOM_ORGANISME); ?>,</p>
                        <p><?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?></p>
                    </div>
                    <div class="col text-right">
                        <p>Pour le b??n??ficiaire, bon pour accord</p>
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
                <p>(ci-apr??s nomm?? l'organisme de formation)</p>
                <p>Situ??: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                <p>D??claration d'activit?? n?? <?php echo e($NUM_DEC_ORGANISME); ?> (<?php echo e($REGION_ACQUISITON_ORGANISME); ?>)</p>
                <p>Num??ro SIRET: <?php echo e($SIRET_ORGANISME); ?></p>
                <p>Repr??sent?? par: <?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?></p>


                <p>Client de la formation: <?php echo e($NOM_CLIENT); ?></p>
                <p>(ci-apr??s nomm?? le b??n??ficiaire)</p>
                <p>Situ??: <?php echo e($ADRESSE_CLIENT); ?></p>
                <p>Est conclue la convention suivante en application des dispositions du livre III de la sixi??me partie du code du travail portant sur l'organisation de la formation professionnelle. </p>

                <h6 class="font-weight-bold">1. Objet, nature et dur??e de la formation</h6>
                <p>Le b??n??ficiaire entend participer ?? l???action de formation suivante organis??e par l???organisme de formation.</p>
                <div class="col-md-12 iq-bg-secondary text-center font-weight-bold">Ma session de formation</div>
                <p>Type d???action de formation (art. L6313-1 du code du travail): <?php echo e($NOM_ACTION); ?></p>
                <p>Dipl??me vis??: <?php echo e($TITRE_VISE); ?></p>
                <p>Dur??e: <?php echo e($DUREE_TOTALE); ?>h (<?php echo e($DUREE_TOTALE_J); ?> jours) </p>
                <p>Lieu de la formation: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                <p>Dates de formation: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                <ul>
                    <?php $__currentLoopData = $seances_dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$seance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li> <?php echo e(strftime(' %e %B %Y', strtotime($key))); ?> -
                        <?php if($seance->where('ID_TYPE_SEANCE',1)->count()>0 && $seance->where('ID_TYPE_SEANCE',2)->count()>0): ?>
                            matin et apr??s-midi
                        <?php elseif($seance->where('ID_TYPE_SEANCE',1)->count()>0): ?>
                            matin
                        <?php elseif($seance->where('ID_TYPE_SEANCE',2)->count()>0): ?>
                            apr??s-midi
                        <?php endif; ?>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <h6 class="font-weight-bold">2. Programme de la formation et formateur</h6>
                <p>La description d??taill??e du programme de formation et du formateur est fournie en annexe. Le niveau de connaissances pr??alables requis pour suivre la formation et obtenir les qualifications auxquelles elle pr??pare est d??taill?? dans ce programme.</p>

                <h6 class="font-weight-bold">3. Engagement de participation ?? l'action de formation</h6>
                <p>Le b??n??ficiaire s???engage ?? assurer sa pr??sence aux dates et lieux pr??vus ci-dessus.</p>

                <h6 class="font-weight-bold">4. Prix de la formation</h6>
                <p>En contrepartie de cette action de formation, le b??n??ficiaire s'acquittera des co??ts suivants qui couvrent l'int??gralit?? des frais engag??s par l'organisme de formation pour cette session:
                </p>

                <div class='col-md-12 mt-3'>
                    <table class="table mb-0 table-bordered">
                        <tbody>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center align-middle">Module: <?php echo e($module['NOM']); ?> <br>Dur??e:<?php echo e(count($module['prix'])>0?$module['prix'][0]['NBR_HEURE']:0); ?>h (<?php echo e(count($module['prix'])>0?$module['prix'][0]['NBR_JOUR']:0); ?> jours)</td>
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
                                                <td><?php echo e($prix['PRIX']); ?>??? </td>
                                                <td><?php echo e($prix['PRIX_HT']); ?>???</td>
                                                <td><?php echo e($prix['TVA']); ?>%</td>
                                                <td><?php echo e($prix['PRIX_TVA']); ?>???</td>
                                                <td><?php echo e($prix['PRIX_TTC']); ?>???</td>
                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right">Prix total module TTC:</td>
                                            <td><?php echo e(collect($module['prix'])->sum('PRIX_TTC')); ?>???</td>
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
                                    Prix total formation TTC: <?php echo e(collect($modules)->pluck('prix')->flatten(1)->sum('PRIX_TTC')); ?>???
                                </h6>
                            </td>

                        </tr>
                        </tfoot>
                    </table>
                </div>

                <h6 class="font-weight-bold">5. Modalit??s de r??glement</h6>
                <p>Le paiement sera d?? ?? r??ception d'une facture ??mise par l'organisme de formation ?? destination du b??n??ficiaire.</p>
                <p>Le b??n??ficiaire s???engage ?? verser la somme due selon les modalit??s de paiement suivantes:</p>
                <ul>
                    <li> Apr??s un d??lai de r??tractation mentionn?? ?? l???article 9 du pr??sent contrat, le stagiaire effectue un premier versement d???un montant de 30% du total.</li>
                    <li> Le paiement du solde, ?? la charge du b??n??ficiaire, devra ??tre fait le lendemain du dernier jour de l'action de formation.</li>
                </ul>


                <h6 class="font-weight-bold">6. Moyens p??dagogiques et techniques mis en ??uvre</h6>
                <p>Voir le programme de formation en annexe d??taillant les moyens mis en ??uvre pour r??aliser techniquement l'action, suivre son ex??cution et appr??cier ses r??sultats. Une feuille d?????margement sign??e par le(s) stagiaire(s) et le formateur, par demi-journ??e de formation, permettra de justifier de la r??alisation de la prestation.</p>

                <h6 class="font-weight-bold">7. Sanction de la formation</h6>
                <p>En application de l???article L.6353-1 du Code du Travail, une attestation mentionnant les objectifs, la nature et la dur??e de l???action et les r??sultats de l?????valuation des acquis de la formation sera remise au(x) stagiaire(s) ?? l???issue de la formation.</p>

                <h6 class="font-weight-bold">8. Non r??alisation de la prestation de formation</h6>
                <p>En application de l???article L6354-1 du Code du travail, il est convenu entre les signataires de la pr??sente convention, que faute de r??alisation totale ou partielle de la prestation de formation, l???organisme prestataire doit rembourser au cocontractant les sommes ind??ment per??ues de ce fait.
                </p>

                <h6 class="font-weight-bold">9. D??dommagement, r??paration ou d??dit</h6>
                <p>A compter de la date de signature du pr??sent contrat, le b??n??ficiaire a un d??lai de 10 jours pour se r??tracter. Le d??lai de r??tractation est port?? ?? 14 jours (article L.121-16 du Code de la consommation) pour les contrats conclus ?? ?? distance ?? et les contrats conclus ?? hors ??tablissement ??. Il en informe l???organisme de formation par lettre recommand??e avec accus?? de r??ception. Dans ce cas, aucune somme ne peut ??tre exig??e du b??n??ficiaire.
                </p>
                <p>Si le b??n??ficiaire est emp??ch?? de suivre la formation par suite de force majeure d??ment reconnue, le contrat de formation professionnelle est r??sili??. Dans ce cas, seules les prestations effectivement dispens??es sont dues au prorata temporis de leur valeur pr??vue au pr??sent contrat.
                </p>
                <p>En cas de renoncement par le b??n??ficiaire avant le d??but du programme de formation</p>
                <ul>
                    <li> Dans un d??lai sup??rieur ?? 1 mois avant le d??but de la formation : 50% du co??t de la formation est d??.</li>
                    <li> Dans un d??lai compris entre 1 mois et 2 semaines avant le d??but de la formation : 70 % du co??t de la formation est d??.</li>
                    <li> Dans un d??lai inf??rieur ?? 2 semaines avant le d??but de la formation : 100 % du co??t de la formation est d??.</li>
                </ul>
                <p>Le co??t ne pourra faire l???objet d???une demande de remboursement ou de prise en charge par l'OPCA</p>


                <h6 class="font-weight-bold">10. Litiges</h6>
                <p>Si une contestation ou un diff??rent ne peuvent pas ??tre r??gl??s ?? l???amiable, le Tribunal de SENLIS sera seul comp??tent pour r??gler le litige.</p>
                <p>Document r??alis?? en 2 exemplaires ?? MONTATAIRE , le 28 octobre 2021.</p>

            </div>
            <div class="row">
                <div class="col text-left">
                    <p>Pour l'organisme de formation,</p>
                    <p><?php echo e($NOM_ORGANISME); ?>,</p>
                    <p><?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?></p>
                </div>
                <div class="col text-right">
                    <p>Pour le b??n??ficiaire, bon pour accord</p>
                    <p><?php echo e($NOM_CLIENT); ?></p>
                </div>
            </div>

        </div>
    </div>

<?php elseif($pdf === 'attestation'): ?>
    <?php $__currentLoopData = $apprenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apprenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class='iq-card'>
            <div class='iq-card-body'>
                <h4 class='font-weight-bold text-center'>Attestation d'assiduit??</h4>
                <div class='col-md-12'>
                    <p>Je, soussign??: <?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?>, repr??sentant de l'organisme de formation <?php echo e($NOM_ORGANISME); ?>,</p>
                    <p>atteste que: <?php echo e($apprenant->NOM); ?> <?php echo e($apprenant->PRENOM); ?></p>
                    <p>a suivi la formation:</p>
                    <div class="col-md-12 iq-bg-secondary text-center" style="background: #f1f2f1 ">
                        <h2><?php echo e($NOM); ?></h2>
                    </div>

                    <p>Lieu de la formation: <?php echo e($NOM_LIEU_FORMATION); ?></p>
                    <p>Dates de la formation: du <?php echo e(strftime('%e %B %Y', strtotime($DEBUT))); ?> au <?php echo e(strftime('%e %B %Y', strtotime($FIN))); ?></p>
                    <p>Dur??e de la formation: <?php echo e($DUREE_TOTALE); ?>h (<?php echo e($DUREE_TOTALE_J); ?> jours)</p>
                    <p>Type d'action de formation: <?php echo e($NOM_ACTION); ?></p>


                    <h5>Assiduit?? du stagiaire</h5>
                    <p>Dur??e effectivement suivie par le/la stagiaire:<?php echo e($apprenant->DUREE_TOTALE); ?>h</p>
                    <p>soit un taux de r??alisation de <?php echo e($apprenant->PERCENT); ?>%</p>



                </div>
                <div class="row">
                    <div class="col text-left">
                        <p>fait ??, le <?php echo e(strftime('%e %B %Y', strtotime(date('Y-m-d H:i:s')))); ?></p>
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
                <p class='font-weight-bold text-center'>Je soussign??e <?php echo e($NOM_ADMIN); ?> <?php echo e($PRENOM_ADMIN); ?>, Directeur de <?php echo e($NOM_ORGANISME); ?>, certifie que </p>
                <p class='text-center'><?php echo e($apprenant->CIVILITE===1?'Mr':'Mme'); ?>.<?php echo e($apprenant->NOM); ?> <?php echo e($apprenant->PRENOM); ?>, <?php echo e($apprenant->DATE_NAISS!== null?' N?? le '.strftime('%d/%m/%Y', strtotime(date($apprenant->DATE_NAISS))).', ':''); ?>CIN: <?php echo e($apprenant->NUM_SEC); ?></p>
                <p class='font-weight-bold text-center'>A valid?? la session de certification:</p>
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