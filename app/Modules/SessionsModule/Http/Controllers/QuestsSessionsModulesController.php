<?php

namespace App\Modules\SessionsModule\Http\Controllers;

use App\Modules\SessionsModule\Http\Models\QuestsReponsesSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\QuestsSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\QuestsSubsReponsesSessionsModulesModel;
use App\Modules\SessionsModule\Http\Models\QuestsSubsSessionsModulesModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
class QuestsSessionsModulesController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function List(){
        return QuestsSessionsModulesModel::join('sessions','sessions.ID_SESSION','sessions_quest.ID_SESSION')
            ->select('sessions_quest.*','sessions.NOM as NOM_SESSION','sessions.DATE as DATE_SESSION')
            ->get()->unique('ID_SESSION');
    }
    public function ListBySession($id){

        return QuestsSessionsModulesModel::leftjoin('sessions','sessions.ID_SESSION','sessions_quest.ID_SESSION')
            ->leftjoin('sessions_quest_types','sessions_quest_types.ID_TYPE','sessions_quest.ID_TYPE')
            ->where('sessions.ID_SESSION',$id)
            ->select(
                'sessions_quest.*',
                'sessions.NOM as NOM_SESSION',
            )
            ->with('sub_quests')
            ->with('reponses')
            ->orderBy('ID_QUEST')
            ->get();
    }

    public function Delete($id){
        $ids =  QuestsSessionsModulesModel::where('ID_SESSION',$id)->get()->pluck('ID_QUEST');
        $ids_subs =  QuestsSubsSessionsModulesModel::whereIn('ID_QUEST',$ids)->get()->pluck('ID_QUEST');
        QuestsSubsReponsesSessionsModulesModel::whereIn('ID_SUB_QUEST',$ids_subs)->delete();
        QuestsSubsSessionsModulesModel::whereIn('ID_QUEST',$ids)->delete();
        QuestsReponsesSessionsModulesModel::whereIn('ID_QUEST',$ids)->delete();
        QuestsSessionsModulesModel::where('ID_SESSION',$id)->delete();
        return response()->json(true);
    }


    public function DeleteAll($id){
        QuestsSessionsModulesModel::where('ID_SESSION',$id)->delete();
        return response()->json(true);
    }

    public function SaveAll(Request $request){
        $session_quests =  QuestsSessionsModulesModel::where('ID_SESSION',$request->ID_SESSION);
        $ids = $session_quests->get()->pluck('ID_QUEST');
        QuestsSubsSessionsModulesModel::whereIn('ID_QUEST',$ids)->delete();
        QuestsReponsesSessionsModulesModel::whereIn('ID_QUEST',$ids)->delete();
        QuestsSessionsModulesModel::where('ID_SESSION',$request->ID_SESSION)->delete();
        $quests = json_decode($request->quests);

        foreach ($quests as $quest) {
            $obj = New QuestsSessionsModulesModel();
            $obj->ID_SESSION = $request->ID_SESSION;
            $obj->ID_TYPE = $quest->ID_TYPE;
            $obj->TEXT = $quest->TEXT;
            $obj->save();
            foreach ($quest->sub_quests as $sub_quest){
                $sq = New QuestsSubsSessionsModulesModel();
                $sq->ID_QUEST = $obj->ID_QUEST;
                $sq->TEXT = $sub_quest->TEXT;
                $sq->save();
//                foreach ($sub_quest->reponses as $sub_reponse){
//                    $re = New QuestsReponsesSessionsModulesModel();
//                    $re->ID_SUB_QUEST = $sq->ID_SUB_QUEST;
//                    $re->TEXT = $sub_reponse->TEXT;
//                    $re->save();
//                }
            }
            foreach ($quest->reponses as $reponse){
                $re = New QuestsReponsesSessionsModulesModel();
                $re->ID_QUEST = $obj->ID_QUEST;
                $re->TEXT = $reponse->TEXT;
                $re->save();
            }
        }
        return response()->json(true);
    }

    public function SendEval(Request $request){

        $receivers = json_decode($request->apprenants,true);
//dd($receivers);
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        $mail->isSMTP();
        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->CharSet = "UTF-8";
//            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'FormaCampT@gmail.com';   //  sender username
            $mail->Password = 'ygbbtglaxiakhqzu';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465
            $mail->isHTML(true);
            $mail->setFrom($mail->Username, 'FormaCamp');

            foreach ($receivers as $receiver){
                if($receiver['EMAIL']){
                    $mail->addAddress($receiver['EMAIL']);
                    $mail->Subject = 'Evaluation: '.$receiver['NOM_SESSION'];
                    $mail->Body    = 'Veuiller passer l\'évaluation concernant '.$receiver['NOM_SESSION'].' <a href="https://formacamp.lion-touch.com/Evaluation/'.$receiver['REF'].'">Lien</a>';

                    if( !$mail->send() ) {
                        return response()->json($mail->ErrorInfo);
                    } else {
                        $connection = imap_open("{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent", $mail->Username, $mail->Password) or die('Cannot connect to Gmail: ' . imap_last_error());
                        imap_append($connection, "{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent",$mail->getSentMIMEMessage(), "\\Seen");


                    }
                }

            }

            return response()->json(true);
        } catch (Exception $e) {
            return response()->json($e);
        }

    }
}
