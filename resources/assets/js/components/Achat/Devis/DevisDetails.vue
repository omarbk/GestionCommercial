<template>
<div>
            
    <div class="loading" v-if="loading">
          <div class="lds-hourglass"></div>
    </div>
    <div v-if="error" class="error">
      {{ error }}
    </div>

<div v-if="!loading">
  <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="Testopen.testEditS">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Status Bien Modifier !</strong>
</div>
     <div class="row">
        <div class="col">
            <!--
        <a href="#"    @click="redirect_To_AddBonCommande(devi)"  class="btn btn-secondary mb-3  float-right" ><i class="fas fa-exchange-alt"></i> Convertir </a>
    -->
        <a href="#"  v-b-modal.modalPrevent style="background-color:#c1b6ca;"    class="btn btn-secondary mb-3  float-right" ><i class="fas fa-exchange-alt"></i> Convertir </a>
       <b-modal id="modalPrevent"
             ref="modal"
             title="+ convertir"
             @ok="handleOk"
             ok-title="Enregister" >
      <form @submit.stop.prevent="handleSubmit">

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Convertir</label>
                <div class="col-sm-10">
                <input type="text"  readonly class="form-control" id="inputPassword" placeholder="" v-model="devi.reference_d" disabled>
                </div>
            </div>

            <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">compte: </label>
                    <div class="col-sm-10">
         <select class="form-control custom-select" id="fk_compte" v-model="document" >
                   <option value="bonCommande">Bon de Commande</option>
                    <option value="bonLivraison">Bon de livraison</option>
                     <option value="facture">Facture</option>
                   
                </select>  

                
                </div>
            </div> 
            
          
      
      </form>

    </b-modal>
        <a href="#"    @click="PdfDevis(devi.reference_d)"  class="btn btn-secondary mb-3  float-right" ><i class="far fa-file-pdf"></i> Imprimer</a>


 


    
        <router-link class="btn btn-primary mb-3 retour float-right " :to="'/getDevisA'">
        <i class="fas fa-long-arrow-alt-left fontsize"></i>
        </router-link>
        </div>
    </div>
<div class="container colBackround">
          
<div class="row">
    <div class="col">
        <br>
    <h5><i class="far fa-file"></i> Informations sur le Devis : <strong>{{devi.reference_d}}</strong></h5>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label"><strong>Devis {{devi.reference_d}} [{{devi.montant_ttc_d}} DH]</strong> </label>

            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Date : {{devi.date_d}}</label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Validité : {{devi.date_limit_d}}  </label>
            </div>
            <div class="top form-group row">
                <label for="inputPassword" class="col-sm-12 col-form-label">Vendeur : {{devi.nom_societe}}  </label>
            </div>
          
    </div>
    <div class="col-md-6 col-sm-12">
        Client :
        <div class="container  infoClient">
            <label class="" for=""><b>{{devi.nom_societe_comp}} </b></label>
            <div class="form-group row">
            <div class="col-sm-10">
            {{devi.adresse_d}}
            </div>
         </div>
        </div>
        <br>
        <div class="form-group row">
                 <div class="col-sm-4"> 
                <select class="form-control custom-select " id="fk_status_d" v-model="devi.fk_status_d" @change="getStatu()">
                    <option value="Brouillon" selected disabled>Brouillon</option>
                    <option v-for="statu in status" :key="statu.id_status" :value="statu.id_status">{{statu.type_status}}</option>
                </select>
                 </div>
                 <div class="col-sm-2"> 
                    <a href="#" @click="updateStatusDevis()"  class="btn btn-secondary badge badge-pill" style="background-color:black" :style="{'background-color': devi.colorStatu ,'color':fontStatu.white , 'font-size':fontStatu.size}"><i class="fa fa-undo"></i></a>                                
                 </div>
        </div>
    </div>
