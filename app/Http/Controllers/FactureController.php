<?php

namespace App\Http\Controllers;

use App\Facture;
use App\Statu;
use App\Commande;
use App\Article;
use App\Mode_paiement;
use App\Compte;
use App\Tva;
use Auth;
use PDF;
use Illuminate\Http\Request;

class FactureController extends Controller
{
       // ajouter un facture
       public function addFacture(Request $request)
       { 
        
           $facture = new Facture();
    
                   $facture->reference_f = $request->factures['reference_f'];
                   $facture->date_f = $request->factures['date_f'];
                   $facture->type_operation_f = $request->factures['type_operation_f'];
                   $facture->objet_f = $request->factures['objet_f'];
                   $facture->date_emission_f = $request->factures['date_emission_f'];
                   $facture->remise_total_f = $request->factures['remise_total_f'];
                   $facture->majoration_f = $request->factures['majoration_f'];
                   $facture->date_limit_f = $request->factures['date_limit_f'];
                   $facture->introduction_f = $request->factures['introduction_f'];
                   $facture->conditions_reglements_f=$request->factures['conditions_reglements_f'];
                   $facture->notes_f = $request->factures['notes_f'];
                   $facture->adresse_f = $request->factures['adresse_f'];
                   $facture->accompte_f = $request->factures['accompte_f'];
                   $facture->fk_status_f = $request->factures['fk_status_f'];
                   $facture->fk_compte_f = $request->factures['fk_compte_f'];
                   
                   $facture->fk_user_f = Auth::user()->id;
                   
                   $facture->total_lettre_f = $request->factures['total_lettre_f'];
                   $facture->total_ht_f = $request->factures['total_ht_f'];
                   $facture->remise_ht_f = $request->factures['remise_ht_f'];
                   $facture->montant_net_f = $request->factures['montant_net_f'];
                   $facture->tva_montant_f = $request->factures['tva_montant_f'];
                   $facture->montant_ttc_f = $request->factures['montant_ttc_f'];
                   $facture->montant_reste_f = $request->factures['montant_reste_f'];
   
                   $facture->save();
   
                   $this->addCommandes_f($request);
                   $this->addModePaiement_f($request);
                    return Response()->json(['etat' => true]);
               
       }

       public function updateFacture(Request $request){

        $facture = Facture::find($request->factures['id_facture']);

                $facture->reference_f = $request->factures['reference_f'];
                $facture->date_f = $request->factures['date_f'];
                $facture->type_operation_f = $request->factures['type_operation_f'];
                $facture->objet_f = $request->factures['objet_f'];
                $facture->date_emission_f = $request->factures['date_emission_f'];
                $facture->remise_total_f = $request->factures['remise_total_f'];
                $facture->majoration_f = $request->factures['majoration_f'];
                $facture->date_limit_f = $request->factures['date_limit_f'];
                $facture->introduction_f = $request->factures['introduction_f'];
                $facture->conditions_reglements_f=$request->factures['conditions_reglements_f'];
                $facture->notes_f = $request->factures['notes_f'];
                $facture->adresse_f = $request->factures['adresse_f'];
                $facture->accompte_f = $request->factures['accompte_f'];
                $facture->fk_status_f = $request->factures['fk_status_f'];
                $facture->fk_compte_f = $request->factures['fk_compte_f'];
                $facture->fk_user_f = Auth::user()->id;
                
                $facture->total_lettre_f = $request->factures['total_lettre_f'];
                $facture->total_ht_f = $request->factures['total_ht_f'];
                $facture->remise_ht_f = $request->factures['remise_ht_f'];
                $facture->montant_net_f = $request->factures['montant_net_f'];
                $facture->tva_montant_f = $request->factures['tva_montant_f'];
                $facture->montant_ttc_f = $request->factures['montant_ttc_f'];
                $facture->montant_reste_f = $request->factures['montant_reste_f'];

        $facture->save();
        $reference_f = $facture->reference_f;
        $this->updateCommandes_f($request,$reference_f);
        $this->updateModePaiement_f($request,$reference_f);

        return Response()->json(['etat' => true]);
    }

