<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\SessionsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PDF;
use Auth;
use DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DevisSessionsModuleController extends Controller
{
    public function index()
    {
        return view('print');
    }

    public function download($id){
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
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
            ->with('apprenants')
            ->with('seances')
            ->with('modules')
            ->select(
                'sessions.ID_SESSION',
                'sessions.DATE',
                'sessions.REF',
                'sessions.NOM',
                'sessions.DEBUT',
                'sessions.FIN',
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
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                DB::raw('COUNT(DISTINCT sessions_modules_seances.DATE) as DUREE_TOTALE_J')
            )->groupBy('sessions.ID_SESSION')
            ->findOrFail($id);
        $data->pdf = 'devis';
        $pdf = PDF::loadView('pdf', $data);
        return $pdf->download('devis'.date('Y-m-d').'.pdf');
    }

    public function Send(Request $request){
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
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
            ->with('apprenants')
            ->with('seances')
            ->with('modules')
            ->select(
                'sessions.ID_SESSION',
                'sessions.DATE',
                'sessions.REF',
                'sessions.NOM',
                'sessions.DEBUT',
                'sessions.FIN',
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
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                DB::raw('COUNT(DISTINCT sessions_modules_seances.DATE) as DUREE_TOTALE_J')
            )->groupBy('sessions.ID_SESSION')
            ->findOrFail($request->ID_SESSION);


        require base_path("vendor/autoload.php");

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
            $data->pdf = 'devis';
            $pdf = PDF::loadView('pdf', $data);

//            $mail->addAddress($request->EMAIL);
            $mail->addAddress('7amzaes@gmail.com');
            $mail->Subject = 'Devis: ' . $data['NOM'];
            $mail->Body = 'Devis: ' . $data['NOM'];
            $mail->AddStringAttachment($pdf->output(), 'attestation' . date('Y-m-d') . '.pdf');
            if (!$mail->send()) {
                return response()->json($mail->ErrorInfo);
            } else {
                $connection = imap_open("{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent", $mail->Username, $mail->Password) or die('Cannot connect to Gmail: ' . imap_last_error());
                imap_append($connection, "{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent", $mail->getSentMIMEMessage(), "\\Seen");
            }


        }
        catch (Exception $e) {

            return response()->json($e);
        }
        return response()->json(true);
    }

    public function test(){
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
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
            ->with('apprenants')
            ->with('seances')
            ->with('modules')
            ->select(
                'sessions.ID_SESSION',
                'sessions.DATE',
                'sessions.REF',
                'sessions.NOM',
                'sessions.DEBUT',
                'sessions.FIN',
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
                DB::raw('SUM(sessions_modules_seances.DUREE) as DUREE_TOTALE'),
                DB::raw('COUNT(DISTINCT sessions_modules_seances.DATE) as DUREE_TOTALE_J')
            )->groupBy('sessions.ID_SESSION')
            ->findOrFail(7);


        require base_path("vendor/autoload.php");
//        $mail = new PHPMailer(true);
        try {

//                // Passing `true` enables exceptions
//            // Email server settings
//            $mail->SMTPDebug = 1;
//            $mail->CharSet = "UTF-8";
//            $mail->Host = 'smtp.gmail.com';             //  smtp host
//            $mail->SMTPAuth = true;
//            $mail->Username = 'FormaCampT@gmail.com';   //  sender username
//            $mail->Password = '123456789@@@';       // sender password
//            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
//            $mail->Port = 587;                          // port - 587/465
//            $mail->isHTML(true);
//            $mail->setFrom('FormaCampT@gmail.com', 'FormaCamp');
//            $data->pdf = 'devis';
//            $pdf = PDF::loadView('pdf', $data);
//
////            $mail->addAddress($request->EMAIL);
//            $mail->addAddress('7amzaes@gmail.com');
//            $mail->Subject = 'Devis: ' . $data->NOM;
//            $mail->Body = 'Devis: ' . $data->NOM;
//            $mail->AddStringAttachment($pdf->output(), 'devis' . date('Y-m-d') . '.pdf');
//            if (!$mail->send()) {
//                return response()->json($mail->ErrorInfo);
//            } else {
//                $connection = imap_open("{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent", $mail->Username, $mail->Password) or die('Cannot connect to Gmail: ' . imap_last_error());
//                imap_append($connection, "{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent", $mail->getSentMIMEMessage(), "\\Seen");
//            }
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'FormaCampT@gmail.com';
            $mail->Password = '123456789@@@';
            $mail->setFrom('FormaCampT@gmail.com', 'FormaCampT');
            $mail->addReplyTo('FormaCampT@gmail.com', 'FormaCampT');
            $mail->addAddress('7amzaes@gmail.com', 'somokos');
            $mail->Subject = 'Testing PHPMailer';
            $mail->Body = 'This is a plain text message body';
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'The email message was sent.';
            }

        }
        catch (Exception $e) {

            return response()->json($e);
        }
        return response()->json(true);
    }
}