</div>
<hr>

  <div>     
        
                     <table class="table table-bordered">
                            <thead>
                          <tr class="trHead">
                            <th>Article</th>
                            <th>Quantite</th>
                            <th>Remise</th>
                           
                            <th>Prix HT</th>
                            <th>TVA</th>
                            <th>Total HT</th>
                          </tr>                           
                        </thead>
                         <tbody>
                          <tr v-for="(commande,index) in commandes" :key="index" >
                            <th> {{commande.designation}}</th>
                            <th>{{commande.quantite_cmd}}</th>
                            <th>{{commande.remise_cmd}}</th>
                           
                            <th>{{commande.prix_ht}}</th>
                            <th>{{commande.taux_tva}} </th> 
                            <th>{{commande.total_ht_cmd}} </th> 

                         </tr>              
                        </tbody>


                         </table>
  </div>
<hr>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="form-group2 row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Total en lettre</label>
                <div class="col-sm-8 col-form-label ">
                <label>{{devi.total_lettre_d}}</label>
                </div>
            </div>
            <div class="form-group2 row">
                <label for="inputPassword" class="col-sm-4 col-form-label">Date Limit</label>
                <div class="col-sm-8 col-form-label">
                {{devi.date_limit_d}}
                </div>
            </div>
            <div class="form-group2 row">
                    <label for="type_paiement" class="col-sm-4 col-form-label" > Type Paiement </label>
                <div class="col-sm-8 col-form-label">
                {{devi.type_paiement}}
                   
                </div>
            </div>
                <div class="form-group2 row">
                    <label for="reference_paiement"  class="col-sm-4 col-form-label" >Reference Paiement </label>
                    <div class="col-sm-8 col-form-label">
                    {{devi.reference_paiement}}
                    </div>
                </div> 
                 <div class="form-group2 row">
                    <label for="date_paiement"  class="col-sm-4 col-form-label" >Date Paiement </label>
                    <div class="col-sm-8 col-form-label">
                    
                    {{devi.date_paiement}} 
                    </div>
                </div>  
                <div class="form-group2 row">
                    <label for="remise_total_d"  class="col-sm-4 col-form-label" >Remise Total </label>
                    <div class="col-sm-8 col-form-label">
                    {{devi.remise_total_d}}
                    </div>
                </div>                  
                      

                                 
    </div>
    <div class="col-md-6 col-sm-12">
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Total HT </label>
            <div class="col-sm-8 cal col-form-label">
            {{devi.total_ht_d}}
            </div>
         </div>
   
       
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Remise Total (montant) </label>
            <div class="col-sm-8 cal col-form-label">
            {{devi.remise_ht_d}}
            </div>
         </div>
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label"> Montant Net HT  </label>
            <div class="col-sm-8 cal col-form-label">
            {{devi.montant_net_d}}
            </div>
         </div>
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">TVA (Montant) </label>
            <div class="col-sm-8 cal col-form-label">
            {{devi.tva_montant_d}}
            </div>
         </div>
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Montant TTC (Montant) </label>
            <div class="col-sm-8 cal col-form-label">
            {{devi.montant_ttc_d}}
            </div>
         </div>
         <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Acompte </label>
            <div class="col-sm-8 cal col-form-label">
            {{devi.accompte_d}}
            </div>
         </div>
         <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-4 col-form-label" style="padding-right: 0px;">Net à payer (Montant) </label>
            <div class="col-sm-8 cal col-form-label" >
            {{devi.montant_reste_d}}
            </div>
         </div>
   
 </div>

        
</div>
<br>
<div class="row">
  <div class="col">
                <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Notes </label>
            <div class="col-sm-10 col-form-label">
            <label>{{devi.notes_d}}</label>
            </div>
         </div>
  </div>
</div>
<br>
<div class="row">
   <div class="col">
          <div class="form-group2 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Conditions </label>
            <div class="col-sm-10 col-form-label">
            <label>{{devi.conditions_reglements_d}}</label>
            </div>
         </div>
   </div>