      //compter le numero de reference facture
      public function countFactures(){
        $count = Facture::withTrashed()->where('type_operation_f','=','vente')->count();
        $count ++;
        return Response()->json(['count' => $count]);
    }

    
    public function updateStatusFacture(Request $request){
        //dd($request->id_factures);
              $facture = Facture::find($request->id_facture);
                      $facture->fk_status_f = $request->fk_status_f;
                      $facture->save();
              return Response()->json(['etat' => true]);
    }

     // ajouter les commandes de facture
     public function addCommandes_f(Request $request){ 
        
        for($i=0;$i<count($request->commandes);$i++) {    
     $commande = new Commande();  
     $commande->quantite_cmd=$request->commandes[$i]['quantite_cmd'];
     $commande->remise_cmd=$request->commandes[$i]['remise_cmd'];
     $commande->majoration_cmd=$request->commandes[$i]['majoration_cmd'];
     $commande->prix_ht=$request->commandes[$i]['prix_ht'];
     $commande->total_ht_cmd=$request->commandes[$i]['total_ht_cmd'];
     $commande->fk_article=$request->commandes[$i]['fk_article'];
     $commande->fk_document=$request->commandes[$i]['fk_document'];
     $commande->fk_tva_cmd=$request->commandes[$i]['fk_tva_cmd'];
     $commande->description_article=$request->commandes[$i]['description_article'];

             $commande->save();
        }
              return Response()->json(['etat' => true]);
         
    }

    public function updateCommandes_f(Request $request , $reference_f){

        for($i=0;$i<count($request->suppCommandes);$i++){
         $commande = Commande::find($request->suppCommandes[$i]['id_cmd']);
         $commande->delete();
 
         }
         for($i=0;$i<count($request->commandes);$i++){
             if (!isset($request->commandes[$i]['id_cmd'])) {
                $commande = new Commande();  
                $commande->quantite_cmd=$request->commandes[$i]['quantite_cmd'];
                $commande->remise_cmd=$request->commandes[$i]['remise_cmd'];
                $commande->majoration_cmd=$request->commandes[$i]['majoration_cmd'];
                $commande->prix_ht=$request->commandes[$i]['prix_ht'];
                $commande->total_ht_cmd=$request->commandes[$i]['total_ht_cmd'];
                $commande->fk_article=$request->commandes[$i]['fk_article'];
                $commande->fk_document=$reference_f;
                $commande->fk_tva_cmd=$request->commandes[$i]['fk_tva_cmd'];
                $commande->description_article=$request->commandes[$i]['description_article'];

                
                $commande->save();
             }    
         }
         for($i=0;$i<count($request->commandes);$i++){
             if (isset($request->commandes[$i]['id_cmd'])) {
         Commande::where('id_cmd','=', $request->commandes[$i]['id_cmd'])->update([
            "quantite_cmd" => $request->commandes[$i]['quantite_cmd'],
            "remise_cmd" => $request->commandes[$i]['remise_cmd'],
            "majoration_cmd" => $request->commandes[$i]['majoration_cmd'],
            "prix_ht" => $request->commandes[$i]['prix_ht'],
            "total_ht_cmd" => $request->commandes[$i]['total_ht_cmd'],
            "fk_article" => $request->commandes[$i]['fk_article'],
            "fk_document" => $request->commandes[$i]['fk_document'],
            "fk_tva_cmd" => $request->commandes[$i]['fk_tva_cmd'],
            "description_article" => $request->commandes[$i]['description_article'],
            ]);
             }
         }
  
    }

        
    public function getFactureF($id_facture){
        // $facture= Facture::find($id_facture);
         $facture= Facture::leftJoin('comptes', 'factures.fk_compte_f', '=', 'comptes.id_compte')
               ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
               ->leftJoin('mode_paiements', 'factures.reference_f', '=', 'mode_paiements.fk_document')
               ->leftJoin('status', 'factures.fk_status_f', '=', 'status.id_status')
               ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
               ->select('factures.*', 'comptes.nom_compte','status.*', 'macompagnies.*','mode_paiements.*','type_paiements.*')
               ->where('id_facture', $id_facture)->get();
         return Response()->json(['facture' => $facture ]);
    }

