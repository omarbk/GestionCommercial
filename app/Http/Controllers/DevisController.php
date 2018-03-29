<?php

namespace App\Http\Controllers;

use App\Devi;
use App\Statu;
use App\Commande;
use App\Mode_paiement;
use Auth;
use Illuminate\Http\Request;

class DevisController extends Controller
{       // ajouter un devis
    public function addDevis(Request $request)
    { 
        
        $devi = new Devi();
 
                $devi->reference_d = $request->devis['reference_d'];
                $devi->date_d = $request->devis['date_d'];
                $devi->type_operation = $request->devis['type_operation'];
                $devi->objet_d = $request->devis['objet_d'];
                $devi->date_emission_d = $request->devis['date_emission_d'];
                $devi->remise_total_d = $request->devis['remise_total_d'];
                $devi->majoration_d = $request->devis['majoration_d'];
                $devi->date_limit_d = $request->devis['date_limit_d'];
                $devi->introduction_d = $request->devis['introduction_d'];
                $devi->conditions_reglements_d=$request->devis['conditions_reglements_d'];
                $devi->notes_d = $request->devis['notes_d'];
                $devi->accompte_d = $request->devis['accompte_d'];
                $devi->fk_status_d = $request->devis['fk_status_d'];
                $devi->fk_compte_d = $request->devis['fk_compte_d'];
                $devi->fk_user_d = Auth::user()->id;
                $devi->save();

                $this->addCommandes($request);
                $this->addModePaiement($request);
                 return Response()->json(['etat' => true]);
            
    }
        //compter le numero de reference devis
    public function countDevis(){
        $count = Devi::withTrashed()->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }


        // ajouter les commandes de devis
    public function addCommandes(Request $request)
    { 
        
           for($i=0;$i<count($request->commandes);$i++) {    
        $commande = new Commande();  
        $commande->quantite_cmd=$request->commandes[$i]['quantite_cmd'];
        $commande->remise_cmd=$request->commandes[$i]['remise_cmd'];
        $commande->majoration_cmd=$request->commandes[$i]['majoration_cmd'];
        $commande->prix_ht=$request->commandes[$i]['prix_ht'];
        $commande->fk_article=$request->commandes[$i]['fk_article'];
        $commande->fk_document=$request->commandes[$i]['fk_document'];
        $commande->fk_tva_cmd=$request->commandes[$i]['fk_tva_cmd'];

                $commande->save();
           }
                 return Response()->json(['etat' => true]);
            
    }

      // ajouter mode de paiement de devis
      public function addModePaiement(Request $request)
      { 
          
          $modeP = new Mode_paiement();
   
                  $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
                  $modeP->date_paiement = $request->modePaiements['date_paiement'];
                  $modeP->type_paiement = $request->modePaiements['type_paiement'];
                  $modeP->fk_document = $request->modePaiements['fk_document'];
                  $modeP->save();
               
                   return Response()->json(['etat' => true]);
              
      }

}