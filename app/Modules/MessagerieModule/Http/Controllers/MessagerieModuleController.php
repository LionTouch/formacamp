<?php

namespace App\Modules\MessagerieModule\Http\Controllers;

use App\Modules\AdminsModule\Http\Models\AdminsModuleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\MessagerieModule\Http\Models\MessagerieSignatureModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;

class MessagerieModuleController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function Send(Request $request){

        $input = $request->all();
        $receivers = json_decode($input['To'],true);
        $i=1;
        $emails = '';

        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        $mail->isSMTP();
        try {

            // Email server settings
            $mail->SMTPDebug = 0;
//            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'FormaCampT@gmail.com';   //  sender username
            $mail->Password = '123456789@@@';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom($mail->Username, 'FormaCamp');

            foreach ($receivers as $receiver){
                $mail->addAddress($receiver['email']);

            }
            if(isset($input['references'])) {
                $mail->addCustomHeader('In-Reply-To', $input['references']);
                $mail->addCustomHeader('References', $input['references']);
            }
            $exist_file = isset($input['file0']);
            $f=0;
            while($exist_file){
                if(isset($input['file'.$f])){
                    $mail->addAttachment($_FILES['file'.$f]['tmp_name'], $_FILES['file'.$f]['name']);

                    $f = $f+1;
                }else{
                    $exist_file = false;
                }
            }

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $input['Subject'];
            $mail->Body    = $input['Message'];

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
                return response()->json($mail->ErrorInfo);
            } else {
                $connection = imap_open("{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent", $mail->Username, $mail->Password) or die('Cannot connect to Gmail: ' . imap_last_error());
                imap_append($connection, "{imap.gmail.com:993/imap/ssl}[Gmail]/INBOX.Sent",$mail->getSentMIMEMessage(), "\\Seen");

                return response()->json(true);
                imap_close($connection);
            }

        } catch (Exception $e) {
            return response()->json('exception');
        }

    }

    public function List(){
        $server = new Server('imap.gmail.com');
        $connection = $server->authenticate("FormaCampT@gmail.com", '123456789@@@');
        $mailbox = $connection->getMailbox('INBOX');
        $messages = $mailbox->getMessages(null,\SORTDATE, true);
        $mails = [];

        foreach($messages as $message){

                $mail = new \stdClass;
                $mail->number = $message->getNumber();
                $mail->id = $message->getId();
                if(count($message->getReferences())>0){
                    $mail->reference =  $message->getReferences()[0] ;
                    $mail->subject = preg_replace('/Re: /','',$message->getSubject(),1);
                }else{
                    $mail->reference = $mail->id ;
                    $mail->subject = $message->getSubject();
                }

                $mail->from = [
                    "mailbox"=>$message->getFrom()->getMailbox(),
                    "hostname"=>$message->getFrom()->getHostname(),
                    "name"=>$message->getFrom()->getName(),
                    "full_address"=>$message->getFrom()->getFullAddress(),
                    "address"=>$message->getFrom()->getAddress(),
                ];
                $mail->to = [];
                foreach ($message->getTo() as $to){
                    $t = [
                        "mailbox"=>$to->getMailbox(),
                        "hostname"=>$to->getHostname(),
                        "name"=>$to->getName(),
                        "full_address"=>$to->getFullAddress(),
                        "address"=>$to->getAddress(),
                    ];
                    array_push($mail->to,$t);
                }

                $mail->date = $message->getDate()->format('Y-m-d H:i:s');
                $mail->answered = $message->isAnswered();
                $mail->deleted = $message->isDeleted();
                $mail->draft = $message->isDraft();
                $mail->seen = $message->isSeen();
                $mail->body = $message->getBodyText();
                array_push($mails,$mail);
        }
        $mails = collect($mails)->unique('reference')->values()->all();
        return response()->json($mails);
    }
    public function ListSent(){
        $server = new Server('imap.gmail.com');
        $connection = $server->authenticate('FormaCampT@gmail.com', '123456789@@@');
        $mailbox = $connection->getMailbox('[Gmail]/Sent Mail');
        $messages = $mailbox->getMessages(null,\SORTDATE, true);
        $mails = [];
        foreach($messages as $message){

            $mail = new \stdClass;
            $mail->number = $message->getNumber();
            $mail->id = $message->getId();
            if(count($message->getReferences())>0){
                $mail->reference =  $message->getReferences()[0] ;
                $mail->subject = preg_replace('/Re: /','',$message->getSubject(),1);
            }else{
                $mail->reference = $mail->id ;
                $mail->subject = $message->getSubject();
            }

            $mail->from = [
                "mailbox"=>$message->getFrom()->getMailbox(),
                "hostname"=>$message->getFrom()->getHostname(),
                "name"=>$message->getFrom()->getName(),
                "full_address"=>$message->getFrom()->getFullAddress(),
                "address"=>$message->getFrom()->getAddress(),
            ];
            $mail->to = [];
            foreach ($message->getTo() as $to){
                $t = [
                    "mailbox"=>$to->getMailbox(),
                    "hostname"=>$to->getHostname(),
                    "name"=>$to->getName(),
                    "full_address"=>$to->getFullAddress(),
                    "address"=>$to->getAddress(),
                ];
                array_push($mail->to,$t);
            }

            $mail->date = $message->getDate()->format('Y-m-d H:i:s');
            $mail->answered = $message->isAnswered();
            $mail->deleted = $message->isDeleted();
            $mail->draft = $message->isDraft();
            $mail->seen = $message->isSeen();
            $mail->body = $message->getBodyText();
            array_push($mails,$mail);
        }
        $mails = collect($mails)->unique('reference')->values()->all();
        return response()->json($mails);
    }
    public function ListCorbeille(){
        $server = new Server('imap.gmail.com');
        $connection = $server->authenticate('FormaCampT@gmail.com', '123456789@@@');
        $mailbox = $connection->getMailbox('[Gmail]/Trash');
        $messages = $mailbox->getMessages(null,\SORTDATE, true);
        $mails = [];
        foreach($messages as $message){

            $mail = new \stdClass;
            $mail->number = $message->getNumber();
            $mail->id = $message->getId();
            if(count($message->getReferences())>0){
                $mail->reference =  $message->getReferences()[0] ;
                $mail->subject = preg_replace('/Re: /','',$message->getSubject(),1);
            }else{
                $mail->reference = $mail->id ;
                $mail->subject = $message->getSubject();
            }

            $mail->from = [
                "mailbox"=>$message->getFrom()->getMailbox(),
                "hostname"=>$message->getFrom()->getHostname(),
                "name"=>$message->getFrom()->getName(),
                "full_address"=>$message->getFrom()->getFullAddress(),
                "address"=>$message->getFrom()->getAddress(),
            ];
            $mail->to = [];
            foreach ($message->getTo() as $to){
                $t = [
                    "mailbox"=>$to->getMailbox(),
                    "hostname"=>$to->getHostname(),
                    "name"=>$to->getName(),
                    "full_address"=>$to->getFullAddress(),
                    "address"=>$to->getAddress(),
                ];
                array_push($mail->to,$t);
            }

            $mail->date = $message->getDate()->format('Y-m-d H:i:s');
            $mail->answered = $message->isAnswered();
            $mail->deleted = $message->isDeleted();
            $mail->draft = $message->isDraft();
            $mail->seen = $message->isSeen();
            $mail->body = $message->getBodyText();
            array_push($mails,$mail);
        }
        $mails = collect($mails)->unique('reference')->values()->all();
        return response()->json($mails);
    }

    public function Get($id,$box){

        $server = new Server('imap.gmail.com');
        $connection = $server->authenticate('FormaCampT@gmail.com', '123456789@@@');
        $mailbox = $connection->getMailbox('[Gmail]/'.$box);//[Gmail]/Sent Mail
        $mainMail = new \stdClass;
        $main = true;
        $pos = 0;

        foreach ($mailbox->getThread() as $key => $val) {

                $tree = explode('.', $key);
                if($val!=0){
                    if ($tree[1] == 'num') {
                        $message = $mailbox->getMessage($val);
                        $mail = new \stdClass;
                        $mail->number = $message->getNumber();
                        $mail->id = $message->getId();
                        $mail->subject = $message->getSubject();
                        $mail->from = [
                            "mailbox"=>$message->getFrom()->getMailbox(),
                            "hostname"=>$message->getFrom()->getHostname(),
                            "name"=>$message->getFrom()->getName(),
                            "full_address"=>$message->getFrom()->getFullAddress(),
                            "address"=>$message->getFrom()->getAddress(),
                        ];
                        $mail->to = [];
                        foreach ($message->getTo() as $to){
                            $t = [
                                "mailbox"=>$to->getMailbox(),
                                "hostname"=>$to->getHostname(),
                                "name"=>$to->getName(),
                                "full_address"=>$to->getFullAddress(),
                                "address"=>$to->getAddress(),
                            ];
                            array_push($mail->to,$t);
                        }
                        $mail->attachments = [];
                        foreach ($message->getAttachments() as $att){
                            $a = [
                                "filename"=>$att->getFilename(),
                                "filetype"=>explode(".",$att->getFilename())[1],
                                "size"=>$att->getSize(),
                                "is_embedded"=>$att->isEmbeddedMessage(),
                                "file"=>base64_encode($att->getDecodedContent())
                            ];
                            array_push($mail->attachments,$a);

                        }


                        $mail->date = $message->getDate()->format('Y-m-d H:i:s');
                        $mail->answered = $message->isAnswered();
                        $mail->deleted = $message->isDeleted();
                        $mail->draft = $message->isDraft();
                        $mail->seen = $message->isSeen();
                        $mail->body = $message->getBodyHtml();
                        if($main){
                                if($mail->id == $id){
                                    $mail->replies =[];
                                    $mainMail = $mail;
                                    $main = false;
                                    $pos = 1;
                                }else{
                                    if($pos!=0){
                                        break;
                                    }
                                }

                        }else{
                            array_push($mainMail->replies,$mail);
                        }

                    } elseif ($tree[1] == 'branch') {
                        $main = true;
                    }
                }


        }

        return response()->json($mainMail);

    }

    public function SaveSignature(Request $request){
        $input = $request->all();
        $signature = new MessagerieSignatureModel();
        $signature->SIGNATURE = $input['signature'];
        $signature->save();
        MessagerieSignatureModel::where('ID_SIGNATURE','<>',$signature->ID_SIGNATURE)->delete();
        return response()->json(true);
    }
    public function GetSignature(){
        return MessagerieSignatureModel::first();
    }
}