</div>
<hr>
</div>
</div>
</div>
</template>
<script>
    


      export default{ 
        
          data: () => ({
              fontStatu : {
                    white : "white",
                    size: "14px",
              },
                    loading: false,
                    error: null,
                     Testopen:{
                testEditS : false,
              },
   // devi
        devi: { 
            id_devis:0,
            reference_d:"",
            date_d:"", 
            adresse_d:"",
            type_operation:"",
            objet_d:"",
            date_emission_d:"",
            remise_total_d:"",
            majoration_d:"",
            date_limit_d:"",
            introduction_d:"",  
            conditions_reglements_d:"",
            notes_d:"",
            accompte_d:"",
           fk_status_d:"",
           fk_compte_d:"",
            fk_user_d:"",

            designation:"",
            nom_compte:"",
            taux_tva:"",

            total_ht_d:0,
            remise_ht_d:0,
            montant_net_d:0,
            tva_montant_d:0,
            montant_ttc_d:0,
            total_lettre_d:"",
            montant_reste_d:0,
            
            nom_societe:"",
            id_compte:0,
            },

            statu :{
              type_status:"",
              colorStatu:"",
            },

              // tableau des devis 
              devis :[],
              //tables foreign key 
              status:[],
              tvas:[],
              articles:[],
              comptes:[],
              index:0,
              total_prix:0,
              remise_T:0,
              
              
              //commandes
            commande:{
                id_cmd:0,
                quantite_cmd:1,
                remise_cmd:0,
                majoration_cmd:0,
                prix_ht:0,
                fk_article:"",
                fk_document:"",
                fk_tva_cmd:"",
               
               //affichage
               
                desig:"",
                total_ht_cmd:0,
                taux_tva:0,
            },
            document :"",
            commandes:[],
    }),
          methods:{
updateStatusDevis(){
                axios.post('/updateStatusDevis',this.devi)
                .then(response => {
                        console.log("updateStatusDevis")

                    if(response.data.etat){
                     this.$router.push({ name: 'getDevisA', params: { success: "editStatusuccess"  }});
             
                      /*  this.$router.push('/DevisDetailsA/editS/'+this.devi.id_devis);
                         if(this.$route.params.success == "editS"){
                            console.log("methode");
                            this.Testopen.testEditS =true; 
                            }*/
                    }
                })
                .catch(error => {
                })
    },
     PdfDevis(reference_d){
                           
                //   window.location.href='/pdf/'+reference_bc
                  window.open('/pdf_d_a/'+reference_d,'_blank');
          },
                        fetchData () {
      this.loading = true
      console.log("loading+++++++++++++++++++++")
      // replace `getPost` with your data fetching util / API wrapper
             this.devi.id_devis = this.$route.params.id_devis;
             this.devi.reference_d=this.$route.params.reference_d;
              this.getDevisD(this.devi.id_devis);
              
              this.getStatus();
              this.getCommandes(this.devi.reference_d);


    },
       getDevisD:function(id_devis){
                  axios.get('/getDevisD/'+id_devis).then(
                  response => {
                         //console.log(response.data.devi.fk_compte_d);
                    //this.loading = false;

                    this.devi= response.data.devi[0];
                    this.devi.colorStatu=response.data.devi[0].colorStatu;
                    console.log("color devi +++++++"+this.devi.colorStatu);
                  });     
        },
        getCommandes:function(reference_d){
                  axios.get('/getCommandes/'+reference_d).then(
                  response => {
                      console.log("commandes:  ");
                         console.log(response.data.commandes);

                    this.commandes= response.data.commandes;
                    this.loading = false;
                    // this.commande.fk_article= response.data.articles;

                  });     
        },

        getStatus(){
        axios.get('/getStatus')
        .then((response) => {
                this.status= response.data.status;
               
        })
        .catch(() => {
                console.log('handle server error from here');
        });
    },
    getStatu(){
        axios.get('/getStatu/'+this.devi.fk_status_d)
            .then((response) => {

                    this.statu = response.data.statu;
                    console.log("devi"+this.devi.fk_status_d)
                    console.log("color   "+response.data.statu.colorStatu)

                     this.devi.colorStatu=response.data.statu.colorStatu;

                 // this.devi.fk_status_d=response.data.statu.adresse_compte;
            })
            .catch(() => {
                    console.log('handle server error from here');
        });
    },
    handleOk(){
        console.log('----- doc ')
            console.log(this.document);
            if(this.document ==="bonCommande"){
                this.redirect_To_AddBonCommande(this.devi);

            }
            if(this.document ==="bonLivraison"){
                this.redirect_To_AddBonLivraison();

            }
             if(this.document ==="facture"){
                this.redirect_To_AddFacture(this.devi);

            }
    },
            redirect_To_AddBonCommande(devi){
                    this.$router.push({ name: 'addBonCommandeA', params: {id_devis: devi.id_devis, reference_d: devi.reference_d,id_compte:devi.id_compte}});

            }, 
            redirect_To_AddBonLivraison(){
                   //  this.$router.push('/ShowBonCommande/'+reference_bc);
                     this.$router.push({ name: 'addBonLivraisonA', params: {devi :this.devi}});

            },
            
            redirect_To_AddFacture(devi){
                    this.$router.push({ name: 'addFactureA', params: {devi: this.devi}});
            },
    },
                created () {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchData()
  },  
 
              updated(){
        if( this.$route.params.success == "editS"){
          let that = this
                            console.log("updated");
              setTimeout(function(){that.Testopen.testEditS = false;}, 2000);
        }
              },
           watch: {
    // call again the method if the route changes
    '$route': 'fetchData',
           }

}
</script>
<style scoped>
 .btnMarge{
     padding-bottom: 10px;
 }
 .widthCard{
     width: 270px;
     height: 350px;
     
 }
 .widthTextCard{
     width  : 236px;
     height: 13px;
 }
 a {
  color: #999;
  color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    
}
.current {
  color: red;
}
ul {
  padding: 0;
  list-style-type: none;
}
li {
  display: inline;
  margin: 5px 5px;
}

