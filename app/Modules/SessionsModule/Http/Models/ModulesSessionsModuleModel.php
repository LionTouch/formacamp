<?php

namespace App\Modules\SessionsModule\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class ModulesSessionsModuleModel extends Model
{
    protected $table = 'sessions_modules';
    protected $primaryKey = 'ID_MODULE';
    public $timestamps = false;

    public function prix()
    {
        return $this->hasMany(PrixModulesSessionsModuleModel::class,'ID_MODULE','ID_MODULE')
            ->leftjoin('sessions_modules','sessions_modules.ID_MODULE','sessions_modules_prix.ID_MODULE')
            ->leftjoin('sessions_modules_prix_tarif','sessions_modules_prix_tarif.ID_TARIF','sessions_modules_prix.ID_TARIF')
            ->leftjoin('sessions_type_prix_modules','sessions_type_prix_modules.ID_TYPE_PRIX','sessions_modules_prix.ID_TYPE_PRIX')
            ->leftjoin('sessions_apprenants','sessions_apprenants.ID_SESSION','sessions_modules.ID_SESSION')
            ->leftjoin('sessions_modules_seances','sessions_modules_seances.ID_MODULE','sessions_modules_prix.ID_MODULE')
            ->select(
                'sessions_modules_prix.*',
                'sessions_type_prix_modules.NOM as NOM_TYPE_PRIX',
                'sessions_modules_prix_tarif.NOM as NOM_TARIF',
                DB::raw("
                COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) as NBR_APPRENANT,
                COUNT(DISTINCT sessions_modules_seances.ID_SEANCE) as NBR_SEANCE,
                COUNT(DISTINCT sessions_modules_seances.DATE) as NBR_JOUR,
                ROUND(SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)),2) as NBR_HEURE,
                 CASE
                       WHEN sessions_modules_prix.ID_TARIF = 1 THEN ROUND(PRIX,2)
                       WHEN sessions_modules_prix.ID_TARIF = 2 THEN ROUND(PRIX * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE),2)
                       WHEN sessions_modules_prix.ID_TARIF = 3 THEN ROUND(PRIX * COUNT(DISTINCT sessions_modules_seances.DATE),2)
                       WHEN sessions_modules_prix.ID_TARIF = 4 THEN ROUND(PRIX * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)),2)
                       WHEN sessions_modules_prix.ID_TARIF = 5 THEN ROUND(PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT),2)
                       WHEN sessions_modules_prix.ID_TARIF = 6 THEN ROUND(PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE),2)
                       WHEN sessions_modules_prix.ID_TARIF = 7 THEN ROUND(PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.DATE),2)
                       WHEN sessions_modules_prix.ID_TARIF = 8 THEN ROUND(PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)),2)
                 END
                 as PRIX_HT,
                 CASE
                       WHEN sessions_modules_prix.ID_TARIF = 1 THEN
                        ROUND(PRIX * sessions_modules_prix.TVA/100,2)
                       WHEN sessions_modules_prix.ID_TARIF = 2 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE) * sessions_modules_prix.TVA/100),2)
                       WHEN sessions_modules_prix.ID_TARIF = 3 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_modules_seances.DATE) * sessions_modules_prix.TVA/100),2)
                       WHEN sessions_modules_prix.ID_TARIF = 4 THEN
                        ROUND((PRIX * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)) * sessions_modules_prix.TVA/100),2)
                       WHEN sessions_modules_prix.ID_TARIF = 5 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * sessions_modules_prix.TVA/100),2)
                       WHEN sessions_modules_prix.ID_TARIF = 6 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE) * sessions_modules_prix.TVA/100),2)
                       WHEN sessions_modules_prix.ID_TARIF = 7 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.DATE) * sessions_modules_prix.TVA/100),2)
                       WHEN sessions_modules_prix.ID_TARIF = 8 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)) * sessions_modules_prix.TVA/100),2)
                 END
                 as PRIX_TVA,
                 CASE
                       WHEN sessions_modules_prix.ID_TARIF = 1 THEN
                        ROUND(PRIX+ROUND(PRIX * sessions_modules_prix.TVA/100,2),2)
                       WHEN sessions_modules_prix.ID_TARIF = 2 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE))+ROUND((PRIX * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE) * sessions_modules_prix.TVA/100),2),2)
                       WHEN sessions_modules_prix.ID_TARIF = 3 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_modules_seances.DATE))+ROUND((PRIX * COUNT(DISTINCT sessions_modules_seances.DATE) * sessions_modules_prix.TVA/100),2),2)
                       WHEN sessions_modules_prix.ID_TARIF = 4 THEN
                        ROUND((PRIX * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)))+ROUND((PRIX * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)) * sessions_modules_prix.TVA/100),2),2)
                       WHEN sessions_modules_prix.ID_TARIF = 5 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT))+ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * sessions_modules_prix.TVA/100),2),2)
                       WHEN sessions_modules_prix.ID_TARIF = 6 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE))+ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.ID_SEANCE) * sessions_modules_prix.TVA/100),2),2)
                       WHEN sessions_modules_prix.ID_TARIF = 7 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.DATE))+ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * COUNT(DISTINCT sessions_modules_seances.DATE) * sessions_modules_prix.TVA/100),2),2)
                       WHEN sessions_modules_prix.ID_TARIF = 8 THEN
                        ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)))+ROUND((PRIX * COUNT(DISTINCT sessions_apprenants.ID_APPRENANT) * SUM(sessions_modules_seances.DUREE)*(COUNT(DISTINCT sessions_modules_seances.ID_SEANCE)/COUNT(*)) * sessions_modules_prix.TVA/100),2),2)
                 END
                 as PRIX_TTC
                 "),
            )
            ->groupBy('ID_PRIX');
    }
    public function seances()
    {
        return $this->hasMany(SeancesModulesSessionsModel::class,'ID_MODULE','ID_MODULE')
            ->leftjoin('sessions_modules_types_seances','sessions_modules_types_seances.ID_TYPE_SEANCE','sessions_modules_seances.ID_TYPE_SEANCE')
            ->leftjoin('salles','salles.ID_SALLE','sessions_modules_seances.ID_SALLE')
            ->select(
            'sessions_modules_seances.*',
            'sessions_modules_types_seances.NOM as NOM_TYPE_SEANCE',
            'sessions_modules_types_seances.DEBUT as MIN',
            'sessions_modules_types_seances.FIN as MAX',
            DB::raw('CONCAT( DATE_FORMAT(HD,"%H:%i"), "-", DATE_FORMAT(HF,"%H:%i")," - Salle: ",CAST(salles.NOM AS CHAR CHARACTER SET utf8) ) as title'),
            'sessions_modules_seances.ID_SEANCE as id',
            'sessions_modules_seances.DATE as start',
            'sessions_modules_seances.DATE as end'
        )->orderBy('DATE')
            ->orderBy('HD')
            ->with(['intervenants','emargement_intervenants','emargement_apprenants']);
    }
    public function seances_intervenants()
    {
        return $this->hasMany(SeancesModulesSessionsModel::class,'ID_MODULE','ID_MODULE')
            ->leftjoin('sessions_modules_types_seances','sessions_modules_types_seances.ID_TYPE_SEANCE','sessions_modules_seances.ID_TYPE_SEANCE')
            ->select(
                'sessions_modules_seances.*',
                'sessions_modules_types_seances.NOM as NOM_TYPE_SEANCE',
                DB::raw('CONCAT( DATE_FORMAT(HD,"%H:%i"), "-", DATE_FORMAT(HF,"%H:%i") ) as title'),
                'DATE as start',
                'DATE as end',
            )
            ->orderBy('DATE')->orderBy('HD');
    }
}