    public function getFactures(){
     
        $factures = Facture::leftJoin('comptes', 'factures.fk_compte_f', '=', 'comptes.id_compte')
        ->leftJoin('status', 'factures.fk_status_f', '=', 'status.id_status')
                    ->select('factures.*', 'comptes.nom_compte','status.*')
                    ->paginate(10);
                   
                 return Response()->json(['factures' => $factures ]);
              }

              public function getPrixArticle_f($fk_article){
                $commande=Commande::find($fk_article);
                $article=Article::leftJoin('tvas', 'articles.fk_tva_applicable', '=', 'tvas.id_tva')
                ->select('articles.*', 'tvas.taux_tva')
                ->where('articles.id_article','=',$fk_article)->get();
                 return Response()->json(['article' => $article ]);
              }

                // ajouter mode de paiement de devis
    public function addModePaiement_f(Request $request) { 
          
        $modeP = new Mode_paiement();
 
                $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
                $modeP->date_paiement = $request->modePaiements['date_paiement'];
                $modeP->fk_type_paiement = $request->modePaiements['fk_type_paiement'];
                $modeP->fk_document = $request->modePaiements['fk_document'];
                $modeP->save();
             
                 return Response()->json(['etat' => true]);
            
    }

    public function updateModePaiement_f(Request $request , $reference_f){
        $modeP = Mode_paiement::find($request->modePaiements['id_modeP']);
        $modeP->reference_paiement = $request->modePaiements['reference_paiement'];
        $modeP->date_paiement = $request->modePaiements['date_paiement'];
        $modeP->fk_type_paiement = $request->modePaiements['fk_type_paiement'];
        $modeP->fk_document = $reference_f;
        $modeP->save();

    }

    public function deleteFactures($id_facture){

        $factures = Devi::find($id_facture);
        $facture->delete();
        $commande = Commande::where('fk_document','=',$id_facture);  
        $commande->delete();   
        $modePaiement = Mode_paiement::where('fk_document','=',$id_facture)->delete(); 
        return Response()->json(['delete' => 'true']);
    }



