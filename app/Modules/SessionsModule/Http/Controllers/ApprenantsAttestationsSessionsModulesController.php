<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\ApprenantsSessionsModuleModel;
use App\Modules\SessionsModule\Http\Models\SeancesModulesSessionsModel;
use App\Modules\SessionsModule\Http\Models\SessionsModuleModel;
use App\Modules\StagiairesModule\Http\Models\StagiairesModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PDF;
use Auth;
use DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class ApprenantsAttestationsSessionsModulesController extends Controller
{
    public function index()
    {
        return view('print');
    }

    public function download($id,$ids_apprenants){
        $liste_apprenants = explode(',',$ids_apprenants);
        $duree_session = SeancesModulesSessionsModel::leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->where('sessions_modules.ID_SESSION',$id)
            ->select('DUREE')
            ->get()->sum('DUREE');
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        $apprenants = ApprenantsSessionsModuleModel::leftjoin('stagiaires','stagiaires.ID_STAGIAIRE','sessions_apprenants.ID_APPRENANT')
            ->leftjoin('sessions','sessions.ID_SESSION','sessions_apprenants.ID_SESSION')
            ->leftjoin('sessions_apprenants_emargements','sessions_apprenants_emargements.ID_APPRENANT','sessions_apprenants.ID_APPRENANT')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_SEANCE','sessions_apprenants_emargements.ID_SEANCE')
            ->leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_seances.ID_MODULE')
            ->whereIn('sessions_apprenants.ID_APPRENANT',$liste_apprenants)
            ->where('sessions_apprenants.ID_SESSION',$id)
            ->where('sessions_modules.ID_SESSION',$id)
            ->select(
                'sessions_apprenants.ID_APPRENANT',
                'sessions_apprenants.ID_SESSION',
                'stagiaires.PHOTO',
                'stagiaires.NOM',
                'stagiaires.PRENOM',
                'stagiaires.EMAIL',
                'stagiaires.TELEPHONE',
                'sessions.NOM as NOM_SESSION',
                'sessions_apprenants.REF',
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                DB::raw('ROUND(SUM(sessions_modules_seances.DUREE)*100/'.($duree_session).',2) as PERCENT'),
                DB::raw('true as "Add"')
            )->groupBy(['ID_APPRENANT','ID_SESSION'])
            ->get();
        $data = SessionsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('users','users.ID_USER','organismes.ID_USER')
            ->leftjoin('admins','admins.ID_ADMIN','users.ID_USER')
            ->leftjoin('sessions_modules','sessions_modules.ID_SESSION','sessions.ID_SESSION')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules.ID_MODULE')
            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
            ->leftjoin('lieu_formation','lieu_formation.ID_LIEU_FORMATION','sessions.ID_LIEU_FORMATION')
            ->where('organismes.ID_USER',Auth::id())
            ->leftjoin('domaines','domaines.ID_DOMAINE','sessions.ID_DOMAINE')
            ->leftjoin('diplomes','diplomes.ID_DIPLOME','sessions.ID_DIPLOME')
            ->leftjoin('action_formation','action_formation.ID_ACTION','sessions.ID_ACTION')
            ->with('intervenants')
            ->with('seances')
            ->select('sessions.*',
                'users.email as EMAIL_ORGANISME',
                'admins.NOM as NOM_ADMIN',
                'admins.PRENOM as PRENOM_ADMIN',
                'clients.NOM as NOM_CLIENT',
                'clients.ADRESSE as ADRESSE_CLIENT',
                'lieu_formation.NOM as NOM_LIEU_FORMATION',
                'organismes.NUM_DEC as NUM_DEC_ORGANISME',
                'organismes.TELEPHONE as TELEPHONE_ORGANISME',
                'organismes.REGION_ACQUISITON as REGION_ACQUISITON_ORGANISME',
                'organismes.NOM as NOM_ORGANISME',
                'organismes.SIRET as SIRET_ORGANISME',
                'organismes.NUM_TVA as NUM_TVA_ORGANISME',
                'domaines.NOM as NOM_DOMAINE',
                'diplomes.NOM as NOM_DIPLOME',
                'action_formation.NOM as NOM_ACTION',
                DB::raw("
                 CASE
                       WHEN NOW() >= DEBUT AND NOW() < FIN THEN 'Planification en cours'
                       WHEN NOW() < DEBUT THEN 'Planifiées'
                       WHEN NOW() >= FIN THEN 'Terminées'
                 END
                 as TYPE"),
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                DB::raw('COUNT(DISTINCT sessions_modules_seances.DATE) as DUREE_TOTALE_J')

            )->groupBy('sessions.ID_SESSION')
            ->findOrFail($id);
        $data->apprenants = $apprenants;
        $data->pdf = 'attestation';
        $pdf = PDF::loadView('pdf', $data);
        return $pdf->download('attestation'.date('Y-m-d').'.pdf');
    }
    public function Send(Request $request){
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        if(isset($request->ID_APPRENANT)){
            $apprenants = StagiairesModuleModel::where('ID_STAGIAIRE',$request->ID_APPRENANT)->get();
        }else{
            $liste_apprenants = json_decode($request->apprenants,true);
            $apprenants = StagiairesModuleModel::whereIn('ID_STAGIAIRE',$liste_apprenants)->get();
        }

        $data = SessionsModuleModel::leftjoin('organismes','organismes.ID_ORGANISME','sessions.ID_ORGANISME')
            ->leftjoin('users','users.ID_USER','organismes.ID_USER')
            ->leftjoin('admins','admins.ID_ADMIN','users.ID_USER')
            ->leftjoin('sessions_modules','sessions_modules.ID_SESSION','sessions.ID_SESSION')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules.ID_MODULE')
            ->leftjoin('clients','clients.ID_CLIENT','sessions.ID_CLIENT')
            ->leftjoin('lieu_formation','lieu_formation.ID_LIEU_FORMATION','sessions.ID_LIEU_FORMATION')
            ->where('organismes.ID_USER',Auth::id())
            ->leftjoin('domaines','domaines.ID_DOMAINE','sessions.ID_DOMAINE')
            ->leftjoin('diplomes','diplomes.ID_DIPLOME','sessions.ID_DIPLOME')
            ->leftjoin('action_formation','action_formation.ID_ACTION','sessions.ID_ACTION')
            ->with('intervenants')
            ->with('seances')
            ->select('sessions.*',
                'users.email as EMAIL_ORGANISME',
                'admins.NOM as NOM_ADMIN',
                'admins.PRENOM as PRENOM_ADMIN',
                'clients.NOM as NOM_CLIENT',
                'clients.ADRESSE as ADRESSE_CLIENT',
                'lieu_formation.NOM as NOM_LIEU_FORMATION',
                'organismes.NUM_DEC as NUM_DEC_ORGANISME',
                'organismes.TELEPHONE as TELEPHONE_ORGANISME',
                'organismes.REGION_ACQUISITON as REGION_ACQUISITON_ORGANISME',
                'organismes.NOM as NOM_ORGANISME',
                'organismes.SIRET as SIRET_ORGANISME',
                'organismes.NUM_TVA as NUM_TVA_ORGANISME',
                'domaines.NOM as NOM_DOMAINE',
                'diplomes.NOM as NOM_DIPLOME',
                'action_formation.NOM as NOM_ACTION',
                DB::raw("
                 CASE
                       WHEN NOW() >= DEBUT AND NOW() < FIN THEN 'Planification en cours'
                       WHEN NOW() < DEBUT THEN 'Planifiées'
                       WHEN NOW() >= FIN THEN 'Terminées'
                 END
                 as TYPE"),
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                DB::raw('COUNT(DISTINCT sessions_modules_seances.DATE) as DUREE_TOTALE_J')
            )->groupBy('sessions.ID_SESSION')
            ->findOrFail($request->ID_SESSION);


        require base_path("vendor/autoload.php");

        foreach ($apprenants as $apprenant){
        try {

            $mail = new PHPMailer(true);     // Passing `true` enables exceptions
            $mail->isSMTP();
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->CharSet = "UTF-8";
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'FormaCampT@gmail.com';   //  sender username
            $mail->Password = '123456789@@@';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465
            $mail->isHTML(true);
            $mail->setFrom($mail->Username, 'FormaCamp');
                $data->apprenants = [$apprenant];
                $data->pdf = 'attestation';
                $pdf = PDF::loadView('pdf', $data)->setPaper('a4', 'landscape');
                    if($apprenant[  'EMAIL']){
                        $mail->addAddress($apprenant['EMAIL']);
                        $mail->Subject = 'Attestation: '.$data['NOM'];
                        $mail->Body    = 'Attestation: '.$data['NOM'];
                        $mail->AddStringAttachment($pdf->output(), 'attestation'.date('Y-m-d').'.pdf');
                        if( !$mail->send() ) {
                            return response()->json($mail->ErrorInfo);
                        } else {
                            $connection = imap_open("{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent", $mail->Username, $mail->Password) or die('Cannot connect to Gmail: ' . imap_last_error());
                            imap_append($connection, "{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent",$mail->getSentMIMEMessage(), "\\Seen");
                        }
                    }

        } catch (Exception $e) {
            return response()->json($e);
        }
         }
        return response()->json(true);
    }
}