a.first::after {
  content:'...'
}

a.last::before {
  content:'...'
}
.cardbox:hover{
 box-shadow: 1px 2px 2px 2px #c9ced2;
}
.mr-4{
    margin-right: 0rem!important;
    width:100px;
}
.colBackround{
     background-color: whitesmoke;
    box-shadow: 1px 1px 3px 4px #d2cfcf;
}
.infoClient{

    background-color:  #42a5f529;

}
.AdressClient{
    width: 121%;
}

.noteCondition{
    width: 77%;
}
.calculePadding{
    padding-left: 50%;
}
.top{
        margin-left: 100px;
    margin-bottom: 0rem;
}
.compte{
        color: blue;
    font-size: large;
}


.table {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.table td, .table th {
    border: 1px solid #ddd;
    padding: 8px;
}

.table tr:nth-child(even){background-color: rgb(236, 236, 236);}


.heade {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    color: #898585;
    background-color: #d8e9f6;
}


.cal{
padding-right: 0px;
padding-left: 120px;
}

.retour {
    border-left-color:#0000009e;
    border-left-width: 3px;
}
.convert{
    background-color: #3f51b5;
}
.show{
     opacity:0.9;
    width: 233px;
    z-index: 100;
    top: 61px;
    right: 0;
    position:  absolute;
    position :fixed;}


/*loading*/
.lds-hourglass {
  display: inline-block;
  position: relative;
  width: 0px;
  height: 20px;
}
.lds-hourglass:after {
  content: " ";
  display: block;
  border-radius: 50%;
  width: 0;
  height: 0;
  margin: 6px;
  box-sizing: border-box;
  border: 15px solid #fff;
  border-color: rgb(0, 0, 0) transparent rgb(0, 0, 0) transparent;
  animation: lds-hourglass 1.2s infinite;
}
@keyframes lds-hourglass {
  0% {
    transform: rotate(0);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
  }
  50% {
    transform: rotate(900deg);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
  }
  100% {
    transform: rotate(1800deg);
  }
}
.trHead{

    background-color: #d8e9f5;

}
.form-group2{
    margin-bottom:0rem;
}
</style>