    public function pdf_f($reference_f){
        $facture= Facture::leftJoin('comptes', 'factures.fk_compte_f', '=', 'comptes.id_compte')
        ->leftJoin('macompagnies', 'comptes.fk_compagnie', '=', 'macompagnies.id_compagnie')
        ->leftJoin('mode_paiements', 'factures.reference_f', '=', 'mode_paiements.fk_document')
        ->leftJoin('type_paiements', 'type_paiements.id_type_paiement', '=', 'mode_paiements.fk_type_paiement')
        ->select('factures.*', 'comptes.nom_compte','comptes.id_compte','macompagnies.*','mode_paiements.*','type_paiements.*')
        ->where('reference_f', $reference_f)->get();

        $commandes= Commande::leftJoin('articles', 'commandes.fk_article', '=', 'articles.id_article')
        ->leftJoin('tvas', 'commandes.fk_tva_cmd', '=', 'tvas.id_tva')
        ->select('commandes.*', 'articles.designation','articles.unite','tvas.taux_tva','articles.reference_art')
        ->where('fk_document', $reference_f)->get();
        //dd($facture);
  
        $logo = public_path().'/storage/images/'.$facture[0]->logo_comp;
      
        $headerHtml =  '<div>
        <img src="'.$logo.'" alt="test alt attribute" width="180" height="70" border="0" />
   
    </div>
        <br>
       <table style="padding: 0px;padding-right:10px">
       <tr>
           <td>
           <span></span><br>
           <b>Facture: '.$facture[0]->reference_f.'</b> <br>
           Date: '.$facture[0]->date_f.'<br>
           Réglement: '.$facture[0]->type_paiement.'<br>
           Validité: '.$facture[0]->date_limit_f.'<br>
           
           </td>
           <td style=" border-right:1px solid black;
           border-left:1px solid black;
           border-bottom:1px solid black;
           border-top:1px solid black;">
           <br>
           <b>'.$facture[0]->nom_compte.'</b>
           <p> '.$facture[0]->adresse_f.'</p>
           
           </td>
       </tr>
       </table>';



       $objethtml = '<p style="margin-top: 50px;">Objet:'. $facture[0]->objet_f.'</p>';
        $commandesHtml ='<table border="1" style="padding: 3px 0px;">
        <thead>
                <tr style="color:white; font-size: 10pt;background-color: black;">
                
                    <th width="80">Code article</th>
                    <th  width="214">Description</th>
                    <th width="35">QTÉ</th>
                    <th width="30">UT</th>
                    <th width="80">PU HT</th>
                    <th width="100">TOTAL HT</th>
                    <th width="25">TVA</th>
         
                </tr>
                </thead>';
         $commandesHtml.='<tbody style="">';
        foreach ( $commandes as $commande ){
            $commandesHtml.='
            <tr style="border-bottom: 1px solid;font-size: 10pt; ">                   
                    <th align="center" width="80">'.$commande->reference_art.'</th>
                    <th  align="center"  width="214">'.$commande->description_article.'</th>
                    <th align="center" width="35">'.$commande->quantite_cmd.'</th>
                    <th align="center" width="30">'.$commande->unite.'</th>
                    <th align="center" width="80">'.$commande->prix_ht.'</th>
                    <th align="center" width="100">'.$commande->total_ht_cmd.'</th>
                    <th align="center" width="25">'.$commande->taux_tva.'</th>
                </tr> ';
            };
            $commandesHtml.='</tbody> </table>';
           //dd($commandesHtml);

        







         $infoComp = ''.$facture[0]->nom_societe.' <span>
        </span>'.$facture[0]->raison_sociale.'<span> 
        ICE: </span>'.$facture[0]->ICE.'<span>
        RC N°: </span>'.$facture[0]->RC.'<span>
        IF: </span>'.$facture[0]->IF.'<span>
        patente: </span>'.$facture[0]->patente.'<span>
        cnss: </span>'.$facture[0]->cnss.'<span>
        compte : </span>'.$facture[0]->nom_bank.'<span>
        RIB: </span>'.$facture[0]->RIB.'<span>
        E-mail: </span>'.$facture[0]->email.'<span>
        Site: </span>'.$facture[0]->webSite_comp.'<span>
        fax: </span>'.$facture[0]->fax_comp.'<span>
        fix: </span>'.$facture[0]->fix_comp.'<span>
        GSM: </span>'.$facture[0]->GSM_comp.'<span>';

        $calculeHtml =  '<div>
        
        <table style="padding: 3px;padding-right:5pt;">
        
        <tr>
        <td style="width:286px;">Total en lettre : '.$facture[0]->total_lettre.'</td>
        <td style="width:140px;" align="left">Total</td> <td style="width:140px;" align="right">'.$facture[0]->total_ht_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Remise</td> <td style="width:140px;" align="right">'.$facture[0]->remise_ht_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">Total HT</td> <td style="width:140px;" align="right">'.$facture[0]->montant_net_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" class="tdC" align="left">TVA</td> <td  style="width:140px;" align="right">'.$facture[0]->tva_montant_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Montant NET TTC (MAD)</td> <td style="width:140px;" align="right">'.$facture[0]->montant_ttc_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Acompte</td> <td style="width:140px;" align="right">'.$facture[0]->accompte_f.'</td>
        </tr>
        <tr>
        <td style="width:286px;"></td>
        <td style="width:140px;" align="left">Net a payer</td> <td style="width:140px;" align="right">'.$facture[0]->montant_reste_f.'</td>
        </tr>


        </table>
        <table>
            <tr>
                <td></td>
                <td><hr></td>
            </tr>
        </table>
        
        </div>
     
        CONDITIONS :'.$facture[0]->conditions_reglements_f.'<br>  
         NOTES : '.$facture[0]->notes_f.'';
        
      

        $testleft = '<div> <h1> lettre </h1></div>';




        PDF::setHeaderCallback(function($pdf) {

            // Set font
            PDF::SetFont('helvetica', 'B', 20);
            // Title
            PDF::Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    
    });
    /*PDF::setData(function($infoComp) {
        $this->template = $infoComp;
    });*/

    
        $this->template = $infoComp;
       
        
    
   
    PDF::setFooterCallback(function($pdf) {
       //dd($infoComp);
      // dd($this->template);
        // Position at 15 mm from bottom
       // $pdf->SetY(-15);
        // Set font
        $pdf->SetFont('helvetica', 'I', 10);
        // Page number
        PDF::writeHTMLCell(0, 0, '',274,'<hr>', 0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0, '',275,$this->template, 0, 1, 0, true, '', true);
        PDF::writeHTMLCell(0, 0, '',290,'<span style="color:blue;text-align:right"> Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages().'</span>', 0, 1, 0, true, '', true);

       // $pdf->Cell(0, 10, $this->template.'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    });


        PDF::SetMargins(5, 5, 5);
       // PDF::SetHeaderMargin(100);
        PDF::SetFooterMargin(10);

        PDF::SetFont('helvetica', 'I', 10);
        PDF::SetAutoPageBreak(TRUE, 25);

        PDF::AddPage();

        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)

      /*  $y = PDF::getY();    
        PDF::MultiCell(40, 0, $left_column, 1, 'R', 0, 1, '', $y, true, 0);

        $y = PDF::getY() + 10;
        PDF::MultiCell(40, 0, $right_column, 1, 'R', 0, 1, '', $y, true, 0);*/


        //---------------
      //  $y = PDF::getY();    
       // PDF::MultiCell(40, 0, $headerHtml, 1, 'R', 0, 1, '', $y, true, 0);
       // $y = PDF::getY() + 10;
 //---------------
 //PDF::writeHTMLCell(0, 0, '',0,$page2 ,0, 1, 0, true, 'top', true);

 $y = PDF::getY();    

 //PDF::writeHTMLCell(0, 0, '', $y,$headerHtml, 0, 1, 0, true, '', true);
//PDF::writeHTMLCell(0, 0, '', $y,$headerHtml, 0, 1, 0, true, '', true);


$left_column = '<b>LEFT COLUMN</b> left column left column left column left</b>';
$right_column = '<b>RIGHT COLUMN</b> right column right column right column</b>';

PDF::writeHTMLCell(80, '', '', $y, $left_column, 0, 0, 0, true, 'left', true);
PDF::writeHTMLCell(80, '', 110, '', $right_column, 0, 1, 0, true, 'right', true);
$y = PDF::getY();  

 
 PDF::writeHTMLCell(0, 0, '',$y,$headerHtml ,0, 1, 0, true, '', true);
 $y = PDF::getY();



 PDF::writeHTMLCell(0, 10, '',$y,$objethtml, 0, 1, 0, true, '', true);
 $y = PDF::getY();
 
 
 
 

 
 //PDF::SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 255)));

 //$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));

 //PDF::Line(5, 40, 5, 30, $style2);
 //$this->Line($p1x, $p1y, $p2x, $p2y, $style);
 /*$border = array(
    'L' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0)),
    'R' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 255)),
    'T' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 255, 0)),
    'B' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 255)));*/


  /*  $border = array(
        'T' => array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 255)),
     );*/



//$y=78 minimum
//chaque ligne = y=6.5 ou 12
// 17 lign 

 PDF::writeHTMLCell(0, 0,'', $y,$commandesHtml,0, 1, 0, true, '', true);

 $y = PDF::getY();
 
 //$height2 = ($y-78.72); // size nb tableau 
 $height2 = ($y-78.72);// $y pointe 78.72 quand commandes vide 
 $resul = $height2/6.5; // le nombre commandes ajouté 
//dd($resul);
 $height3 =  ((18-$resul)*18); // premier 18 nb max commandes page 1
 
 //dd($height3);
  //dd($height3);

 //dd($height2/6.5);
//dd($height2/6.5);
 //



 //dd($y);
//dd($y);

 //$height = 400-$y-12;
//dd($y);
//if($y<130)

/*else if($y<180)
$height = 380-$y*1.5;
else
$height = 300-$y*1.5;*/
 
 $commandesHtml2 = '<table style="padding: 3px 0px;"> 
 
 <thead>
           
 <tr style="color:white;font-size: 10pt; line-height:'.$height3.' px;">
      
 <th width="80" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th  width="214" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="35" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="30" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="80" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="100" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 "> </th>
 <th width="25" style="
 border-right:1px solid black;
 border-left:1px solid black;
 border-bottom: 1px solid black;
 
 "> </th>

</tr>
 
 </thead> 

 </table>';
 PDF::writeHTMLCell(0, 0,'', $y,$commandesHtml2,0, 1, 0, true, '', true);
 $y = PDF::getY();



 if($y>216){ // si page 1 complet les calcule saute vers page 2
 $y = $y+80;

 }
 

 
 //PDF::writeHTMLCell(0, 140,'', $y,$commandesHtml,1, 1, 0, true, '', true);

 
 //if($y>205){
   // PDF::writeHTMLCell(0, 0, '',$y,$page2 ,0, 1, 0, true, '', true);}


  
 PDF::writeHTMLCell(0, 0, '',$y,$calculeHtml , 0, 1, 0, true, '', true);








        //$view = \View::make('pdf', array('facture' => $facture[0],'commandes' => $commandes ,'logo' => $logo ));
        //$html_content = $view->render();
   

        
        
        //PDF::SetAutoPageBreak(TRUE, 0);
         // Set font
        
     
        // PDF::SetFooterMargin(0);
         
         //PDF::writeHTML($html_content, true, false, true, false, '');
         //PDF::Cell(0, 100, 'azertyu yuiop fghjklm dfghjkl ', 0, false, 'C', 0, '', 0, false, 'T', 'M');       
         //writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
        //PDF::writeHTMLCell(80, '', '', '290', 'oooook', '', '', '', '', '', '');
       // PDF::writeHTMLCell(0, 0, '',3,$headerHtml , 0, 0, 0, false, '', true);
       
        
       // PDF::writeHTMLCell(0, 0, '',37,$objethtml, 0, 0, 0, false, '', true);
       // PDF::writeHTMLCell(0, 135,'', 70,$commandesHtml, 1, 0, 0, false, '', true);
       // PDF::writeHTMLCell(0, 0, '',130,$calculeHtml.'<br>'.$infoComp , 0, 0, 0, false, '', true);
     
     //  PDF::writeHTMLCell(0,0,'',0,$test1, 1, 0, 0, false, '', true);
       
      // PDF::writeHTMLCell(0,0,'',120,$test2,1, 0, 0, false, '', true);


        //PDF::writeHTMLCell(203, 100, '', 70,$infoComp, 1, 0, 0, false, '', true);





       //  PDF::writeHTMLCell(0, '', '', 290,$infoComp, 0, 0, 0, false, '', true);
         //PDF::SetY(0);
         
         
         PDF::Output($reference_f.'.pdf');
         
      }
   
    
}